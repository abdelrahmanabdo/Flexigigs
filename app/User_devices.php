<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class User_devices extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','device_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function user()
    {
       return $this->hasMany(User::class);
    }    
}
