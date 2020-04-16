<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceVideo extends Model
{

      protected $table = 'serviceveds';

      protected $fillable = ['url'];

      public function service()
    {
     return $this->belongsTo(Service::class);
    }
}
