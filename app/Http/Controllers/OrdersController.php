<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Gigs;
use App\Service;
use App\Gigattach;
use App\Gigskills;
use App\User;
use App\Category;
use App\Applications;
use App\Orders;
use App\Request as ServiceRequest;
use App\Helpers\Flexihelp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;

class OrdersController extends Controller
{
	public function orderRejection(Request $request ,$order_id = null)
	{
	  	$validator = Validator::make($request->all(),['falier'=>'required']);
		if ($validator->fails()) {
	        $data['status']=false;
	        $data['message']= $validator->errors()->toArray();
	        return response()->json($data,422);
	    }
	    // finding the order with this id
  		$order = Orders::where('id',$order_id)->with(['supplier','customer','request','application.gig'])->first();
	    if ($order->type == 1) {
			// will it`s request
		    // if ==============================>order delevery
		    if ($request->falier == 1) {
		    	// change request falier = 2 and order falier = 2
		    	Orders::where('id',$order_id)->update(['falier'=>$request->falier]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->orderRejected($order);
		      // elseif ==========================>order finished
		    }
	  		// finding the order with this id
	  		$order = Orders::where('id',$order_id)->with(['supplier','customer','request','application.gig'])->first();
	  		// if not found
	  		if(!$order){
	  			$data['status'] = false;
			    $data['message'] = "record not found";
			    return response()->json($data,400); 
	  		}

	      $data['status'] = true;
	      return response()->json($data,200);
		}
	}
	public function orderExtendDeadline(Request $request ,$order_id = null)
	{
	  	$validator = Validator::make($request->all(),['delivery_at'=>'required']);
		if ($validator->fails()) {
	        $data['status']=false;
	        $data['message']= $validator->errors()->toArray();
	        return response()->json($data,422);
	    }
	    // finding the order with this id
  		$order = Orders::where('id',$order_id)->with(['supplier','customer','request','application.gig'])->first();
	    if ($order) {
	    	Orders::where('id',$order_id)->update(['delivery_at'=>$request->delivery_at]);
		    // $noti = new \App\Http\Controllers\NotificationController();
		    // $noti->orderRejected($order);
		    // finding the order with this id
	  		$data['order'] = Orders::where('id',$order_id)->with(['supplier','customer','request','application.gig'])->first();
	      	$data['status'] = true;
	      	/*Osman edits 27/9 */
	      	$noti = new \App\Http\Controllers\NotificationController();
            $noti->DeadlineExtension($data['order']);
            /*********************/
	      	return response()->json($data,200);
		}else{
	  		// if not found
  			$data['status'] = false;
		    $data['message'] = "record not found";
		    return response()->json($data,400); 
  		}
	}
	public function claim_refund(Request $request ,$order_id = null)
	{
	  	$validator = Validator::make($request->all(),['claim_refund'=>'required']);
		if ($validator->fails()) {
	        $data['status']=false;
	        $data['message']= $validator->errors()->toArray();
	        return response()->json($data,422);
	    }
	    // finding the order with this id
  		$order = Orders::where('id',$order_id)->with(['supplier','customer','request','application.gig'])->first();
	    if ($order) {
	    	Orders::where('id',$order_id)->update(['claim_refund'=>$request->claim_refund]);
		    // $noti = new \App\Http\Controllers\NotificationController();
		    // $noti->orderRejected($order);
		    // finding the order with this id
	  		$data['order'] = Orders::where('id',$order_id)->with(['supplier','customer','request','application.gig'])->first();
	      	$data['status'] = true;
	      	/*Osman edits 27/9 */
	      	$noti = new \App\Http\Controllers\NotificationController();
            $noti->ClaimRefund($data['order']);
            /*********************/
	      	return response()->json($data,200);
		}else{
	  		// if not found
  			$data['status'] = false;
		    $data['message'] = "record not found";
		    return response()->json($data,400); 
  		}
	}
   	// going to move it to order Controller  and name it OrderStatus
  	public function orderStatus(Request $request ,$order_id = null)
  	{
  	$validator = Validator::make($request->all(),['status'=>'required']);
	if ($validator->fails()) {
        $data['status']=false;
        $data['message']= $validator->errors()->toArray();
        return response()->json($data,422);
     }
  		// finding the order with this id
  		$order = Orders::where('id',$order_id)->with(['supplier','customer','request','application.gig'])->first();
  		// if not found
  		if(!$order){
  			$data['status'] = false;
		    $data['message'] = "record not found";
		    return response()->json($data,400); 
  		}

  		// let`s check the order type
  		if ($order->type == 1) {
  			// will it`s request
		    // if ==============================>order delevery
		    if ($request->status == 1) {
		    	// change request status = 1 and order status = 1
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->OrderAccepted($order);
		      // elseif ==========================>order finished
		    }elseif ($request->status == 3) {
		    	// change request status = 2 and order status = 2
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
		    	ServiceRequest::where('id',$order->request->id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->OrderDelivery($order);
		      // elseif ==========================>order finished
		    }elseif ($request->status == 4) {
		    	// change request status = 3 and order status = 3
		    	Orders::where('id',$order_id)->update([
		    	    'status'=>$request->status,
                    'completed_at'=>date('Y-m-d G:i:s')
                ]);
		    	ServiceRequest::where('id',$order->request->id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->OrderFinished($order);
		      // elseif ==========================>order Admin mark completed 
		    }elseif ($request->status == 5) {
		    	// change request status = 4 and order status = 4
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
		    	ServiceRequest::where('id',$order->request->id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->markCompleted($order);
		      // elseif ==========================>order Admin Cancel order
		    }elseif ($request->status == 6) {
		    	// change request status = 5 and order status = 5
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
		    	ServiceRequest::where('id',$order->request->id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->cancelOrder($order);
		      // elseif ==========================>order Admin Change to paid
		    }elseif ($request->status == 7) {
		    	// change request status = 6 and order status = 6
		    	$validator = Validator::make($request->all(),['transaction_id'=>'required']);
		    	if ($validator->fails()) {
			        $data['status']=false;
			        $data['message']= $validator->errors()->toArray();
			        return response()->json($data,422);
			     }
		    	Orders::where('id',$order_id)->update(['status'=>$request->status,'transaction_id'=>$request->transaction_id]);
		    	ServiceRequest::where('id',$order->request->id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->changeToPaid($order);
		    }
      		$data['message']= "Request and order status updated";
  		}elseif($order->type == 2){
  			// so it`s accepted application
  			if ($request->status == 3) {
		    	// change gig status = 2 application status = 2 and order status = 2
		    	Gigs::where('id',$order->application->gig->id)->update(['status'=>$request->status]);
		    	Applications::where('id',$order->application->id)->update(['status'=>$request->status]);
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->OrderDelivery($order);
		      // elseif ==========================>order finished
		    }elseif ($request->status == 4) {
		    	// change gig status = 3 request status = 3 and order status = 3
		    	Gigs::where('id',$order->application->gig->id)->update(['status'=>$request->status]);
		    	Applications::where('id',$order->application->id)->update(['status'=>$request->status]);
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->OrderFinished($order);
		      // elseif ==========================>order Admin mark completed 
		    }elseif ($request->status == 5) {
		    	// change request status = 4 and order status = 4
		    	Gigs::where('id',$order->application->gig->id)->update(['status'=>$request->status]);
		    	Applications::where('id',$order->application->id)->update(['status'=>$request->status]);
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->markCompleted($order);
		      // elseif ==========================>order Admin Cancel order
		    }elseif ($request->status == 6) {
		    	// change request status = 5 and order status = 5
		    	Gigs::where('id',$order->application->gig->id)->update(['status'=>$request->status]);
		    	Applications::where('id',$order->application->id)->update(['status'=>$request->status]);
		    	Orders::where('id',$order_id)->update(['status'=>$request->status]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->cancelOrder($order);
		      // elseif ==========================>order Admin Change to paid
		    }elseif ($request->status == 7) {
		    	// change request status = 6 and order status = 6
		    	$validator = Validator::make($request->all(),['transaction_id'=>'required']);
		    	if ($validator->fails()) {
			        $data['status']=false;
			        $data['message']= $validator->errors()->toArray();
			        return response()->json($data,422);
			     }
		    	Gigs::where('id',$order->application->gig->id)->update(['status'=>$request->status]);
		    	Applications::where('id',$order->application->id)->update(['status'=>$request->status]);
		    	Orders::where('id',$order_id)->update(['status'=>$request->status,'transaction_id'=>$request->transaction_id]);
			    $noti = new \App\Http\Controllers\NotificationController();
			    $noti->changeToPaid($order);
		    }
      		$data['message']= "gig , application and order status updated";
  		}
  	
      $data['status'] = true;
      return response()->json($data,200);
	}
	public function mass_paid(Request $request)
    {
        return 1;
        if($request->order_id){
            Orders::whereIn('id', $request->order_id)->update(['status' => 6]);
        }
    }
	public function single(Request $request ,$id)
  	{
	  	$order = Orders::where('id',$id)->with(['supplier','customer','request','application.gig','cus_review','ser_review'])->first();
	  	if ($order->type == 1) {
	  		$data['sub_slug'] = $sub_cat= Category::where('id',$order->request->category_id)->first();
		   	$data['parent_slug'] = Category::where('id',$sub_cat['parent_id'])->first();
	  	}
	  	if ($order) {
	  		$data['status'] = true;
	  		$data['order'] = $order;
	  		$type = ($order->type == 1)?'service':"gig";
	        if ($type=='service' &&$order->request) {
	          $data['order']['pricedata'] = Flexihelp::fixprice($order->request,$type);
	        }elseif($type=='gig' &&$order->application->gig){
	          $data['order']['pricedata'] = Flexihelp::fixprice($order->application->gig,$type);
	        }
	  		return response()->json($data,200);
	  	}else{
	  		$data['status'] = false;
	  		$data['message'] = 'record not found';
	  		return response()->json($data,400);
	  	}
  	}
  	public function OrderByItemId(Request $request ,$item_id)
  	{
  		$type = ($request->type)?$request->type:1;
	  	$order = Orders::where(['item_id'=>$item_id,'type'=>$type])->first();
	  	if ($order) {
	  		$data['status'] = true;
	  		$data['order'] = $order;
	  		return response()->json($data,200);
	  	}else{
	  		$data['status'] = false;
	  		$data['message'] = 'record not found';
	  		return response()->json($data,400);
	  	}
  	}
  
	public function orders(Request $request)
  	{
	    // pagination
	    $page_num = ($request->page)?$request->page:1;
	    $limit = ($request->limit)?$request->limit:10;
	    $offset = $page_num*$limit;
	    // where
        $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
        $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
	    $where  = [];
	    if($request->date_from)
	      $where[] = ['created_at','>=',$date_from];
	    if($request->date_to)
	      $where[] = ['created_at','<=',$date_to];
	    if($request->status)
	      $where[] = ['status',$request->status];
	    if($request->type)
	      $where[] = ['type',$request->type];
	    // prepering model
	    $orders = Orders::with(['request.service','application.gig.skills.category','customer','supplier'])->where($where);
	    if($request->customer){
	      $orders->whereHas('customer',function ($query)use($request) {
	        $query->where('username','like','%'.$request->customer.'%');
	      });
	    }
	    if($request->supplier){
	      $orders->WhereHas('supplier',function ($query)use($request) {
	        $query->where('username','like','%'.$request->supplier.'%');
	      });
	    }


	 	 // dd($request->all());
	    
	    // sorting it
	    if($request->sort_by == "created_asc")
	      $orders->orderBy('created_at');
	    elseif($request->sort_by == "created_desc")
	      $orders->orderBy('created_at','DESC');
	    else
	      $orders->orderBy('created_at','DESC');


	    // boooooo fire 
	    $orders_result = $orders->paginate($limit)
	                            ->appends(['status'=>$request->status,
	                                       'date_from'=>$request->date_from,
	                                       'date_to'=>$request->date_to,
	                                       'type'=>$request->type,
	                                       'customer'=>$request->customer,
	                                       'supplier'=>$request->supplier,
	                                       'sort_by'=>$request->sort_by,
	                                      ]);
	    foreach ($orders_result as $order) {
	      if ($order->type == 1) {
	        $order->request->subsub_cat = Category::find($order->request->category_id); 
	        $order->request->sub_cat = Category::find($order->request->subsub_cat['parent_id']); 
	        if ($order->request->sub_cat['parent_id']==0) {
	          $order->request->parent_cat = $order->request->sub_cat; 
	          $order->request->sub_cat = $order->request->subsub_cat; 
	        }else{
	          $order->request->parent_cat = Category::find($order->request->sub_cat['parent_id']); 
	        }
	      }
	    }
	    // get max and min price in service
	    $service_min_price = Service::min('price_per_unit');
	    $service_max_price = Service::max('price_per_unit');
	    // get max and min price in service
	    $gig_min_price = Gigs::min('price');
	    $gig_max_price = Gigs::max('price');
	    // fire max and min price
	    $data['min_price'] = ($service_min_price<$gig_min_price)?$service_min_price:$gig_min_price;
	    $data['max_price'] = ($service_max_price<$gig_max_price)?$service_max_price:$gig_max_price;
	    // fire counter data
	    $data['counter_title'] = "Orders";
	    $data['counter'] = Orders::count();
	    // fire final order results 
	    $data['orders'] = $orders_result;
	    return ($request['is_api'])?response()->json($data,200):view('admin.orders.list',$data);
	}  
   public function exportorder(Request $request){
    // where
	$date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
	$date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
    $where  = [];
    if($request->date_from)
      $where[] = ['created_at','>=',$date_from];
    if($request->date_to)
      $where[] = ['created_at','<=',$date_to];
    if ($request->earning && !$request->status)
      $where[] = ['status','>=',3];
    elseif($request->status)
      $where[] = ['status',$request->status];
    if($request->type)
      $where[] = ['type',$request->type];
  	if ($request->claim_refund && $request->refund) 
  		$where[] = ['claim_refund',$request->claim_refund];
  	elseif($request->refund)
  		$where[] = ['claim_refund','>',0];
    // prepering model
    $orders = Orders::with(['request.service','application.gig','customer','supplier'])->where($where);
    if($request->supplier){
      $orders->WhereHas('supplier',function ($query)use($request) {
        $query->where('username','like','%'.$request->supplier.'%');
      });
    }
    if($request->customer){
      $orders->WhereHas('customer',function ($query)use($request) {
        $query->where('username','like','%'.$request->customer.'%');
      });
    }
    
    // sorting it
    if($request->sort_by == "created_asc")
      $orders->orderBy('created_at');
    elseif($request->sort_by == "created_desc")
      $orders->orderBy('created_at','DESC');
    else
      $orders->orderBy('created_at','DESC');
    // boooooo fire 
    $orders_result = $orders->get();
    if ($request->refund || ($request->earning && $request->payment_method == 1)){
		$result[] = ['Billing Account'=>'رقم البطاقة ',
	                 'Amount'=>'الفلوس',
	                 'ExtraInfoAr'=>'',
	                 'Issue date'=>'تاريخ الفاتورة',
	                 'Expiration Date'=>'تاريخ انتهاء الفاتورة ',
	                 'ExtraInfoEn'=>"",
	                 'Hidden Info'=>"",
	                 'BillRefNo'=>"",
	                 'Key1'=>'اسم العميل ',
	                 'Key2'=>"",
	                 'Key3'=>"",
	                 'Key4'=>"",
	                 'Key5'=>"",
	                ];

	}
    foreach ($orders_result as $order) {
    	if ($request->earning) {
	    	if($order->Status == 6)
    			$status = 'paid';
    		else
    			$status = 'due';
    	}else{
    	if($order->status == 1)
    		$status = 'Running';
    	if($order->status == 2)
    		$status = 'Done';
    	if($order->status == 3)
    		$status = 'Delevered';
    	if($order->status == 4)
    		$status = 'Marked Completed';
    	if($order->status == 5)
    		$status = 'Canceld';
    	if($order->status == 6)
    		$status = 'Finished';
    	}

    	if ($order->type == 1) {
    		if ($order->request) {
		    	$title = $order->request->name;
		    	$type = 'service';
		    	$price = ($order->request->price_per_unit == 'hour')?$order->request->price_per_unit*$order->request->days_to_deliver:$order->request->price_per_unit;
    		}
    	}else{
    		if ($order->application) {
	    		$title = $order->application->gig->title;
		    	$type = 'gig';
		    	$price = $order->application->gig->price;
    		}
    	}
    	if ($order->type == 1) {
    		if ($order->request) {
    			if ($request->refund) {
	    			$result[] = ['Billing Account'=>$order->fawryRefNo,
				                 'Amount'=>$price,
				                 'ExtraInfoAr'=>$order->customer->username,
 				                 'Issue date'=>date('Y/m/d',strtotime($order->created_at)),
				                 'Expiration Date'=>"",
				                 'ExtraInfoEn'=>"",
				                 'Hidden Info'=>"",
				                 'BillRefNo'=>"",
				                 'Key1'=>$order->customer->username,
				                 'Key2'=>"",
				                 'Key3'=>"",
				                 'Key4'=>"",
				                 'Key5'=>"",
				                ];

    			}
    			elseif ($request->earning) {
    			    if($request->payment_method == 1)
                    {
                        $result[] = ['Billing Account'=>$order->fawryRefNo,
                            'Amount'=>$price,
                            'ExtraInfoAr'=>$order->supplier->username,
                            'Issue date'=>date('Y/m/d',strtotime($order->completed_at)),
                            'Expiration Date'=>"",
                            'ExtraInfoEn'=>"",
                            'Hidden Info'=>"",
                            'BillRefNo'=>"",
                            'Key1'=>$order->supplier->username,
                            'Key2'=>"",
                            'Key3'=>"",
                            'Key4'=>"",
                            'Key5'=>"",
                        ];
                    }
                    else
                    {
                        $result[] = ['ID'=>$order->id,
                            'Title'=>$title,
                            'HH username'=>$order->customer->username,
                            'GH username'=>$order->supplier->username,
                            'price'=>$price,
                            'status'=>$status,
                            'type'=>$type,
                            'date request'=>$order->created_at,
                            'Beneficiary Name'=>$order->supplier->beneficiary_name,
                            'Account No.'=>$order->supplier->bank_account_number,
                            'IBAN'=>$order->supplier->iban,
                            'Bank Name'=>$order->supplier->bank_name,
                            'Bank Address'=>$order->supplier->banks_address,
                            'Swift Code'=>$order->supplier->swift_code,
                        ];
                    }

    			}else{
		    	$result[] = ['ID'=>$order->id,
			                 'Title'=>$title,
			                 'HH username'=>$order->customer->username,
			                 'GH username'=>$order->supplier->username,
			                 'price'=>$price,
			                 'status'=>$status,
			                 'type'=>$type,
			                 'date request'=>$order->created_at,
			                ];
    			}
			}
		}else{
			if ($order->application) {
		    	if ($request->refund) {
	    			$result[] = ['Billing Account'=>$order->fawryRefNo,
				                 'Amount'=>$price,
				                 'ExtraInfoAr'=>$order->customer->username,
				                 'Issue date'=>date('Y/m/d',strtotime($order->created_at)),
				                 'Expiration Date'=>"",
				                 'ExtraInfoEn'=>"",
				                 'Hidden Info'=>"",
				                 'BillRefNo'=>"",
				                 'Key1'=>$order->customer->username,
				                 'Key2'=>"",
				                 'Key3'=>"",
				                 'Key4'=>"",
				                 'Key5'=>"",
				                ];

    			}elseif ($request->earning) {
			    	$result[] = ['ID'=>$order->id,
				                 'Title'=>$title,
				                 'HH username'=>$order->customer->username,
				                 'GH username'=>$order->supplier->username,
				                 'price'=>$price,
				                 'status'=>$status,
				                 'type'=>$type,
				                 'date request'=>$order->created_at,
				                 'transaction_id'=>$order->transaction_id,
				                ];
    			}else{
			    	$result[] = ['ID'=>$order->id,
				                 'Title'=>$title,
				                 'HH username'=>$order->customer->username,
				                 'GH username'=>$order->supplier->username,
				                 'price'=>$price,
				                 'status'=>$status,
				                 'type'=>$type,
				                 'date request'=>$order->created_at,
				                ];
    			}
			}

		}
	}
    Excel::create('Orders '.$request->month, function($excel) use($result,$request) {
        $excel->sheet('Orders '.$request->month, function($sheet) use($result,$request) {
            $sheet->fromArray($result);
        });
        // Set the title
        $excel->setTitle('flexigigs system data exportation');
        // Chain the setters
        $excel->setCreator('Flexigigs')
              ->setCompany('road9media');
        // Call them separately
        $excel->setDescription('Orders of '.$request->month.' and filter result');

    })->download('xlsx');
  }
}
