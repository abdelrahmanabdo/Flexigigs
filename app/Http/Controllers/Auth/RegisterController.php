<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Notifications\SendNotifications;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Intervention\Image\ImageManagerStatic as Image;
use Socialite;
use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\EntrustPermission;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;
use Zizaco\Entrust\AttachRole;
use App\Helpers\Flexihelp;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $loginPath = '/'; 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
   public function showRegistrationForm(Request $request)
    {
      $CurrentURL= redirect()->back()->getTargetUrl();
      $request->session()->put('ReferertUrl',$CurrentURL);
      $request->session()->flash('UserRegInfo', 'Please Registre');
      return redirect(app()->getLocale());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

      $roles = [
          'username' => 'required|string|max:255|unique:users',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => ['required','regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
          'password' => ['required','regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
          'password_confirmation' => 'required|same:password',
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'phone' => ['required','numeric'/*,'regex:/^01(0|1|2|5)\d{8}$/'*/],
          'gender' => 'required',
          'age_group' => 'required',
          'terms'=>'accepted',
          'city' => 'required',
          'g-recaptcha-response' => 'required|recaptcha'
        ];
        // var_dump($data['role_id']);exit;
      if ($data['role_id']==2){
        $roles['skills'] = 'required';
      }
      return Validator::make($data, $roles ,['password.regex'=>'Password must be at least 8 charachters and contain at least one uppsercase letter and one digit']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\user    
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->except(['terms']))));
        $user->attachRole($request->role_id);
        $noti = new \App\Http\Controllers\NotificationController();
        $noti->SendVerifyMail($user);
        // $this->guard()->login($user);
        if ($request->file('avatar')) {
          $file = Flexihelp::upload($request->file('avatar'),'useravatar');
          if (@$file->pathToSave) {
            $user->update(['avatar' => $file->pathToSave ]);
          }
        }

        // return $this->registered($request, $user)
                        // ?: redirect($this->redirectPath());
        $data['status'] = true;
        $data['user'] = $user;
        $data['message']='Please check your email! A verification email with activation link has been sent to your email address.';
        return response()->json($data,201);
    }
    public function resendVarification(Request $request,$id=null)
    {
      $data['status'] = false;
      $data['message'] = 'can`t catch id';
      if ($id) {
        $user = User::find($id);
        $noti = new \App\Http\Controllers\NotificationController();
        $noti->SendVerifyMail($user);
        $data['status'] = true;
        $data['message'] = "email sent";
      }
      return ($request['is_api'])?response()->json($data,200):redirect(app()->getLocale());
    }
    
     protected function create(array $data)
    {
        // $data['member_type'] = $data['role_id'];
        $data['password'] = bcrypt($data['password']); 
        $data['token'] = str_random(60);
        $data['lang_perfix'] = app()->getLocale(); 
        $userdata = User::create($data);
        return $userdata;
    }
      /**
     * Obtain the user information from facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        // var_dump($request->membertype);
        // $request->session()->put('membertype', $request->membertype);
        // var_dump(session('membertype'));exit;
        $user = Socialite::driver('facebook')->user();
        $user->membertype = $request->session()->get('membertype');
        // $user->token;
        $request->session()->forget('membertype');
        $this->findOrCreateUser($user);
        return redirect(app()->getLocale());
    }
    public function findOrCreateUser($data)
    {
        $authUser = User::where('ud_id', $data->id)->first();
        if ($authUser) {
            $this->guard()->login($authUser);
            return redirect(app()->getLocale());
        }
        $userdata = $this->fbcreate($data);
        // $membertype = session('membertype');
        if (empty($userdata['membertype'])) {
          event(new Registered($user = $userdata));
          $this->guard()->login($user);
        }else{
          app('request')->session()->flash('newreg',$userdata);
        }
        return redirect(app()->getLocale());
    }
    protected function fbcreate($data){
      $email_checker=[];
      if (!empty(@$data->email))
        $email_checker = $userdata = User::where('email',$data->email)->first();
      if (count($email_checker)) {
          User::where('id',$userdata->id)->update(['ud_id'=>$data->id]);
         return $email_checker;
      }else{
         $user = [
            'ud_id' => $data->id,
            'username' => strtolower(str_replace(" ", "_",$data->name)),
            'email' => $data->email,
            'first_name' => $data->name,
            'last_name' => $data->nickname,
            'facebook' => $data->profileUrl,
            'availability' => 0,
            'membertype'=>$data->membertype,
            'lang_perfix'=>app()->getLocale()

        ];
        // var_dump($user);exit;
        return $user;
      }
    }

}
