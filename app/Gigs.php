<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Flexihelp;

class Gigs extends Model
{
	protected $fillable = ['customer_id', 'title', 'price', 'description', 'deadline', 'status'];
  protected $appends = ['price_data','desc','gig_status'];

    public function attach() {
       return $this->hasMany(Gigattach::class);
    }
    public function skills() {
       return $this->hasMany(Gigskills::class);
    }
    public function supplier_type() {
       return $this->hasMany(Gigsuppliertype::class);
    }
    public function customer() {
     return $this->belongsTo(User::class, 'customer_id');
    }
    public function applications() {
       return $this->hasMany(Applications::class,'gig_id');
    }
    public function order() {
       return $this->hasOne(Orders::class,'item_id');
    }
    public function getPriceDataAttribute()
    {
       return Flexihelp::fixprice($this,'gig');
    }
    public function getDescAttribute()
    {
       return nl2br($this->description);
    }
    public function getGigStatusAttribute()
    {
      if ($this->status == 0)
        return trans('gigs.dashboard_customer_posts_gig_info.status.opened');
      elseif ($this->status == 5)
        return trans('gigs.dashboard_customer_posts_gig_info.status.canceld');
      elseif ($this->status >= 1)
        return trans('gigs.dashboard_customer_posts_gig_info.status.closed');
    }
}