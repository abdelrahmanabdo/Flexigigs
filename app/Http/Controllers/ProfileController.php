<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\Flexihelp;
use App\Service;
use App\Gigs;
use App\Category;
use App\User;
use App\Reviews;
use App\Http\Controllers\FollowController ;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
     public function supplier(Request $request,$username)
     {
        $data['userdata'] = $userdata = (object) User::where("username",$username)->first();
        if (!isset($userdata->id)){
            if($request['is_api']){
                $errors['status'] = false;
                $errors['message'] = 'can`t found record';
                response()->json($errors,400);
            }else{
                abort(404);
            }
        }
        $data['skills'] = Flexihelp::userSkills($userdata->skills);
        if (!$request['is_api']) {
            if ($request->session()->has('profile_views')) {
                $views = $request->session()->get('profile_views');
                if (!in_array($userdata->id, $views)) {
                    $datatostore['views']=$userdata->views+1;
                    if(User::where('id',$userdata->id)->update($datatostore)){
                        $views[] = $userdata->id;
                        $request->session()->put('profile_views',$views );
                        // var_dump('true');exit;
                    }
                }
            }else{
                $views=[];
                // var_dump('expression');exit;
                $datatostore['views']=$userdata->views+1;
                if(User::where('id',$userdata->id)->update($datatostore)){
                    $views[] = $userdata->id;
                    $request->session()->put('profile_views',$views );
                    // var_dump('true');exit;
                }
            }
        }
        $data['parents_categories']= Category::where('parent_id',"<","0")->orderBy('name')->get();
        $my_services =  Service::where('supplier_id',$userdata->id)->with(['videos','photos','reviews.user','requests_done','allreviews'])->paginate(5);
        foreach ($my_services as $service) {
            $service->sub_cat = Category::find($service->category_id); 
            $service->parent_cat = Category::find($service->sub_cat['parent_id']); 
        }
        $data['my_services'] =$my_services;
        $data['total_services'] = Service::where('supplier_id',$userdata->id)->count();
        return ($request['is_api'])?response()->json($data,200):view('supplier.profile.profile',$data);
     }
    public function customer(Request $request,$username)
    {
        $limit = ($request->limit)?$request->limit:5;
        $data['userdata'] = $userdata = (object) User::where("username",$username)->first();
        if (!isset($userdata->id)){
            if($request['is_api']){
                $errors['status'] = false;
                $errors['message'] = 'can`t found record';
                response()->json($errors,400);
            }else{
                abort(404);
            }
        }
        $views=[];
        if (!$request['is_api']) {

            if ($request->session()->has('profile_views')) {
                $views = $request->session()->get('profile_views');
                if (!in_array($userdata->id, $views)) {
                    $datatostore['customer_views']=$userdata->views+1;
                    if(User::where('id',$userdata->id)->update($datatostore)){
                        $views[] = $userdata->id;
                        $request->session()->put('profile_views',$views );
                        // var_dump('true');exit;
                    }
                }
            }else{
                $views=[];
                // var_dump('expression');exit;
                $datatostore['customer_views']=$userdata->views+1;
                if(User::where('id',$userdata->id)->update($datatostore)){
                    $views[] = $userdata->id;
                    $request->session()->put('profile_views',$views );
                    // var_dump('true');exit;
                }
            }
        }
        $reviews = Reviews::where(['user_id'=>$userdata->id,'type'=>2])->with(['supplier']);
        if($request->sort_by == "rate_desc")
            $reviews->orderBy('rate','DESC');
          elseif($request->sort_by == "rate_asc")
            $reviews->orderBy('rate');
          elseif($request->sort_by == "created_asc")
            $reviews->orderBy('created_at');
          elseif($request->sort_by == "created_desc")
            $reviews->orderBy('created_at','desc');
        else
            $reviews->orderBy('created_at','desc');
        $data['reviews'] = $reviews->paginate($limit)->appends(['sort_by'=>$request->sort_by]);
        $data['total_gig'] = Gigs::where('customer_id',$userdata->id)->count();
        $data['parents_categories']= Category::where('parent_id',"<","0")->orderBy('name')->get();

        /*Osman edits*/
        $followerID = Auth::user()->id;
        $followeeID = $userdata->id;
        $followController = new FollowController();
        $isFollow = $followController->isFollow($followerID ,$followeeID );
        $data['isFollow'] = $isFollow;

        $followersNumber =  $followController->getFollowers($followeeID);
        $data['followers'] = $followersNumber;
        /********************/
        return ($request['is_api'])?response()->json($data,200):view('customer.profile.profile',$data);
    }
    public function ghreviews(Request $request,$username)
    {
        $limit = ($request->limit)?$request->limit:5;
        $data['userdata'] = $userdata = User::where("username",$username)->first();
        if (!$userdata){
            if($request['is_api']){
                $errors['status'] = false;
                $errors['message'] = 'can`t found record';
                response()->json($errors,400);
            }else{
                abort(404);
            }
        }
        if (!$request['is_api']) {
            $views=[];
            if ($request->session()->has('profile_views')) {
                $views = $request->session()->get('profile_views');
                if (!in_array($userdata->id, $views)) {
                    $datatostore['customer_views']=$userdata->views+1;
                    if(User::where('id',$userdata->id)->update($datatostore)){
                        $views[] = $userdata->id;
                        $request->session()->put('profile_views',$views );
                        // var_dump('true');exit;
                    }
                }
            }else{
                $views=[];
                // var_dump('expression');exit;
                $datatostore['customer_views']=$userdata->views+1;
                if(User::where('id',$userdata->id)->update($datatostore)){
                    $views[] = $userdata->id;
                    $request->session()->put('profile_views',$views );
                    // var_dump('true');exit;
                }
            }
        }
        $reviews = Reviews::where(['supplier_id'=>$userdata->id,'type'=>1])->with(['supplier','user','service','gig','order']);
        if($request->sort_by == "rate_desc")
            $reviews->orderBy('rate','DESC');
          elseif($request->sort_by == "rate_asc")
            $reviews->orderBy('rate');
          elseif($request->sort_by == "created_asc")
            $reviews->orderBy('created_at');
          elseif($request->sort_by == "created_desc")
            $reviews->orderBy('created_at','desc');
        if($request->filter == "all"){

        }elseif($request->filter == "gig"){
            $reviews->whereHas('order',function($query) use($request){
                $query->where(['type'=>2,'item_id'=>$request->filter]);
            });
        }elseif($request->filter){
            $reviews->whereHas('order.request',function($query) use($request){
                $query->where('service_id',$request->filter);
            });
        }
        $data['reviews'] = $reviews->paginate($limit)->appends(['sort_by'=>$request->sort_by]);
        $data['reviewd_services'] = Service::where(['supplier_id'=>$userdata->id])->has('reviews')->get();
        $data['total_services'] = Service::where('supplier_id',$userdata->id)->count();
        $data['parents_categories']= Category::where('parent_id',"<","0")->orderBy('name')->get();
        return ($request['is_api'])?response()->json($data,200):view('supplier.profile.readreviews',$data);   
    }
}
