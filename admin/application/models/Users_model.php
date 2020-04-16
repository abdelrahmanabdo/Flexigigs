<?php
class users_model extends CI_Model
{
    public $table = 'users';

    public function __construct() 
    {
        parent::__construct();
    }

    public function get_user_type() 
    {
     return $this->db->get_where($this->table,  array('type=>editor'));
    }

    public function login($user_name,$password)
    {
        if (!empty($user_name)&&!empty($password))
        {
          return $this->db->get_where($this->table,array("user_name"=> $user_name,"password"=> $password));
        }
    }

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_by($value,$key)
    {
        if(!empty($value)&& !empty($key))
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where($value,$key);
            $q= $this->db->get();
            return $q->result();
    }

    public function super_get_by($value,$key)
    {
        if(!empty($value)&& !empty($key))
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where_in($value,$key);
            $q= $this->db->get();
            return $q->result();
    }

    public function update($id =NULL, $data = NULL)
    {
        if(empty($id) || empty($data))
            return False;
        $this->db->where('user_id', $id);
        return $this->db->update($this->table, $data);
    }

    public function add($data)
    {
        if($this->db->insert($this->table, $data))
        {
            return true;
        }
           return false;
    }

    public function delete($id = NULL)
    {
        if (empty($id))
            return FALSE;
        $this->db->where_in('user_id', $id);
        return $this->db->delete($this->table);
    }
}