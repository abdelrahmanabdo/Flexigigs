<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Service;
use App\User;
use App\Gigs;
use App\Orders;
use App\Category;
use App\ServiceVideo;
use App\Helpers\Fawry;
use App\Helpers\Flexihelp;
use App\ServicePhoto;
use App\Applications;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;
class ApplicationController extends Controller
{
  public function getApplication(Request $request ,$id)
    {
      $data['application'] = $application = Applications::where("id",$id)->with(['customer','supplier','gig.skills.category','gig.attach'])->first();
      if(!$application||$application->status){
        $error['status'] = false;
        $error['message'] = ($application)?'application not found':'you are not permeted to access this application it`s accepted and closed';
        return ($request['is_api'])?response()->json($error,200):abort(404);
      }
      $data['userdata'] = $userdata = $application->supplier;
      $data['user_skills'] = Flexihelp::userSkills($userdata->skills);
      $customer_id = 0;
      if (Auth::check()) {
        $customer_id = Auth::user()->id;
      }else{
        $customer_id = ($request['is_api'])?$request->customer_id:0;
        if ($request['is_api']&&!$request->customer_id) {
          $error['status'] = false;
          $error['message'] = 'customer_id not send';
          response()->json($error,400);
        }
      }
      if ($application->customer->id != $customer_id ){
        $error['status'] = false;
        $error['message'] = 'you are not permeted to access this application';
        if (Auth::check()) {
          if (!Auth::user()->hasRole('admin')) {
            return ($request['is_api'])?response()->json($error,200):abort(403);
          }
        }else{
          return ($request['is_api'])?response()->json($error,200):abort(403);
        }
      }
      $data['total_services'] = Service::where('supplier_id',$userdata->id)->count();
     return ($request['is_api'])?response()->json($data,200):view('checkout.accept_supplier',$data);
   }
  public function checkout(Request $request ,$id)
    {
      $data['application'] = $application = Applications::where("id",$id)->with(['supplier','gig.skills.category','gig.attach'])->first();
      if(!$application||$application->status)
        abort(404);
      if (!$request->segment(2)=="mobile" && $application->customer->id != Auth::user()->id)
        abort(403);
      $price = Flexihelp::fixprice($application->gig,'gig');
      $data['handlingfee'] = $price->handling;
      $data['totalfee'] = $price->total_handling;
      if ($request->isMethod('post')||$request->segment(2)=="mobile") {
        $validator = Validator::make($request->all(), [
          'total_price' => 'required',
          'accept_gighanter_note' => 'required',
          'accept_flexigigs_terms' => 'required',
          'payment_method' => 'required',
        ])->validate();
        $dataToStore = ['item_id'=>$application->id,
                        'customer_id'=>$application->customer_id,
                        'supplier_id'=>$application->supplier_id,
                        'delivery_at'=>$application->deadline,
                        'type'=>2,
                        'status'=>2,
                      ];
        $data['order'] = $order = Orders::create($dataToStore); 

        $item_type = ($order->type==1)?"service":'gig';
        $item_data = ($order->type==1)?$order->request:$order->application;
        // for testing
        if($request->semulate){
          $dataToStore = ['status'=>2,'falier'=>0,'paymeny'=>'PAID','payment_method'=>'Fawry','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345'];
          // Orders::where(['id'=>$id])->update(['status'=>1,'payment'=>'NEW','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345']);
        }else{
          $dataToStore = ['status'=>1,'falier'=>1,'paymeny'=>'CANCELED','payment_method'=>'Fawry','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345'];
          // Orders::where(['id'=>$id])->update(['status'=>1,'payment'=>'NEW','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345']);
        }
        Orders::find($order->id)->update($dataToStore);
        return redirect()->route('applicationReturn', ['application_id'=>$application->id, 'transaction_token'=>$application->transaction_token,'vpc_TxnResponseCode' =>$request->semulate]);
        // real payment
        // $fawry = new Fawry();
        // return redirect($fawry->checkOutLink($item_type,$item_data,route('payment_callback',['order_id'=>$order->id]),app()->getLocale()));
      }
     return view('checkout.confirmation.application',$data);
   }
   public function callback(Request $request)
     {
      if ($request->application_id&&$request->transaction_token) {
        $data['application'] = $application = Applications::where(['id'=>$request->application_id,'transaction_token'=>$request->transaction_token])
                                                          ->with(['supplier','gig.skills.category','gig.attach','customer'])
                                                          ->first();
      
        if ($application->status!=0){
          if ($request->segment(2)=="mobile") {
            $data['status'] = false;
            $data['message'] = 'this application is already acepted and paid';
            return response()->json($data,400);
          }else{
            abort(404);          
          }
        }
        if (!$request->vpc_TxnResponseCode) {
            $data['status'] = false;
            $data['message'] = 'payment refused';
            return ($request['is_api'])?response()->json($data,400):view('checkout.payment_callback.application_refused',$data);
        }else{
          Applications::where(['id'=>$request->application_id,'transaction_token'=>$request->transaction_token])->update(['status'=>1]);
          Gigs::where('id',$application->gig_id)->update(['status'=>1]);
          $data['order'] = $order = Orders::where(['type'=>2,'item_id'=>$request->application_id])->first();
          $noti = new \App\Http\Controllers\NotificationController();
          $noti->application​Accepted($application->customer,$application->supplier,$application->gig,$order);
          return ($request->segment(2)=="mobile")?response()->json($data,200):view('checkout.payment_callback.application',$data);
        }
      }else{
        abort(404);
      }
     }
     public function delete(Request $request ,$id=null)
     {
        $application = Applications::where('id',$id)->first();
       if (count($application)) {
          if($request['is_api']){
            Applications::where('id',$id)->delete();
            // $noti = new \App\Http\Controllers\NotificationController();
            // $noti->cancelApplication​($application->customer,$application->gig);
            $data['status']=true;
            $data['message']='deleted with success';
            return response()->json($data,200);
          }
        }else{
            $data['status']=false;
            $data['message']='Record not found';
            return response()->json($data,400);
        }
     }

  
}
