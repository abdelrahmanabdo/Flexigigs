<?php
class member_model extends CI_Model
{

    public function insert_member($table)
    {
        $this->db->insert($table,$this->input->post());
    }

    public function get_all($table)
    {
        return $this->db->get($table)->result();
    }
}
