<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }
    
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->validationErrorMessages());
        if($request['is_api']&&$validator->fails()){
            $data['status'] = false;
            $data['message'] = $validator->errors()->toArray();
            return response()->json($data,422);
        }else{
            $validator->validate();
        }
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $user = [];
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) use($request) {
                $this->resetPassword($request, $user, $password);
            }
        );
        if ($request['is_api']) {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                $data['status'] = true;
                $data['message'] = 'no record found with this email';
                return response()->json($data, 200);
            }
        }
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request,$response,$validator)
                    : $this->sendResetFailedResponse($request, $response,$user);
    }
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password'=>['required','regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
            'password_confirmation' => 'required|same:password',
        ];
    }
    protected function validationErrorMessages()
    {
        return ['password.regex'=>'Password must be at least 8 charachters and contain at least one uppsercase letter and one digit'];
    }
    protected function sendResetResponse(Request $request,$response,$validator)
    {
        $data['status'] = true;
        $data['message'] = "password reset with success";
        return  ($request['is_api'])?response()->json($data,200):redirect($this->redirectPath())->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        // echo "string";exit;
        $data['status'] = true;
        $data['message'] = "access token is invalid";
        return  ($request['is_api'])?response()->json($data,400):redirect()->back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
    }
    protected function resetPassword(Request $request, $user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();
        if (!$request->wantsJson()) {
            $this->guard()->login($user);
        }
    }
}
