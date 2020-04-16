<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Flexihelp;

class Request extends Model
{
     protected $fillable = [
    'service_id', 'supplier_id', 'customer_id', 'price','delivery_date','notes',
    'answer1','answer2','answer3','name','category_id',
    'price_unit','price_per_unit','days_to_deliver','description','terms','question1','question2',
    'question3','transaction_token'];
    protected $appends = ['price_data'];
    public function supplier() {
     return $this->belongsTo(User::class, 'supplier_id');
    }
    public function customer() {
     return $this->belongsTo(User::class, 'customer_id');
    }
    public function service() {
     return $this->belongsTo(Service::class);
    }
    public function order() {
     return $this->belongsTo(Orders::class,'item_id');
    }
    public function category()
    {
     return $this->belongsTo(Category::class, 'category_id');
    }
    public function getPriceDataAttribute()
    {
       return Flexihelp::fixprice($this,'service');
    }
}
