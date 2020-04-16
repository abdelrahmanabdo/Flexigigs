<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Service;
use App\Helpers\Flexihelp;
use App\Gigs;
use App\Category;
use App\User;
use App\Favorite;
use App\ServicePhoto;
use App\Request as ServiceRequest;
use App\Orders;
use App\Applications;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Pagination\Paginator;
use Omnipay\Omnipay;
use App\Traits\GigComponant;
class CustomerController extends Controller
{
  use GigComponant;

	public function __construct()
    {
        // $this->middleware('auth');
    }
     public function dashboard(Request $request)
     {
     	// user data
     	$data['userdata'] = $userdata = Auth::user();
     	// favorite
     	$page_num = ($request->page_num)?$request->page_num:0;
         $limit = ($request->limit)?$request->limit:888888;
         $offset = $page_num*$limit;
         $favorites = Favorite::limit($limit)->offset($offset)->where('user_id', $userdata->id)->get();
         $servicefav=[];
         foreach ($favorites as $favorite) {
            $favorite->service = (object) Service::find($favorite->service_id);
            if($favorite->service){
              if (@$favorite->service->supplier_id) {
                $favorite->service->user = User::find($favorite->service->supplier_id);
                $favorite->service->photos = ServicePhoto::where('service_id',$favorite->service_id)->get();
              }
            }
            $servicefav[]=$favorite->service;
         }
         $data['favorites'] = $servicefav;
         $data['total_gig'] = Gigs::where('customer_id',$userdata->id)->count();
         $data['gigs'] = Gigs::where('customer_id',$userdata->id)->with(['attach','skills'])->get();
        return view('customer.dashboard.dashboard',$data);
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

         /*edited by Osman*/
      $dumy = 0;
      if($request->status == 7){
        // $orders->where('falier',0) ;
        $dumy=7;
        $request->merge(['status' => '1']);
       }


        // pagination
        $page_num = ($request->page)?$request->page:1;
        $limit = ($request->limit)?$request->limit:10;
        $offset = $page_num*$limit;
        // where
        $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
        $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
        $where  = [];
        $where[] =['customer_id',$userdata->id];
        $where[] =['claim_refund',0];
        if($request->type)
          $where[] = ['type',$request->type];
        if($request->order_id)
          $where[] = ['id',$request->order_id];
        if($request->date_from)
          $where[] = ['created_at','>=',$date_from];
        if($request->date_to)
          $where[] = ['created_at','<=',$date_to];
        if($request->status||$request->status=="0")
          $where[] = ['status',$request->status];

        if($dumy==7){
          $current = Carbon::now();

          $orders = Orders::with(['request.service','application.skills.category','customer','supplier','ser_review'])->where('customer_id',$userdata->id)->where('claim_refund',0);
          // dd($orders->get());
          if($request->has('type')){
            $orders->where('type',$request->type);
          }
          if($request->has('order_id')){
            $orders->where('id',$request->order_id);
          }
          if($request->has('date_from')){
            $orders->where('created_at','>=',$date_from);
          }
          if($request->has('date_to')){
            $orders->where('created_at','<=',$date_to);
          }
          if($request->has('status')){
            $orders->where(function ($query){
              $query->where('status',1)->where('falier',6)->
              orWhere('status',0)->//where('created_at')
              orWhere('status',6);
            });
          }
        }


        else{
        // prepering model
          $orders = Orders::with(['request.service','application.skills.category','customer','supplier','ser_review'])->where($where);
        }
        
        // dd($orders->get());
        /*->toSql();var_dump($orders);exit;*/
        if($request->type==1&&$request->search){
          $orders->WhereHas('request',function ($query)use($request) {
            $query->where('name','like','%'.$request->search.'%');
          });
        }elseif($request->type==2&&$request->search){
          $orders->WhereHas('application',function ($query)use($request) {
            $query->where('title','like','%'.$request->search.'%');
          });
        }

 
       // dd($orders->first());


        // sorting it
        if($request->sort_by == "created_asc")
          $orders->orderBy('created_at');
        else
          $orders->orderBy('created_at','DESC');
        // boooooo fire 
        $orders_result = $orders->paginate($limit)
                     ->appends(['status'=>$request->status,
                                'date_from'=>$request->date_from,
                                'date_to'=>$request->date_to,
                                'sort_by'=>$request->sort_by
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

          /*Osman edits*/
        $order->supplier;
        $order->customer;
        $order->application;
        $order->request;
        /*************/
        }

        $data['total_gig'] = Gigs::where('customer_id',$userdata->id)->count();
        $data['orders'] = $orders_result;
        $data['search_with'] = $request->except(['exeed_limit','page','limit','is_api']);

        /*Osman edits*/
        if(isset(Auth::user()->id)){
        $followerID = Auth::user()->id;
        $followeeID = $userdata->id;
        $followController = new FollowController();
        $isFollow = $followController->isFollow($followerID ,$followeeID );
        $data['isFollow'] = $isFollow;

        $followersNumber =  $followController->getFollowersNumber($followeeID);
        $data['followers'] = $followersNumber;
      }
        /********************/
        return ($request['is_api'])?response()->json($data,200):view('customer.orders.list',$data);
     }
      public function refund(Request $request)
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
        // pagination
        $page_num = ($request->page)?$request->page:1;
        $limit = ($request->limit)?$request->limit:10;
        $offset = $page_num*$limit;
        // where
        $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
        $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
        $where  = [];
        $where[] = ['customer_id',$userdata->id];
        $where[] = ['claim_refund','>',0];
        if($request->order_id)
          $where[] = ['id',$request->order_id];
        if($request->claim_refund)
          $where[] = ['claim_refund',$request->claim_refund];
        if($request->fawryRefNo)
          $where[] = ['fawryRefNo',$request->fawryRefNo];
        if($request->date_from)
          $where[] = ['created_at','>=',$date_from];
        if($request->date_to)
          $where[] = ['created_at','<=',$date_to];
        // prepering model
        $orders = Orders::with(['request.service','application.skills.category','customer','supplier','ser_review'])->where($where);
        /*->toSql();var_dump($orders);exit;*/
        // if ($request->status==3) 
        // $orders->whereIn('status',[3,4,6]);
        // sorting it
        if($request->sort_by == "created_asc")
          $orders->orderBy('created_at');
        else
          $orders->orderBy('created_at','DESC');
        // boooooo fire 
        $orders_result = $orders->paginate($limit)
                     ->appends(['status'=>$request->status,
                                'date_from'=>$request->date_from,
                                'date_to'=>$request->date_to,
                                'sort_by'=>$request->sort_by
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
        $data['total_gig'] = Gigs::where('customer_id',$userdata->id)->count();
        $data['orders'] = $orders_result;
        $data['search_with'] = $request->except(['exeed_limit','page','limit','is_api']);
        return ($request['is_api'])?response()->json($data,200):view('customer.refund.list',$data);
     }
     public function posts(Request $request)
     {
        // user data
        $data['userdata'] = $userdata =($request['is_api'])?User::where('id',$request->customer_id)->first():$request->user();
        if (!$userdata) {
            if ($request['is_api']) {
              $data['status'] = false;
              $data['message'] = 'userdata is invalid';
              response()->json($data,400);
            }else{
              abort(404);
            }
        }
        $limit = ($request->limit)?$request->limit:10;
        $where  = [];
        $where[] = ['customer_id',$userdata->id];
        // where
        if($request->status=="0"||$request->status){
          if ($request->status=="0"||$request->status) {
            $where[] = ['status',$request->status];
          }else{
            $where[] = ['status','>',0];
            $where[] = ['status','!=',5];
          }
        }
        $data['posts'] = $this->gig_filter($request,$where)->with(['customer','applications.supplier','skills.category','supplier_type'])
                                                           ->paginate($limit)
                                                           ->appends($request->except(['exeed_limit','page','limit','is_api']));
        $data['total_gig'] = Gigs::where('customer_id',$userdata->id)->count();
        $data['search_with'] = $request->except(['exeed_limit','page','limit','is_api']);
        return ($request['is_api'])?response()->json($data,200):view('customer.posts.list',$data);
     }
    
     public function favorites(Request $request)
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
        // favorite
        $page_num = ($request->page_num)?$request->page_num:0;
        $limit = ($request->limit)?$request->limit:9;
        $offset = $page_num*$limit;
        $favorites = Favorite::limit($limit)
                            ->with(['service.photos','service.videos','service.user'])
                            ->offset($offset)
                            ->where('user_id', $userdata->id)
                            ->paginate($limit);
        foreach ($favorites as $favorite) {
          if ($favorite->service) {
            $favorite->service->rate = Flexihelp::get_stars('service',$favorite->service->id,true);
          }
        } 
        $servicefav=[];
        $data['favorites'] = $favorites;
        $data['total_gig'] = Gigs::where('customer_id',$userdata->id)->count();
        return ($request['is_api'])?response()->json($data,200):view('customer.favorites.list',$data);
     }
     public function messages(Request $request)
     {
        // user data
        $data['userdata'] = $userdata = Auth::user();
        $data['total_gig'] = Gigs::where('customer_id',$userdata->id)->count();
        return view('customer.messages.list',$data);
     }
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
          'city' => 'required|required_with:formatted_address',
          'email' => 'required|email|unique:users,email,'.$userdata->id.'|max:255',
          'phone' => 'required|numeric',
          // 'newPw' => 'string|min:6|rNewPw',
          'avatar' => 'file|mimes:jpeg,png,jpg|max:5120'
        ])->validate();
        // prepare   
        $dataToStore = $request->except(['exeed_limit','avatar','oldPw','newPw','newPw_confirmation','_token','is_api','redirect_to']);
        // if change in password
        if ($request->oldPw || $request->newPw || $request->newPw_confirmation) {
             $this->ValidateOldPassword($request)->validate();
            $dataToStore['password'] = bcrypt($request->newPw);
        }
        if ($request->phone)
          Validator::make($request->all(),['phone' => 'numeric'])->validate();
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
          return ($request->redirect_to)?redirect($request->redirect_to):redirect('customer/reviews/'.$userdata->username);
        }
      }
        return view('customer.profile.edit',$data);
     }
     public function getFavorite(Request $request , $id) {
       if ($request->pagination) {
         $page_num = ($request->page_num)?$request->page_num:0;
         $limit = ($request->limit)?$request->limit:5;
         $offset = $page_num*$limit;
         $favorites = Favorite::limit($limit)->offset($offset)->where('user_id', $id)->get();
         foreach ($favorites as $favorite) {
            $favorite->service = Service::find($favorite->service_id);
            if($favorite->service){
              $favorite->supplier_data = User::find($favorite->service->supplier_id);
              $favorite->service_pics =  ServicePhoto::where('service_id',$favorite->service_id)->first();

            }
         }
       }else{
         $favorites = Favorite::where('user_id', $id)->get();
         foreach ($favorites as $favorite) {
            $favorite->service = Service::find($favorite->service_id);
            if($favorite->service){
              $favorite->supplier_data = User::find($favorite->service->supplier_id);
              $favorite->service_pics =  ServicePhoto::where('service_id',$favorite->service_id)->first();
            }
         }
       }
       if ($favorites) {
         $data['status'] = true;
         $data['list'] = $favorites;
         return response()->json($data , 200);
       }
     }
}
