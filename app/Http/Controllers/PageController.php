<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
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
    public function contactus(Request $request)
    {
      $data['status'] = true;
      $data['message'] = 'message sent';
      if ($request->isMethod('post')) {
         $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|email',
          'subject' => 'required',
          'message' => 'required',
        ]);
        if ($validator->fails()) {
          $data['status']=false;
          $data['message']= $validator->errors()->toArray();
          return ($request['is_api'])?response()->json($data,422):redirect(app()->getLocale().'/contact-us')->withErrors($validator);
        }
        $messagedata = $request->all();
        $noti = new \App\Http\Controllers\NotificationController();
        $noti->contactUs($messagedata);
        return ($request['is_api'])?response()->json($data,200):redirect(app()->getLocale().'/contact-us')->with(['success'=>true]);
      }
      return ($request['is_api'])?response()->json($data,200):view('pages.contactus');
    }
    public function faq(Request $request)
    {
      $lang = ($request['is_api'])?$request->lang:app()->getLocale();
      $data['employer_faq'] = config('staticpages_'.$lang.'.faq.employer_faq');
      $data['freelancer_faq'] = config('staticpages_'.$lang.'.faq.freelancer_faq');
      return ($request['is_api'])?response()->json($data,200):view('pages.faq',$data);
    }
    public function howItWork(Request $request)
    {
      $lang = ($request['is_api'])?$request->lang:app()->getLocale();
      $data['howitwork'] = config('staticpages_'.$lang.'.howitwork');
      return ($request['is_api'])?response()->json($data,200):view('pages.howItWork',$data);
    }
    public function terms(Request $request)
    {
      $lang = ($request['is_api'])?$request->lang:app()->getLocale();
      $terms = config('staticpages_'.$lang.'.terms');
      if($request['is_api']){
        $result = "";
        foreach($terms as $term):
        $result .=' <div class="row">
            <div class="col-md-12">
               <div>';
                  foreach($term as $item):
                    $result .="<".$item['tag'].">".$item['text']."</".$item['tag'].">"; 
                  endforeach;
               $result.='</div>
            </div>
        </div>';
        endforeach;
        $data['terms'] = $result;
      }else{
        $data['terms'] = $terms;
      }
      return ($request['is_api'])?response()->json($data,200):view('pages.terms',$data);
    }
    public function privacy(Request $request)
    {
      $lang = ($request['is_api'])?$request->lang:app()->getLocale();
      $privacy = config('staticpages_'.$lang.'.privacy');
      if($request['is_api']){
        $result = "";
        foreach($privacy as $pri):
        $result .=' <div class="row">
            <div class="col-md-12">
               <div>';
                  foreach($pri as $item):
                    $result .="<".$item['tag'].">".$item['text']."</".$item['tag'].">"; 
                  endforeach;
               $result.='</div>
            </div>
        </div>';
        endforeach;
        $data['privacy'] = $result;
      }else{
        $data['privacy'] = $privacy;
      }
      return ($request['is_api'])?response()->json($data,200):view('pages.policy',$data);
    }
    public function refund(Request $request)
    {
      $lang = ($request['is_api'])?$request->lang:app()->getLocale();
      $refund = config('staticpages_'.$lang.'.refund');
      if($request['is_api']){
        $result = "";
        foreach($refund as $ref):
        $result .=' <div class="row">
            <div class="col-md-12">
               <div>';
                  foreach($ref as $item):
                    $result .="<".$item['tag'].">".$item['text']."</".$item['tag'].">"; 
                  endforeach;
               $result.='</div>
            </div>
        </div>';
        endforeach;
        $data['refund'] = $result;
      }else{
        $data['refund'] = $refund;
      }
      return ($request['is_api'])?response()->json($data,200):view('pages.refund',$data);
    }
}
