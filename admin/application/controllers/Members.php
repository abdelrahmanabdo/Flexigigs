<?php 
class Members extends Admin_Controller{
  public function __construct() 
    {
        parent::__construct();
        $this->load->library('Datatables');
        $this->load->library('table');
        $this->load->model(array('member_model','admin/users_model','role_model'));
    }
  public function index()
  {
    $data['title'] = lang('users');
    $data['add_link']=base_url('admin/members/add');
    $tmpl = array ( 'table_open'  => '<table id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" class="uk-table uk-cell-border compact  uk-table-hover uk-width-1 code-container dataTables_wrapper form-inline dt-uikit md-processed" cellspacing="0" width="100%" role="grid" style="width: 100%;">' );
    $this->table->set_template($tmpl); 

    $this->table->set_heading('ID',lang('name'),lang('mobile'),lang('email'),lang('position'),lang('group'),lang('action'));
    $data['main_content'] = 'admin/member/admin_list';
    $this->load->view('admin/blank',$data);
  }
  public function group()
  {
    $data['title'] = lang('users');
    $data['add_link']=base_url('admin/members/add');
    $tmpl = array ( 'table_open'  => '<table id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" class="uk-table uk-cell-border compact  uk-table-hover uk-width-1 code-container dataTables_wrapper form-inline dt-uikit md-processed" cellspacing="0" width="100%" role="grid" style="width: 100%;">' );
    $this->table->set_template($tmpl); 

    $this->table->set_heading('ID',lang('name'),lang('mobile'),lang('email'),lang('position'),lang('action'));
    $data['main_content'] = 'admin/member/editors_list';
    $this->load->view('admin/blank',$data);
  }
      public function get_admin()
    {
      $this->load->library('Datatable', array('model' => 'm_admin'));
      $json = $this->datatable->datatableJson();
      $this->output->set_header("Pragma: no-cache");
      $this->output->set_header("Cache-Control: no-store, no-cache");
      $this->output->set_content_type('application/json') -> set_output(json_encode($json));
    }
      public function get_group()
    {
      $this->load->library('Datatable', array('model' => 'm_editors'));
      $json = $this->datatable->datatableJson();
      $this->output->set_header("Pragma: no-cache");
      $this->output->set_header("Cache-Control: no-store, no-cache");
      $this->output->set_content_type('application/json') -> set_output(json_encode($json));
    }
   public function validation($key=null)
   {
    $this->form_validation->set_rules($key, $key, 'trim|required|is_unique[users.'.$key.']');
          if ($this->form_validation->run()){
            echo json_encode('<i class="material-icons uk-text-success">&#xE876;</i>');
          }
          else{
            echo "shit";
          }
   }
    public function add()
  {
    $data['title'] = lang('users');
    $data['message'] = null;
    $type = $this->uri->segment(4);
    if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
      $store = $this->input->post();
      $this->form_validation->set_rules('user_name', 'user_name', 'trim|required|is_unique[users.user_name]');
      $this->form_validation->set_rules('password', 'Password', 'required|matches[password2]');
      $this->form_validation->set_rules('password2', 'Password Confirmation', 'required');
      $this->form_validation->set_rules('e_mail', 'e_mail', 'trim|required|valid_email|is_unique[users.e_mail]');
      $this->form_validation->set_rules('start_date', 'start_date', 'trim|required');
      $this->form_validation->set_rules('end_date', 'end_date', 'trim|required');
      $this->form_validation->set_rules('position', 'position', 'trim|required');
      $this->form_validation->set_rules('log_start', 'log_start', 'trim|required');
      $this->form_validation->set_rules('log_end', 'log_end', 'trim|required');
      $this->form_validation->set_rules('mobile', 'mobile', 'trim|required|is_unique[users.mobile]');
      if ($this->form_validation->run())
            {
          // save data 
                  //if the insert has returned true then we show the flash message
                  if (strlen($_FILES['img']['name'])) {
                    $image = $this->m_image->do_upload('img');
                    $store['img'] = $image['file_name'];
                  } 
                  $store['created_date']=date('Y-m-d');
                  //if the insert has returned true then we show the flash message
                  $store['created_by'] = $this->session->login_data->user_name;
                  $store['status']=(!empty($store['status']))?1:0;
                  unset($store['password2']);
                  $store['password'] = md5(md5(sha1($this->input->post('password'))));
                if( $this->users_model->add($store) ){
                    $this->session->set_flashdata('message',show_message('new account have been created with success'));
                  // redirect('admin/members/');
                }else{
                  $this->session->set_flashdata('message',show_message('no','danger'));
                  // redirect('admin/members/');
                }
            }else{
            $this->session->set_flashdata('message', show_message(validation_errors(),'danger'));
                  redirect('admin/members/add');
            }
    }
    $data['roles']=$this->role_model->get_by();
    $data['main_content'] = 'admin/member/add';
    $this->load->view('admin/blank',$data);
  }
    public function get_all()
    {
      $this->load->library('Datatable', array('model' => 'm_deals'));
      $json = $this->datatable->datatableJson();
      $this->output->set_header("Pragma: no-cache");
      $this->output->set_header("Cache-Control: no-store, no-cache");
      $this->output->set_content_type('application/json') -> set_output(json_encode($json));
    }
  
  public function edit($uid=null)
    {
    $data['roles']=$this->role_model->get_by();
    $data['title'] = lang('users');
      $id = (empty($uid))?$this->uri->segment(4):$uid;
          $data['view'] = current($this->users_model->get_by('user_id',$id));
           $data['message'] = null;
      if ($this->input->server('REQUEST_METHOD') === 'POST')
          {
        $store = $this->input->post();
        $this->form_validation->set_rules('user_name', 'user_name', 'trim|required');
        $this->form_validation->set_rules('e_mail', 'e_mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('start_date', 'start_date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'end_date', 'trim|required');
        $this->form_validation->set_rules('position', 'position', 'trim|required');
        $this->form_validation->set_rules('log_start', 'log_start', 'trim|required');
        $this->form_validation->set_rules('log_end', 'log_end', 'trim|required');
        $this->form_validation->set_rules('mobile', 'mobile', 'trim|required');
        if ($this->form_validation->run())
              {
            // save data 
                if (strlen($_FILES['img']['name'])) {
                $image = $this->m_image->do_upload('img');
                $store['img'] = $image['file_name'];
                } 
                  //if the insert has returned true then we show the flash message
                  if(!$this->input->post('password') == ''){
                    $store['password'] = md5(md5(sha1($this->input->post('password'))));
                  }else{
                    unset($store['password']);
                  }
                  unset($store['password2']);
                  $store['status']=(!empty($store['status']))?1:0;
                  if( $this->users_model->update($id,$store) ){
                      $this->session->set_flashdata('message', show_message('edit on have been done with success'));
                      // var_dump($this->input->post());
                        redirect('admin/members');
                  }else{
                      $this->session->set_flashdata('message', show_message('database error please call developer','danger'));
                      redirect('admin/members/edit/'.$id);
                    }
              }else{
                      $this->session->set_flashdata('message', show_message(validation_errors(),'danger'));
                      redirect('admin/members/edit/'.$id);
                        }
    }
    $data['main_content'] = 'admin/member/edit';
    $this->load->view('admin/blank',$data);
  }

    public function delete()
  {
    $id = (int)$this->uri->segment(4);
    if($id == 1){
      $this->session->set_flashdata('message',show_message('this is a super user you he can access every module in this area you can`t delete this account','danger'));
      redirect('admin/members');
    }
    $this->users_model->delete($id);
    $this->session->set_flashdata('message', show_message('Delete is Done!'));
      redirect('admin/members');
  }
    public function permissions()
    {
      $id = $this->uri->segment(4);
      if(empty($id))
      redirect('admin/members');
      $data['member']    =$member= current($this->users_model->get_by('user_id',$id));
      if(empty($member->role_id) || $member->role_id == 6 || $member->role_id == 1){
        $this->session->set_flashdata('message',show_message('this is a super user you he can access every module in this area you can`t limit his permission','danger'));
        redirect('admin/members');
      }
      $post_name = $this->input->post('name');
      if ($this->input->server('REQUEST_METHOD') === 'POST')
      $this->perm->Permission_add($id,$this->input->post('name'),$this->perm->getRolePermissions($member->role_id));
      $data['permissions'] = $this->perm->Permission_index();
      $allowed=$this->perm->allowed($member->user_name);
      if ($allowed) {
        $data['allowed'] = $this->perm->allowed($member->user_name);
        // var_dump($data['allowed']);
        $data['saved'] = "This permissions is the saved permissions for ".$member->full_name;
        $data['color'] = "success";
      }else{
        $data['allowed']   = $this->perm->allowedRolls($member->role_id);
        $data['saved'] = "This permissions is the defult permissions for this gruop please save it to make this user Active ";
        $data['color'] = "danger";
      }
      $data['main_content'] = 'admin/users/permission';
      $this->load->view('admin/blank',$data);
    } 
}