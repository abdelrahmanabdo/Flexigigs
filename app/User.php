<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\HasRole;
use Zizaco\Entrust\AttachRole;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Passport\HasApiTokens;
use App\Reviews;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    use EntrustUserTrait; // add this trait to your user model

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username' , 'first_name' , 'last_name' , 'email' , 'phone' , 'intro' , 'password', 'avatar',
              'city' , 'facebook' , 'linkedin' , 'twitter' , 'instagram' , 'skills' , 'availability' , 'access_role' ,
              'status','ud_id','supplier_type','company_name','site_url','formatted_address','token','receive_noti','gender','age_group','lang_perfix' ];

    protected $appends = ['customer_rate','supplier_rate','gendertxt'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function services()
    {
       return $this->hasMany(Service::class);
    }
    public function requests()
    {
       return $this->hasMany(Request::class);
    }
    public function favorites()
    {
       return $this->hasMany(Favorite::class);
    }
    public function devices()
    {
       return $this->hasMany(User_devices::class);
    }

   public function followers(){
      return $this->belongsToMany('App\User' , 'follow' , 'HH_id' , 'GH_id');
    }public function getGendertxtAttribute()
    {if ($this->gender==0) {
      return trans('user.gender_male');
    }else{
      return trans('user.gender_female');
    }
   }
   public function getCustomerRateAttribute()
   {
       return round(Reviews::where(['type'=>2,'user_id'=>$this->id])->avg('rate'));}

   public function getSupplierRateAttribute($user)
   {
       return round(Reviews::where(['type'=>1,'supplier_id'=>$this->id])->avg('rate'));
   }
    public function getHasTransactionAttribute()
    {
        $has_transaction = false;
        $orders = Orders::where('supplier_id',$this->id)
            ->where('status',4)->get();
        if (sizeOf($orders)>0)
            $has_transaction = true;
           return $has_transaction;
    }
}
