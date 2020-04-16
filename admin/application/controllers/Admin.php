<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
    if( !$this->session->has_userdata('login_data') ) redirect('users');
	}

	public function _example_output($output = null)
	{
		$this->load->view('admin/blank',(array)$output);
	}

  public function index($slug=null)
    {
      $get_module = get_this('module',['url'=>$slug]);
        if($get_module)
        {
            $crud = new grocery_CRUD();
			      $crud->set_table($get_module['table_name']);
            $crud->set_subject($get_module['the_name']);
             if($get_module['is_sort'])
                    $crud->order_by($get_module['is_sort'],$get_module['order_by']);
             if($get_module['is_limit'])
                    $crud->limit($get_module['is_limit'],$get_module['offset']);
             if($get_module['is_where'])
                {
                  $where = json_decode($get_module['is_where']);
                  foreach ( $where as $wheres )
                  { 
                    $crud->where($wheres->key,$wheres->value);
                  }
                }   
            if($get_module['is_join'])
                {
                  $join = json_decode($get_module['is_join']);
                  foreach ($join as $key ) 
                  {
                     $crud->set_relation($key->cond1,$key->table,$key->cond2);
                  }
                }
            if($get_module['buttons'])
                {
                  $unset = json_decode($get_module['buttons']);
                    if ( in_array('Add' ,$unset) )
                    $crud->unset_add();
                    if ( in_array('Edit' ,$unset) )
                    $crud->unset_edit();
                    if ( in_array('View' ,$unset) )
                    $crud->unset_read();     
                    if ( in_array('Delete' ,$unset) )
                    $crud->unset_delete();
                }
            if($get_module['unset'])
                 {  $unset2 = json_decode($get_module['unset']);
                  foreach ($unset2 as $keys ) {
                     $crud->unset_fields([$keys]);
                    }
                 }        
            $get_required = get_table('columns',['module_id'=>$get_module['id']]);
            $arr = $arrz = [];
            foreach ( $get_required as $req )
            { 
               $tags = explode(',',$req->options); 
               if( $req->type == 1 )
                 {  
                    $crud->field_type($req->name, 'string');
                 } 
               if( $req->type == 2 )
                 {
                    $crud->field_type($req->name, 'textarea');
                 }
                if( $req->type == 3 )
                  {
                     $crud->field_type($req->name, 'true_false',$tags);
                  } 
               if( $req->type == 4 )
                 {
                    $crud->field_type($req->name, 'text');
                 } 
               if( $req->type == 5 )
                 {
                    $crud->field_type($req->name, 'true_false');
                 }  
               if( $req->type == 6 )
                 {
                    $crud->field_type($req->name, 'dropdown',$tags);
                 }
               if( $req->type == 7 )
                 {
            		    $crud->set_field_upload($req->name,'../storage/app/20');
                 }
               if( $req->type == 8 )
                 {
                    $crud->field_type($req->name, 'date');
                 }
              if( $req->type == 9 )
                 {
                    $crud->field_type($req->name, 'datetime');
                 }
               if( $req->type == 10 )
                 {
                    $crud->field_type($req->name, 'integer');
                 } 
               if( $req->type == 11 )
                 {
                    $crud->field_type($req->name, 'readonly');
                 }
              if( $req->type == 12 )
                 {
                    $crud->field_type($req->name, 'password');
                    $crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
                    $crud->callback_add_field('password',array($this,'set_password_input_to_empty'));
                    $crud->callback_before_update(array($this,'encrypt_password_callback'));
                 }
               if( $req->is_required == 1 )
                 {
					          $arr[]=$req->name;
                 }
			         if( $req->list == 0 )
                 {
                    $arrz[]=$req->name;
                 }     
            $crud->display_as($req->name,$req->is_rename);
            }

            $crud->required_fields($arr);
		      	$crud->unset_fields($arrz);  

            $crud->unset_columns(json_decode($get_module['unset']));
            $get_callbacks = get_table('callbacks',['module_name'=>$slug]);
             if ( $get_callbacks )
                {
                  foreach ($get_callbacks as $callbacks) 
                  { 
                    $crud->add_action($callbacks->action,$callbacks->img_url,$callbacks->url ,$callbacks->css);
                  }
                }
            $output = $crud->render();
            $this->_example_output($output);  
        }
    }

    function encrypt_password_callback($post_array, $primary_key) 
    {      
        //Encrypt password only if is not empty. Else don't change the password to an empty field
        if(!empty($post_array['password'])){
          $post_array['password'] = md5(md5($post_array['password']));
        }
        else{
            unset($post_array['password']);
        }
          return $post_array;
    }
      
    function set_password_input_to_empty() 
    {
      return "<input type='password' name='password' value='' />";
    }
}