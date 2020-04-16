<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller; 
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = '/'.app()->getLocale();
    }
    /**
     * Redirect the user to the facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    protected function GetReferertUrl(Request $request){
        return $request->session()->get('ReferertUrl');
    }
    /*public function FacebookAuth(Request $request)
    {       
         if(!$request->has('error')):
         $RedirectURL=$this->GetReferertUrl($request);          
            $User =Socialite::driver('facebook')->user();
            $UserInstance=User::where(array('email'=>$User->email,'status'=>1))->first();
            $UserInstanceDisabled=User::where(array('email'=>$User->email,'status'=>0))->first();
            if($UserInstance):
                Auth::login($UserInstance);
                return redirect($RedirectURL);
            elseif($UserInstanceDisabled):
                $request->session()->flash('loginform_message',$this->BannedMessage);
                return redirect($RedirectURL);    
            else:
                $request->session()->flash('UserRegInfo',$User);
                return redirect($RedirectURL);
            endif;
         else:
             $request->session()->flash('loginform_message','Please login to your social media account first!');
             return redirect($RedirectURL);
         endif;
    }*/
    public function redirectToProvider(Request $request)
    {
        $RedirectURL=$this->GetReferertUrl($request);
        // var_dump($request->membertype);exit;
        $request->session()->put('membertype', $request->membertype);
        $request->session()->put('redirect_to', $RedirectURL);
        return //redirect(app()->getLocale().'/login/facebook/callback');
        Socialite::driver('facebook')->redirect();
    }
    public function login(Request $request)
    {
        $roles = [
          'email' => 'required|email',
          'password'=> 'required',
        ];
        $validator = Validator::make($request->all(),$roles);
        if($request['is_api'] && $validator->fails()){
            $data['status'] = false;
            $data['message'] = $validator->errors()->toArray();
            return response()->json($data,422);
        }else{
            $UserInstanceDisabled = User::where(array('email'=>$request->email,'status'=>0))->first();
            $UserInstanceBaned = User::where(array('email'=>$request->email,'status'=>2))->first();
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'status'=>1])):
                return response()->json(['status'=>true,'message'=>'test'],200);
            elseif($UserInstanceDisabled):
                $data['status'] = false;
                $data['user_id'] = $UserInstanceDisabled->id;
                $data['message'] = trans('auth.auth.notActivated');
                return response()->json($data,400);
            elseif($UserInstanceBaned):
                $data['status'] = false;
                // $data['user_id'] = $UserInstanceBaned->id;
                $data['message'] = trans('auth.band');
                return response()->json($data,400);
            else:
                $data['status'] = false;
                $data['message'] = trans('auth.auth.notFound');
                return response()->json($data,400);
            endif;
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function showLoginForm(Request $request)
    {   
        $CurrentURL= redirect()->back()->getTargetUrl();
        $request->session()->put('ReferertUrl',$CurrentURL);
        $request->session()->flash('loginform_message', 'Please Login ');
        return redirect('/'.app()->getLocale());
    }
    protected function credentials(Request $request)
    {
       return $request->only($this->email(), 'password') + ['status' => true] ;
    }
       /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->email() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->email(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function email()
    {
        return 'email';
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/'.app()->getLocale());
    }
   
}
