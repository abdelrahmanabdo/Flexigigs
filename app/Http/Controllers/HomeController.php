<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Helpers\Flexihelp;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Category;
use App\Gigs;
use App\Service;
use Carbon\Carbon;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['gigs'] = Gigs::limit(3)->where('status',0)->where('deadline','>=',date('Y-m-d'))->orderBy('created_at','DESC')->get();
        $data['services'] = Service::limit(4)->orderBy('created_at','DESC')->get();
        $lang = ($request['is_api'])?$request->lang:app()->getLocale();
        $categories = Category::where([['parent_id', 0],['featured',1]])->orderBy('name')->limit(6)->get();
         $data['categories'] = $categories;
         // $data['current'] = ;
         $data['howitwork'] = config('staticpages_'.$lang.'.howitwork');
         if ($request['is_api']) {
            
        } else {
            if(Auth::check()){
                if (!$request->session()->has('member_type')) {
                    $request->session()->put('member_type',Auth::user()->member_type);
                }
            }
            return view('home',$data);
            // return HTML response
        }
    }
    public function changeType(Request $request , $member_type)
    {
        if ($member_type === "supplier" || $member_type === "customer") {
            $type =($member_type === "supplier")?0:1;
            if(!$request['is_api'])
              $request->session()->put('member_type',$type);
            $user_id = ($request['is_api'])?$request->user_id:Auth::user()->id;
            User::where('id',$user_id)->update(['member_type'=>$type]);
            $redirect_url = explode('/',$request->url);
            if($request->url && (in_array('customer', $redirect_url)||in_array('supplier', $redirect_url))){
              if (in_array('supplier', $redirect_url)) {
                $followers = 20;
                return ($request['is_api'])?response()->json(['status'=>true,'message'=>'member type changed with success'],200):redirect()->route('customer_orders');
              }elseif(in_array('customer', $redirect_url)){
                return ($request['is_api'])?response()->json(['status'=>true,'message'=>'member type changed with success'],200):redirect()->route('supplier_gigs');
              }else{
                return ($request['is_api'])?response()->json(['status'=>true,'message'=>'member type changed with success'],200):redirect()->route('home');
              }
            }else{
              return ($request['is_api'])?response()->json(['status'=>true,'message'=>'member type changed with success'],200):redirect($request->url);
            }
        }else{
            abort(404);
        }
    }
    public function search(Request $request,$type)
    {
        if ($type === "services") {
            ///=======================service==============================
            $page_num = ($request->page)?($request->page-1):0;
            $limit = ($request->limit)?$request->limit:6;
            $offset = $page_num*$limit;
            // start Query
            $services = $services_pagination = Service::has('user')
                                                      ->limit($limit)
                                                      ->offset($offset)
                                                      ->where([['name','like','%'.$request->free_text.'%']])
                                                      ->orWhere('description','like','%'.$request->free_text.'%');
            // add sort to the Query
            if ($request->sort_by){
                if ($request->sort_by == 'price_desc') {
                  $services = $services->orderBy('price_per_unit','DESC');
                }elseif ($request->sort_by == 'price_asc') {
                  $services = $services->orderBy('price_per_unit');
                }elseif($request->sort_by == 'rating_desc'){
                  $services = $services->orderBy('rating','DESC');
                }elseif($request->sort_by == 'rating_asc'){
                  $services = $services->orderBy('rating','ASC');
                }
            }
            $services = $services->with(['user','photos','category'])->get();
            $data['services_pagination'] = $services_pagination->paginate($limit)->appends(['free_text'=>$request->free_text,'sort_by'=>$request->sort_by]);
            // end query 
            if (count($services)>0){
              $data['status'] = true;
              $data['result'] = $services;
              $data['pagination_status'] = true;
            }else{
              $data['status'] = false;
              $data['result'] = false;
              $data['message'] = 'no more data';
              $data['pagination_status'] = false;
            }
            return view('search.service',$data);
        }elseif ($type === "categories") {
            ///=======================categories==============================
            $data['categories'] = Category::where('name','like','%'.$request->free_text.'%')
                                          ->orWhere('intro','like','%'.$request->free_text.'%')
                                          ->orderBy('created_at','DESC')
                                          ->get();
            return view('search.category',$data);
        }elseif ($type === "gigs") {
            ///=======================gigs==============================
          // Skills in filter
          $page = (($request->page)?$request->page:1)-1;
          $limit = ($request->limit)?$request->limit:6;
          $offset = $page*$limit;
          // start Query
          $gigs = $gigs_pagination = Gigs::limit($limit)
                                     ->offset($offset)
                                     ->where([['title','like','%'.$request->free_text.'%'],['deadline','>=',date('Y-m-d')]])
                                     ->orWhere('description','like','%'.$request->free_text);
         // add sort to the Query
         if ($request->sort_by){
          if ($request->sort_by == 'price_desc') {
            $gigs->orderBy('price','DESC');
          }elseif ($request->sort_by == 'price_asc') {
            $gigs->orderBy('price');
          }elseif($request->sort_by == 'created_asc'){
            $gigs->orderBy('created_at');
          }elseif($request->sort_by == 'created_desc'){
            $gigs->orderBy('created_at');
          }elseif($request->sort_by == 'deadline_desc'){
            $gigs->orderBy('deadline','DESC');
          }elseif($request->sort_by == 'deadline_asc'){
            $gigs->orderBy('deadline');
          }else{
            $gigs->orderBy('created_at','DESC');
          }
        }else{
            $gigs->orderBy('created_at','DESC');
        }
        $gigs = $gigs->with(['skills.category'])->get();
        // end query 
        $data['result'] =(count($gigs)>0)?$gigs:false;
        $data['gigs_pagination'] = $gigs_pagination->paginate($limit)->appends(['sort_by'=>$request->sort_by, 'free_text'=>$request->free_text]);
        $data['gigs'] = Gigs::where('title',$request->free_text)->orderBy('created_at','DESC')->get();
        return view('search.gig',$data);
	   }
    }
    public function applejson()
    {
      $data['applinks'] = [
        "apps"=>[],
        "details"=>[
          [
            "appID"=>"NM7J7GSGKQ.flexigigs.me",
            "paths"=>["*"]
          ]
        ]
      ];
      return response()->json($data,200);
    }
    public function system_guide()
    {
      // Order success scenario
      $success_order['HH_order']=['status'=>0];
      $success_order['GH_accept_order']=['status'=>1];
      $success_order['HH_pay_for_order']=['status'=>2];
      $success_order['GH_says_order_done']=['status'=>3];
      $success_order['HH_says_confirm_done']=['status'=>4];
      $success_order['Admin_transfare_mony_to_GH']=['status'=>5];
      // Order falier scenario
      $falier_order['GH_reject_order'] = ['falier'=>1];
      $falier_order['HH_reject_pay_for_order'] = ['falier'=>2];
      $falier_order['GH_brake_deadline'] = ['falier'=>3];
      $falier_order['HH_had_conflect'] = ['falier'=>4];
      $falier_order['GH_had_conflect'] = ['falier'=>5];
      // Order Admin Actions
      $admin_actions['admin_mark_completed'] = ['admin_actions'=>1];
      $admin_actions['admin_cancel_order'] = ['admin_actions'=>2];
      // request_scenario
      $request['HH_request_service']=['status'=>0];
      $request['GH_aproved_request']=['status'=>1];
      // application_scenario
      $application['GH_make_application']=['status'=>0];
      $application['HH_accept_application']=['status'=>1];
      // Gig_scenario
      $gig['HH_create_gig']=['status'=>0,'open'];
      $gig['HH_accept_application']=['status'=>1,'closed'];
      $gig['HH_cancel_gig']=['status'=>2,'canceled'];
      $data['Order_life_cycle'] = ['Order success scenario'=>$success_order,
                                   'Order falier scenario'=>$falier_order,
                                   'Order Admin Actions'=>$admin_actions ];
      $data['request_scenario'] = $request;
      $data['application_scenario'] = $application;
      $data['Gig_scenario'] = $gig;
      return response()->json($data,200);
    }
}
