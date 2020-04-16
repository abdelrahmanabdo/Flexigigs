<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Request as ServiceRequest;
use App\Service;
use App\User;
use App\Orders;
use App\Category;
use App\ServiceVideo;
use App\Helpers\Flexihelp;
use App\Helpers\Fawry;
use App\ServicePhoto;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;
use Omnipay\Migs\Message\AbstractRequest;

class RequestsController extends Controller
{

  public function requestService(Request $request,$id){
    $service = Service::find($id);
    if (empty($service))
      abort(404);
    $data['sub_slug'] = $sub_cat= Category::where('id',$service['category_id'])->first();
    $data['parent_slug'] = Category::where('id',$sub_cat['parent_id'])->first();
    if ($service) {
      $data['status'] = true;
      $data['service'] = $service;
      $price = Flexihelp::fixprice($service,'service');
      $data['servicefee'] = $price->price;
      $data['handlingfee'] =$price->handling ;
      $data['handlingcommission'] = config('site_settings.commission.gig.handling')*100;
      $data['totalfee'] = $price->total_handling;
      $data['user'] = User::find($service['supplier_id']);
      $data['category'] = Category::find($service['category_id']);
      if ($request->isMethod("post")||($request->isMethod("get")&&$request->segment(1)=="api")) {
        $roles = [
          'answer1' => 'required|max:255',
          'notes' => 'required',
          // 'delvery_time' => 'required',
          'total_price' => 'required',
          'accept_gigger_terms' => 'required',
          'accept_flexigigs_terms' => 'required',
        ];
        if($service->price_unit=='hour')
          $roles['delivery_at'] = 'required';
        if ($request->segment(1)=="api") 
          $roles['customer_id'] = 'required';
        if ($service->question2)
          $roles['answer2'] = 'required|max:255';
        if ($service->question3)
          $roles['answer3'] = 'required|max:255';
          $validator = Validator::make($request->all(),$roles);
          if ($validator->fails()) {
            if ($request->segment(1)=="api") {
              if ($validator->fails()) {
                $errors['status']=false;
                $errors['message']= $validator->errors()->toArray();
                return response()->json($errors,422);
              }
            }else{
              return redirect()->back()->withErrors($validator)->withInput();
            }
          }
          $customer_id = ($request->customer_id)?$request->customer_id:Auth::user()->id;
          $dataToStore = ['service_id'=>$id,
                          'supplier_id'=>$service->supplier_id,
                          'customer_id'=>$customer_id,
                          'price'=>$price->total_handling_payment,
                          'notes'=>$request->notes,
                          'answer1'=>$request->answer1,
                          'answer2'=>$request->answer2,
                          'answer3'=>$request->answer3,
                          'name'=>$service->name,
                          'category_id'=>$service->category_id,
                          'price_unit'=>$service->price_unit,
                          'price_per_unit'=>$service->price_per_unit,
                          'days_to_deliver'=>$service->days_to_deliver,
                          'description'=>$service->description,
                          'terms'=>$service->terms,
                          'question1'=>$service->question1,
                          'question2'=>$service->question2,
                          'question3'=>$service->question3,
                          'transaction_token'=>str_random(60),
                          'status'=>0
                        ];
          $data['service_request'] = $service_request = ServiceRequest::create($dataToStore);
          $delvery_time = ($service_request->price_unit=="project")?date('Y-m-d h:i:s',strtotime(date('Y-m-d h:i:s')."+".$service_request->days_to_deliver." days")):$request->delivery_at;
          $orderToStore = ['item_id'=>$service_request->id,
                          'customer_id'=>$service_request->customer_id,
                          'supplier_id'=>$service_request->supplier_id,
                          'delivery_at'=>$delvery_time,
                          'type'=>1];
          $data['order'] = $order = Orders::create($orderToStore);
          // for bank method check bank.txt (old method)
          if ($request->segment(1)=="api") {
            return response()->json($data,200);
          }else{
            return redirect()->route('request_callback',['order_id'=>$order->id]);
          }
        }
        if ($request->segment(1)=="api") {
          return response()->json($data , 200);
        }else{
          return view('checkout.confirmation.request',$data);
        }
    }else{
      if ($request->segment(1)=="api") {
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 400);
      }else{
        abort(404);
      }
    }
  }
  
  public function requestCallback(Request $request,$id)
  {
    $data['order'] = $order = Orders::find($id);
    if ($order){
      $noti = new \App\Http\Controllers\NotificationController();
      $noti->requestCallback($order);
      if($request->segment(2)=="mobile"){
        $data['status'] = true;
        return response()->json($data,200);
      }
    }else{
      if($request->segment(2)=="mobile"){
        $data['status'] = false;
        $data['message']='record not found';
        return response()->json($data,400);
      } else{
        abort(404);
      }
    }
    return view('checkout.callback.request',$data);
  }

  public function proceed_to_payment(Request $request,$id)
  {
    $data['order'] = $order = Orders::where('id',$id)->first();
    $order->request->subsub_cat = Category::find($order->request->category_id); 
    $order->request->sub_cat = Category::find($order->request->subsub_cat['parent_id']); 
    if ($order->request->sub_cat['parent_id']==0) {
      $order->request->parent_cat = $order->request->sub_cat; 
      $order->request->sub_cat = $order->request->subsub_cat; 
    }else{
      $order->request->parent_cat = Category::find($order->request->sub_cat['parent_id']); 
    }
    if ($order){
      $item_type = ($order->type==1)?"service":'gig';
      $item_data = ($order->type==1)?$order->request:$order->application;
      $fawry = new Fawry();
      $data['fawryLink'] = $fawry->checkOutLink($item_type,$item_data,route('payment_callback',['order_id'=>$order->id]),app()->getLocale());
      if($request->segment(2)=="mobile"){
        $data['status'] = true;
        return response()->json($data,200);
      }
    }else{
      if($request->segment(2)=="mobile"){
        $data['status'] = false;
        $data['message']='record not found';
        return response()->json($data,400);
      } else{
        abort(404);
      }
    }
    return view('checkout.payment_method.proceed_to_payment',$data);
  }

   public function requestReturn(Request $request,$id)
   {
      $data['order'] = $order = Orders::find($id);
      if ($order){
          // online handling
          // Orders::where(['id'=>$id])->update(['status'=>1,'payment'=>$request->,'fawryRefNo'=>'$request->fawryRefNo','MerchnatRefNo'=>$request->MerchnatRefNo]);
        if($request->semulate||($request['is_api']&&$request->status==2)){
          $dataToStore = ['status'=>2,'falier'=>0,'paymeny'=>'PAID','payment_method'=>'Fawry','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345'];
          $noti = new \App\Http\Controllers\NotificationController();
          $noti->proceed_to_payment($order);
          // Orders::where(['id'=>$id])->update(['status'=>1,'payment'=>'NEW','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345']);
        }else{
          $dataToStore = ['status'=>1,'falier'=>1,'paymeny'=>'CANCELED','payment_method'=>'Fawry','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345'];
          $noti = new \App\Http\Controllers\NotificationController();
          $noti->paymentNoActionGH($order);
          $noti = new \App\Http\Controllers\NotificationController();
          $noti->paymentNoActionHH($order);
          // Orders::where(['id'=>$id])->update(['status'=>1,'payment'=>'NEW','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345']);
        }
        Orders::find($order->id)->update($dataToStore);
        // handle testing fawry
        // Orders::where(['id'=>$id])->update(['status'=>1,'payment'=>'NEW','fawryRefNo'=>'2232434','MerchnatRefNo'=>'345345']);
      }else{
        abort(404);
      }
     return ($request['is_api'])?response()->json($data,200):view('checkout.payment_callback.request',$data);
   }
  
}
