<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
	protected $fillable = [	'id_from'	, 'id_to' , 'msg' , 'attach' ,'size','type', 'end_of_chat' ,'created_at','order_id','conflect'];

	public function message_from() {
     return $this->belongsTo(User::class, 'id_from');
    }
    public function message_to() {
     return $this->belongsTo(User::class, 'id_to');
    }
    public function order() {
     return $this->belongsTo(Orders::class, 'order_id');
    }
    public function admin() {
     return $this->belongsTo(User::class, 'admin_id');
    }
    public function getMsgAttribute($value)
    {
        return nl2br($value);
    }
}
