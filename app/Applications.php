<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Flexihelp;

class Applications extends Model
{
    protected $fillable = ['gig_id','customer_id', 'supplier_id','status','notes','transaction_token','title','price','description','deadline'];
    protected $appends = ['price_data'];
    public function supplier() {
     return $this->belongsTo(User::class, 'supplier_id');
    }
    public function customer() {
     return $this->belongsTo(User::class, 'customer_id');
    }
    public function skills() {
       return $this->hasMany(Gigskills::class,'gigs_id','gig_id');
    }
    public function gig() {
     return $this->belongsTo(Gigs::class,'gig_id','id');
    }
    public function order() {
     return $this->belongsTo(Orders::class,'item_id');
    }
    public function getPriceDataAttribute()
    {
       return Flexihelp::fixprice($this,'gig');
    }
}
