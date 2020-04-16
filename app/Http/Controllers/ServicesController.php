<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\User;
use App\Category;
use App\Favorite;
use App\ServiceVideo;
use App\Helpers\Flexihelp;
use App\ServicePhoto;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ServicesController extends Controller
{
  public function getService(Request $request,$id){
       $service = Service::where('id', $id)->with(['reviews.user','requests_done'])->first();
       if ($service) {
         $sub_cat= Category::where('id',$service->category_id)->first();
         $parent_slug = Category::where('id',$sub_cat->parent_id)->first();
         if($parent_slug->parent_id==0){
            $data['parent_slug'] = $parent_slug;
            $data['sub_slug'] = $sub_cat;
         }else{
            $data['parent_slug'] = Category::where('id',$parent_slug->parent_id)->first();
            $data['sub_slug'] = $parent_slug;
            $data['subsub_slug'] = $sub_cat;
         }
          $service_veds = ServiceVideo::where('service_id',$id)->get();
          $service_photos = ServicePhoto::where('service_id',$id)->get();
          $data['status'] = true;
          $service->rate = Flexihelp::get_stars('service',$id,true);
          $data['service'] = $service;
          $data['services_veds'] = $data['videos'] = $service_veds;
          $data['services_photo'] = $data['photos'] =  $service_photos;
          $data['user'] = $user = User::find($service['supplier_id']);
          $data['category'] = Category::find($service['category_id']);
        if ($request->customer_id)
            $data['favorite'] = Favorite::where(['service_id'=>$service->id,'user_id'=>$request->customer_id])->first();
          $reviews = Service::find($id)->reviews()->with('user');
            $reviews = $reviews->orderBy('rate');
          if($request->sort_by == "rate_desc")
            $reviews = $reviews->orderBy('rate','DESC');
          // elseif($request->sort_by == "rate_asc")
          elseif($request->sort_by == "created_asc")
            $reviews = $reviews->orderBy('created_at');
          elseif($request->sort_by == "created_desc")
            $reviews = $reviews->orderBy('created_at','desc');
         $data['reviews'] = $reviews->paginate(5)->appends(['sort_by'=>$request->sort_by]);
         config(['meta.type' => "service"]);
         config(['meta.keywords' => $user->skills]);
         config(['meta.description' => $service->description]);
         if (count($service_photos)) {
            config(['meta.image' => Flexihelp::get_file($service_photos[0]->filename,20)]);
         }
         if ($request['is_api']) {
           return response()->json($data , 200);
         }else{
          return view('service_details',$data);
         }
       }else{
         if ($request['is_api']) {
            $data['status'] = false;
            $data['message'] = 'record not found';
            return response()->json($data , 400);
         }else{
            abort(404);
         }
       }
     }
  public function addservice(Request $request){
      if ($request['exeed_limit']) {
        $data['status']= false;
        $data['message']=['img'=>'file exeed limit'];
        return  response()->json($data,422);
      }
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'price_per_unit' => 'required|numeric|between:0,99999999999,max:11',
        'price_unit' => 'required',
        'description' => 'required|max:2500',
        'terms' => 'required|max:2500',
        'question1' => 'required|max:200',
        'question2' => 'max:200',
        'question3' => 'max:200',
        'videourl[]' => 'url',
        'img.*' => 'required|file|mimes:jpeg,png,jpg,gif,max:1024',
      ]);
      if ($validator->fails()) {
        $data['status']=false;
        $data['message']= $validator->errors()->toArray();
        return response()->json($data,422);
      }
        $datatostore = $request->except(['exeed_limit','img','videourl','parent','sub','subsub','is_api','_token']);
        $categoryslug = ($request->input('subsub')&&$request->input('subsub')!=null&&$request->input('subsub')!="")?$request->input('subsub'):$request->input('sub');
        if ($request['is_api']) {
          $Categoryparent = Category::where('id',$request->parent)->first();
          $category = Category::where('id',$categoryslug)->first();
        }else{
          $Categoryparent = Category::where('slug',$request->parent)->first();
          $category = Category::where('slug',$categoryslug)->first();
        }
        if (empty($Categoryparent)) {
          $data['status'] = false;
          $data['message'] = ['category'=>"you have to select a valid category"];
          return response()->json($data,422);
        }
        if(empty($category)){
          $data['status'] = false;
          $data['message'] = ['category'=>"you have to select a valid category"];
          return response()->json($data,422);
        }else{
          $subs = Category::where('parent_id',$category['id'])->get();
          if (count($subs)) {
            $data['status'] = false;
            $data['message'] = ['category'=>"you have to select a valid category"];
            return response()->json($data,422);;
          }
        }
        $datatostore['category_id'] = $category['id'];
        $service = Service::create($datatostore);
        // Saving= Urls in serviceVeds table (( each service has up to 3 veds ))
        if ($request->videourl) {
          foreach($request->videourl as $key => $value):
            if ($value && filter_var($value, FILTER_VALIDATE_URL)) {
            $ServiceVideo = new ServiceVideo;
            $ServiceVideo->url = $value;
            $ServiceVideo->service()->associate($service);
            $ServiceVideo->save();
            }
          endforeach;
        }
    
       $images=$request->file('img');
        if ($images) {
          for( $i=0; $i<=(count($images) - 1); $i++):
            $file = Flexihelp::upload($images[$i],'serviceportofilo');
            $servicephoto = new ServicePhoto;
            $servicephoto->create(['service_id'=>$service->id,'filename' => $file->pathToSave ]);
            endfor;
        }
        $noti = new \App\Http\Controllers\NotificationController();
        $user = User::where('id',$request->supplier_id)->first();
        $noti->SendNewService($user,$service);
        $data['status'] = true;
        $data['service'] = $service;
        return response()->json($data , 201);
     }
    
    public function update_service(Request $request,$id)
     {
      if ($request['exeed_limit']) {
        $data['status']= false;
        $data['message']=['img'=>'file exeed limit'];
        return  response()->json($data,422);
      }
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
       $categoryslug = ($request->input('subsub'))?$request->input('subsub'):$request->input('sub');
      if ($request['is_api']) {
       $category = Category::where('id',$categoryslug)->first();
      }else{
       $category = Category::where('slug',$categoryslug)->first();
      }
       if(empty($category)){
          $data['status'] = false;
          $data['message'] = "NO Category with this id";
          $data['category'] = "you have to select a valid category";
          return response()->json($data , 422);
        }else{
          $subs = Category::where('parent_id',$category['id'])->get();
          if (count($subs)) {
              $data['status'] = false;
              $data['message'] = "NO Category with this id";
              $data['category'] = "you have to select a valid category";
              return response()->json($data , 422);
          }
        }
        $datatostore = $request->except(['exeed_limit','img','videourl','parent','sub','subsub','_token','is_api']);
        $datatostore['category_id'] = $category['id'];
        Service::where('id',$id)->update($datatostore);
        $service = Service::where('id',$id)->with('photos')->first();
        // Saving video Urls in serviceVeds table (( each service has up to 3 veds ))
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
        $remaincount = 10-count($service->photos);
        $imagescount = (count($images)>$remaincount)?$remaincount:count($images);
        if ($images) {
            $validator = Validator::make($request->all(), [
              'img.*' => 'required|file|mimes:jpeg,png,jpg,gif,max:1024',
            ]);
          if ($validator->fails()) {
            $data['status']=false;
            $data['message']= $validator->errors()->toArray();
            return response()->json($data,422);
          }
          for( $i=0; $i<=(imagescount - 1); $i++):
            $file = Flexihelp::upload($images[$i],'serviceportofilo');
            $servicephoto = new ServicePhoto();
            $servicephoto->create(['service_id'=>$id,'filename' => $file->pathToSave ]);
            endfor;
        }
        $data['status'] = true;
        $data['service'] = $service;
        return response()->json($data , 200);
     }
     public function addserviceimage(Request $request,$id)
     {
      if ($request['exeed_limit']) {
        $data['status']= false;
        $data['message']=['img'=>'file exeed limit'];
        return  response()->json($data,422);
      }
      $validator = Validator::make($request->all(), [
        'img' => 'required|file|mimes:jpeg,png,jpg,gif,max:1024',
      ]);
        $data['prams'] = $request->all();
        $data['files'] = $request->file();
      if ($validator->fails()) {
        $data['status']=false;
        $data['message']= $validator->errors()->toArray();
        return response()->json($data,422);
      }
        $image=$request->file('img');
        $file = Flexihelp::upload($image,'serviceportofilo');
        $servicephoto = new ServicePhoto();
        $servicephoto->create(['service_id'=>$id,'filename' => $file->pathToSave ]);
        $data['status'] = true;
        $data['message'] = 'image added with name of '.$file->pathToSave;
        return response()->json($data , 200);
     }

      
      public function deleteService($id){
        $service = Service::find($id);
        if ($service) {
         $service->photos()->delete();
         $service->videos()->delete();
         $service->favorites()->delete();
         $service->delete();
         $data['status'] =  true;
         $data['message'] = 'Service deleted succefully';
        }else{
         $data['status'] =  false;
         $data['message'] = 'record not found';
         return response()->json($data , 400);           	
        }
        return response()->json($data , 200);
      }
      
      public function deleteServiceImage($id){
           $ServicePhoto = ServicePhoto::find($id);
           $service_id = $ServicePhoto->service_id;
           if ($ServicePhoto) {
             $ServicePhoto->delete();
             $data['status'] =  true;
             $data['photos'] =  (ServicePhoto::where('service_id',$service_id)->count())?true:false;
             $data['service_id'] =  $service_id;
             $data['message'] = 'Service photo deleted succefully';
           }else{
             $data['status'] =  false;
             $data['message'] = 'record not found';
             return response()->json($data , 400);            
           }
           return response()->json($data , 200);
       }
       public function deleteServiceVideo($id)
       {
           $ServiceVideos = ServiceVideo::find($id);
           if ($ServiceVideos) {
             $ServiceVideos->delete();
             $data['status'] =  true;
             $data['message'] = 'Service Video deleted succefully';
           }else{
             $data['status'] =  false;
             $data['message'] = 'record not found';
             return response()->json($data , 400);            
           }
           return response()->json($data , 200);
       }
       public function filter_data(){
        $data['status'] = true;
        $data['max_price'] = Service::max('price_per_unit');
        $data['min_price'] = Service::min('price_per_unit');
        return response()->json($data,200);
       }
      public function filterServices(Request $request,$category=null) {

        // echo $category;exit;
        if (!$request['is_api']) {
          if (!$category)
            abort(404);
          if($request->parent&&$request->sub&&$request->subsub){
              return redirect()->route('service_list',['slug'=>$request->subsub,'price_from'=>$request->price_from,'price_to'=>$request->price_to,'free_text'=>$request->free_text,'rating'=>$request->rating,'location'=>$request->location,'formated'=>$request->formated,'availability'=>$request->availability,'up_to'=>$request->up_to]);
          }elseif ($request->parent&&$request->sub) {
              return redirect()->route('service_list',['slug'=>$request->sub,'price_from'=>$request->price_from,'price_to'=>$request->price_to,'free_text'=>$request->free_text,'rating'=>$request->rating,'free_text'=>$request->free_text,'location'=>$request->location,'formated'=>$request->formated,'availability'=>$request->availability,'up_to'=>$request->up_to]);
          }
        }
        if (!$request['is_api']) {
          $categorydata = Category::where('slug',$category)->first();
          if (empty($categorydata))
            abort(404);
          $category_id = $categorydata['id'];
          $data['parent'] = $parent = Category::where('id',$categorydata['parent_id'])->first();
          $data['sub'] = $sub = $categorydata;
          // if has parent
          if ($parent->parent_id!=0) {
            $data['sub'] = $sub = $parent;
            $data['parent'] = $parent = Category::where('id',$parent->parent_id)->first();
            $data['subsub'] = $categorydata;
            $data['subsub_categories'] = Category::where('parent_id',$sub['id'])->orderBy('name')->get();
          }
          $data['parents_categories'] = Category::where('parent_id',0)->orderBy('name')->get();
          $data['sub_categories'] = Category::where('parent_id',$parent['id'])->orderBy('name')->get();
          ///=======================pagination
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
          $page_num = ($request->page)?($request->page-1):0;
          $limit = ($request->limit)?$request->limit:15;
          $offset = $page_num*$limit;
          $where = [];
            // Start where array

          $searchcat_id = ($request->category_id)?$request->category_id:@$category_id;
        if ($searchcat_id)
          $where[]  = ['category_id',$searchcat_id];
        if ($request->rating)
          $where[]  = ['rating','>=',$request->rating];
        if($request->price_from)
          $where[]  = ['price_per_unit','>=',$request->price_from];
        if($request->price_to)
          $where[]  = ['price_per_unit','<=',$request->price_to];
        if ($request->up_to) {
          $where[]  = ['days_to_deliver','>=',$request->up_to];
          $where[]  = ['price_unit','project'];
        }
        // if($request->rating)
          // $where[]  = ['rate','>=',$request->rating];
        if ($request->free_text){
          $where[]  = ['name','like','%'.$request->free_text.'%'];
          // $where[]  = ['description','like','%'.$request->free_text];
        }
        // End where array
        // start Query
        $services = $services_pagination = Service::has('user')->limit($limit)->offset($offset)->where($where);
        
        if($request->location||$request->availability){
          // var_dump($request->location);exit;
          $services->whereHas('user',function($query) use($request){
            if ($request->location) 
              $query->where('city',$request->location);
            if ($request->availability)
              $query->where('availability',0);
          });
        }
        // add sort to the Query
        if ($request->sort_by){
          if($request->sort_by !== "location"){
            if ($request->sort_by == 'price_desc') {
              $services = $services->orderBy('price_per_unit','DESC');
            }elseif ($request->sort_by == 'price_asc') {
              $services = $services->orderBy('price_per_unit');
            }elseif($request->sort_by == 'rating_desc'){
              $services = $services->orderBy('rating','DESC');
            }elseif($request->sort_by == 'rating_asc'){
              $services = $services->orderBy('rating','ASC');
            }
          }else{
            if($request->location){
              //do some thing
            }
          }
        }
        if($request->supplier_name){
          $services->whereHas('user',function($query) use($request){
            $query->where('username','like','%'.$request->supplier_name.'%');
          });
        }
        $services = $services->with(['videos','photos'])->orderBy('created_at','desc')//->toSql();var_dump($services); exit();
        ->get();
        $data['services_pagination'] = $services_pagination->orderBy('created_at','desc')->paginate($limit)->appends(['price_from'=>$request->price_from,'price_to'=>$request->price_to,'free_text'=>$request->free_text,'rating'=>$request->rating,'location'=>$request->location,'formated'=>$request->formated,'sort_by'=>$request->sort_by]);
        // end query 
        if (count($services)>0){
          foreach ($services as $service) {
            $service['category'] = Category::find($service->category_id);
            $service['user'] = User::find($service->supplier_id);
            if ($request->customer_id)
              $service['favorite'] = Favorite::where(['service_id'=>$service->id,'user_id'=>$request->customer_id])->first();
          }
          $data['status'] = true;
          $data['result'] = $services;
          $data['min_price'] = Service::/*where('category_id',$searchcat_id)->*/min('price_per_unit');
          $data['max_price'] = Service::/*where('category_id',$searchcat_id)->*/max('price_per_unit');
          $data['pagination_status'] = true;
        }else{
          $data['status'] = false;
          $data['result'] = false;
          $data['message'] = 'no more data';
          $data['pagination_status'] = false;
        }
          $data['category'] = Category::where('id',$searchcat_id)->first();
          $data['count_all'] = Service::where($where)->count();
          $data['page_number'] = $page_num;
          $data['search_with'] = $request->except(['exeed_limit','page','limit','is_api']);
          if ($request['is_api']) {
            return response()->json($data,200);
          }else{
            return view('service_list',$data);
          }
        
    }
    public function exportservice(Request $request)
    {
      $where = [];
      if ($request->supplier_name) 
        $where[] = ['supplier_name' ,'like','%'.$request->supplier_name.'%'];
      if ($request->service_name) 
        $where[] = ['service_name' ,'like','%'.$request->service_name.'%'];
      if($request->date_from){
        $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
        $where[]  = ['created_at','>=',$date_from];
      }
      if($request->date_to){
        $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
        $where[]  = ['created_at','<=',$date_to];
      }
      if($request->price_from)
        $where[]  = ['price_per_unit','>=',$request->price_from];
      if($request->price_to)
        $where[]  = ['price_per_unit','<=',$request->price_to];
      $services = Service::orderBy('created_at','ASC')
                   ->with('user')
                   ->where($where)
                   ->whereYear('created_at',date('Y',strtotime($request->month)))
                   ->whereMonth('created_at',date('m',strtotime($request->month)))
                   ->get();
      $result = [];
      foreach ($services as $service) {
        $service->subsub_cat = Category::find($service->category_id); 
        $service->sub_cat = Category::find($service->subsub_cat['parent_id']); 
        if ($service->sub_cat['parent_id']==0) {
          $service->parent_cat = $service->sub_cat; 
          $service->sub_cat = $service->subsub_cat; 
        }else{
          $service->parent_cat = Category::find($service->sub_cat['parent_id']); 
        }
        $result[] = ['ID'=>$service->id,
                     'Name'=>$service->name,
                     'GH username'=>$service->user->username,
                     'category'=>$service->parent_cat['name'].' - '.$service->sub_cat['name'],
                     'price'=>$service->price_per_unit,
                     'per'=>$service->price_unit,
                     'question1'=>$service->question1,
                     'question2'=>$service->question2,
                     'question3'=>$service->question3,
                    ];
      }
      Excel::create('services '.$request->month, function($excel) use($result,$request) {
          $excel->sheet('services '.$request->month, function($sheet) use($result,$request) {
              $sheet->fromArray($result);
          });
          // Set the title
          $excel->setTitle('flexigigs system data exportation');
          // Chain the setters
          $excel->setCreator('Flexigigs')
                ->setCompany('road9media');
          // Call them separately
          $excel->setDescription('services of '.$request->month.' and filter result');

      })->download('xlsx');
    }
}
