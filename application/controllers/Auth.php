<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication System
 *
 * @author      Orif, section informatique (ViDi)
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c), Orif <http://www.orif.ch>
 * @version     2.0
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
    public function login ()
    {
        if (!is_null($this->input->post('after_login_redirect'))) {
            // Store the redirection URL in a session variable
            $_SESSION['after_login_redirect'] = $this->input->post('after_login_redirect');
        } 

        if (!is_null($this->input->post('btn_login'))) {
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

                    // Send the user to the redirection URL or to the site's root
                    if (isset($_SESSION['after_login_redirect'])) {
                        redirect($_SESSION['after_login_redirect']);
                    } else {
                        redirect(base_url());
                    }
                } else {
                    // Login failed
                    $this->session->set_flashdata('message-danger', $this->lang->line('msg_err_invalid_password'));
                }
            }
        }
        
        // Display login page
        $this->display_view('auth/login_form');
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
    
    public function change_password(){
        
        // Check if this is allowed
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            $username = $_SESSION["username"];
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            // Keeping in memory the last page in user's history so we can redirect there later
            if(isset($_SERVER["HTTP_REFERER"])) {
                if($_SERVER["HTTP_REFERER"] != current_url()){
                    $_SESSION["before_login_page"] = $_SERVER["HTTP_REFERER"];
                }
            } else {
                $_SESSION["before_login_page"] = base_url();
            }
            // Recovering the last page in user's history so we can redirect there after login
            $redirect_url = $_SESSION["before_login_page"];

            $this->form_validation->set_rules('old_password', 'lang:field_old_password', 'trim|required|min_length[6]|max_length[72]|callback_old_password_check['.$_SESSION['username'].']', array('old_password_check' => $this->lang->line('msg_err_invalid_old_password')));
            $this->form_validation->set_rules('new_password', 'lang:field_new_password', 'trim|required|min_length[6]|max_length[72]');
            $this->form_validation->set_rules('confirm_password', 'lang:field_password_confirm', 'trim|required|min_length[6]|max_length[72]|matches[new_password]');
            
            if ($this->form_validation->run() == true) {
                
                $this->load->model('user_model');
                $this->user_model->update($_SESSION['user_id'], array("password" => password_hash($new_password, PASSWORD_DEFAULT)));

                // Send the user back to his last page
                redirect($redirect_url);
                exit();
            }

            // Displaying the form
            $this->display_view('auth/password_change_form');
        } else {
            // Access is not allowed
            $this->ask_for_login();
        }
    }
    
    public function old_password_check($pwd,$user){
        if($this->user_model->check_password($user, $pwd)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}