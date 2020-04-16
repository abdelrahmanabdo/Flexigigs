<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Orders extends Model
{
    protected $table = 'orders';
	protected $fillable = ['type','item_id','status','falier','admin_actions','customer_id','supplier_id','delivery_at','claim_refund','notes','payment','payment_method','fawry_number','fawryRefNo'];
    protected $appends = ['order_status','order_hhmessage','order_ghmessage','delivery_status','refund_status'];
    
	public function supplier() {
    	return $this->belongsTo(User::class,'supplier_id');
    }
    public function customer() {
    	return $this->belongsTo(User::class,'customer_id');
    }
    public function request() {
    	return $this->belongsTo(Request::class,'item_id');
    }
    public function application() {
    	return $this->belongsTo(Applications::class,'item_id');
    }
    public function conflects() {
        return $this->hasMany(Messages::class,'order_id');
    }
    public function cus_review() {
        return $this->hasOne(Reviews::class,'order_id')->where('type',2);
    }
    public function ser_review() {
        return $this->hasOne(Reviews::class,'order_id')->where('type',1);
    }
    public function getDeliveryStatusAttribute()
    {
        $data['created_exed_24hh'] = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->updated_at."+1 days"))&&$this->status==1)?true:false;
        $data['created_exed_24gh'] = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->updated_at."+1 days"))&&$this->status==0)?true:false;
        $current = Carbon::now();
        $after_2days  = Carbon::create(date('Y',strtotime($this->delivery_at)),date('m',strtotime($this->delivery_at)),date('d',strtotime($this->delivery_at)))->addDay(2)->format('Y-m-d');
        $before_2days = Carbon::create(date('Y',strtotime($this->delivery_at)),date('m',strtotime($this->delivery_at)),date('d',strtotime($this->delivery_at)))->subDay(2)->format('Y-m-d');
        $after_4days  = Carbon::create(date('Y',strtotime($this->delivery_at)),date('m',strtotime($this->delivery_at)),date('d',strtotime($this->delivery_at)))->addDay(4)->format('Y-m-d');
        $data['current'] = $current->format('Y-m-d');
        $data['after_2daystime'] = $after_2days;
        $data['after_4daystime'] = $after_4days;    
        // get exeed deadline
        $data['exeed_deadline'] = ($this->delivery_at <= $current->format('Y-m-d'))?true:false;
        // get delevery status before 2 days
        $data['before_2days']   = ($before_2days <= $current->format('Y-m-d')&&
                                   $before_2days >= $current->format('Y-m-d'))?true:false;
        // get delevery status in day
        $data['in_day']         = ($this->delivery_at <= $current->format('Y-m-d') &&
                                   $this->delivery_at >= $current->format('Y-m-d'))?true:false;
        // get delevery status after 2 days
        $data['after_2days']    = ($after_2days  < $current->format('Y-m-d')&&
                                   $after_4days  > $current->format('Y-m-d'))?true:false;
        // get delevery status after 4 days
        $data['after_4days']    = ($after_4days <= $current->format('Y-m-d'))?true:false;
        return (object)$data;
    }
    public function getOrderStatusAttribute()
    {
        $exed_24h = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->updated_at."+1 days")))?true:false;
        $exed_4d = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->delivery_at."+4 days")))?true:false;
        if($this->admin_actions==1)
            return trans('orders.admin_mark_completed');
        if($this->admin_actions==2)
            return trans('orders.admin_cancel_order');
        if ($this->falier==1) 
            return trans('orders.GH_reject_order');
        if ($this->falier==2) 
            return trans('orders.HH_reject_pay_for_order');
        if ($this->falier==3) 
            return trans('orders.GH_brake_deadline');
        if ($this->falier==4) 
            return trans('orders.HH_had_conflect');
        if ($this->falier==5) 
            return trans('orders.GH_had_conflect');
        if($exed_24h && $this->status==0)
            return trans('orders.GH_not_accepted_for_24');
        if ($this->status==0) 
            return trans('orders.HH_order');
        if($exed_24h && $this->status==1)
            return trans('orders.HH_not_pay_for_order_24');
        if ($this->status==1) 
            return trans('orders.GH_accept_order');
        if($this->claim_refund==1 && $this->status==2)
            return trans('orders.cancle_and_refunded');
        if($exed_4d && $this->status==2)
            return trans('orders.exed_delevery_8');

        if ($this->status==2) 
            return trans('orders.HH_pay_for_order');
        if ($this->status==3) 
            return trans('orders.GH_says_order_done');
        if ($this->status==4) 
            return trans('orders.HH_says_confirm_done');
        if ($this->status==5) 
            return trans('orders.Admin_transfare_mony_to_GH');
    }
    public function getOrderHhmessageAttribute()
    {
        $exed_24h = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->updated_at."+1 days")))?true:false;
        $exed_4d = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->delivery_at."+4 days")))?true:false;
        if ($this->status==0) 
            return trans('orders.hhmessage.HH_order');
        if($exed_24h && $this->status==1){
            //which mean HH didn't pay
            $this->falier = 6 ;
            return trans('orders.hhmessage.HH_not_pay_for_order_24');
        }
        if ($this->status==1) 
            return trans('orders.hhmessage.GH_accept_order');
        if($exed_4d && $this->status==2)
            return trans('orders.hhmessage.exed_delevery_8');
        if ($this->status==2) 
            return trans('orders.hhmessage.HH_pay_for_order');
        if ($this->status==3) 
            return trans('orders.hhmessage.GH_says_order_done');
        if ($this->status==4) 
            return trans('orders.hhmessage.HH_says_confirm_done');
        if ($this->status==5) 
            return trans('orders.hhmessage.Admin_transfare_mony_to_GH');
    }
    public function getOrderGhmessageAttribute()
    {
        $exed_24h = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->updated_at."+1 days")))?true:false;
        $exed_4d = (date('Y-m-d h:i:s') > date('Y-m-d h:i:s',strtotime($this->delivery_at."+4 days")))?true:false;
        // osman edits
        if($exed_24h && $this->status==0)
            return trans('orders.ghmessage.GH_not_replay_for_order_24');


        if ($this->status==0) 
            return trans('orders.ghmessage.HH_order');
        if ($this->status==1) 
            return trans('orders.ghmessage.GH_accept_order');
        if($exed_4d && $this->status==2)
            return trans('orders.ghmessage.exed_delevery_8');
        if ($this->status==2) 
            return trans('orders.ghmessage.HH_pay_for_order');
        if ($this->status==3) 
            return trans('orders.ghmessage.GH_says_order_done');
        if ($this->status==4) 
            return trans('orders.ghmessage.HH_says_confirm_done');
        if ($this->status==5) 
            return trans('orders.ghmessage.Admin_transfare_mony_to_GH');
    }
    public function getRefundStatusAttribute()
    {
        if ($this->claim_refund==1) 
            return trans('general.refund.status.toRefund');
        if ($this->claim_refund==2) 
            return trans('general.refund.status.refund');
    }
}
