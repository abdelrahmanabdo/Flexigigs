<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
     protected $fillable = ['user_id','supplier_id','item_id','order_id','rate','notes','comment','type'];
    public function user() {
     return $this->belongsTo(User::class, 'user_id');
    }
    public function customer() {
     return $this->belongsTo(User::class, 'item_id')->where('type', 2);
    }
    public function supplier() {
     return $this->belongsTo(User::class, 'supplier_id');
    }
    public function service() {
     return $this->belongsTo(Service::class,'item_id');
    }
    public function gig() {
     return $this->belongsTo(Gigs::class,'item_id');
    }
    public function application() {
     return $this->belongsTo(Applications::class,'item_id','gig_id');
    }
    public function order() {
     return $this->belongsTo(Orders::class,'order_id');
    }
}
