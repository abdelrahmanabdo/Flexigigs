<?php
class permission_model extends CI_Model
{
    public function getUserPermission($user_id,$mod_id) 
	{
        return $this->db->get_where('permission',array('user_id'=>$user_id,'mod_id'=>$mod_id));
    }

    public function do_login($username)
	{
		if(empty($username))
			return false;
		$whare = array(
					'username' => $username,
					// 'password' => md5(md5(sha1($password)))
				);
		$this->db->where($whare);
		$query = $this->db->get('users');
		$save = $query->first_row();
		unset($save->password);
		if( empty($save) )
			return FALSE;
		$this->session->set_userdata('login_data',$save);
		return true ;
	}
	
	public function update_login($username ,$user_id )
	{
		if(empty($username) || empty($user_id))
			return false;
		$whare = array(
					'user_name' => $username,
					'user_id' => $user_id
				);
		$this->db->where($whare);
		$query = $this->db->get('users');
		$save = $query->first_row();
		unset($save->password);
		if( empty($save) )
			return FALSE;
		$this->session->set_userdata('login_data',$save);
		return true ;
	}
}