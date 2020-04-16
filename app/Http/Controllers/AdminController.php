<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Orders;
use App\Gigs;
use App\Service;
use App\ServiceVideo;
use App\ServicePhoto;
use App\Category;
use App\Reviews;
use App\Messages;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Flexihelp;
use Carbon\Carbon;

class AdminController extends Controller
{
	public function __construct()
  {
      // $this->middleware('auth');
  }
  public function dashboard(Request $request)
  {
   	// return redirect('admin/categories');
   	$data['userdata'] = Auth::user();
   	$data['parents_categories']= Category::where('parent_id',"<=","0")->orderBy('name')->get();
   	$my_services =  Service::with(['videos','photos'])->get();
   	foreach ($my_services as $service) {
   		$service->subsub_cat = Category::find($service->category_id); 
   		$service->sub_cat = Category::find($service->subsub_cat['parent_id']); 
   		if ($service->sub_cat['parent_id']==0) {
     		$service->parent_cat = $service->sub_cat; 
     		$service->sub_cat = $service->subsub_cat; 
   		}else{
     		$service->parent_cat = Category::find($service->sub_cat['parent_id']); 
   		}
   	}
   	$data['my_services'] = $my_services;
    return view('admin.dashboard.dashboard',$data);
  }
   // start categories
  public function categories()
  {
   	$data['parents_categories']= Category::where('parent_id',"<=","0")->orderBy('name')->get();
   	$parent_categories = Category::where('parent_id',"<=","0")->get();
   	foreach ($parent_categories as $parent) {
   		$children = Category::where('parent_id',$parent->id)->get();
   		if (!empty($children)) {
   			foreach ($children as $child) {
   				$child->children =Category::where('parent_id',$child->id)->get(); 
   			}
   		}
   		$parent->children = $children; 
   	}
    $data['counter_title'] = trans('service_category.dashboard_categories_title');
    $data['counter'] = Category::count();
   	$data['parent_categories']= $parent_categories;
    return view('admin.categories.list',$data);
  }
  public function addcategory(Request $request)
  {
   	$this->validate($request,[
      'name' => 'required|max:100',
      'name_ar' => 'required|max:100',
      'slug' => 'required|max:100|unique:categories',
      'intro' => 'max:2500',
      'intro_ar' => 'max:2500'
    ]);
   	$datatostore = $request->except(['exeed_limit','image','slug']);
   	if ($request->file('image'))
  	  $datatostore['image'] = Flexihelp::upload($request->file('image'),'categoryicon')->pathToSave;
    $datatostore['slug'] = Flexihelp::clean($request->slug);
    $category = Category::create($datatostore);
    $data['status'] = true;
    $data['category'] = $category;
    return response()->json($data , 201);
  }
  public function editcategory(Request $request)
  {
    $this->validate($request,[
      'name' => 'required|max:100',
      'name_ar' => 'required|max:100',
      'slug' => 'required|unique:categories,slug,'.$request->id.'|max:100',
      'intro' => 'max:2500',
      'intro_ar' => 'max:2500'
    ]);
    $datatostore = $request->except(['exeed_limit','id','image','slug']);
    if ($request->file('image'))
        $datatostore['image'] = Flexihelp::upload($request->file('image'),'categoryicon')->pathToSave;
    $datatostore['slug'] = Flexihelp::clean($request->slug);
  	$service = Category::find($request->id)->update($datatostore);
  	$data['status'] = true;
    $data['service'] = $service;
    return response()->json($data , 201);
  }
  // end categortis
  protected function ValidateOldPassword(Request $request)
  {
    $userdata = User::where('id',Auth::user()->id)->first();
     // var_dump(Hash::check( $request->oldPw ,$userdata['password']));//exit;
    Validator::extend('like_old', function ($attribute, $value, $parameters, $validator) use ($request,$userdata)  {
      return Hash::check( $request->oldPw ,$userdata['password']);
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
  public function editProfile(Request $request)
  {
  	$data['userdata'] = $userdata = Auth::user();
      if ($request->isMethod('post')) {
        $validator = Validator::make($request->all(),[
          'username' => 'required|unique:users,username,'.$userdata->id.'|max:255',
          'first_name' => 'required',
          'last_name' => 'required',
          'email' => 'required|email|unique:users,email,'.$userdata->id.'|max:255',
          'city' => 'required|required_with:formatted_address',
          'phone' => 'required|numeric',
          // 'newPw' => 'string|min:6|rNewPw',
          'avatar' => 'file|mimes:jpeg,png,jpg|max:5120'

        ])->validate();
        // prepare   
        $dataToStore = $request->except(['exeed_limit','avatar','oldPw','newPw','newPw_confirmation','_token','is_api']);
        // if change in password
        if ($request->oldPw || $request->newPw || $request->newPw_confirmation) {
             $this->ValidateOldPassword($request)->validate();
            $dataToStore['password'] = bcrypt($request->newPw);
        }
        if ($request->phone) 
          validator::make($request->all(),['phone'=>'numeric'])->validate();
       // image avatar
       if($request->file('avatar')){
            $img = Image::make($request->file('avatar')->getRealPath());
            $file = Flexihelp::upload($request->file('avatar'),'useravatar');
            $dataToStore['avatar'] = $file->pathToSave;
        }
        // update
        $update_detector = User::where(['id'=>Auth::user()->id])->update($dataToStore);
        $data['userdata'] = $userdata = User::find($userdata->id);
        if ($update_detector) {
          return redirect(app()->getLocale().'/admin/dashboard/users');
        }
    }
    return view('admin.profile.edit',$data);
  }
   
  public function updateService(Request $request, $id)
  {
 		if (Service::where('id', $id)->first()) {
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'price_per_unit' => 'required|numeric|between:0,99999999999,max:11',
        'price_unit' => 'required',
        'description' => 'required|max:2500',
        'terms' => 'required|max:2500',
        'question1' => 'required|max:200',
        'question2' => 'max:200',
        'question3' => 'max:200',
      ]);
      if ($validator->fails()) {
        $data['status']=false;
        $data['message']= $validator->errors()->toArray();
        return response()->json($data,422);
      }
  		if(!Category::where('id',$request->category_id)->first()){
  			$data['status'] = false;
      	$data['message'] = "NO Category with this id";
      	return response()->json($data , 400);exit;
  		}

      $datatostore = $request->except(['exeed_limit','img','videourl','parent','sub','subsub']);
      $datatostore['category_id'] = $category['id'];
      Service::find($id)->update($datatostore);
      $service = Service::find($id)->with('photos')->first();
          // Updating video Urls in serviceVeds table (( each service has up to 3 veds ))
    	if ($request->videourl) {
          ServiceVideo::where('service_id',$id)->delete();
          foreach($request->videourl as $key => $value):
            if ($value && filter_var($value, FILTER_VALIDATE_URL)) {
              $ServiceVideo = new ServiceVideo;
              $ServiceVideo->url = $value;
              $ServiceVideo->service_id = $id;
              $ServiceVideo->save();
            }
          endforeach;
        }
      $images=$request->file('img');
      if ($images) {
        for( $i=0; $i<=(count($images) - 1); $i++):
          $file = Flexihelp::upload($images[$i],'serviceportofilo');
          $servicephoto = new ServicePhoto;
          $servicephoto->create(['service_id'=>$id,'filename' => $file->pathToSave ]);
          endfor;
      }
  		$data['status'] = true;
  		$data['service'] = $service;
      return response()->json($data , 200);
 		}else{
      $data['status'] = false ;
      $data['message'] = 'record not found';
      return response()->json($data , 400);
 		}
  }
  public function filterServices(Request $request) 
  {
    $data['userdata'] = Auth::user();
    $data['parents_categories']= Category::where('parent_id',"<=","0")->orderBy('name')->get();
    ///=======================pagination
    $page_num = ($request->page)?($request->page-1):0;
    $limit = ($request->limit)?$request->limit:10;
    $offset = $page_num*$limit;
    $where = [];
    // Start where array
    $searchcat_id = ($request->category_id)?$request->category_id:@$category_id;
    if ($searchcat_id)
      $where[]  = ['category_id',$searchcat_id];
    if($request->price_from)
      $where[]  = ['price_per_unit','>=',$request->price_from];
    if($request->price_to)
      $where[]  = ['price_per_unit','<=',$request->price_to];
    if($request->date_from){
      $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
      $where[]  = ['created_at','>=',$date_from];
    }
    if($request->date_to){
      $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
      $where[]  = ['created_at','<=',$date_to];
    }
    if($request->rating)
      $where[]  = ['rating','>=',$request->rating];
    if ($request->service_name){
      $where[]  = ['name','like','%'.$request->service_name.'%'];
      // $where[]  = ['description','like','%'.$request->service_name];
    }
    // End where array
    // start Query
    $services = $services_pagination = Service::has('user')
                                              ->limit($limit)
                                              ->offset($offset)
                                              ->orderBy('created_at','DESC')
                                              ->where($where);
    if($request->supplier_name){
      // var_dump($request->location);exit;
      $services->whereHas('user',function($query) use($request){
        $query->where('username','like','%'.$request->supplier_name.'%');
      });
    }
    $services = $services->with(['videos','photos'])->get();
    $data['services_pagination'] = $services_pagination->paginate($limit)
                                                       ->appends(['price_from'=>$request->price_from,
                                                                  'price_to'=>$request->price_to,
                                                                  'service_name'=>$request->service_name,
                                                                  'rating'=>$request->rating,
                                                                  ]);
    // end query 
    if (count($services)>0){
      foreach ($services as $service) {
        $service->subsub_cat = Category::find($service->category_id); 
        $service->sub_cat = Category::find($service->subsub_cat['parent_id']); 
        if ($service->sub_cat['parent_id']==0) {
          $service->parent_cat = $service->sub_cat; 
          $service->sub_cat = $service->subsub_cat; 
        }else{
          $service->parent_cat = Category::find($service->sub_cat['parent_id']); 
        }
        $service['user'] = User::find($service->supplier_id);
      }
      $data['status'] = true;
      $data['my_services'] = $services;
      $data['months'] = Service::get()->groupBy(function($d) {
           return Carbon::parse($d->created_at)->format('Y-m');
        });
      $data['min_price'] = Service::min('price_per_unit');
      $data['max_price'] = Service::max('price_per_unit');
      $data['pagination_status'] = true;
    }else{
      $data['status'] = false;
      $data['my_services'] = false;
      $data['message'] = 'no more data';
      $data['pagination_status'] = false;
    }
    $data['category'] = Category::where('id',$searchcat_id)->first();
    $data['count_all'] = Service::where($where)->count();
    $data['page_number'] = $page_num;
    $data['counter_title'] = trans('general.dashboard_nav_services');
    $data['counter'] = Service::count();
    if ($request['is_api']) {
      return response()->json($data,200);
    }else{
      return view('admin.services.list',$data);
    }
  }
  public function orders(Request $request)
  {
    // user data
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
    // pagination
    $page_num = ($request->page)?$request->page:1;
    $limit = ($request->limit)?$request->limit:10;
    $offset = $page_num*$limit;
    // where
    $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
    $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
    $where   = [];
    $where[] = ['claim_refund',0];
    if($request->date_from)
      $where[] = ['created_at','>=',$date_from];
    if($request->date_to)
      $where[] = ['created_at','<=',$date_to];
    if($request->status=="0"||($request->status&&$request->status != 3)){
      $where[] = ['status',$request->status];
    }
    
    if($request->type)
      $where[] = ['type',$request->type];
    // prepering model
    $orders = Orders::with(['request.service','application.skills.category','customer','supplier'])->where($where);
    if ($request->status==3) 
        $orders->whereIn('status',[3,4,6]);
    if($request->customer){
      $orders->whereHas('customer',function ($query)use($request) {
        $query->where('username','like','%'.$request->customer.'%');
      });
    }
    if($request->supplier){
      $orders->WhereHas('supplier',function ($query)use($request) {
        $query->where('username','like','%'.$request->supplier.'%');
      });
    }
    
    // sorting it
    if($request->sort_by == "created_asc")
      $orders->orderBy('created_at');
    elseif($request->sort_by == "created_desc")
      $orders->orderBy('created_at','DESC');
    else
      $orders->orderBy('created_at','DESC');
    // boooooo fire 
    $orders_result = $orders->paginate($limit)
                            ->appends(['status'=>$request->status,
                                       'date_from'=>$request->date_from,
                                       'date_to'=>$request->date_to,
                                       'type'=>$request->type,
                                       'customer'=>$request->customer,
                                       'supplier'=>$request->supplier,
                                       'sort_by'=>$request->sort_by,
                                      ]);
    foreach ($orders_result as $order) {
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
    }
    // get max and min price in service
    $service_min_price = Service::min('price_per_unit');
    $service_max_price = Service::max('price_per_unit');
    // get max and min price in service
    $gig_min_price = Gigs::min('price');
    $gig_max_price = Gigs::max('price');
    // fire max and min price
    $data['min_price'] = ($service_min_price<$gig_min_price)?$service_min_price:$gig_min_price;
    $data['max_price'] = ($service_max_price<$gig_max_price)?$service_max_price:$gig_max_price;
    // fire counter data
    $data['counter_title'] = trans('general.dashboard_nav_orders');
    $data['counter'] = Orders::count();
    // fire final order results 
    $data['orders'] = $orders_result;
    $data['months'] = Orders::get()->groupBy(function($d) {
       return Carbon::parse($d->created_at)->format('Y-m');
    });
    return ($request['is_api'])?response()->json($data,200):view('admin.orders.list',$data);
  }
  public function gigs(Request $request)
  {
    // user data
    $data['userdata'] = $userdata =($request['is_api'])?User::where('id',$request->customer_id)->first():Auth::user();
    if (!$userdata) {
        if ($request['is_api']) {
          $data['status'] = false;
          $data['message'] = 'userdata is invalid';
          response()->json($data,404);
        }else{
          abort(404);
        }
    }
    // post
    $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
    $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
    // pagination
    $page_num = ($request->page)?$request->page:0;
    $limit = ($request->limit)?$request->limit:10;
    $offset = $page_num*$limit;
    // where
    $where  = [];
    $whereNotIn = [];
    if($request->status=="0"||$request->status){
      if ($request->status=="0"||$request->status==5) {
        $where[] = ['status',$request->status];
      }else{
        $where[] = ['status','>',0];
        $whereNotIn = [0,5];
      }
    }
    if($request->free_text)
      $where[] = ['title','like','%'.$request->free_text.'%'];
    if($request->date_from)
      $where[] = ['deadline','>=',$date_from];
    if($request->date_to)
      $where[] = ['deadline','<=',$date_to];
    if($request->price_from)
      $where[] = ['price','>=',$request->price_from];
    if($request->price_to)
      $where[] = ['price','<=',$request->price_to];
    // preparing
    $posts = Gigs::where($where)->with(['customer','applications.supplier','skills.category']);
    if (!empty($whereNotIn)) {
      $posts->whereNotIn('status',$whereNotIn);
    }
    // sorting
    if($request->sort_by == "price_desc")
      $posts->orderBy('price','DESC');
    elseif($request->sort_by == "price_asc")
      $posts->orderBy('price');
    elseif($request->sort_by == "created_asc")
      $posts->orderBy('created_at');
    elseif($request->sort_by == "created_desc")
      $posts->orderBy('created_at','DESC');
    else
      $posts->orderBy('status')->orderByDesc('created_at');
    // fire
    $data['counter_title'] = trans('general.dashboard_nav_gigs');
    $data['counter'] = Gigs::count();
    // var_dump($posts->toSql());exit;
    $data['posts'] = $posts->paginate($limit)
                           ->appends(['status'=>$request->status,
                                      'free_text'=>$request->free_text,
                                      'date_from'=>$request->date_from,
                                      'date_to'=>$request->date_to,
                                      'sort_by'=>$request->sort_by,
                                      'price_form'=>$request->price_from,
                                      'price_to'=>$request->price_to,
                                     ]);
    $data['min_price'] = Gigs::min('price');
    $data['max_price'] = Gigs::max('price');
    $data['months'] = Gigs::get()->groupBy(function($d) {
       return Carbon::parse($d->created_at)->format('Y-m');
    });
    return ($request['is_api'])?response()->json($data,200):view('admin.gigs.list',$data);  
  }
  public function earnings(Request $request)
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
    $limit = ($request->limit)?$request->limit:10;
    $offset = $page_num*$limit;
    $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
    $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
    $where  = [];
    $where[] =['status','>=',3];
    if($request->date_from)
      $where[] = ['updated_at','>=',$date_from];
    if($request->date_to)
      $where[] = ['updated_at','<=',$date_to];
    if($request->status&&$request->status==5){
      $where[] = ['status','!=',4]; //canteceld
      $where[] = ['status','!=',6]; //paid
    }
    if($request->status&&$request->status==6)
      $where[] = ['status',$request->status];
    if($request->type)
      $where[] = ['type',$request->type];
    $orders = Orders::with(['request','customer','application.skills.category'])->where($where);
    if($request->sort_by == "created_asc")
      $orders->orderBy('created_at');
    elseif($request->sort_by == "created_desc")
      $orders->orderBy('created_at','DESC');
    else
      $orders->orderBy('created_at','DESC');
    if($request->supplier){
      $orders->WhereHas('supplier',function ($query)use($request) {
        $query->where('username','like','%'.$request->supplier.'%');
      });
    }
    $result = $orders->paginate($limit)
                     ->appends(['status'=>$request->status,
                               'date_from'=>$request->date_from,
                               'date_to'=>$request->date_to,
                               'type'=>$request->type,
                               'supplier'=>$request->supplier,
                               'sort_by'=>$request->sort_by,
                              ]);
    $data['orders'] = $result;
    $data['counter_title'] = trans('general.dashboard_nav_earnings');
    $data['counter'] = Orders::where('status','>=',3)->count();
    $data['months'] = Orders::get()->where('status','>=',3)->groupBy(function($d) {
       return Carbon::parse($d->created_at)->format('Y-m');
    });
    return ($request['is_api'])?response()->json($data,200):view('admin.earnings.list',$data);
  }
  public function refund(Request $request)
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
    $limit  = ($request->limit)?$request->limit:10;
    $offset = $page_num*$limit;
    $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
    $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
    $where   = [];
    $where[] = ['claim_refund','>',0];
    if($request->date_from)
      $where[] = ['updated_at','>=',$date_from];
    if($request->date_to)
      $where[] = ['updated_at','<=',$date_to];
    if($request->type)
      $where[] = ['type',$request->type];
    if($request->claim_refund)
      $where[] = ['claim_refund',$request->claim_refund];
    $orders = Orders::with(['request','customer','application.skills.category'])->where($where);
    if($request->sort_by == "created_asc")
      $orders->orderBy('created_at');
    elseif($request->sort_by == "created_desc")
      $orders->orderBy('created_at','DESC');
    else
      $orders->orderBy('created_at','DESC');
    if($request->supplier){
      $orders->WhereHas('supplier',function ($query)use($request) {
        $query->where('username','like','%'.$request->supplier.'%');
      });
    }
    $result = $orders->paginate($limit)
                     ->appends(['date_from'=>$request->date_from,
                               'date_to'=>$request->date_to,
                               'type'=>$request->type,
                               'supplier'=>$request->supplier,
                               'sort_by'=>$request->sort_by,
                              ]);
    $data['orders'] = $result;
    $data['counter_title'] = trans('general.dashboard_nav_earnings');
    $data['counter'] = Orders::where('status','>=',3)->count();
    $data['months'] = Orders::get()->where('status','>=',3)->groupBy(function($d) {
       return Carbon::parse($d->created_at)->format('Y-m');
    });
    return ($request['is_api'])?response()->json($data,200):view('admin.refund.list',$data);
  }
  public function changeToRefund(Request $request)
  {
    if($request->order_id){
      Orders::whereIn('id', $request->order_id)->update(['claim_refund' => 2]);
    }
    return redirect()->route('admin_refund',['date_from'=>$request->date_from,'date_to'=>$request->date_to,'type'=>$request->type,'supplier'=>$request->supplier,'sort_by'=>$request->sort_by]);
  }
   // just for edit on account data in profile and backend
  protected function ValidatePassword(Request $request)
  {
    $userdata = User::where('id',$request->id)->first();
    $password=Validator::make($request->all(), [
    'newPw'=>['required','regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
    'newPw_confirmation'=>['required','same:newPw'],
    ],['newPw.min'=>"password mast be more than 8 characters",
       'newPw.regex'=>"Password must be at least 8 charachters and contain at least one uppsercase letter and one digit",
     ]);
    return $password;
  }
  public function profile(Request $request,$id) {
    $data['userdata'] = $userdata = User::where('id',$id)->first();
    if ($request->isMethod('post')) {
      $validator = Validator::make($request->all(),[
        'username' => 'required|unique:users,username,'.$userdata->id.'|max:255',
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email,'.$userdata->id.'|max:255',
        'phone' => 'required|numeric',
        'city' => 'required|required_with:formatted_address',
        // 'newPw' => 'string|min:6|rNewPw',
        'avatar' => 'file|mimes:jpeg,png,jpg|max:5120'
      ])->validate();
      // prepare   
      if ($request->phone) 
          validator::make($request->all(),['phone'=>'numeric'])->validate();
      $dataToStore = $request->except(['exeed_limit','avatar','oldPw','newPw','newPw_confirmation','_token','is_api']);
      // if change in password
      if ($request->newPw || $request->newPw_confirmation) {
          $this->ValidatePassword($request)->validate();
          $dataToStore['password'] = bcrypt($request->newPw);
      }
      // image avatar
      if($request->file('avatar')){ 
          $img = Image::make($request->file('avatar')->getRealPath());
          $file = Flexihelp::upload($request->file('avatar'),'useravatar');
          $dataToStore['avatar'] = $file->pathToSave;
      }
      // update
      $update_detector = User::where(['id'=>$userdata->id])->update($dataToStore);
      $data['userdata'] = $userdata = User::find($userdata->id);  
      if ($update_detector) {
        return redirect(app()->getLocale().'/admin/dashboard/users');
      }
    }
    return view('admin.users.edit',$data);
  }
  public function conflects_messages(Request $request)
  {
    // user data
    $data['userdata'] = $userdata = Auth::user();
    $data['counter_title'] = trans('general.sort_option_conflect_msg');
    $data['counter'] =  Messages::Where([['order_id','>',0],['end_of_chat',1]])->count();
    return view('admin.messages.conflects.list',$data);
  }
  public function direct_messages(Request $request)
  {
    // user data
    $data['userdata'] = $userdata = Auth::user();
    $data['counter_title'] = trans('general.sort_option_direct_msg');
    $data['counter'] =  Messages::Where([['order_id','=',0],['end_of_chat',1],['id_from',$userdata->id]])
                                ->orWhere([['order_id','=',0],['end_of_chat',1],['id_to',$userdata->id]])
                                ->count();
    return view('admin.messages.direct.list',$data);
  }
  public function reviews(Request $request)
  {
    $limit = ($request->limit)?$request->limit:10;
    $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
    $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
    $where  = [];
    // prepare search 
    if($request->date_from)
      $where[] = ['created_at','>=',$date_from];
    if($request->date_to)
      $where[] = ['created_at','<=',$date_to];
    if($request->type)
      $where[] = ['type',$request->type];
    if($request->order_id)
      $where[] = ['order_id',$request->order_id];
    // start query
    $reviews = Reviews::where($where)->with(['service','application','supplier','user','order']);
    // search by username in 2 relation
    // if it customer review service/gig
    if ($request->type == 1) {
      if($request->user_from){
        $reviews->whereHas('user',function ($query) use($request) { 
          $query->where('username','like','%'.$request->user_from.'%');
        });
      }
      if($request->user_to){
        $reviews->whereHas('supplier',function ($query) use($request) {
          $query->where('username','like','%'.$request->user_to.'%');
        });
      }
    // if it supplier review customer
    }elseif($request->type == 2){
      if($request->user_from){
        $reviews->whereHas('supplier',function ($query) use($request) { 
          $query->where('username','like','%'.$request->user_from.'%');
        });
      }
      if($request->user_to){
        $reviews->whereHas('user',function ($query) use($request) {
          $query->where('username','like','%'.$request->user_to.'%');
        });
      }
    }
    $data['reviews'] =$reviews->paginate($limit)
                              ->appends(['date_from'=>$request->date_from,
                                         'date_to'=>$request->date_to,
                                         'user_from'=>$request->user_from,
                                         'user_to'=>$request->user_to,
                                         'order_id'=>$request->order_id,
                                         'type'=>$request->type,
                                        ]);
    // user data
    $data['userdata'] = $userdata = Auth::user();
    $data['counter_title'] = trans('general.dashboard_nav_reviews');
    $data['counter'] = Reviews::count();
    return view('admin.reviews.list',$data);
  }
  public function usermessages(Request $request)
  {
    if ($request->isMethod('post')) {
      $limit    = ($request->limit)?$request->limit:5;
      $offset   = ($request->page)?$request->page*$limit:0;
      $where = [];
      $where[] = ['end_of_chat',1];
      $where[] = ['order_id',0] ;
      if($request->date_to)
        $where[]  = ['created_at','<=',Flexihelp::query_date($request->date_to)]; 
      if($request->date_from)
        $where[]  = ['created_at','>=',Flexihelp::query_date($request->date_from)]; 
      $messages = Messages::with(['message_from','message_to'])
                         ->orderBy('created_at','desc')
                         ->where($where)
                        ;
      if($request->from){
        $messages->whereHas('message_from',function ($query) use($request) {
          $query->where('username','like','%'.$request->from.'%');
        });
      }
      if($request->to){
        $messages->whereHas('message_to',function ($query) use($request){
          $query->where('username','like','%'.$request->to.'%');
        });
      }
      $messages_result =
      $messages->paginate($limit)
               ->withPath(route('admin_usermessages'))
               ->appends([ 'date_from'=>$request->date_from,
                           'date_to'=>$request->date_to,
                           'form'=>$request->form,
                           'to'=>$request->to,
                          ]);
      if (count($messages_result)) {
        if ($request['is_api']) {
          $data['status'] = true;
          $data['messages'] = $messages_result;
          return response()->json($data , 200);
        }else{
          $data['messages'] = $messages_result;
          if ($request->type) {
            return view('admin.usermessages.parts.item',$data);
          }
        }
      }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 400);
      }
    }
    // user data
    $data['userdata'] = $userdata = Auth::user();
    $data['counter_title'] = trans('general.dashboard_nav_usersmessages');
    $data['counter'] = Messages::where('end_of_chat',1)->count();
    return view('admin.usermessages.list',$data);
  }
}
