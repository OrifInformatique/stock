<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Authentication
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 * @version     2.0
 */
class Auth extends MY_Controller {
    /**
     * Constructor
     */
    public function __construct()
    {
        /* Define controller access level */
        $this->access_level = '*';

        parent::__construct();

        // Load required items
        $this->load->library('form_validation')->model('user_model');

        // Assign form_validation CI instance to this
        $this->form_validation->CI =& $this;
    }

    /**
     * Login user and create session variables
     *
     * @return void
     */
    public function login()
    {
        // If user already logged
        if(!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)) {
            // Store the redirection URL in a session variable
            if (!is_null($this->input->post('after_login_redirect'))) {
                $_SESSION['after_login_redirect'] = $this->input->post('after_login_redirect');
            }
            // If no redirection URL is provided or the redirection URL is the
            // login form, redirect to site's root after login
            if (!isset($_SESSION['after_login_redirect'])
                    || $_SESSION['after_login_redirect'] == current_url()) {

                $_SESSION['after_login_redirect'] = base_url();
            }

            // Check if the form has been submitted, else just display the form
            if (!is_null($this->input->post('btn_login'))) {
                // Define fields validation rules
                $validation_rules = array(
                    array(
                        'field' => 'username',
                        'label' => 'lang:field_username',
                        'rules' => 'trim|required|'
                                 . 'min_length['.$this->config->item('username_min_length').']|'
                                 . 'max_length['.$this->config->item('username_max_length').']'
                    ),
                    array(
                        'field' => 'password',
                        'label' => 'lang:field_password',
                        'rules' => 'trim|required|'
                                 . 'min_length['.$this->config->item('password_min_length').']|'
                                 . 'max_length['.$this->config->item('password_max_length').']'
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
                        $_SESSION['user_id'] = (int)$user->id;
                        $_SESSION['username'] = (string)$user->username;
                        $_SESSION['user_access'] = (int)$user->user_type->access_level;
                        $_SESSION['logged_in'] = (bool)true;

                        // Send the user to the redirection URL
                        redirect($_SESSION['after_login_redirect']);

                    } else {
                        // Login failed
                        $this->session->set_flashdata('message-danger', lang('msg_err_invalid_password'));
                    }
                }
            }

            // Display login page
            $output = array('title' => lang('title_page_login'));
            $this->display_view('user/auth/login', $output);
        } else {
            redirect(base_url());
        }
    }

    /**
     * Logout and destroy session
     *
     * @return void
     */
    public function logout()
    {
        // Restart session with empty parameters
        $_SESSION = [];
        session_reset();
        session_unset();

        redirect(base_url());
    }

    /**
     * Displays a form to let user change his password
     *
     * @return void
     */
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
                                 . 'min_length['.$this->config->item('password_min_length').']|'
                                 . 'max_length['.$this->config->item('password_max_length').']|'
                                 . 'callback_cb_old_password_check['.$username.']',
                        'errors' => array(
                            'cb_old_password_check' => lang('msg_err_invalid_old_password')
                        )
                    ),
                    array(
                        'field' => 'new_password',
                        'label' => 'lang:field_new_password',
                        'rules' => 'trim|required|'
                                 . 'min_length['.$this->config->item('password_min_length').']|'
                                 . 'max_length['.$this->config->item('password_max_length').']'
                    ),
                    array(
                        'field' => 'confirm_password',
                        'label' => 'lang:field_password_confirm',
                        'rules' => 'trim|required|'
                                 . 'min_length['.$this->config->item('password_min_length').']|'
                                 . 'max_length['.$this->config->item('password_max_length').']|'
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
                    $this->user_model->update($_SESSION['user_id'],
                            array("password" => password_hash($new_password, $this->config->item('password_hash_algorithm'))));

                    // Send the user back to the site's root
                    redirect(base_url());
                }
            }

            // Display the password change form
            $output['title'] = $this->lang->line('page_password_change');
            $this->display_view('user/auth/change_password', $output);
        } else {
            // Access is not allowed
            $this->login();
        }
    }

    /**
     * Callback method for change_password validation rule
     *
     * @param string $pwd = The previous password
     * @param string $user = The username
     * @return boolean = Whether or not the combination is correct
     */
    public function cb_old_password_check($pwd, $user)
    {
        return $this->user_model->check_password($user, $pwd);
    }
}
