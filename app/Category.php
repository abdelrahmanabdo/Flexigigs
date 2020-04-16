<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [
              'name','name_ar', 'parent_id', 'intro', 'intro_ar', 'email', 'icon', 'icon_web','image','featured','ordernum' ,'slug', 'keywords'];
    public function services()
    {
     return $this->hasMany(Service::class,'category_id','id');
    }
}
