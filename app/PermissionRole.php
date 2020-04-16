<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{

      protected $table = 'permission_role';
	  protected $fillable = ['permission_id','role_id'];

    public function role()
    {
     return $this->belongsTo(Role::class);
    }
    public function permission()
	{
     return $this->belongsTo(Permission::class);

	   // return $this->hasOne(Permission::class);
	}
    
}
