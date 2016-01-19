<?php

/**
 * Created by PhpStorm.
 * User: MoJe
 * Date: 15.12.2015
 * Time: 09:43
 */
class Authentification_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function login($username, $password)
    {
        $this->db->select('id, username, password');
        $this->db->from('users');
        $this->db->where('username', $username);
        $this->db->where('password', MD5($password));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->num_rows() == 1 ? $query->result() : false;
    }

    function logged_in()
    {
        return (bool)$this->session->userdata('logged_in');
    }

    public function logout()
    {
        $this->session->sess_destroy();
    }

}