<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Gigs;
use App\Category;
use App\Applications;
use App\Helpers\Flexihelp;
use Illuminate\Support\Facades\Validator;
use App\Traits\GigComponant;
class GigsController extends Controller
{
  use GigComponant;
  public function filter(Request $request,$category=null)
  {

    // getting Skills in filter
    $data['subsub'] = null;
    $data['subsub_categories'] = false;
    if (!$request['is_api']) {
      if (!$category)
        abort(404);
      if($request->parent&&$request->sub&&$request->subsub){
          return redirect()->route('gig_list',['slug'=>$request->subsub,'price_from'=>$request->price_from,'price_to'=>$request->price_to,'free_text'=>$request->free_text,'rating'=>$request->rating,'location'=>$request->location,'formated'=>$request->formated,'up_to'=>$request->up_to,'supplier_type'=>$request->supplier_type]);
      }elseif ($request->parent&&$request->sub) {
          return redirect()->route('gig_list',['slug'=>$request->sub,'price_from'=>$request->price_from,'price_to'=>$request->price_to,'free_text'=>$request->free_text,'rating'=>$request->rating,'free_text'=>$request->free_text,'location'=>$request->location,'formated'=>$request->formated,'up_to'=>$request->up_to,'supplier_type'=>$request->supplier_type]);
      }
    }
    if (!$request['is_api']) {
      $categorydata = Category::where('slug',$category)->first();
      if (empty($categorydata))
        abort(404);
      $data['childs'] = $childs = Category::where('parent_id',$categorydata->id)->first();
      if($childs)
        abort(404);
      $category_id = $categorydata['id'];
      $data['parent'] = $parent = Category::where('id',$category_id)->first();
      $data['sub'] = $sub = $categorydata;
      $data['subsub'] = null;
      // if has parent
      if ($parent->parent_id!=0) {
        $data['sub'] = $sub = $parent;
        $data['parent'] = $parent = Category::where('id',$parent->parent_id)->first();
        $data['subsub'] = $categorydata;
        $data['subsub_categories'] = Category::where('parent_id',$sub['id'])->orderBy('name')->get();
      }
      $data['parents_categories'] = Category::where('parent_id',0)->orderBy('name')->get();
      $data['sub_categories'] = Category::where('parent_id',$parent['id'])->orderBy('name')->get();
    }else{
      if ($request->category_id) {
        $categorydata = Category::where('id',$request->category_id)->first();
        $category_id = $categorydata['id'];
        $data['parent'] = $parent = Category::where('id',$categorydata['parent_id'])->first();
        $data['sub'] = $sub = $categorydata;
        // if has parent
        if ($parent->parent_id!=0) {
          $data['sub'] = $sub = $parent;
          $data['parent'] = $parent = Category::where('id',$parent->parent_id)->first();
          $data['subsub'] = $categorydata;
        }
      }
    }
    $limit = ($request->limit)?$request->limit:15;
    $where = [];
    $where[] = ['deadline','>=',date('Y-m-d')];
    $where[] = ['status',0];
    if($request->up_to){
      $up_to = date('Y-m-d',strtotime(date('Y-m-d').' +'.$request->up_to.'days'));
      $where[]  = ['deadline','<=',$up_to];
    }
    $gigs = $this->gig_filter($request,$where,@$data['parent'],@$data['sub'],@$data['subsub'])->with(['skills.category'])
                                              ->paginate($limit)
                                              ->appends($request->except(['exeed_limit','page','limit','is_api']));
                                              unset($data['subsub']);
    $data['min_price'] = Gigs::where([['deadline','>=',date('Y-m-d 23:59:59')],['status',0]])->min('price');
    $data['max_price'] = Gigs::where([['deadline','>=',date('Y-m-d 23:59:59')],['status',0]])->max('price');                                                   
    $data['status'] = true;
    $data['gigs_pagination'] = $gigs;
    $data['pagination_status'] = true;
    if (count($gigs)==0){
      $data['status'] = false;
      $data['message'] = 'no more data';
      $data['pagination_status'] = false;
    }
    $data['search_with'] = $request->except(['exeed_limit','page','limit','is_api']);
    return ($request['is_api'])?response()->json($data , 200):view('gigs',$data);
 }
 
  public function getGig(Request $request,$id){
    $data['parents_categories'] = Category::where('parent_id',0)->orderBy('name')->get();
    $data['min_price'] = Gigs::where([['deadline','>=',date('Y-m-d 23:59:59')],['status',0]])->min('price');
    $data['max_price'] = Gigs::where([['deadline','>=',date('Y-m-d 23:59:59')],['status',0]])->max('price');
    $getgig = $this->single_gig($request,$id);
    if(is_array($getgig))
      $data = array_merge($getgig,$data);
    else
      return $getgig;
    return ($request['is_api'])?response()->json($data , 200):view('gig_details',$data);
  }
   // going to move it to order Controller  and name it OrderStatus
  public function gigStatus(Request $request ,$id)
  {
    $applications = $applications_data =  Applications::where(['gig_id'=>$id])->with(['supplier'])->get();
    $emails = [];
    $users = [];
      # get all users emails
    foreach ($applications_data as $application) {
      $emails[] = $application->supplier->email; 
      $users[] = $application->supplier; 
    }
    Applications::where(['gig_id'=>$id])->delete();
    // update gig status
    Gigs::where('id',$id)->update(['status'=>5]);
    // get gig
    $gig = Gigs::where('id',$id)->first();
    // send email
      // elseif ==========================>Cancel Gig
    if ($gig->status == 5) {
      $noti = new \App\Http\Controllers\NotificationController();
      $noti->gigCanceled($emails,$gig,$users);
    }
    if (!$gig) {
      $data['status'] = false;
      $data['message'] = "record not found";
      return response()->json($data,400); 
    }else{
      $data['status'] = true;
      $data['message']= "gig status updated";
      return response()->json($data,200);
    }
  }
}
