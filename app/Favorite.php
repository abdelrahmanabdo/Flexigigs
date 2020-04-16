<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	public function user() {
     return $this->belongsTo(user::class);
    }
    public function service()
    {
       return $this->belongsTo(Service::class,'service_id');
    }
}
