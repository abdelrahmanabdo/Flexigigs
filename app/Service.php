<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Flexihelp;

class Service extends Model
{
  protected $fillable = [
    'name', 'supplier_id', 'category_id', 'price_unit','price_per_unit',
  'days_to_deliver','description','terms','question1','question2','question3'];
  protected $appends = ['price_data','rate','desc','terms_handle'];

    public function user()
    {
     return $this->belongsTo(User::class, 'supplier_id');
    }
    public function category()
    {
     return $this->belongsTo(Category::class, 'category_id');
    }
    public function photos()
    {
       return $this->hasMany(ServicePhoto::class);
    }
    public function videos()
    {
       return $this->hasMany(ServiceVideo::class);
    }
    public function requests()
    {
       return $this->hasMany(Request::class);
    }
    public function requests_done()
    {
      return $this->hasMany(Request::class,'service_id')->where('status','>',2);
    }
    public function favorites()
    {
       return $this->hasMany(Favorite::class);
    }
    public function reviews()
    {
       return $this->hasMany(Reviews::class,'item_id')->where('type',1)->limit(5)->orderBy('created_at','desc');
    }
    public function allreviews()
    {
       return $this->hasMany(Reviews::class,'item_id')->where('type',1)->orderBy('created_at','desc');
    }
    public function getPriceDataAttribute()
    {
       return Flexihelp::fixprice($this,'service');
    }
    public function getRateAttribute()
    {
      return $this->rating;
    }
    public function getDescAttribute()
    {
       return nl2br($this->description);
    }
    public function getTermsHandleAttribute()
    {
       // return nl2br($this->description);
       return nl2br($this->terms);
    }
}
