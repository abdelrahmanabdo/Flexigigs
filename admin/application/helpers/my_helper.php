<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists( 'b_lang' )){
 function b_lang( $text ){
    $ci = & get_instance();
        if ($text){   
            $lang=($ci->session->has_userdata('lang'))?$ci->session->lang:"en";
            $word = $ci->db->get_where('back_lang',['text'=>$text])->row();
            if($word){
                $translated = $ci->db->get_where('back_lang',['parent'=>$word->id,'lang'=>$lang])->row();
                if($translated){
                    return $translated->text;
                }else{
                    return $text;
                }
            }else{
                if(!$ci->db->get_where('back_lang',['text'=>$text,'lang'=>'en'])->row())
                $ci->db->insert('back_lang',['text'=>$text,'lang'=>'en']);
                return $text;
            }
        }   
    }
}
if ( !function_exists( 'f_lang' )){
 function f_lang( $text ){
    $ci = & get_instance();
        if ($text){   
            $lang=($ci->session->has_userdata('lang'))?$ci->session->lang:"en";
            $word = $ci->db->get_where('front_lang',['text'=>$text])->row();
            if($word){
                $translated = $ci->db->get_where('front_lang',['parent'=>$word->id,'lang'=>$lang])->row();
                if($translated){
                    return $translated->text;
                }else{
                    return $text;
                }
            }else{
                if(!$ci->db->get_where('back_lang',['text'=>$text,'lang'=>'en'])->row())
                $ci->db->insert('back_lang',['text'=>$text,'lang'=>'en']);
                return $text;
            }
        }   
    }
}
function get_sourcename($id)
{
if($id==0)
return 'site news';	
else{
    $ci = & get_instance();

    $role = $ci->db->get_where('out_sources', array('out_sources.id' => $id))->row();

    return $role->name;
}
}
function get_this($table=null , $where=null ,$colomn=null){
    if (empty($table)||empty($where)) {
        return false;
    }else{
        $ci = & get_instance();
        $role = $ci->db->get_where($table, $where)->row_array();
        if (!empty($colomn)) {
            return $role[$colomn];
        }else{
            return $role;
        }
    }
}
function get_avg($table,$table_id='',$id='')
{
    $ci = & get_instance();
if($id)
    $rate = $ci->db->select_avg('rate')->get_where($table,[$table_id=>$id])->row()->rate;
    if($rate)
    return $rate;
else
    return 0;
}
function get_table($table=null , $where=null,$return=null){
    if (empty($table)) {
        return false;
    }else{
        $ci = & get_instance();
        if ($return == "count") {
            return $ci->db->where($where)->count_all_results($table);
        }else{
         return $ci->db->get_where($table, $where)->result();
        }
    }
}
function get_count_all($table=null ,$col=null,$where=null){
    $ci = & get_instance();
    if (empty($table)) {
        return false;
    }else{
        if ($col) {
                   $ci->db->select_sum($col);
            return $ci->db->get_where($table,$where)->result()[0]->$col; 
        }else{
            return $ci->db->count_all_results($table);
        }
    }
}
function get_mobile($id=null,$type = null){
    if (empty($id)) {
        return false;
    }else{
        $ci = & get_instance();
        $company = $ci->db->get_where('companies', array('id'=>$id))->row_array();
        $more_mobile = $ci->db->get_where('companies_more_data', array('company_id'=>$id,'key'=>'mobile'))->result();
        $data = ($company['mobile'])?$company['mobile']:"";
        if ($type == "table") {
        foreach ($more_mobile as $mobile) {
             $data = $data."<br>".$mobile->value;
         } 
        }else{
        foreach ($more_mobile as $mobile) {
             $data = $data."-".$mobile->value;
         } 
        }

         return $data;
    }
}
function get_chat($where=null,$return=null){
    if ($where) {
        $ci = & get_instance();
        if ($return == "conut") {
            return $ci->db->where($where)->count_all_results('chat');
        }else{
         return $ci->db->get_where('chat', $where)->result();
        }
    }else{
        return false;
    }
}
function add_chat($data_to_store=null){
    $ci = & get_instance();
    if ($data_to_store)
        return $ci->db->insert('chat',$data_to_store);
    else
        return false;
}
function update_chat($where=null,$data_to_store = null){
    $ci = & get_instance();
    if ($where && $data_to_store)
        return $ci->db->where($where)->update('chat', $data_to_store);
    else
        return false;
}
function get_time(){
   return array('09:00'=>'09:00 AM',
                '10:30'=>'10:30 AM',
                '11:00'=>'11:00 AM',
                '11:30'=>'11:30 AM',
                '12:00'=>'12:00 PM',
                '12:30'=>'12:30 PM',
                '13:00'=>'01:00 PM',
                '13:30'=>'01:30 PM',
                '14:00'=>'02:00 PM',
                '14:30'=>'02:30 PM',
                '15:00'=>'03:00 PM',
                '15:30'=>'03:30 PM',
                '16:00'=>'04:00 PM',
                '16:30'=>'04:30 PM',
                '17:00'=>'05:00 PM',
                '17:30'=>'05:30 PM'
                ); }
function get_reached($key=null){
 $option=array(1=>"Facebook",2=>"Incoming Call",3=>"Gathering Data",4=>"Other");
 if(!empty($key))
 return $option[$key];
 else
 return false;
}
function generate_password($len = 5){
      $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
      $base = strlen($charset);
      $result = '';

      $now = explode(' ', microtime())[1];
      while ($now >= $base){
        $i = $now % $base;
        $result = $charset[$i] . $result;
        $now /= $base;
      }
      return substr($result, -5);
    }
function change_color($cat_id) {
    $CI = & get_instance();
    $returnred='';
    $query = $CI->db->get_where('category', array('cat_id' => $cat_id))->result();
    if ($query) {
        $parent_cat=$query[0]->parent;
        if($parent_cat!=0)
        {
            $returnred='<p style="color:red;" >'.$query[0]->cat_title.'</p>';
        }
        else
        {
            $returnred=$query[0]->cat_title;
        }

    }
    return $returnred;
}

function get_categoryname($id)

{

    $ci = & get_instance();

    $role = $ci->db->get_where('out_categories', array('out_categories.id' => $id))->row();

    return $role->name;

}
function get_category_name($id)

{

    $ci = & get_instance();

    $role = $ci->db->get_where('category', array('category.cat_id' => $id))->row_array();

    return $role['cat_title'];

}
function get_buttons($id, $controller)
{
    $ci = & get_instance();
    $html = '<span class="actions">';
    $html .= '<a href="' . base_url() . 'index.php/admin/'.$controller.'/edit/' . $id . '"><i class="fa fa-2x fa-pencil-square-o"></i>&nbsp;';
    $html .= '<a href="javascript:void(0);" onclick="deleteRow($(this), '.$id.')"><i class="fa fa-2x fa-trash"></i></a>';
    $html .= '</span>';
 
    return $html;
}
function get_newsletter_buttons($id, $controller)
{
    $ci = & get_instance();
    $html = '<span class="actions">';
    $html .= '<a href="' . base_url() . 'index.php/admin/'.$controller.'/send/' . $id . '"><i class="fa fa-2x fa-paper-plane-o"></i></a>&nbsp;';
    $html .= '<a href="' . base_url() . 'index.php/admin/'.$controller.'/edit/' . $id . '"><i class="fa fa-2x fa-pencil-square-o"></i></a>&nbsp;';
    $html .= '<a href="javascript:void(0);" onclick="deleteRow($(this), '.$id.')"><i class="fa fa-2x fa-trash"></i></a>';
    $html .= '</span>';
 
    return $html;
}
function get_newsletter_emails_buttons($id, $controller)
{
    $ci = & get_instance();
    
    $html = '<span class="actions">';
    $html .= '<a href="javascript:void(0);" onclick="deleteRow($(this), '.$id.')" title="delete"><i class="fa fa-2x fa-trash"></i></a>';
    $html .= '</span>';
 
    return $html;
}
function get_buttons2($id, $controller)
{
    $ci = & get_instance();
    $html = '<span class="actions">';
    $html .= '<a href="javascript:void(0);" onclick="deleteRow($(this), '.$id.')"><img width="30" height="30" src="' . base_url() . 'template/img/delete.png"/></a>';
    $html .= '</span>';
 
    return $html;
}

function get_buttons3($id, $controller)
{
    $ci = & get_instance();
    $html = '<span class="actions">';
    $html .= '<a href="' . base_url() . 'index.php/admin/'.$controller.'/view/' . $id . '"><img width="30" height="30" src="' . base_url() . 'template/img/view.png"/></a>&nbsp;';
    $html .= '<a href="javascript:void(0);" onclick="deleteRow($(this), '.$id.')"><img width="30" height="30" src="' . base_url() . 'template/img/delete.png"/></a>';
    $html .= '</span>';
 
    return $html;
}

function get_thumbnail($img, $width = '', $height = '')
{
    if(empty($width) && empty($height))
    {
        return base_url() . "/uploads/" . $img;
    }
     $img_name = pathinfo($img, PATHINFO_FILENAME);
     $img_ext = pathinfo($img, PATHINFO_EXTENSION);
     return base_url() . "/uploads/" . $img_name . '_thumb_'.$width.'x'.$height.'.' . $img_ext;
} 
function change_status($publish,$id)

{
    $returned_data='';
    if($publish==1)
    {
        $returned_data='
        <label class="switch" id="change-status">
        	<input type="checkbox" onclick="change_status('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue" checked/>
		 	 <span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';
    }
    else
    {
        $returned_data='
        <label class="switch" id="change-status">
        	<input type="checkbox" onclick="change_status('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue"/>
		 	<span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';
    }
    return $returned_data;
}

function change_video($publish,$id)

{
    $returned_data='';
    if($publish==1)
    {
        $returned_data='
        <label class="switch" id="change-status">
        	<input type="checkbox" onclick="change_video('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue" checked/>
		 	 <span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';
    }
    else
    {
        $returned_data='
        <label class="switch" id="change-status">
        	<input type="checkbox" onclick="change_video('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue"/>
		 	<span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';
    }
    return $returned_data;
}
function change_video_status($publish,$id)
{
    $returned_data='';
    if($publish==1)
    {
        $returned_data='
        <label class="switch" id="change-status">
            <input type="checkbox" onclick="change_video_status('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue" checked/>
             <span class="switch-label" data-on="On" data-off="Off"></span>
            <span class="switch-handle"></span>
        </label>
        ';
    }
    else
    {
        $returned_data='
        <label class="switch" id="change-status">
            <input type="checkbox" onclick="change_video_status('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue"/>
            <span class="switch-label" data-on="On" data-off="Off"></span>
            <span class="switch-handle"></span>
        </label>
        ';

    }
    return $returned_data;
}

function change_poll_status($publish,$id)

{
    $returned_data='';
    if($publish==1)

    {
        $returned_data='
        <label class="switch" id="change-status">
            <input type="checkbox" onclick="change_poll_status('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue" checked/>
             <span class="switch-label" data-on="On" data-off="Off"></span>
            <span class="switch-handle"></span>
        </label>
        ';
    }

    else

    {
        $returned_data='
        <label class="switch" id="change-status">
            <input type="checkbox" onclick="change_poll_status('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue"/>
            <span class="switch-label" data-on="On" data-off="Off"></span>
            <span class="switch-handle"></span>
        </label>
        ';

    }

    return $returned_data;

}
function change_comment($publish,$id)
{
    $returned_data='';
    if($publish==1)
    {

        $returned_data='
        <label class="switch" id="change-status">
        	<input type="checkbox" onclick="change_comment('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue" checked/>
		 	 <span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>';
    }
    else
    {
        $returned_data='
        <label class="switch" id="change-status">
        	<input type="checkbox" onclick="change_comment('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue"/>
		 	<span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>';
    }
    return $returned_data;
}
function change_important($publish,$id)
{
    $returned_data='';
    if($publish==1)
    {
        $returned_data='
        <label class="switch" id="change-important">
        	<input type="checkbox" onclick="change_important('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue" checked/>
		 	 <span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';
    }
    else
    {
        $returned_data='
        <label class="switch">
        	<input type="checkbox" onclick="change_important('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue"/>
		 	<span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';

    }
    return $returned_data;
}
function change_bar($publish,$id)
{
    $returned_data='';
    if($publish==1)
    {
        $returned_data='
        <label class="switch" id="bar-action">
        	<input type="checkbox" onclick="change_bar('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue" checked/>
		 	 <span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';
    }
    else
    {
        $returned_data='
        <label class="switch">
        	<input type="checkbox" onclick="change_bar('.$id.')" id="'.$id.'" class="switch-input" data-color-on="blue"/>
		 	<span class="switch-label" data-on="On" data-off="Off"></span>
		  	<span class="switch-handle"></span>
		</label>
        ';
    }
    return $returned_data;
}
function update_setting($name, $value) {
    $CI = & get_instance();
    $CI->db->query("UPDATE settings SET value='$value' WHERE name='$name'");
}
function get_setting($name) {
    $CI = & get_instance();
    $query = $CI->db->get_where('settings', array('name' => $name))->result();
    if ($query) {
        return $query[0]->value;
    } else {
        return "";
    }
}
function age($birthday)
{
	$year = '31556926';
	return floor((time()-$birthday)/$year);
}
function show_message($message,$type='success')
{
    $message = trim(preg_replace('/\s+/', ' ', $message));
	$type = ($type == 'success') ?'success':'danger'; 
    return'<script>
                UIkit.notify({
                    message : "'.$message.'",
                    status  : "'.$type.'",
                    timeout : 5000,
                    pos     : "top-center"
                });
            </script>';
}
function show_message2($message,$type='success')
{
    $type = ($type == 'success') ?'success':'danger'; 
    return '<div class="alert media fade in remove alert-'.$type.' alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                '.$message.'
            </div>';
}