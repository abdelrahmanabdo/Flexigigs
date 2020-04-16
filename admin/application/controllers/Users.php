<?php 
class Users extends CI_Controller{
    public function __construct() 
    {
        parent::__construct();
        $this->load->library('table');
        $this->load->model('permission_model');
        $this->load->model('member_model');
        $this->load->database();
    }

    public function index()
    {
        $this->form_validation->set_rules('user_name', 'User Name', 'required');
        // $this->form_validation->set_rules('password', 'Password', 'required' );
        $data['message'] = Null;
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            if ($this->form_validation->run())
            {
                $username = $this->input->post('user_name');
                // $password = $this->input->post('password');
                if($this->permission_model->do_login($username))
                {
                    // if ($this->session->login_data->role_id == 1 || $this->session->login_data->role_id == 6) {
                        redirect('creator');
                 /*   }else{
                        if (date("Y-m-d H:i:s")>=get_this('users',array('user_id'=>$this->session->login_data->user_id),'start_date') && date("Y-m-d H:i:s")<=get_this('users',array('user_id'=>$this->session->login_data->user_id),'end_date') && $this->session->login_data->status == 1 && date("H:i")>=get_this('users',array('user_id'=>$this->session->login_data->user_id),'log_start') && date("H:i")<=get_this('users',array('user_id'=>$this->session->login_data->user_id),'log_end')) {
                            redirect('admin/dashboard/sales');
                        }else{
                            $this->session->sess_destroy();
                            $this->session->set_flashdata('message',show_message2('You can`t access the system now', 'danger'));
                            redirect('users');
                        }
                    }*/
                }else{
                    $this->session->set_flashdata('message',show_message2('خطأ فى الأسم / كلمة المرور ', 'danger'));
                    redirect('users');
                }
            }else{
                $this->session->set_flashdata('message',show_message2(validation_errors(), 'danger'));
                    redirect('users');
            }
        }
        if ($this->session->has_userdata('login_data')) {
            if ($this->session->login_data->role_id == 1 || $this->session->login_data->role_id == 6|| $this->session->login_data->role_id == 2) {
                redirect('creator/modules');
            }else{
                redirect('admin/dashboard/sales');
            }
        }
        $this->load->view('admin/login',$data);
    }

    public function create()
    {

    }

    public function forget()
    {
        $this->form_validation->set_rules('e_mail', 'Email', 'required|valid_email');
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            if ($this->form_validation->run())
            {
                $email = $this->input->post('e_mail');
                $member_data = current($this->users_model->get_by('e_mail',$email));
                if(!empty($member_data)){
                    $new_pass = generate_password(10);
                    $this->users_model->update($member_data->user_id,array('password'=>$new_pass));
                    $this->email->from('info@nilemm.net', 'Nile Multimedia');
                    $this->email->to($member_data->e_mail);
                    $this->email->subject('password changes');
                    $this->email->message('hay '.$member_data->user_name.'We have changed your password the new one is : '.$new_pass);  

                    $this->email->send();
                    $this->session->set_flashdata('message',show_message2('hay '.$member_data->user_name.'we have sent an Email to you chick your mail to get your new password .'));
                    redirect('users');
                }else{
                    $this->session->set_flashdata('message',show_message2('There is no account uses this Email', 'danger'));
                    redirect('users');
                }
            }else{
                $this->session->set_flashdata('message',show_message2(validation_errors(), 'danger'));
                    redirect('users');
            }
        }
        $this->load->view('admin/login',$data);
    }

    function logout() 
    {
        $this->session->sess_destroy();
        redirect('users');
    }
}