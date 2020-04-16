<?php 
namespace App;

use Zizaco\Entrust\EntrustPermission;
class Permission extends EntrustPermission
{
	public function permission()
    {
	   return $this->hasOne(PermissionRole::class);

     // return $this->belongsTo(PermissionRole::class);
    }
}