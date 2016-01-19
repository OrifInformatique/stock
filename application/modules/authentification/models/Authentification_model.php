<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: MoJe
 * Date: 15.12.2015
 * Time: 09:43
 */
class Authentification_model extends CI_Model
{
    public $username;
    public $password;
    private $_table = "users";
    private $_data = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function validate()
    {
        $this->username = $this->input->post('username');
        $this->password = $this->input->post('password');

        $this->db->where("username", $this->username);
        $query = $this->db->get($this->_table);

        if ($query->num_rows()) {
            $row = $query->row_array();
            if (password_verify($this->password, $row['password'])) {
                unset($row['password']);
                $this->_data = $row;
                return ERR_NONE;
            }
            return ERR_INVALID_PASSWORD;
        } else {
            return ERR_INVALID_USERNAME;
        }

    }

    public function get_data()
    {
        return $this->set_session();
    }

    function set_session()
    {

    }


}