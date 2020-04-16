<?php

namespace App\Http\Controllers;
use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\EntrustPermission;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;
use Zizaco\Entrust\AttachRole;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
// use App\SendNotification;
use Intervention\Image\ImageManagerStatic as Image;
use App\Service;
use App\User;
use App\Role;
use App\Location;
use App\Category;
use App\ServiceVideo;
use App\ServicePhoto;
use App\User_devices;
use App\Helpers\Flexihelp;
use App\Helpers\Notification;
use App\Notifications\SendNotifications;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function field_validator(Request $request)
    {
      if (!$request->name&&!$request->value) {
        $data['status'] = false;
        $data['message'] = 'bad parameter check DOCX file';
        return response()->json($data,208);
      }
      $records = User::where($request->name,$request->value)->first();
      if ($records) {
        $data['status'] = false;
        $data['message'] = $request->name.' used by another one';
        return response()->json($data,208);
      }else{
        $data['status'] = true;
        $data['message']= $request->name.' is avilable';
        return response()->json($data,200);
      }
    }
    public function registration(Request $request) {
        if ($request['exeed_limit']) {
          $data['status']= false;
          $data['message']=['avatar'=>'file exeed limit'];
          return  response()->json($data,422);
        }
        $roles = [
          'username' => 'required|string|max:255|unique:users',
          'email' => 'required|string|email|max:255|unique:users',
          'password'=>['required','min:6','max:191','string','confirmed','regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
          'password_confirmation' => 'required|same:password',
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'city' => 'required',
          'phone' => 'required|numeric',
          'formatted_address'=>'required'
         ];
        if ($request->role_id==2) {
          $roles['skills'] = 'required';
        }
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
          $data['status']=false;
          $data['message']= $validator->errors()->toArray();
          return response()->json($data,422);
        }
        $dataToStore = $request->except(['exeed_limit','password','password_confirmation','avatar','access_role']);
        $dataToStore['token']= str_random(60);
        if ($request->file('avatar')) {
          $file = Flexihelp::upload($request->file('avatar'),'useravatar');
          $dataToStore['avatar'] = $file->pathToSave;
        }  
        // $dataToStore['status'] = 1;//change to  0  after mobile stabilty
        // $dataToStore['access_role'] = $request->access_role;//change to  0  after mobile stabilty
        // Create user 
        $dataToStore['password'] = bcrypt($request->input('password'));
        $user = User::create($dataToStore);
        $userdata = User::where('id',$user->id)->first();
        // $user->attachRole( $request->access_role );
        if ($userdata) {
          $noti = new \App\Http\Controllers\NotificationController();
          $noti->SendVerifyMail($userdata);
          $data['status'] = true;
          $data['user'] = $userdata;  
          return response()->json($data,201);
        }else{
          $data['status'] = false;
          $data['message'] = 'DB error call the developer for this issue'; 
          return response()->json($data,400);
        }
    }
    public function regimage(Request $request) {
      if ($request['exeed_limit']) {
        $data['status']= false;
        $data['message']=['avatar'=>'file exeed limit'];
        return  response()->json($data,422);
      }
      $validator = Validator::make($request->all(), [
          'id' => 'required',
         ]);
        if ($validator->fails()) {
          $data['status']=false;
          $data['message']= $validator->errors()->toArray();
          return response()->json($data,422);
        }
        $user = User::where('id',$request->id)->first();
        if ($user) {
        
          if ($request->avatar) {
            $file = Flexihelp::upload($request->file('avatar'),'useravatar');
              // $dataToStore['avatar'] = $file->pathToSave;
            User::where('id',$request->id)->update(['avatar' => $file->pathToSave ]);
          }
          $data['status'] = true;
          $data['user'] = User::where('id',$request->id)->first();
          return response()->json($data,201);
        }else{
          $data['status'] = false;
          $data['message'] = 'DB error call the developer for this issue'; 
          return response()->json($data,400);
        }
    }
    public function FBregistration(Request $request) {
      $validator = Validator::make($request->all(), [
          'ud_id' => 'required|string|max:255|unique:users',
          'email' => 'required|string|email|max:255|unique:users',
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'access_role' => 'required'
         ]);
        if ($validator->fails()) {
          $data['status']=false;
          $data['message']= $validator->errors()->toArray();
          return response()->json($data,422);
        }
        $dataToStore = $request->except(['exeed_limit','avatar','access_role']);
        $dataToStore['status'] = 0;
        $user= User::create($dataToStore);
        $user->attachRole( $request->access_role );
        if ($user) {
          $userdata = $user;
          if ($request->avatar) {
            $img = Image::make($request->avatar);
            $img->save(public_path('storage/app/useravatar/user_'.$user->id.'.jpg'));
            $img->save(public_path('storage/app/60/useravatar/user_'.$user->id.'.jpg'),60);
            $img->save(public_path('storage/app/20/useravatar/user_'.$user->id.'.jpg'),20);
            $user->update(['avatar' => 'useravatar/user_'.$user->id.'.jpg' ]);
          }
          $data['status'] = true;
          $data['message'] = 'you have to complete regestration';
          $data['user'] = $user;  
          return response()->json($data,201);
        }else{
          $data['status'] = false;
          $data['message'] = 'DB error call the developer for this issue'; 
          return response()->json($data,400);
        }
    }
    public function FBregistration2(Request $request) {
      $validator = Validator::make($request->all(), [
        'id'=>'required',
        'username' => 'required|string|max:255|unique:users',
        'password'=>['required','min:6','max:191','string','confirmed','regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
        'password_confirmation' => 'required|same:password',
        'phone' => 'required|numeric',
        'city' => 'required',
        'formatted_address'=>'required'
       ]);
        if ($validator->fails()) {
          $data['status']=false;
          $data['message']= $validator->errors()->toArray();
          return response()->json($data,422);
        }
        $status = User::where([['status','=',"1"],["id",'=',$request->id]])->first();
        if ($status) {
          $data['status'] = false; 
          $data['message'] = 'your have already an active account try to login';
          return response()->json($data,208 );
        }
        $user_chick = User::where('username',$request->username)->whereNotIn('id',[$request->id])->first();
        if ($user_chick) {
          $data['status'] = false; 
          $data['message'] = 'user name used by another one';
          return response()->json($data,208 );
        }
        $dataToStore = $request->except(['exeed_limit','password','password_confirmation','id','is_api']);
        $dataToStore['password'] = bcrypt($request->password);
        $dataToStore['status'] = 1;
        // Create user 
        $user = User::where(['id'=>$request->id])->update($dataToStore);
        if ($user) {
          $user_data = User::where('id',$request->id)->first();
          $data['status'] = true;
          $data['user'] = $user_data;  
          return response()->json($data,201);
        }else{
          $data['status'] = false;
          $data['message'] = 'DB error call the developer for this issue'; 
          return response()->json($data,400);
        }
    }
    // end of regestration  
    // next you have to varify
    public function varify(Request $request,$token=null) {
      if ($request->email&&$token) {
        $user_chick = User::where(['email'=>$request->email,'token'=>$token])->first();
        if ($user_chick) {
          if ($user_chick->status == 1) {
            if ($request['is_api']) {
              $data['status'] = false;
              $data['message'] = 'your account is already active , and you are not permited to access this area again , be carefull it may mad your account pend';
              return response()->json($data,200);
            }else{
              $request->session()->flash('account_activated','your account is already active');    
              return redirect(app()->getLocale());  
            }
          }elseif($user_chick->status == 2){
            if ($request['is_api']) {
              $data['status'] = false;
              $data['message'] = 'your account pend';
              return response()->json($data,200);
            }else{
              $request->session()->flash('account_activated','your account pend');    
              return redirect(app()->getLocale());  
            }
          }
          $user_chick->update(['status' => "1"]);
          if ($user_chick) {
            $user = User::where(['email'=>$request->email,'token'=>$token])->first();
          }
          if ($request['is_api']) {
            $data['status'] = true; 
            $data['message'] = 'Account varifaied with success';
            $data['user'] = $user; 
            return response()->json($data,200);
          }else{
            $request->session()->flash('account_activated','Your email has been successfully verified!');    
            return redirect(app()->getLocale().'/login');
          }
        }else{
          if ($request['is_api']) {
            $data['status'] = false; 
            $data['message'] = 'record not found';
            return response()->json($data,400);
          }else{
            abort(404);
          }
        }
      }else{
        if ($request['is_api']) {
          $data['status'] = false;
          $data['message'] = 'bad parameter check DOCX file';
          return response()->json($data,400);
        }else{
          abort(404);
        }
      }
    }
    public function active(Request $request)
    {
      if ($request['is_api']) {
        if($request->id){
          $user_chick = User::find($request->id);
          $user_chick->update(['status' => "1"]);
          if ($user_chick) {
            $user = User::where(['id'=>$request->id])->first();
          }
          $data['status'] = true; 
          $data['message'] = 'Account varifaied with success';
          $data['user'] = $user; 
          return response()->json($data,200);
        }else{
          $data['status'] = false;
          $data['message'] = 'bad parameter check DOCX file';
          return response()->json($data,400);
        }
      }else{
        abort(404);
      }
    }
    // you can use it for pending an account
    public function pending(Request $request) {
      if ($request->id) {
        $user_chick = User::where('id',$request->id)->first();
        if ($user_chick) {
          if ($user_chick->status == 2) {
            $data['status'] = false;
            $data['message'] = 'this account is already pand';
            return response()->json($data,208 );exit;
          }
          $user = User::where('id',$request->id)->update(['status' => "2"]);
          if ($user) {
            $user = User::where('id',$request->id)->first();
          }
          $data['status'] = true; 
          $data['message'] = 'Account pand with success';
          $data['user'] = $user; 
          return response()->json($data,200);
        }else{
          $data['status'] = false; 
          $data['message'] = 'record not found';
          return response()->json($data,400);
        }
      }else{
        $data['status'] = false;
        $data['message'] = 'bad parameter check DOCX file';
        return response()->json($data,400);
      }
    }  
    public function logout(Request $request)
    {
      if ($request->device_id) {
          $device = User_devices::where('device_id',$request->device_id)->first();
          if ($device) {
            User_devices::where('device_id',$request->device_id)->delete();
            $data['status'] = true;
            $data['message'] = "device id removed";
            return response()->json($data,200);
          }else{
            $data['status'] = false;
            $data['message'] = 'record not found';
            return response()->json($data,400);
          }
      }else{
        $data['status'] = false;
        $data['message'] = 'bad parameter check DOCX file';
        return response()->json($data,400);
      }
    }
    public function login(Request $request) {
      if ($request->email&&$request->password) {
        $user_chick = [];
        $email_chick = User::where(['email'=>$request->email])->first();
        if ($email_chick) {
          if (Hash::check( $request->password ,$email_chick->password)) 
            $user_chick = $email_chick;
        }
        if ($user_chick) {
          if ($user_chick->status == 2) {
            $data['status'] = false;
            $data['message'] = 'this account is pand';
            return response()->json($data,208 );exit;
          }elseif($user_chick->status == 0) {
            $data['status'] = false;
            $data['message'] = 'you just need to varify your account please check your mail to find the varifing link';
            $data['user_id'] = $user_chick->id;
            return response()->json($data,208 );exit;
          }else{
            $data['status'] = true; 
            $isadmin = DB::table('role_user')->where(['user_id'=>$user_chick->id,'role_id'=>1])->first();
            if ($isadmin) {
              $errors['status'] = false;
              $errors['message'] = 'Dear Admin, Please use your account either from Mobile website or from desktop version to administrate the system.';
              $errors['message_ar'] = 'عزيري مدير الموقع، برجاء الدخول الي حسابك من النسخة المتوافقة من الهواتف الذكية من متصفحك او من علي نسخة السطح المكتبي';
              return response()->json($errors,400);
            }
            $data['user'] = $user_chick;
            if($request->device_id){
              $device = User_devices::where('device_id',$request->device_id)->first();
              if (!$device) {
                $data['device'] = User_devices::create(['user_id'=>$user_chick->id,'device_id'=>$request->device_id]);
              }
            }
            if ($request->lang) {
              $this->change_lang($request,false);
            }
            return response()->json($data,200);
          }
        }else{
          if ($email_chick) {
            $data['status'] = false;
            $data['email'] = true;
            $data['pass'] = false;
            $data['user_name'] = $email_chick->username;
            $data['message'] = 'sorry worng password';
            return response()->json($data,409);exit;
          }else{
            $data['email'] = false;
            $data['pass'] = true;
            $data['message'] = 'sorry worng email & password';
            return response()->json($data,409);exit;
          }
        }
      }else{
        $data['status'] = false;
        $data['message'] = 'bad parameter check DOCX file';
        return response()->json($data,400);
      }
    } 

    public function FBlogin(Request $request) {
      if ($request->ud_id) {
        $user_chick = [];
        $user_chick = User::where(['ud_id'=>$request->ud_id])->first();
        if ($user_chick) {
          if ($user_chick->status == 2) {
            $data['status'] = false;
            $data['message'] = 'this account is pand';
            return response()->json($data,200);
          }elseif($user_chick->status == 0) {
            $data['status'] = false;
            $data['message'] = 'your email is not varifaied yet';
            $data['message_ar'] = 'بريدك الالكتروني  غير مفعل حتي الان';
            $data['user_id'] = $user_chick->id;
            return response()->json($data,200);
          }else{
            $data['status'] = true; 
            $data['user'] = $user_chick;
            if($request->device_id){
              $device = User_devices::where('device_id',$request->device_id)->first();
              if (!$device) {
                $data['device'] = User_devices::create(['user_id'=>$user_chick->id,'device_id'=>$request->device_id]);
              }
            }
            return response()->json($data,200);
          }
        }else{
          if ($request->email) {
            $email_checker = $userdata = User::where('email',$request->email)->first();
            if (count($email_checker)) {
              User::where('id',$email_checker->id)->update(['ud_id'=>$request->ud_id]);
              $data['status'] = true;
              $data['user'] = $email_checker;
              return response()->json($data,200);
            }else{
              $data['status'] = false;
              $data['message'] = 'you have not regesterd by facebook before';
              return response()->json($data,200);
            }
          }else{
            $data['status'] = false;
            $data['message'] = 'you have not regesterd by facebook before';
            return response()->json($data,200);
          }
        }
      }else{
        $data['status'] = false;
        $data['message'] = 'bad parameter check DOCX file';
        return response()->json($data,400);
      }
    }
    // end of login by facebook 
    // just for edit on account data in profile and backend
    protected function ValidateOldPassword(Request $request)
    {
      $userdata = User::where('id',$request->id)->first();
      Validator::extend('like_old', function ($attribute, $value, $parameters, $validator) use ($request,$userdata)  {
        return Hash::check( $request->oldPw ,$userdata->password);
       });
       $password=Validator::make($request->all(), [
      'oldPw' => 'required|like_old',
      'newPw'=>['required','regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
      'newPw_confirmation'=>['required','same:newPw'],
      ],['oldPw.like_old'=>"old password is wrong",
         'newPw.min'=>"password mast be more than 8 characters",
         'newPw.regex'=>"Password must be at least 8 charachters and contain at least one uppsercase letter and one digit",
       ]);
      return $password;
    }
    public function profile(Request $request) {
        if ($request['exeed_limit']) {
          $data['status']= false;
          $data['message']=['avatar'=>'file exeed limit'];
          return  response()->json($data,422);
        }
        $roles = [
        'id' =>'required',
        'username' => 'required|unique:users,username,'.$request->id.'|max:255',
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email,'.$request->id.'|max:255',
        'city' =>'required',
        'phone' => 'required|numeric',
        // 'newPw' => 'string|min:6|rNewPw',
        ];
        if ($request->role_id == 2) {
          $roles['skills'] = 'required';
        }
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
          $data['status']=false;
          $data['prams']= $request->all();
          $data['message']= $validator->errors()->toArray();
          return response()->json($data,422);
        }
        $userdata = User::where('id',$request->id)->first();
        $dataToStore = $request->except(['exeed_limit','avatar','oldPw','newPw','newPw_confirmation','_token','is_api','role_id']);
        if ($request->oldPw || $request->newPw || $request->newPw_confirmation) {
          $password = $this->ValidateOldPassword($request);
          if ($password->fails()) {
            $data['status']=false;
            $data['message']= $password->errors()->toArray();
            return response()->json($data,422);
          }
          $dataToStore['password'] = bcrypt($request->input('newPw'));
        }
    
        if($request->file('avatar')){
            $img = Image::make($request->file('avatar')->getRealPath());
            $file = Flexihelp::upload($request->file('avatar'),'useravatar');
            $dataToStore['avatar'] = $file->pathToSave;
        }
        $update_detector = User::where(['id'=>$request->id])->update($dataToStore);
        if ($update_detector) {
          $user = User::find($request->id);
          if (!$request['is_api']) {
            return redirect(app()->getLocale().'/admin/dashboard/users');
          }
          // if ($request->email != $user_data->email) {
            
          // $user->notify(new SendNotifications($userdata));
          /* Mail::send('emails.users.SendNotification', ['title' => 'testmails', 'message' => 'varefication mail'], function ($message)
              {
                $message->to('code.hifny@gmail.com');
              });*/
          // Mail::from('code.hifny@gmail.com')->to($request->email)->send(new SendNotification($user));
          // }
          $data['status'] = true;
          $data['user'] = User::where('id',$request->id)->first();  
          return response()->json($data,200);
        }else{
          $data['status'] = false;
          $data['message'] = 'db error call developer';
          return response()->json($data,400);  
        }
    }
    public function getUsers(Request $request)
    {
        $page_num = ($request->page_num)?$request->page_num:0;
        $limit = ($request->limit)?$request->limit:5;
        $offset = $page_num*$limit;
        $where = [];
        $orWhere = [];
        // Start where array
        if ($request->status||$request->status == 0 && $request->status != "")
          $where[]  = ['status',$request->status];
        if ($request->free_text){
          $where[]  = ['username','like','%'.$request->free_text.'%'];
        }
        // End where array
        // start Query
        $users = $pagination = User::limit($limit)->offset($offset)->where($where)->orderBy('created_at','DESC');
        $data['user_pagination'] = $pagination->paginate($limit)
                                              ->appends(['free_text'=>$request->free_text,
                                                         'status'=>$request->status,
                                                        ]);
        $users = $users->get();
        // end query 
        if (count($users)>0){
          $data['status'] = true;
          $data['result'] = $users;
          $data['pagination_status'] = true;
        }else{
          $data['status'] = false;
          $data['result'] = $users;
          $data['message'] = 'no more data';
          $data['pagination_status'] = false;
        }
        $data['count_all'] = User::join('role_user', 'users.id', '=', 'role_user.user_id')->where($where)->orWhere($orWhere)->count();
        $data['page_number'] = $page_num;
        $data['months'] = User::get()->groupBy(function($d) {
           return Carbon::parse($d->created_at)->format('Y-m');
        });
        if ($request['is_api']) {
          return response()->json($data , 200);
        }else{
          $data['counter_title'] = trans('service_category.dashboard_users_title');
          $data['counter'] = User::count();
          return view('admin.users.list',$data);
        }
    }
    public function getUser($id)
    {
      $user = User::find($id);
      // end query 
      if ($user){
        $data['status'] = true;
        $data['skills'] = Flexihelp::userSkills($user->skills);
        $data['supplier_rate'] = Flexihelp::get_stars('supplier',$user->id,true);
        $data['customer_rate'] = Flexihelp::get_stars('customer',$user->id,true);
        $data['user'] = $user;
        return response()->json($data , 200 );
      }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 400 );
      }
    }
    public function deleteUser($id)
    {
      $user = User::find($id);
      if ($user) {
        $data['status'] = true;
        $data['message'] = 'Record deleted succefully';
        $user->delete();
        return response()->json($data , 200);
      }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 400);
      }
    }
    public function exportusers(Request $request)
    {
      $where = [];
      if ($request->status) 
        $where[] = ['status',$request->status];
      if ($request->free_text) 
        $where[] = ['username' ,'like','%'.$request->free_text.'%'];
      $users = User::orderBy('created_at','ASC')
                   ->where($where)
                   ->whereYear('created_at',date('Y',strtotime($request->month)))
                   ->whereMonth('created_at',date('m',strtotime($request->month)))
                   ->get();
      // var_dump($users);
      $result = [];
      foreach ($users as $user) {
        $status = '';
        if ($user->status == 0) {
          $status = 'unvarifaied';
        }elseif($user->status == 1){
          $status = 'varifaied';
        }elseif($user->status == 2){
          $status = 'pand';
        }else{
          $status = 'un defined case call app developer';
        }
        $result[] = ['ID'=>$user->id,
                     'username'=>$user->username,
                     'full_name'=>$user->first_name.' '.$user->last_name,
                     'email'=>$user->email,
                     'city'=>$user->formatted_address,
                     'skills'=>$user->skills,
                     'created_at'=>$user->created_at,
                     'status'=>$status,
                     'i`m a'=>$user->supplier_type
                    ];
      }
      // var_dump($result);
      // return response()->json($users , 200);
      Excel::create('users '.$request->month, function($excel) use($result,$request) {
          $excel->sheet('users '.$request->month, function($sheet) use($result,$request) {
              $sheet->fromArray($result);

          });

          // Set the title
          $excel->setTitle('Our new awesome title');

          // Chain the setters
          $excel->setCreator('Maatwebsite')
                ->setCompany('Maatwebsite');

          // Call them separately
          $excel->setDescription('A demonstration to change the file properties');

      })->download('xlsx');
    }
    // for mobile api 
    public function change_lang(Request $request,$return=true)
    {
      if ($request->email&&$request->lang) {
        $userdata = User::where('email',$request->email)->first();
        if (!$userdata) {
          $errors['status'] = false;
          $errors['message'] = 'can not find user';
          if ($return)
          return response()->json($errors,400);
        }else{
          if ($userdata->lang_perfix != $request->lang) 
            user::where('email',$request->email)->update(['lang_perfix'=>$request->lang]);
          $data['status'] = true;
          $data['message'] = 'lang set as '.$request->lang;
          if ($return)
          return response()->json($data,200);
        }
      }else{
        $errors['status'] = false;
        $errors['message'] = 'you miss email or lang';
        if ($return)
        return response()->json($errors,400);
      }
    }
}
