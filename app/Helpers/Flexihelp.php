<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use App\Messages;
use App\Reviews;
use App\Service;
use App\Category;
/**
 * Description of Flexihelp
 *
 * @author Hifny number one on php overall middeleast
 */
class Flexihelp
{
    static function auth()
    {
        $token = session('token');
        if ($token['expires_at'] <= date('Y-m-d h:i:s')) {
            $http = new \GuzzleHttp\Client;

            $response = $http->post(url('oauth/token'), [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => '3',
                    'client_secret' => 'GJuV86h8m3Uem6HFsQRUDwEQNGDTHLozVqi7Tyi8',
                    'scope' => '*',
                ],
            ]);
            $token = json_decode((string) $response->getBody(), true);
            session('token',$token);
            return $token['access_token']; 
        }else{
            return $token['access_token'];
        }

    }
    static function uploadAnyFile( $content=null , $savePath=null ,$exeed_limit=false){   
        if ($content) {
            if(!$savePath){
                return 'can`t find the path that where to save the file please use';
            }
            $max_size = 10;//<=========10MB
            $file_size = round(($content->getClientSize()/1024)/1024,3);//<=========== get the uploaded file size before uploading
            $file_type = $content->getClientOriginalExtension();
            $original_name = $content->getClientOriginalName();
            if ($max_size < $file_size) {
                $upload_response['status'] = false;
                $upload_response['size'] = $file_size;
                $upload_response['size'] = $file_size;
                $upload_response['message'] = 'can`t upload file becouse of the size , max uploaded file is 10MB';
                return $upload_response;
            }
            if (config('filesystems.default') == "s3") {
                // ================ save on s3 for aws ===============
                Storage::disk('s3')->put('storage/app/'.$savePath.'/'.$content->hashName(), file_get_contents($content),'public');
                $pathToSave = $savePath.'/'.$content->hashName();
            }else{
                $pathToSave = $content->store($savePath);
            }
            $upload_response['pathToSave'] = $pathToSave;//$content->store($savePath);
            $upload_response['status'] = true;
            $upload_response['size'] = $file_size;
            $upload_response['type'] = $file_type;
            $upload_response['message'] = 'uploaded with success';
            return (object)$upload_response;
        }
        return 'no files';
    }
    static function upload( $content=null , $savePath=null ){	
    	if ($content) {
	    	if(!$savePath){
	    		return 'can`t find the path that where to save the file please use';
	    	}
	    	$max_size = 10;//<=========10MB
    		$file_size = round(($content->getClientSize()/1024)/1024,3);//<=========== get the uploaded file size before uploading
    		$file_type = $content->getClientOriginalExtension();
    		$original_name = $content->getClientOriginalName();
    		if ($max_size < $file_size) {
	    		$upload_response['status'] = false;
	    		$upload_response['size'] = $file_size;
	    		$upload_response['size'] = $file_size;
	    		$upload_response['message'] = 'can`t upload file becouse of the size , max uploaded file is 10MB';
		        return $upload_response;
    		}
	    	$images_ext = ['png','jpg','jpeg','gif'];//<========== allawed extension for images
	    	$files_ext = ['doc','docx','xlsx','xlsm','xltx','xltm','xls','pdf'];//<========== allawed extension for Files
	    	if (in_array($file_type , $images_ext)) { //<========= is image? YES let`s upload images with multi qualities
                // $path = ""
                if (config('filesystems.default') == "s3") {
                    $img = Image::make($content);
                    // ================ save on s3 for aws ===============
                    $image_normal = $img->stream($file_type);
                    Storage::disk('s3')->put('storage/app/'.$savePath.'/'.$content->hashName(), $image_normal->__toString());
                    $image_normal60 = $img->stream($file_type,60);
                    Storage::disk('s3')->put('storage/app/60/'.$savePath.'/'.$content->hashName(), $image_normal->__toString()); 
                    $image_normal20 = $img->stream($file_type,20);
                    Storage::disk('s3')->put('storage/app/20/'.$savePath.'/'.$content->hashName(), $image_normal->__toString()); 
                }else{
		            $img = Image::make($content->getRealPath());
                    // ================save on local===============
                    $img->save(public_path('storage/app/'.$savePath.'/'.$content->hashName()));
                    $img->save(public_path('storage/app/60/'.$savePath.'/'.$content->hashName()),60);
                    $img->save(public_path('storage/app/20/'.$savePath.'/'.$content->hashName()),20);
                }
	    		$upload_response['pathToSave'] = $savePath.'/'.$content->hashName();
	    	}elseif (in_array($file_type , $files_ext)) { //<========= is file? YES let`s upload the file
	    		$upload_response['pathToSave'] = $content->store($savePath);
	    	}else{
	    		$upload_response['status'] = false;
	    		$upload_response['message'] = 'file extension not supported';
	    	}
    		$upload_response['status'] = true;
    		$upload_response['size'] = $file_size;
    		$upload_response['type'] = $file_type;
    		$upload_response['message'] = 'uploaded with success';
	        return (object)$upload_response;
    	}
    	return 'no files';
    }
    // get image path to be used
    static function get_file($path=null,$type=null,$quality=null,$gender=0){
        if ($path) {
            if ($quality)
                return (config('filesystems.default') == "s3")?'https://s3-'.config('filesystems.disks.s3.region').'.amazonaws.com/'.config('filesystems.disks.s3.bucket').'/storage/app/'.$quality.'/'.$path:asset('storage/app/'.$quality.'/'.$path);
            else
                return (config('filesystems.default') == "s3")?'https://s3-'.config('filesystems.disks.s3.region').'.amazonaws.com/'.config('filesystems.disks.s3.bucket').'/storage/app/'.$path:asset('storage/app/'.$path);
        }else{
            if ($type == "service") {
                return asset('images/defult/service.jpg');
            }elseif($type == "user"){
                if ($gender) {
                    return asset('images/defult/female.png');
                }else{
                    return asset('images/defult/male.png');
                }
            }else{
                return 'http://via.placeholder.com/600x600?text=undefind+type';
            }
        }
    }
    static function get_user($user_id=null)
    {
        if ($user_id) {
            return DB::table('users')->where('id',$user_id)->first();
        }else{
            return false;
        }
    }
    static function get_messages_between($id_from=null,$id_to=null,$limit=5,$offset=0,$conflect=null)
    {
        $where = [];
        $where[] = ['id_from', $id_from];
        $where[] =['id_to', $id_to];
        $orWhere = [];
        $orWhere[] = ['id_to', $id_from];
        $orWhere[] = ['id_from', $id_to];
        if ($conflect) {
            $orWhere[] = $where[] = ['conflect',1];
            $orWhere[] = $where[] = ['order_id',$conflect];
        }
        $messages =  Messages::with(['message_from','message_to'])
                 ->where($where)
                 ->orWhere($orWhere)
                 ->orderBy('created_at','desc')
                 ->limit($limit)
                 ->offset($offset);
                 
        return $messages->get();
    }
    static function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    static function getSkills($type='slug',$selected="",$lang="en"){
        $skills = "";
        $parents_categories = Category::where("parent_id",0)->orderBy('name')->get(); 
        foreach($parents_categories as $cat){
            $name = ($lang=="ar"&&$cat->name_ar)?$cat->name_ar:$cat->name;
            $skills.="<optgroup label='".$name."'>";
            $data_selected = explode(",", $selected);
            $subs = Category::orderBy('name')->where("parent_id",$cat->id)->get();
            if (count($subs)) {
                foreach ($subs as $sub) {
                    $subsubs = Category::orderBy('name')->where("parent_id",$sub->id)->get();
                    if (!count($subsubs)){
                        $is_selected = (in_array($sub->slug, $data_selected))?"selected":"";
                        $subname = ($lang=="ar"&&$cat->name_ar)?$sub->name_ar:$sub->name;
                        $value = ($type == "slug")?$sub->slug:$sub->id;
                        $skills.='<option  class="pl-5" value="'.$value.'" '.$is_selected.'>'.$subname.'</option>';
                    }else{
                        $subname = ($lang=="ar"&&$cat->name_ar)?$sub->name_ar:$sub->name;
                        $skills.="<option disabled class='pl-5'>".$subname."</option>";
                        foreach ($subsubs as $subsub) {
                            $is_selected = (in_array($subsub->slug, $data_selected))?"selected":"";
                            $subsubname = ($lang=="ar"&&$cat->name_ar)?$subsub->name_ar:$subsub->name;
                            $subsubvalue = ($type == "slug")?$subsub->slug:$subsub->id;
                            $skills.='<option value="'.$subsubvalue.'" '.$is_selected.'>'.$subsubname.'</option>';   
                        }
                    }
                }
            }
            $skills.="</optgroup>";
        }
        return ($skills);
    }
    static function userSkills($user_skills=""){
        $skills_array = explode(',', $user_skills);
        $skills = [];
        foreach($skills_array as $cat){
            $skills[] = Category::where("slug",$cat)->first();
        }
        return $skills;
    }
    static function get_stars($type='',$item_id ,$is_api=false){
        if ($type == "supplier") {
            $user_id = $item_id;
            $rate = round(Reviews::where(['type'=>1,'supplier_id'=>$user_id])->avg('rate'));
        }elseif($type =="customer"){
            $user_id = $item_id;
            $rate = round(Reviews::where(['type'=>2,'user_id'=>$user_id])->avg('rate'));
        }elseif($type =="review"){
            $rate = $item_id;
        }elseif($type =="service"){
            $service_id = $item_id;
            $rate = round(Service::find($service_id)->allreviews()->avg('rate'));
        }else{
            $rate = 0;
        }
        $rate0 = ($rate == 0)?"selected":'';
        $rate1 = ($rate == 1)?"selected":'';
        $rate2 = ($rate == 2)?"selected":'';
        $rate3 = ($rate == 3)?"selected":'';
        $rate4 = ($rate == 4)?"selected":'';
        $rate5 = ($rate == 5)?"selected":'';
        if ($is_api) 
            return $rate;
        return '<select class="user-rating" data-readonly="true">
                <option value="" '.$rate0.'></option>
                <option value="1" '.$rate1.'>1</option>
                <option value="2" '.$rate2.'>2</option>
                <option value="3" '.$rate3.'>3</option>
                <option value="4" '.$rate4.'>4</option>
                <option value="5" '.$rate5.'>5</option>
        </select>';
    }
    static function defult_date($date,$withtime = false,$time_custom_format = false){
        if($time_custom_format)
            return date('d/m/Y h:i A',strtotime($date));
        return ($withtime)? date('h:i:s d/m/Y',strtotime($date)):date('d/m/Y',strtotime($date));
    }
    static function query_date($date,$withtime = false){
        return ($withtime)? date('Y-m-d h:i:s',strtotime($date)):date('Y-m-d',strtotime($date));
    }
    static function fixprice ($item=null,$type=null){
        if($item&&$type){
            if ($type == "service") {
                $service = $item;
                $data['price']= $price = ($service->price_unit=="hour")?$service->price_per_unit*$service->days_to_deliver:$service->price_per_unit;
                $data['formated_price']= number_format($price);
                $data['transaction_commission']= $transaction_commission = config('site_settings.commission.service.transaction');
                $transaction = $price*$transaction_commission;
                $data['handling_commission']= $handling_commission = config('site_settings.commission.service.handling');
                $handling = $price*$handling_commission;
            }else{
                $gig = $item;
                $data['price']= $price = $gig->price;
                $data['formated_price']= number_format($price);
                $data['transaction_commission']= $transaction_commission = config('site_settings.commission.gig.transaction');
                $transaction = $price*$transaction_commission;
                $data['handling_commission']= $handling_commission = config('site_settings.commission.gig.handling');
                $handling = $price*$handling_commission;
            }
            $data['handling'] = $handling;
            $data['transaction'] = $transaction;
            // total amount to be paid by customer in requesting service || gig (price + handling fees)
            $data['total_handling']= number_format(round($price+$handling));
            $data['total_handling_payment']= round($price+$handling);
            // total amount to be paid for supplier in earnings after transaction fees deduction (price - transaction fees)
            $data['total_transaction'] = number_format(round($price-$transaction));
            $data['total_transaction_payment'] = round($price-$transaction);
            $data['bank_commission'] = config('site_settings.commission.bank');
            $data['total_bank_commission'] = intval($data['bank_commission'])*intval($data['total_transaction']);
            if($data['total_bank_commission']<60)
                $data['total_bank_commission'] = 60;
            return (object)$data;
        }
    }
    static function catname($data=null,$lang = "en",$type = 'object'){
        if ($data) {
            $catname = "";
            if ($type == 'object') {
                $catname = ($lang == "ar" && $data->name_ar)?$data->name_ar:$data->name;
            }else{
                $catname = ($lang == "ar" && $data['name_ar'])?$data['name_ar']:$data['name'];
            }
            return $catname;
        }
    }
    static function get_agegroup($type=null,$num=0){
        $groups = ['16-18','18-30','30-50','+50'];
        if ($type=="array") {
            $response = $groups;
        }elseif ($type=="single") {
            $response = $groups[$num];
        }elseif($type=="options"){
            $response = "<option disabled selected>".trans('user.register_age')."</option>";
            foreach ($groups as $key => $value) {
                $selected = ($num-1 ==$key)?'selected':"";
                $response .="<option value='".$key."' ".$selected.">".$value."</option>";
            }
        }
        if ($type) {
            return $response;
        }else{
            return false;
        }
    }
    static function supplier_type($selected='',$need) {
        $types = ['freelancer'=>trans('user.supplier_edit_profile.i_am_a.freelancer'),
                  'parttimer'=>trans('user.supplier_edit_profile.i_am_a.part_timer'),
                  'intern'=>trans('user.supplier_edit_profile.i_am_a.intern') ];
        // get all
        if ($need=="all") {
            return $types;
        // get one
        }elseif($need=="one"){
            return $types[$selected];
        // get options tag
        }elseif($need=="options"){
            $data = "<option value='' disabled selected>".trans('user.register_iam_a')."</option>";
            foreach ($types as $type => $value) {
                $selected = ($type == $selected)?"selected":"";
                $data.="<option value='".$type."' ".$selected." >".$value."</option>";
            }
            return $data;
        }
    }
}