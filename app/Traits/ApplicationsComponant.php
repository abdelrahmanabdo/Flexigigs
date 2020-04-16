<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Applications;
use App\Orders;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait ApplicationsComponant{
	
	public function store_application(Request $request,$gig,$supplier_id)
	{
    
		$validator = Validator::make($request->all(), [
          'notes' => 'required',
          'delivery_date' => 'required',
          'gig_price' => 'required',
        ]);
        if ($request['is_api']) {
          if ($validator->fails()) {
            $error['status']=false;
            $error['message']= $validator->errors()->toArray();
            return response()->json($error,422);
          }
        }else{
          $validator->validate();
        }
        $application_check = Applications::where(['gig_id'=>$gig->id,'supplier_id'=>$supplier_id])->first();
        if (!$application_check) {
        	$dataTostore = ['title'=>$gig->title,
        					'price'=>$gig->price,
        					'description'=>$gig->description,
        					'deadline'=>$gig->deadline,
        					'gig_id'=>$gig->id,
                  'customer_id'=>$gig->customer_id,
                  'supplier_id'=>$supplier_id,
                  'notes'=>$request->notes,
                  'transaction_token'=>str_random(60)];
	        $data['applications'] = $applications = Applications::create($dataTostore);
          	if ($applications) {
	            $noti = new \App\Http\Controllers\NotificationController();
	            $noti->SendNewApplication($gig->customer,$gig,$applications);
          	}
        }
       if ($request['is_api']) {
         $data['message'] = 'application created'; 
       }else{
          return back()->with('applications_created', true);
        }
	}
}