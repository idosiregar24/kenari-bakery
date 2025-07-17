<?php
class Auth_model extends CI_Model
{
    public function register($data)
    {
        return $this->db->insert('pengguna', $data);
    }

    public function get_user_by_username($username)
    {
        return $this->db->get_where('pengguna', ['username' => $username])->row_array();
    }

    public function get_user_by_id($id_user)
{
    return $this->db->get_where('pengguna', ['id_user' => $id_user])->row_array();
}
}