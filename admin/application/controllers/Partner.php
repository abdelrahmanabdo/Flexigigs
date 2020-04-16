<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

    public function index()
	{
		$this->load->view('admin/before_entry');
	}

    public function login($slug=null)
	{
		if ( $this->session->has_userdata('customer') )
           redirect('partner/customers/'.$this->session->customer->id);
		elseif( $this->session->has_userdata('investor') )
		redirect('partner/investor/'.$this->session->investor->id);

		$this->form_validation->set_rules('user','Username','trim|required|xss_clean');
		$this->form_validation->set_rules('pass','Password','trim|required|xss_clean');

		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			if ( $slug == 'customer') {
				$info=array( 'username'  =>$this->input->post('user',TRUE),
							 'password'  =>$this->input->post('pass'));
				$pass= md5(md5($info['password']));
				$person=$this->db->get_where('customers',['username'=>$info['username'],'password'=>$pass],1);  
					if ( $person->num_rows() == 1 )
					{
						$go = $person->row();
						unset($go->password);
						$this->session->set_userdata('customer',$go);
						redirect('partner/customers/'.$this->session->customer->id);
					}else{
						$this->session->set_flashdata('message',show_message2('خطأ فى الأسم / كلمة المرور ', 'danger'));
					}		
			}elseif($slug == 'investor'){
				$info=array( 'username'  =>$this->input->post('user',TRUE),
							 'password'  =>$this->input->post('pass'));
				$pass= md5(md5($info['password']));
				$person=$this->db->get_where('investor',['username'=>$info['username'],'password'=>$pass],1);  
					if ( $person->num_rows() == 1 )
					{
						$go = $person->row();
						unset($go->password);
						$this->session->set_userdata('investor',$go);
						redirect('partner/investor/'.$this->session->investor->id);
					}else{
						$this->session->set_flashdata('message',show_message2(' خطأ فى الأسم / كلمة المرور ', 'danger'));
					}	
			}else{
				show_404();
			}
		  }
				$this->load->view('admin/entry');

	}

	public function customers($id=null)
	{
		if ( !$this->session->has_userdata('customer') ) redirect('partner');
			$get_customer = get_table('customers',['id'=>$id]);
		if ( $id == $this->session->customer->id ){
			$data['total'] = get_this('contracts',['cust_id'=>$id]);
			$data['paid'] = $this->db->get_where('bonds',['customer_id'=>$id,'contract_id'=>$data['total']['id']])->num_rows();
		}else{
			show_404();
		}
			$data['main_content'] = 'admin/customers';
			$this->load->view('admin/blank_partner',$data);
	}

    public function investor($id=null)
	{
		if ( !$this->session->has_userdata('investor') ) redirect('partner');
		$get_investor = get_table('investor',['id'=>$id]);
		if ( $id == $this->session->investor->id ){
			$data['total'] = get_count_all('contracts','total',['invest_id'=>$id]);
			$data['invested'] = get_count_all('contracts','total',['invest_id'=>$id,'validity'=>1]);
			$contracts = get_table('contracts',['invest_id'=>$id,'validity'=>1]);
			$total_bonds = 0;
			if ($contracts) {
				foreach ($contracts as $contract) {
					$bonds = [];
					$bonds = get_table('bonds',['contract_id'=>$contract->id]);
					if ($bonds) {
						foreach ($bonds as $bond) {
							$total_bonds += $bond->cash_paid;
						}
					}
				}
			}
		$data['total_bonds'] = $total_bonds;
		}else{
			show_404();
		}
		$data['main_content'] = 'admin/investor';
		$this->load->view('admin/blank_partner',$data);
	}

//  public function forget()
//     {
//         $this->form_validation->set_rules('e_mail', 'Email', 'required|valid_email');
//         if ($this->input->server('REQUEST_METHOD') === 'POST')
//         {
//             if ($this->form_validation->run())
//             {
//                 $email = $this->input->post('e_mail');
//                 $member_data = current($this->users_model->get_by('e_mail',$email));
//                 if(!empty($member_data)){
//                     $new_pass = generate_password(10);
//                     $this->users_model->update($member_data->user_id,array('password'=>$new_pass));
//                     $this->email->from('info@nilemm.net', 'Nile Multimedia');
//                     $this->email->to($member_data->e_mail);
//                     $this->email->subject('password changes');
//                     $this->email->message('hay '.$member_data->user_name.'We have changed your password the new one is : '.$new_pass);  

//                     $this->email->send();
//                     $this->session->set_flashdata('message',show_message2('hay '.$member_data->user_name.'we have sent an Email to you chick your mail to get your new password .'));
//                     redirect('users');
//                 }else{
//                     $this->session->set_flashdata('message',show_message2('There is no account uses this Email', 'danger'));
//                     redirect('users');
//                 }
//             }else{
//                 $this->session->set_flashdata('message',show_message2(validation_errors(), 'danger'));
//                     redirect('users');
//             }
//         }
//         $this->load->view('admin/login',$data);
//     }

   public function logout()
    {
		$this->session->sess_destroy();
		redirect('partner');
    }
}