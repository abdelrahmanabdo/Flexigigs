<?php
 namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

 	protected $fillable = ['name','display_name','description', 'delete'];
	 public function permissionrole()
	{
	   return $this->hasMany(PermissionRole::class);
	}
}