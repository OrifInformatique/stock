<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    /**
     * '*' all user
     * '@' logged in user
     * 'Admin' for admin
     * 'Editor' for editor group
     * 'Author' for author group
     * @var string
     */
    protected $access = "*";

    public function __construct()
    {
        parent::__construct();
        $this->login_check();
    }

    public function login_check()
    {
        if ($this->access != "*") {
            if (!$this->permission_check()) {
                die("<h4>Access denied</h4>");
            }
            if (!$this->session->userdata("logged_in")) {
                redirect('authentification', 'refresh');
            }
        }
    }

    public function permission_check()
    {
        if ($this->access == "@") {
            return true;
        } else {
            $access = is_array($this->access) ? $this->access : explode(",", $this->access);
            if (in_array($this->session->userdata("role"), array_map("trim", $access))) {
                return true;
            }
            return false;
        }
    }

}