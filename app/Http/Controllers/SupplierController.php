<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Service;
use App\ServiceVideo;
use App\ServicePhoto;
use App\Category;
use App\User;
use App\Orders;
use App\Applications;
use App\Helpers\Flexihelp;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function searchList()
    {
        $data['userdata'] = $userdata = Auth::user();
        $data['total_services'] = Service::where('supplier_id', $userdata->id)->count();
        return view('supplier.messages.searchList', $data);
    }

    public function searchSingle()
    {
        $data['userdata'] = $userdata = Auth::user();
        $data['total_services'] = Service::where('supplier_id', $userdata->id)->count();
        return view('supplier.messages.searchSingle', $data);
    }


    public function dashboard(Request $request)
    {
        $data['userdata'] = $userdata = Auth::user();
        $data['parents_categories'] = Category::where('parent_id', "<=", "0")->orderBy('name')->get();
        $my_services = Service::where('supplier_id', Auth::user()->id)->with(['videos', 'photos'])->get();
        foreach ($my_services as $service) {
            $service->subsub_cat = Category::find($service->category_id);
            $service->sub_cat = Category::find($service->subsub_cat['parent_id']);
            if ($service->sub_cat['parent_id'] == 0) {
                $service->parent_cat = $service->sub_cat;
                $service->sub_cat = $service->subsub_cat;
            } else {
                $service->parent_cat = Category::find($service->sub_cat['parent_id']);
            }
        }
        $data['my_services'] = $my_services;
        $data['total_services'] = Service::where('supplier_id', $userdata->id)->count();
        return view('supplier.dashboard.dashboard', $data);
    }

    public function gigs(Request $request)
    {
        // dd('hi');
        $data['userdata'] = $userdata = ($request['is_api']) ? User::where('id', $request->supplier_id)->first() : Auth::user();
        if (!$userdata) {
            if ($request['is_api']) {
                $data['status'] = false;
                $data['message'] = 'userdata is invalid';
                response()->json($data, 404);
            } else {
                abort(404);
            }
        }
        $page_num = ($request->page) ? $request->page : 1;
        $limit = ($request->limit) ? $request->limit : 6;
        $offset = $page_num * $limit;
        $date_from = date('Y-m-d 00:00:00', strtotime($request->date_from));
        $date_to = date('Y-m-d 23:59:59', strtotime($request->date_to));
        $where = [];
        $where[] = ['supplier_id', $userdata->id];
        // if($request->date_from)
        //   $where[] = ['created_at','>=',$date_from];
        // if($request->date_to)
        //   $where[] = ['created_at','<=',$date_to];
        // if($request->status || $request->status=="0")
        //   $where[] = ['status',$request->status];
        // if($request->type)
        //   $where[] = ['type',$request->type];
        // if($request->order_id)
        //   $where[] = ['id',$request->order_id];

        /*osman edits 20/8 12:20*/
        $ordersObject = new Orders;
        $orders = $ordersObject->newQuery();
        $orders->where('supplier_id', $userdata->id);
        if ($request->has('date_from'))
            $orders->where('created_at', '>=', $request['date_from']);
        if ($request->has('date_to'))
            $orders->where('created_at', '<=', $request['date_to']);
        if ($request->has('status'))
            $orders->where('status', $request['status']);
        if ($request->has('type'))
            $orders->where('type', $request['type']);
        if ($request->has('order_id'))
            $orders->where('id', $request['order_id']);

        /*******************************/

        // $orders = Orders::with(['request','customer','application.skills.category','cus_review'])->where($where);


        // $orders = Orders::with(['request','customer','application.gig'])->where($where);
        if ($request->sort_by == "created_asc")
            $orders->orderBy('created_at');
        elseif ($request->sort_by == "created_desc")
            $orders->orderBy('created_at', 'DESC');
        else
            $orders->orderBy('created_at', 'DESC');

      $result = $orders->paginate($limit)
                       ->appends(['status'=>$request->status,
                                  'date_from'=>$request->date_from,
                                  'date_to'=>$request->date_to,
                                  'free_text'=>$request->free_text,
                                  'rating'=>$request->rating,
                                  'type'=>$request->type,
                                  'sort_by'=>$request->sort_by
                                 ]);
                        // dd($result);
      foreach ($result as $order) {
        if ($order->type == 1) {
          $order->request->subsub_cat = Category::find($order->request->category_id); 
          $order->request->sub_cat = Category::find($order->request->subsub_cat['parent_id']); 
          if ($order->request->sub_cat['parent_id']==0) {
            $order->request->parent_cat = $order->request->sub_cat; 
            $order->request->sub_cat = $order->request->subsub_cat; 
          }else{
            $order->request->parent_cat = Category::find($order->request->sub_cat['parent_id']); 
          }
        }

      /*Osman edits*/
        $order->supplier;
        $order->customer;
        $order->application;
        $order->request;
        /*************/
      }$data['gigs'] = $result;
      $data['total_services'] = Service::where('supplier_id',$userdata->id)->count();
      $data['search_with'] = $request->except(['exeed_limit','page','limit','is_api']);

      return ($request['is_api'])?response()->json($data,200):view('supplier.gigs.list',$data);
    }

    public function application(Request $request)
    {
      $data['userdata'] = $userdata =($request['is_api'])?User::where('id',$request->supplier_id)->first():Auth::user();
      if (!$userdata) {
        if ($request['is_api']) {
          $data['status'] = false;
          $data['message'] = 'userdata is invalid';
          response()->json($data,404);
        }else{
          abort(404);
        }
      }
      $page_num = ($request->page)?$request->page:1;
      $limit = ($request->limit)?$request->limit:6;
      $offset = $page_num*$limit;
      $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
      $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
      $where  = [];
      $where[] =['supplier_id',$userdata->id];
      $where[] = ['status',0];
      if($request->date_from)
        $where[] = ['created_at','>=',$date_from];
      if($request->date_to)
        $where[] = ['created_at','<=',$date_to];
      $applicaton = Applications::where($where)->orderBy('created_at','desc');
      $data['applications'] = $applicaton->with('customer','skills.category')->paginate($limit)
                                         ->appends(['date_from'=>$request->date_from,
                                                    'date_to'=>$request->date_to]);
      foreach ($data['applications'] as $key => $application) {
        $application->gig;
      }$data['total_services'] = Service::where('supplier_id',$userdata->id)->count();
      $data['search_with'] = $request->except(['exeed_limit','page','limit','is_api']);
      return ($request['is_api'])?response()->json($data,200):view('supplier.application.list',$data);
    }

    public function services(Request $request)
    {
        $page_num = ($request->page) ? $request->page : 1;
        $limit = ($request->limit) ? $request->limit : 6;
        $offset = $page_num * $limit;
        $data['userdata'] = $userdata = ($request['is_api']) ? User::where('id', $request->supplier_id)->first() : Auth::user();
        if (!$userdata) {
            if ($request['is_api']) {
                $data['status'] = false;
                $data['message'] = 'userdata is invalid';
                response()->json($data, 404);
            } else {
                abort(404);
            }
        }
        $data['parents_categories'] = Category::where('parent_id', "<=", "0")->orderBy('name')->get();
        $my_services = Service::where('supplier_id', $userdata->id)->with(['videos', 'photos'])->orderBy('created_at', 'desc')->paginate($limit);
        foreach ($my_services as $service) {
            $service->subsub_cat = Category::find($service->category_id);
            $service->sub_cat = Category::find($service->subsub_cat['parent_id']);
            if ($service->sub_cat['parent_id'] == 0) {
                $service->parent_cat = $service->sub_cat;
                $service->sub_cat = $service->subsub_cat;
            } else {
                $service->parent_cat = Category::find($service->sub_cat['parent_id']);
            }
        }
        $data['my_services'] = $my_services;
        $data['total_services'] = Service::where('supplier_id', $userdata->id)->count();
        return ($request['is_api']) ? response()->json($data, 200) : view('supplier.services.list', $data);

    }

    public function messages(Request $request)
    {
        $data['userdata'] = $userdata = Auth::user();
        $data['total_services'] = Service::where('supplier_id', $userdata->id)->count();
        return view('supplier.messages.list', $data);
    }

    public function earnings(Request $request)
    {
        $data['userdata'] = $userdata = ($request['is_api']) ? User::where('id', $request->supplier_id)->first() : Auth::user();
        if (!$userdata) {
            if ($request['is_api']) {
                $data['status'] = false;
                $data['message'] = 'userdata is invalid';
                response()->json($data, 404);
            } else {
                abort(404);
            }
        }
        $page_num = ($request->page) ? $request->page : 1;
        $limit = ($request->limit) ? $request->limit : 6;
        $offset = $page_num * $limit;
        $date_from = date('Y-m-d 00:00:00', strtotime($request->date_from));
        $date_to = date('Y-m-d 23:59:59', strtotime($request->date_to));
        $where = [];
        $where[] = ['supplier_id', $userdata->id];
        $where[] = ['status', '>=', 3];
        if($request->date_from)
            $where[] = ['updated_at','>=',$date_from];
        if($request->date_to)
            $where[] = ['updated_at','<=',$date_to];
        if($request->status==5){
            $where[] = ['status','>=',4];
            $where[] = ['status','<',6]; //paid
        }
        if($request->payment_method==1){
            $where[] = ['payment_method','Fawry'];
        }
        if($request->payment_method==2){
            $where[] = ['payment_method','<>','Fawry'];
        }
        if($request->status==6)
            $where[] = ['status',$request->status];
        if($request->type)
            $where[] = ['type',$request->type];
        $orders = Orders::with(['request', 'customer', 'application.skills.category'])->where($where);
        // $orders = Orders::with(['request','customer','application.gig'])->where($where);
        if ($request->sort_by == "created_asc")
            $orders->orderBy('created_at');
        elseif ($request->sort_by == "created_desc")
            $orders->orderBy('created_at', 'DESC');
        else
            $orders->orderBy('created_at', 'DESC');

        $result = $orders->paginate($limit)
            ->appends(['sort_by' => $request->sort_by,]);
        foreach ($result as $order) {
            $type = ($order->type == 1) ? 'service' : "gig";
            if ($type == 'service' && $order->request) {
                $order->pricedata = Flexihelp::fixprice($order->request, $type);
            } elseif ($type == 'gig' && $order->application) {
                if ($order->application) {
                    $order->pricedata = Flexihelp::fixprice($order->application, $type);
                }
            }
        }
        $data['orders'] = $result;
        $data['total_services'] = Service::where('supplier_id', $userdata->id)->count();
        return ($request['is_api']) ? response()->json($data, 200) : view('supplier.earnings.list', $data);
    }

    public function earning_details(Request $request, $id)
    {
        $where = [];
        $where[] = ['id', $id];
        $where[] = ['status', '>=', 3];
        $data['status'] = true;
        $data['order'] = $order = Orders::with(['request', 'customer', 'application.skills.category'])->where($where)->first();
        if ($order) {
            $type = ($order->type == 1) ? 'service' : "gig";
            if ($type == 'service' && $order->request) {
                $data['order']['pricedata'] = Flexihelp::fixprice($order->request, $type);
            } elseif ($type == 'gig' && $order->application) {
                $data['order']['pricedata'] = Flexihelp::fixprice($order->application, $type);
            }
            return response()->json($data, 200);
        } else {
            $data['status'] = false;
            $data['message'] = 'record not found';
            return response()->json($data, 404);
        }
    }

    public function bank(Request $request)
    {
        $data['userdata'] = $userdata = ($request['is_api']) ? User::where('id', $request->id)->first() : Auth::user();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'beneficiary_name' => 'required|max:255',
                'iban' => 'required|unique:users,iban,' . $userdata->id . '|max:255',
                // 'beneficiary_address' => 'required|max:255',
                // 'beneficiary_mobile_number' => 'required|unique:users,beneficiary_mobile_number,'.$userdata->id.'|max:255',
                'bank_name' => 'required|max:255',
                'bank_number' => 'required|max:255',
                // 'banks_address' => 'required|max:255',
                'swift_code' => 'required|unique:users,swift_code,' . $userdata->id . '|max:255',
            ]);
            if ($validator->fails()) {
                $data['status'] = false;
                $data['message'] = $validator->errors()->toArray();
                return ($request['is_api']) ? response()->json($data, 422) : redirect(app()->getLocale() . '/supplier/dashboard/bank')->withErrors($validator);
            }

            $dataToStore = $request->except(['exeed_limit', '_token', 'is_api', 'id']);
            $update_detector = User::where(['id' => $userdata->id])->update($dataToStore);
            $data['userdata'] = $userdata = User::where(['id' => $userdata->id])->first();
        }
        $data['total_services'] = Service::where('supplier_id', $userdata->id)->count();
        return ($request['is_api']) ? response()->json($data, 200) : view('supplier.bank.form', $data);
    }

    public function cashout(Request $request, $type)
    {
        $user_id = ($request['is_api']) ? $request->user_id : Auth::user()->id;
        $type = ($type == "fawry") ? 0 : 1;
        User::where('id', $user_id)->update(['cashout' => $type]);
        $data['userdata'] = User::where('id', $user_id)->first();
        return ($request['is_api']) ? response()->json($data, 200) : redirect()->route('supplier_bank');
    }

    protected function ValidateOldPassword(Request $request)
    {
        $userdata = User::where('id', Auth::user()->id)->first();
        // var_dump(Hash::check( $request->oldPw ,$userdata['password']));//exit;
        Validator::extend('like_old', function ($attribute, $value, $parameters, $validator) use ($request, $userdata) {
            return Hash::check($request->oldPw, $userdata['password']);
        });
        $password = Validator::make($request->all(), [
            'oldPw' => 'required|like_old',
            'newPw' => ['required', 'regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
            'newPw_confirmation' => ['required', 'same:newPw'],
        ], ['oldPw.like_old' => "old password is wrong",
            'newPw.min' => "password mast be more than 8 characters",
            'newPw.regex' => "Password must be at least 8 charachters and contain at least one uppsercase letter and one digit",
        ]);
        return $password;

    }

    public function editProfile(Request $request)
    {
        $data['userdata'] = $userdata = Auth::user();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users,username,' . $userdata->id . '|max:255',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,' . $userdata->id . '|max:255',
                'city' => 'required|required_with:formatted_address',
                'phone' => 'required|numeric',
                'skills' => 'required',
                'avatar' => 'file|mimes:jpeg,png,jpg|max:5120'
                // 'newPw' => 'string|min:6|rNewPw',
            ])->validate();
            // prepare
            $dataToStore = $request->except(['avatar', 'oldPw', 'newPw', 'newPw_confirmation', '_token', 'is_api', 'exeed_limit']);
            // if change in password
            if ($request->phone)
                Validator::make($request->all(), ['phone' => 'numeric'])->validate();
            if ($request->oldPw || $request->newPw || $request->newPw_confirmation) {
                $this->ValidateOldPassword($request)->validate();
                $dataToStore['password'] = bcrypt($request->newPw);
            }
            // image avatar
            if ($request->file('avatar')) {
                $file = Flexihelp::upload($request->file('avatar'), 'useravatar');
                $dataToStore['avatar'] = $file->pathToSave;
            }
            // update
            $update_detector = User::where(['id' => $userdata->id])->update($dataToStore);
            $data['userdata'] = $userdata = User::find($userdata->id);
            if ($update_detector) {
                return redirect(app()->getLocale() . '/supplier/profile/' . $userdata->username);
            }
        }
        return view('supplier.profile.edit', $data);
    }

    public function addservice(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'price_per_unit' => 'required|numeric|between:0,99999999999,max:11',
            'price_unit' => 'required',
            'description' => 'required|max:2500',
            'terms' => 'required|max:2500',
            'question1' => 'required|max:200',
            'question2' => 'max:200',
            'question3' => 'max:200',
            'videourl[]' => 'url'
        ]);
        $datatostore = $request->except(['exeed_limit', 'img', 'videourl', 'parent', 'sub', 'subsub']);
        $categoryslug = ($request->input('subsub')) ? $request->input('subsub') : $request->input('sub');
        $category = Category::where('slug', $categoryslug)->first();
        if (empty($category)) {
            $data['status'] = false;
            $data['message'] = "NO Category with this id";
            $data['category'] = "you have to select a valid category";
            return response()->json($data, 422);
        } else {
            $subs = Category::where('parent_id', $category['id'])->get();
            if (count($subs)) {
                $data['status'] = false;
                $data['message'] = "NO Category with this id";
                $data['category'] = "you have to select a valid category";
                return response()->json($data, 422);
            }
        }
        $datatostore['category_id'] = $category['id'];
        $datatostore['supplier_id'] = Auth::user()->id;
        $service = Service::create($datatostore);
        // Saving= Urls in serviceVeds table (( each service has up to 3 veds ))
        if ($request->videourl) {
            foreach ($request->videourl as $key => $value):
                if ($value && filter_var($value, FILTER_VALIDATE_URL)) {
                    $ServiceVideo = new ServiceVideo;
                    $ServiceVideo->url = $value;
                    $ServiceVideo->service()->associate($service);
                    $ServiceVideo->save();
                }
            endforeach;
        }

        $images = $request->file('img');
        if ($images) {
            for ($i = 0; $i <= (count($images) - 1); $i++):
                $file = Flexihelp::upload($images[$i], 'serviceportofilo');
                if (@$file->pathToSave) {
                    $servicephoto = new ServicePhoto;
                    $servicephoto->create(['service_id' => $service->id, 'filename' => $file->pathToSave]);
                } else {
                    $data['image_message'] = $file;
                }
            endfor;
        }
        $noti = new \App\Http\Controllers\NotificationController();
        $user = User::where('id', $service->supplier_id)->first();
        $noti->SendNewService($user, $service);
        $data['status'] = true;
        $data['service'] = $service;
        return response()->json($data, 201);
    }

    public function update_service(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'price_per_unit' => 'required|numeric|between:0,99999999999,max:11',
            'price_unit' => 'required',
            'description' => 'required|max:2500',
            'terms' => 'required|max:2500',
            'question1' => 'required'
        ]);

        $categoryslug = ($request->input('subsub')) ? $request->input('subsub') : $request->input('sub');
        $category = Category::where('slug', $categoryslug)->first();
        if (empty($category)) {
            $data['status'] = false;
            $data['message'] = "NO Category with this id";
            $data['category'] = "you have to select a valid category";
            return response()->json($data, 422);
        } else {
            $subs = Category::where('parent_id', $category['id'])->get();
            if (count($subs)) {
                $data['status'] = false;
                $data['message'] = "NO Category with this id";
                $data['category'] = "you have to select a valid category";
                return response()->json($data, 422);
            }
        }
        $datatostore = $request->except(['exeed_limit', 'img', 'videourl', 'parent', 'sub', 'subsub', '_token']);
        $datatostore['category_id'] = $category['id'];
        Service::where('id', $id)->update($datatostore);
        $service = Service::where('id', $id)->first();
        // Saving video Urls in serviceVeds table (( each service has up to 3 veds ))
        if ($request->videourl) {
            ServiceVideo::where('service_id', $id)->delete();
            foreach ($request->videourl as $key => $value):
                if ($value && filter_var($value, FILTER_VALIDATE_URL)) {
                    $ServiceVideo = new ServiceVideo;
                    $ServiceVideo->url = $value;
                    $ServiceVideo->service_id = $id;
                    $ServiceVideo->save();
                }
            endforeach;
        }
        $images = $request->file('img');

        if ($images) {
            for ($i = 0; $i <= (count($images) - 1); $i++):
                $file = Flexihelp::upload($images[$i], 'serviceportofilo');
                $servicephoto = new ServicePhoto();
                $servicephoto->create(['service_id' => $id, 'filename' => $file->pathToSave]);
            endfor;
        }
        $data['status'] = true;
        $data['service'] = $service;
        return response()->json($data, 201);
    }
}
