<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Creator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	if( !$this->session->has_userdata('login_data') ) redirect('users');
	}

	public function index()
	{
		$data['main_content'] = 'admin/main';
		$this->load->view('admin/blank',$data);
	}

	public function _example_output($output = null)
	{
		$this->load->view('admin/blank',(array)$output);
	}

	public function query()
	{
		$data['main_content'] = 'admin/query';
		$this->load->view('admin/blank',$data);
	}

	public function modules()
	{
		$data['tables'] = get_table('module'); 
		$data['main_content'] = 'admin/modules';
		$this->load->view('admin/blank',$data);
	}

	public function columns($id)
	{
		$data['main_content'] = 'admin/columns';
		$this->load->view('admin/blank',$data);
	}

   public function add_column()
   {
	   if ($this->input->server('REQUEST_METHOD') === 'POST') {
		   $names = $this->input->post('name');
	       $renames = $this->input->post('rename');
	       $types = $this->input->post('type');
	       $check = $this->input->post('check');
		   $req = $this->input->post('req');
	       $id = $this->input->post('id');
		   $options = $this->input->post('options');
	       $dataz =  [ 'name'=>$names, 
	      			   'is_rename'=>($renames)?$renames:$names, 
	      			   'type'=>($types)?$types:0,
	      			   'list'=>($check)?1:0,
					   'is_required'=>($req)?1:0,
					   'options'=>$options,
	      			   'module_id'=>$id,
	      			 ];
	     	if($this->db->insert('columns',$dataz))
	     		echo "Add successfully";
	     	else
	     		echo "Add successfully";
	   }else{
	   	echo "bad parametrs";
	   }

   }
   public function update_column()
   {
	   if ($this->input->server('REQUEST_METHOD') === 'POST') {
		   $names = $this->input->post('name');
	       $renames = $this->input->post('rename');
	       $types = $this->input->post('type');
	       $check = $this->input->post('check');
		   $req = $this->input->post('req');
	       $id = $this->input->post('id');
	       $options = $this->input->post('options');

	       $dataz =  [ 'name'=>$names, 
	      			   'is_rename'=>($renames)?$renames:$names, 
	      			   'type'=>($types)?$types:0,
	      			   'list'=>($check)?1:0,
					   'is_required'=>($req)?1:0,
					   'options'=>$options,
	      			 ];
	     	if($this->db->where('id',$id)->update('columns',$dataz))
	     		echo "Updated successfully";
	     	else
	     		echo "Updated successfully";
	   }else{
	   	echo "bad parametrs";
	   }
   }

    public function delete_column()
    {
	   if ($this->input->server('REQUEST_METHOD') === 'POST') {
	       $this->db->delete('columns',['id'=>$this->input->post('id')]);
	   }else{
	   	echo "bad parametrs";
	   }
    }

	public function add_query()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
	    	$store = $this->input->post();
	    	$keys = $this->input->post('key');
	    	unset($store['key']);
	    	$values = $this->input->post('value');
	    	unset($store['value']);
	        $joins = $this->input->post('join');
	    	unset($store['join']);
	        $cond1 = $this->input->post('cond1');
	    	unset($store['cond1']);
	        $cond2 = $this->input->post('cond2');
	    	unset($store['cond2']);
	        $join_type = $this->input->post('join_type');
	    	unset($store['join_type']);
	        $buttons = $this->input->post('buttons');
	    	unset($store['buttons']);
			$unsets = $this->input->post('unset');
	    	unset($store['unset']);
	    	unset($store['save']);
	    	unset($store['no_redirect']);
	    	$where = [];
	     	for ($i=0; $i < count($keys) ; $i++) { 
	     		if(@$keys[$i] && @$values[$i])
					$where[] =[ 'key'	=>$keys[$i],
								'value'	=>$values[$i],
							  ]; 
	    	}
	    	$where = json_encode($where);
	    	$store['is_where'] = $where;
	    	$join = [];
	     	for ($i=0; $i < count($joins) ; $i++) { 
	     		if(@$joins[$i])
	         		$join[]= ['table'=>$joins[$i],
					 		  'cond1'=>$cond1[$i],
							  'cond2'=>$cond2[$i],
							  'type' =>$join_type[$i]
							 ];
	    	}
			$join = json_encode($join);
	    	$store['is_join'] = $join;
	    	$button = [];
	     	for ($i=0; $i < count($buttons) ; $i++) { 
	     		if(@$buttons[$i])
	         		$button[]=$buttons[$i];
	    	}
			$button = json_encode($button);
	    	$store['buttons'] = $button; 
			$unset = [];
	     	for ($i=0; $i < count($unsets) ; $i++) { 
	     		if(@$unsets[$i])
	         		$unset[]=$unsets[$i];
	    	}
			$unset = json_encode($unsets);
	    	$store['unset'] = $unset;
          	$the_id = $this->db->insert('module',$store);
		  if ($this->input->post('save')) {
			redirect('creator/modules');
         }elseif($this->input->post('no_redirect')){
         	redirect('creator/columns/'. $this->db->insert_id() );
          }else{
           $this->session->set_flashdata('message', show_message2(validation_errors(),'danger'));
         }
	    }
		$data['main_content'] = 'admin/query';
		$this->load->view('admin/blank',$data);
	}

	public function edit_query($id)
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
	    	$store = $this->input->post();
	    	$keys = $this->input->post('key');
	    	unset($store['key']);
	    	$values = $this->input->post('value');
	    	unset($store['value']);
	        $joins = $this->input->post('join');
	    	unset($store['join']);
	        $cond1 = $this->input->post('cond1');
	    	unset($store['cond1']);
	        $cond2 = $this->input->post('cond2');
	    	unset($store['cond2']);
	        $join_type = $this->input->post('join_type');
	    	unset($store['join_type']);
	        $buttons = $this->input->post('buttons');
	        unset($store['buttons']);
			$unsets = $this->input->post('unset');
	    	unset($store['unset']);
	    	unset($store['save']);
	    	unset($store['no_redirect']);
	    	$where = [];
	     	for ($i=0; $i < count($keys) ; $i++) { 
	     		if(@$keys[$i] && @$values[$i])
	         		$where[] =[ 'key'	=>$keys[$i],
								'value'	=>$values[$i],
							  ]; 
	    	}
	    	$where = json_encode($where);
	    	$store['is_where'] = $where;
	    	$join = [];
	     	for ($i=0; $i < count($joins) ; $i++) { 
	     		if(@$joins[$i])
	         		$join[]= ['table'=>$joins[$i],
					 		  'cond1'=>$cond1[$i],
							  'cond2'=>$cond2[$i],
							  'type' =>$join_type[$i]
							 ];
	    	}
			$join = json_encode($join);
	    	$store['is_join'] = $join;
	    	$button = [];
	     	for ($i=0; $i < count($buttons) ; $i++) { 
	     		if(@$buttons[$i])
	         		$button[]=$buttons[$i];
	    	}
			$button = json_encode($button);
	    	$store['buttons'] = $button;
			$unset = [];
	     	for ($i=0; $i < count($unsets) ; $i++) { 
	     		if($unsets[$i])
	         		$unset[]=$unsets[$i];
	    	}
			$unset = json_encode($unset);
	    	$store['unset'] = $unset;
          	$the_id = $this->db->where('id',$id)->update('module',$store);
		  if ($this->input->post('save')) {
			redirect('creator/modules');
         }elseif($this->input->post('no_redirect')){
         	redirect('creator/columns/' . $this->uri->segment('3') );
          }else{
           $this->session->set_flashdata('message', show_message2(validation_errors(),'danger'));
         }
	    }
		$data['main_content'] = 'admin/query';
		$this->load->view('admin/blank',$data);
	}

	public function delete_query($id)
	{
		$this->db->delete('module',['id'=>$id]);
		$this->db->delete('columns',['module_id'=>$id]);
		redirect('creator/modules');
	}

    public function contracts()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('contracts');
		    $crud->set_subject(' عقود');
			$crud->set_relation('cust_id','customers','{identity_no} - {username}' );
			$crud->set_relation('invest_id','investor','{identity_no} - {username}');
            $get_required = get_table('columns',['module_id'=>4]);
            foreach ( $get_required as $req )
            { 
               $arr[] = $req->name;
               $tags = explode(',',$req->options); 
               if( $req->type == 1 )
                 {  
                    $crud->field_type($req->name, 'string');
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
               if( $req->type == 8 )
                 {
                    $crud->field_type($req->name, 'date');
                 }
               if( $req->type == 10 )
                 {
                    $crud->field_type($req->name, 'integer');
                 }  
               if( $req->is_required == 1 )
                 {
                    $crud->required_fields($arr);
                 }
               if( $req->list == 1 )
                 {
                    $crud->columns($arr);
                 }     
            $crud->display_as($req->name,$req->is_rename);
			}
			$crud->add_action('أضف سند',base_url().'assets/grocery_crud/themes/flexigrid/css/images/add.png','creator/bonds' ,'');
			$output = $crud->render();
			$this->_example_output($output);
	}

    public function bonds($id)
	{
			$crud = new grocery_CRUD();

			$crud->set_table('bonds');
			$crud->set_subject(' سندات');
			$crud->set_relation('customer_id','customers','{identity_no} - {username}');
			$crud->set_relation('investor_id','investor','{identity_no} - {username}');
			$crud->where('contract_id',$id);

            $get_required = get_table('columns',['module_id'=>5]);
            foreach ( $get_required as $req )
            { 
               $arr[] = $req->name;
               $tags = explode(',',$req->options); 
               if( $req->type == 1 )
                 {  
                    $crud->field_type($req->name, 'string');
                 } 
               if( $req->type == 6 )
                 {
                    $crud->field_type($req->name, 'dropdown',$tags);
                 }
               if( $req->type == 8 )
                 {
                    $crud->field_type($req->name, 'date');
                 }
               if( $req->type == 10 )
                 {
                    $crud->field_type($req->name, 'integer');
                 }
               if( $req->is_required == 1 )
                 {
                    $crud->required_fields($arr);
                 }
               if( $req->list == 1 )
                 {
                    $crud->columns($arr);
                 }     
            $crud->display_as($req->name,$req->is_rename);
			}
			
			$crud->add_fields('customer_id','contract_id','investor_id','cash_paid','next_date','created_date');
			$crud->field_type('contract_id', 'hidden',$id);
			$crud->edit_fields('customer_id','investor_id','cash_paid','next_date','created_date');
			$crud->field_type('contract_id', 'hidden',$id);

			$output = $crud->render();
			$this->_example_output($output);
	}

	public function admins()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('users');
			$crud->set_subject('مشرفين');
			$crud->required_fields('user_name','e_mail','password','created_date');
	        $crud->display_as('full_name','الأسم الكامل ')
			     ->display_as('user_name','أسم المستخدم ')
				 ->display_as('e_mail','البريد الألكترونى ')
				 ->display_as('password','كلمة المرور ')
				 ->display_as('created_by','المسؤول ')
				 ->display_as('status','الحالة ')
				 ->display_as('last_login','آخر دخول ')
				 ->display_as('img','الصورة الشخصية ')
				 ->display_as('role_id','نوع المشرف ')
				 ->display_as('start_date','تاريخ البداية ')
				 ->display_as('end_date','تاريخ النهاية ')
				 ->display_as('created_date','تاريخ التسجيل ')
				 ->display_as('position','الوظيفة ')
				 ->display_as('log_start','وقت الدخول ')
				 ->display_as('log_end','وقت الخروج ')
				 ->display_as('mobile','الهاتف ')
				 ->display_as('branch','الفرع ')
				 ->display_as('barcode','باركود ');
		    $crud->set_field_upload('img','assets/uploads/files');
			$crud->field_type('status','true_false');
		    // $crud->field_type('log_start','time');
			// $crud->field_type('log_end','time');
			$crud->field_type('status','true_false');
			$crud->field_type('mobile','integer');
			$crud->field_type('password', 'password');
			$crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));
			$crud->callback_add_field('password',array($this,'set_password_input_to_empty'));
			$crud->callback_before_update(array($this,'encrypt_password_callback'));
		    $crud->set_relation('role_id','role','role_name');

			$output = $crud->render();
			$this->_example_output($output);
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