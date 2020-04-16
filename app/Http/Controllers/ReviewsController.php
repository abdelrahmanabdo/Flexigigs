<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Flexihelp;
use App\User;
use App\Reviews;
use App\Service;
use App\Orders;
use App\Gigs;
use Intervention\Image\ImageManagerStatic as Image;
use DB;
class ReviewsController extends Controller
{
  public function reviews(Request $request)
  {
    $limit = ($request->limit)?$request->limit:10;
    $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
    $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
    $where  = [];
    // prepare search 
    if($request->date_from)
      $where[] = ['created_at','>=',$date_from];
    if($request->date_to)
      $where[] = ['created_at','<=',$date_to];
    if($request->type)
      $where[] = ['type',$request->type];
    if($request->order_id)
      $where[] = ['order_id',$request->order_id];
    // start query
    $reviews = Reviews::where($where)->with(['service','gig','supplier','user','order']);
    // search by username in 2 relation
    // if it customer review service/gig
    if ($request->type == 1) {
      if($request->user_from){
        $reviews->whereHas('user',function ($query) use($request) { 
          $query->where('username','like','%'.$request->user_from.'%');
        });
      }
      if($request->user_to){
        $reviews->whereHas('supplier',function ($query) use($request) {
          $query->where('username','like','%'.$request->user_to.'%');
        });
      }
    // if it supplier review customer
    }elseif($request->type == 2){
      if($request->user_from){
        $reviews->whereHas('supplier',function ($query) use($request) { 
          $query->where('username','like','%'.$request->user_from.'%');
        });
      }
      if($request->user_to){
        $reviews->whereHas('user',function ($query) use($request) {
          $query->where('username','like','%'.$request->user_to.'%');
        });
      }
    }
    $data['reviews'] =$reviews->paginate($limit)
                              ->appends(['date_from'=>$request->date_from,
                                         'date_to'=>$request->date_to,
                                         'user_from'=>$request->user_from,
                                         'user_to'=>$request->user_to,
                                         'order_id'=>$request->order_id,
                                         'type'=>$request->type,
                                        ]);
    $errors['status'] = false;
    $errors['message'] = 'no reviews match your request';
    return ($reviews)?response()->json($data,200):response()->json($errors,400);
  }

  public function add(Request $request , $type) {
    $validator = Validator::make($request->all(), [
      'rate' => 'required|max:1',
      'comment' => 'required|max:2500'
    ]);
    if ($validator->fails()) {
      $data['status']=false;
      $data['message']= $validator->errors()->toArray();
      return response()->json($data,422);
    }
    $order = Orders::where('id',$request->order_id)->first();
    $dataToStore = $request->except('exeed_limit');
    $dataToStore['type'] = $type;
    // customer reviewing service or gig
    if ($type == 1) {
      if ($order->type==1) {
        $service = Service::where('id',$request->item_id)->first();
        if (!$service) {
          $data['status'] = false;
          $data['mesasge'] = 'service not found';
          return response()->json($data,400);
        }
      }else{
        $gig = Gigs::where('id',$request->item_id)->first();
        if (!$gig) {
          $data['status'] = false;
          $data['mesasge'] = 'Gig not found';
          return response()->json($data,400);
        }
      }
    // supplier reviewing customer
    }else{
      $customer = User::where('id',$request->user_id)->first();
      if (!$customer) {
        $data['status'] = false;
        $data['mesasge'] = 'customer not found';
        return response()->json($data,400); 
      }
    }
    $data['status'] = true;
    $data['reviews'] = $reviews = Reviews::create($dataToStore);
    if ($order->type == 1) {
      $rate = round(Reviews::where(['type'=>1,'item_id'=>$request->item_id])->orderBy('created_at','desc')->avg('rate'));
      Service::where('id',$request->item_id)->update(['rating'=>$rate]);
    }
    $noti = new \App\Http\Controllers\NotificationController();
    $noti->SendNewReview($reviews);
    return response()->json($data,200);
  }

  public function edit(Request $request , $id) {
    $review = Reviews::where('id',$id)->first();
    if ($review) {
      $validator = Validator::make($request->all(), [
        'rate' => 'required|max:1',
        'comment' => 'required|max:2500'
      ]);
      if ($validator->fails()) {
        $data['status']=false;
        $data['message']= $validator->errors()->toArray();
        return response()->json($data,422);
      }
      $dataToStore = $request->except('is_api','_token','exeed_limit');
      Reviews::where('id',$id)->update($dataToStore);
      if ($review->order->type == 1) {
        $rate = round(Reviews::where(['type'=>1,'item_id'=>$review->item_id])->orderBy('created_at','desc')->avg('rate'));
        Service::where('id',$review->item_id)->update(['rating'=>$rate]);
      }
      $data['status'] = true;
      $data['reviews'] = Reviews::where('id',$id)->first();
      return response()->json($data,200);
    }else{
      $data['status'] = false;
      $data['message'] = 'record not found';
      return response()->json($data,200);
    }
  }

  public function delete(Request $request , $id) {
    $review = Reviews::where('id',$id)->first();
    if ($review) {
      Reviews::where('id',$id)->delete();
      $data['status'] = true;
      $data['message'] = "review deleted with success";
      return response()->json($data,200);
    }else{
      $data['status'] = false;
      $data['message'] = 'record not found';
      return response()->json($data,200);
    }
  }
}
