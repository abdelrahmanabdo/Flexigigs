<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePhoto extends Model
{

      protected $table = 'servicepics';
	  protected $fillable = ['filename','service_id'];

      public function service()
    {
     return $this->belongsTo(Service::class);
    }
}
