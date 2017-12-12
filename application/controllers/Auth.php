<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication System
 *
 * @author      Jeffrey Mostroso
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */
class Auth extends MY_Controller
{
    /* MY_Controller variables definition */
    protected $access_level = "*";


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('user_type_model');
        $this->load->library('form_validation');
    }



    /**
     * Login and create session variables
     */
    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($this->form_validation->run() == true) {
            // Fields validation passed

            if ($this->user_model->check_password($username, $password)) {
                // Login success
                $user = $this->user_model->with('user_type')
                                         ->get_by('username', $username);

                // Set session variables
                $_SESSION['user_id'] = (int)$user->user_id;
                $_SESSION['username'] = (string)$user->username;
                $_SESSION['user_access'] = (int)$user->user_type->access_level;
                $_SESSION['logged_in'] = (bool)true;

                // Display item's list
                redirect('/item');

            } else {
                // Login failed
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">'.$this->lang->line('msg_err_invalid_password').'</div>');
            }
        }

        // Display login page
        $this->display_view('login_view');
    }

    /**
     * Logout and erase session variables
     */
    public function logout()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {

            // Erase session variables
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
        }
        
        redirect('/');
    }
}