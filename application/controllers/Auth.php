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
        // Store the redirection URL in a session variable
        if (!is_null($this->input->post('after_login_redirect'))) {
            $_SESSION['after_login_redirect'] = $this->input->post('after_login_redirect');
        }

        // Check if the form has been submitted, else just display the form
        if (!is_null($this->input->post('btn_login'))) {
            // Define fields validation rules
            $validation_rules = array(
                array(
                    'field' => 'username',
                    'label' => 'lang:field_username',
                    'rules' => 'trim|required|'
                             . 'min_length['.USERNAME_MIN_LENGTH.']|'
                             . 'max_length['.USERNAME_MAX_LENGTH.']'
                ),
                array(
                    'field' => 'password',
                    'label' => 'lang:field_password',
                    'rules' => 'trim|required|'
                             . 'min_length['.PASSWORD_MIN_LENGTH.']|'
                             . 'max_length['.PASSWORD_MAX_LENGTH.']'
                )
            );
            $this->form_validation->set_rules($validation_rules);
            
            // Check fields validation rules
            if ($this->form_validation->run() == true) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

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
                    if (isset($_SESSION['after_login_redirect'])
                        && $_SESSION['after_login_redirect'] != current_url()) {
                        redirect($_SESSION['after_login_redirect']);
                    } else {
                        redirect(base_url());
                    }
                } else {
                    // Login failed
                    $this->session->set_flashdata('message-danger', lang('msg_err_invalid_password'));
                }
            }
        }
        
        // Display login page
        $this->display_view('auth/login_form');
    }

    /**
     * Logout and destroy session
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect(base_url());
    }
    
    public function change_password()
    {
        // Check if access is allowed
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            
            // Check if the form has been submitted, else just display the form
            if (!is_null($this->input->post('btn_change_password'))) {
                $username = $_SESSION["username"];
                
                // Define fields validation rules
                $validation_rules = array(
                    array(
                        'field' => 'old_password',
                        'label' => 'lang:field_old_password',
                        'rules' => 'trim|required|'
                                 . 'min_length['.PASSWORD_MIN_LENGTH.']|'
                                 . 'max_length['.PASSWORD_MAX_LENGTH.']|'
                                 . 'callback_old_password_check['.$username.']',
                        'errors' => array(
                            'old_password_check' => lang('msg_err_invalid_old_password')
                        )
                    ),
                    array(
                        'field' => 'new_password',
                        'label' => 'lang:field_new_password',
                        'rules' => 'trim|required|'
                                 . 'min_length['.PASSWORD_MIN_LENGTH.']|'
                                 . 'max_length['.PASSWORD_MAX_LENGTH.']'
                    ),
                    array(
                        'field' => 'confirm_password',
                        'label' => 'lang:field_password_confirm',
                        'rules' => 'trim|required|'
                                 . 'min_length['.PASSWORD_MIN_LENGTH.']|'
                                 . 'max_length['.PASSWORD_MAX_LENGTH.']|'
                                 . 'matches[new_password]'
                    )
                );
                $this->form_validation->set_rules($validation_rules);

                // Check fields validation rules
                if ($this->form_validation->run() == true) {
                    $old_password = $this->input->post('old_password');
                    $new_password = $this->input->post('new_password');
                    $confirm_password = $this->input->post('confirm_password');
                
                    $this->load->model('user_model');
                    $this->user_model->update($_SESSION['user_id'], array("password" => password_hash($new_password, PASSWORD_DEFAULT)));

                    // Send the user back to the site's root
                    redirect(base_url());
                }
            }
            
            // Display the password change form
            $this->display_view('auth/password_change_form');
            
        } else {
            // Access is not allowed
            $this->ask_for_login();
        }
    }
    
    // Callback method for change_password validation rule
    public function old_password_check($pwd,$user){
        return $this->user_model->check_password($user, $pwd);
    }
}