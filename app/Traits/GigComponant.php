<?php 
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Gigs;
use App\Gigsuppliertype;
use App\Gigattach;
use App\Gigskills;
use App\User;
use App\Category;
use App\Applications;
use App\Orders;
use App\Helpers\Flexihelp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\FollowController;

trait GigComponant {
	use ApplicationsComponant;

    public function gig_filter(Request $request,$where=[],$parent=null,$sub=null,$subsub=null) {
		$page = (($request->page)?$request->page:1)-1;
		$limit = ($request->limit)?$request->limit:6;
		$offset = $page*$limit;
		$datefrom = date('Y-m-d 00:00:00',strtotime($request->deadline_from));
		$dateto = date('Y-m-d 23:59:59',strtotime($request->deadline_to));
		// Start where array
		if($request->price_from)
			$where[]  = ['price','>=',$request->price_from];
		if($request->price_to)
			$where[]  = ['price','<=',$request->price_to];
		if($request->deadline_from)
			$where[]  = ['deadline','>=',$datefrom];
		if($request->deadline_to)
			$where[]  = ['deadline','<=',$dateto];
		if ($request->free_text){
			$where[]  = ['title','like','%'.$request->free_text.'%'];
		// 	$where[]  = ['description','like','%'.$request->free_text];
		}
		// End where array
		// start Query
		$gigs = Gigs::limit($limit)->offset($offset)->where($where);
		$keySkill = ($subsub)?$subsub->slug:@$sub->slug;
		if ($keySkill){
		  $category_id = Category::where('slug',$keySkill)->value('id');
		  if ($category_id){
		    $gigs->whereHas('skills',function($query) use($category_id) {
		        $query->where('category_id',$category_id);
		    });
		  } 
		}
		if ($request->supplier_type){
			$gigs->whereHas('supplier_type',function($query) use($request) {
			    $query->where('type',$request->supplier_type);
			});
		} 
		// add sort to the Query
	  	if ($request->sort_by == 'price_desc') {
	    	$gigs->orderBy('price','DESC');
	  	}elseif ($request->sort_by == 'price_asc') {
	    	$gigs->orderBy('price');
	  	}elseif($request->sort_by == 'created_asc'){
	    	$gigs->orderBy('created_at');
	  	}elseif($request->sort_by == 'created_desc'){
	    	$gigs->orderBy('created_at','DESC');
	  	}elseif($request->sort_by == 'deadline_desc'){
	    	$gigs->orderBy('deadline','DESC');
	  	}elseif($request->sort_by == 'deadline_asc'){
	    	$gigs->orderBy('deadline');
	  	}else{
	    	$gigs->orderBy('created_at','DESC');
		}
		return $gigs;
    }

    public function single_gig(Request $request,$id)
    {
    	$gig = Gigs::where('id', $id)->with('skills.category','supplier_type','applications.supplier','attach')->first();
	 	if(!$gig||!$request->customer_id||($gig->customer_id!=$request->customer_id)){
		    if (!$gig||$gig->status!=0) {
		      if ($request['is_api']) {
		        $error['status'] = false;
		        $error['message'] = 'record not found';
		        return response()->json($error , 400);
		      }else{
		        abort(404);
		      }
		    }
	 	}
		$data['status'] = true;
		$data['gig'] = $gig;
		$key_skills = '';
		$i = count($gig->skills);
		foreach ($gig->skills as $skill) {
			$i--; $comma = ($i==0)?"":',';
			$key_skills.= $skill->category->slug.$comma;
		}
        $data['key_skills']= $key_skills;
	    $data['user'] = $user = User::find($gig['customer_id']);
	    $supplier_id = 0;
	    if ($request->user()) {
	       $supplier_id = ($request['is_api'])?$request->supplier_id:$request->user()->id;
	    }else{
	        if ($request->supplier_id) {
	          $supplier_id = $request->supplier_id;
	        }
	    }
	    if($request->isMethod('post')){
	        $this->store_application($request,$gig,$supplier_id);
	    }
	    $data['is_apply'] = Applications::where(['supplier_id'=>$supplier_id,'gig_id'=>$id])->first();
	    return $data;  
    }
    
    public function store(Request $request) {
	    if ($request['exeed_limit']) {
	        $data['status'] = false;
	        $data['message'] = ['attach'=>'file exeed limit'];
	        return response()->json($data,200);
	    }
	    $roles = [
	      'title' => 'required|max:255',
	      'description' => 'required|max:2500',
	      'deadline' => 'required',
	      'skills' => 'required',
	      'customer_id' => 'required',
	      'price' => 'required|numeric',
	      'supplier_type'=>'required'
	    ];
	    if(count($request->file('attach'))){
		     $roles['attach.*'] = 'file|mimes:jpeg,png,jpg,gif,doc,csv,docx,xlsx,xlsm,xltx,xltm,xls,pdf|max:5120';
		}
	    $validator = Validator::make($request->all(), $roles);
	    if ($validator->fails()) {
        	$data['status']=false;
	        $data['message']= $validator->errors()->toArray();
	        return response()->json($data,422);
	    }
	    if(!User::find($request->customer_id)){
	      	$data['status'] = false;
	      	$data['message'] = "NO user with this id";
	      	return response()->json($data , 400);
	    }


	    $dataToStore = $request->except(['exeed_limit','attach','is_api','skills','deadline','supplier_type','repost']);
	    $dataToStore['status'] = 0 ;
	    $dataToStore['deadline'] = date('Y-m-d h:i:s',strtotime($request->deadline));
	    $gig = Gigs::create($dataToStore);
	    // Saving attachmentsfiles in gigattachs table (( each gig has up to 5 attachments ))
	    if ($request->file('attach')) {
	      $length = (count($request->file('attach'))<=5)?count($request->file('attach')):5;
	      for ($i=0; $i < $length ;  $i++) { 
	        $file = Flexihelp::uploadAnyFile($request->file('attach')[$i],'gigattach',$request['exeed_limit']);
	        $gigattach = ['filename'=>$file->pathToSave, 'type'=>$file->type, 'size'=>$file->size, 'gigs_id'=> $gig->id ];
	        Gigattach::create($gigattach);
	      }
	    }

	    
	    // Saving skilles in gigskills table (( each gig has up to 5 skills ))
	    if ($request->slugs) {
	      $slug = explode(',', $request->skills);
	      $length = (count($slug)<=5)?count($slug):5;
	      $skills=[];
	      for ($i=0; $i < $length ; $i++) { 
	        $cat = Category::where('slug',$slug[$i])->first();
	        if ($cat) {
	        	$skills[] = $cat->id;
				$dataToStore = ['category_id'=>$cat->id,'gigs_id'=>$gig->id];
	          	Gigskills::create($dataToStore);
	        }
	      }
	    }else{
	      if ($request->skills) {
	        $skills = explode(',', $request->skills);
	        $length = (count($skills)<=5)?count($skills):5;
	        for ($i=0; $i < $length ; $i++) { 
	          if ($skills[$i]) {
	          	$dataToStore = ['category_id'=>$skills[$i],'gigs_id'=>$gig->id];
	          	Gigskills::create($dataToStore);
	          }
	        }
	      }
	    }
	    if ($request->supplier_type) {
	    	$supplier_type = $request->supplier_type;
	    	for ($i=0; $i < count($supplier_type); $i++) { 
	    		$dataToStore=['gigs_id'=>$gig->id,'type'=>$supplier_type[$i]];
	    		Gigsuppliertype::create($dataToStore);
	    	}
	    }
	    if ($request->repost) {
	    	$oldGig = Gigs::where('id',$request->repost)->first();
	    	if($oldGig){
    			$oldgig = Gigs::find($request->repost);
	    		if ($oldGig->order) {
					$oldgig->delete();
	    		}else{
	    			$oldgig->skills()->delete();
					$oldgig->attach()->delete();
					$oldgig->applications()->delete();
					$oldgig->delete();
	    		}
	    	}
	    }
	    $noti = new \App\Http\Controllers\NotificationController();
	    $user = User::where('id',$request->customer_id)->with('devices')->first();

	    /*Osman edits*/
	    $followeeID = Auth::user()->id;
	    $followController = new FollowController();
        $followeeOBJ = $followController->getFollowers($followeeID);
        foreach ($followeeOBJ->followers as $key => $follower) {
        	$data['noti'] = $noti->sendFollowersGig($follower,$gig);
        }
        $data['followee'] = $followeeOBJ;
		/************/

	    $data['noti'] = $noti->SendNewGig($user,$gig,$skills);
	    $data['status'] = true;
	    $data['gig'] = $gig;


	    return response()->json($data , 201);
	}

	// we use this function after store gig for mobile uploads
	public function addgigattachment(Request $request,$id) {
	    $validator = Validator::make($request->all(), [
	      'attach' => 'file|mimes:jpeg,png,jpg,gif,doc,docx,xlsx,xlsm,xltx,xltm,xls,pdf,csv|max:5120'
	      // 'attach' => 'file|mimes:jpeg,png,jpg,gif,doc,docx,csv,pdf|max:5120'
	    ]);
	    if ($request['exeed_limit']||$validator->fails()) {
	      $gig = Gigs::find($id);
	      if (count($gig)) {
	        $gig->attach()->delete();
	        $gig->delete();
	      }else{
	        $data['status'] = true;
	        $data['message'] = 'gig not found';        
	        return response()->json($data,400);
	      }

	      $data['status']=false;
	      $data['message']= $validator->errors()->toArray();
	      if ($request['exeed_limit']) 
	        $data['message'] = ['attach'=>'file exeed limit'];
	      return response()->json($data,422);
	    }
	    $attach = $request->file('attach');
	    $file = Flexihelp::uploadAnyFile($attach,'gigattach');
	    $gigattach = ['filename'=>$file->pathToSave,
	                  'type'=>$file->type,
	                  'size'=>$file->size,
	                  'gigs_id'=> $id
	                  ];
	    Gigattach::create($gigattach);
	    $data['status'] = true;
	    $data['message'] = 'file added with name of '.$file->pathToSave;
	    return response()->json($data , 200);
	}
	
	public function filter_data(){
		$data['status'] = true;
		$data['max_price'] = Gigs::max('price');
		$data['min_price'] = Gigs::min('price');
		return response()->json($data,200);
	}

	public function deleteGig($id){
	    $gig = Gigs::find($id);
	    if ($gig) {
			$gig->skills()->delete();
			$gig->attach()->delete();
			$gig->delete();
			$data['status'] =  true;
			$data['message'] = 'Gig deleted succefully';
	    }else{
			$data['status'] =  false;
			$data['message'] = 'record not found';
			return response()->json($data , 400);            
	    }
	    return response()->json($data , 200);
	}

	public function exportgig(Request $request){
	    $where = [];
	    if ($request->free_text) 
	      $where[] = ['title' ,'like','%'.$request->free_text.'%'];
	    if ($request->status) 
	      $where[] = ['status',$request->status];
	    if($request->date_from){
	      $date_from = date('Y-m-d 00:00:00',strtotime($request->date_from));
	      $where[]  = ['created_at','>=',$date_from];
	    }
	    if($request->date_to){
	      $date_to = date('Y-m-d 23:59:59',strtotime($request->date_to));
	      $where[]  = ['created_at','<=',$date_to];
	    }
	    $gigs = gigs::orderBy('created_at','ASC')
	                 ->with(['customer','attach','skills'])
	                 ->where($where)
	                 ->whereYear('created_at',date('Y',strtotime($request->month)))
	                 ->whereMonth('created_at',date('m',strtotime($request->month)))
	                 ->get();
	    $result = [];
	    foreach ($gigs as $gig) {
	      if ($gig->status==0)
	        $status = 'new';
	      elseif($gig->status==1)
	        $status = 'on progress';
	      elseif($gig->status==2)
	        $status = 'closed';
	      elseif($gig->status==3)
	        $status = 'Canceled';
	      $attachments = "";
	      foreach ($gig->attach as $attachment) {
	        $attachments .= ' - '.url('storage/app/'.$attachment->filename);
	      }
	      $skills = '';
	      foreach ($gig->skills as $skill) {
	        $skills .= ' , '.$skill->Category->name;
	      }
	      $result[] = ['ID'=>$gig->id,
	                   'Title'=>$gig->title,
	                   'HH username'=>$gig->customer->username,
	                   'price'=>$gig->price,
	                   'status'=>$status,
	                   'skills'=>$skills,
	                   'attachments'=>$attachments,
	                   'total number of applications'=>count($gig->applications),
	                  ];
	    }
	    Excel::create('Gig '.$request->month, function($excel) use($result,$request) {
	        $excel->sheet('Gig '.$request->month, function($sheet) use($result,$request) {
	            $sheet->fromArray($result);
	        });
	        // Set the title
	        $excel->setTitle('flexigigs system data exportation');
	        // Chain the setters
	        $excel->setCreator('Flexigigs')
	              ->setCompany('road9media');
	        // Call them separately
	        $excel->setDescription('Gig of '.$request->month.' and filter result');

	    })->download('xlsx');
	}
}