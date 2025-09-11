<?php
/**
 * User Authentication
 *
 * @author      Orif (ViDi,HeMa,MoDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace User\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use User\Models\User_model;
use User\Models\User_type_model;
use CodeIgniter\Email\Email;
use CodeIgniter\HTTP\Response;
use Config\UserConfig;

class Auth extends BaseController {

    /**
     * Constructor
     */
    
    public function initController(RequestInterface $request,
        ResponseInterface $response, LoggerInterface $logger): void
    {
        // Set Access level before calling parent constructor
        // Accessibility for all users to let visitors have access to authentication
        $this->access_level = "*";
        parent::initController($request, $response, $logger);
        
        // Load required helpers
        helper('form');

        // Load required services
        $this->validation = \Config\Services::validation();

        // Load required models
        $this->user_model = new User_model();

        $this->db = \Config\Database::connect();
        
    }

    private function errorhandler(?string $message=null): string
    {
        $data['Exception'] = $message;
        $data['title'] = 'Azure error';
        return $this->display_view('\User\errors\azureErrors', $data);
    }

    public function processMailForm() {

        // Check if the user verification code is empty
        // If empty: send code by mail
        if (!isset($_POST['user_verification_code'])) {

            $_SESSION['form_email'] = $this->request->getPost('user_email');

            $ci_user = $this->user_model->where('email', $_SESSION['form_email'])->first();

            if (isset($ci_user['email']) && !empty($ci_user['email'])) {
                $_SESSION['new_user'] = false;
            } else {
                $_SESSION['new_user'] = true;
            }
            // In both cases, send verification code and redirect to verification code form view

            $_SESSION['verification_attempts'] = 3;

            // Set verification attempts and send verification code
            $_SESSION['verification_code'] = $this->sendVerificationMail($_SESSION['form_email']);
            
            $output = array(
                'title' => lang('user_lang.title_email_validation'),
            );

            return $this->display_view('\User\auth\verification_code_form', $output);
        }
    
        // User verification code is not empty
        $user_verification_code = $this->request->getPost('user_verification_code');
    
        if ($user_verification_code == $_SESSION['verification_code']) {

            if ($_SESSION['new_user'] == true)  {

                // A new user needs to be created in the db
                
                // Receive array $user from createNewUser()
                $new_user = $this->createNewUser();
                
                // insert this new user
                $this->user_model->insert($new_user);

            } else {

                // User already in DB => Update azure_mail in DB
                
                $ci_user = $this->user_model->where('email', $_SESSION['form_email'])->first();
                
                // Verification code matches
                $_SESSION['user_access'] = (int)$this->user_model->get_access_level($ci_user);
                $_SESSION['user_id'] = (int)$ci_user['id'];
                $_SESSION['username'] = $ci_user['username'];
    
                $data = [
                    'azure_mail' => $_SESSION['azure_mail']
                ];
                
                $this->user_model->update($ci_user['id'], $data);
            }

        } else {
            // Verification code does not match
            $_SESSION['verification_attempts'] -= 1;
    
            if ($_SESSION['verification_attempts'] <= 0) {
                // No more attempts, keep default user access
            } else {
                $output = array(
                    'title' => lang('user_lang.title_email_validation'),
                    'errorMsg' => lang('user_lang.msg_err_validation_code'),
                    'attemptsLeft' => $_SESSION['verification_attempts'],
                    'msg_attemptsLeft' => lang('user_lang.msg_err_attempts') . ' ' . $_SESSION['verification_attempts'],
                );
    
                return $this->display_view('\User\auth\verification_code_form', $output);
            }
        }
    
        // Reset session variables
        $_SESSION['new_user'] = null;
        $_SESSION['form_email'] = null;
        $_SESSION['azure_mail'] = null;
        $_SESSION['verification_attempts'] = null;
        $_SESSION['verification_code'] = null;
    
        // Send the user to the redirection URL
        return redirect()->to($_SESSION['after_login_redirect']);
    }

    public function sendVerificationMail($form_email) { // gen code and send mail

        // Random code generator
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $verification_code = '';

        for ($i =0; $i < 6; $i++) {
            $verification_code .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // setup
        $email = \Config\Services::email();
                
        $emailConfig = [
            'protocol' => getenv('PROTOCOL'),
            'SMTPHost' => getenv('SMTP_HOST'),
            'SMTPUser' => getenv('SMTP_ID'),
            'SMTPPass' => getenv('SMTP_PASSWORD'),
            'SMTPPort' => getenv('SMTP_PORT'),
        ];

        $email->initialize($emailConfig);

        // Sending code to user's  mail
        $email->setFrom('smtp@sectioninformatique.ch', 'packbase'); 
        $email->setTo($form_email);
        $email->setSubject('Code de vérification');
        $email->setMessage('Voici votre code de vérification: '.$verification_code);
        
        $email->send();
        return $verification_code;
    }

    public function createNewUser() {
        
        $user_type_model = new User_type_model();
        $user_config = config('\User\Config\UserConfig');

        // Setting up default azure access level
        $default_access_level = $user_config->azure_default_access_lvl;
        $new_user_type =  $user_type_model->where("access_level = ".$default_access_level)->first();

        // Generating username
        $username_max_length = $user_config->username_max_length;
        $new_username = explode('@', $_SESSION['azure_mail']);
        $new_username = substr($new_username[0], 0, $username_max_length);

        // Generating a random password
        $password_max_lenght = $user_config->password_max_length;
        $new_password = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-={}[]|:;"<>,.?/~`';

        for ($i = 0; $i < $password_max_lenght; $i++) {
            $new_password .= $characters[rand(0, strlen($characters) - 1)];
        }

        $new_user = array(
            'fk_user_type'      => $new_user_type['id'],
            'username'          => $new_username,
            'password'          => $new_password,
            'password_confirm'  => $new_password,
            'email'             => $_SESSION['form_email'],
            'azure_mail'        => $_SESSION['azure_mail'],
        );
        
        return $new_user;
    }

    /**
     * Login user and create session variables
     *
     * @return void
     */
    public function azure_login(): string|Response
    {
        $client_id = getenv('CLIENT_ID');
        $client_secret = getenv('CLIENT_SECRET');
        $ad_tenant = getenv('TENANT_ID');
        $graphUserScopes = getenv('GRAPH_USER_SCOPES');
        $redirect_uri = getenv('REDIRECT_URI');
        
        // Authentication part begins
        if (!isset($_GET["code"]) and !isset($_GET["error"])) {
            
            // First stage of the authentication process
            $url = "https://login.microsoftonline.com/" . $ad_tenant . "/oauth2/v2.0/authorize?";
            $url .= "state=" . session_id();
            $url .= "&scope=" . $graphUserScopes;
            $url .= "&response_type=code";
            $url .= "&approval_prompt=auto";
            $url .= "&client_id=" . $client_id;
            $url .= "&redirect_uri=" . urlencode($redirect_uri);
            return redirect()->to($url); // Redirection to Microsoft's login page

        // Second stage of the authentication process
        } elseif (isset($_GET["error"])) {
            return $this->errorhandler();
        //Checking that the session_id matches to the state for security reasons
        } elseif (strcmp(session_id(), $_GET["state"]) == 0) {
            
            //Verifying the received tokens with Azure and finalizing the authentication part
            $content = "grant_type=authorization_code";
            $content .= "&client_id=" . $client_id;
            $content .= "&redirect_uri=" . urlencode($redirect_uri);
            $content .= "&code=" . $_GET["code"];
            $content .= "&client_secret=" . urlencode($client_secret);
            $options = array(
                "http" => array(  //Use "http" even if you send the request with https
                "method"  => "POST",
                "header"  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($content) . "\r\n",
                "content" => $content
                )
            );
            $context  = stream_context_create($options);

            // Special error handler to verify if "client secret" is still valid
            try {
                $json = file_get_contents("https://login.microsoftonline.com/" . $ad_tenant . "/oauth2/v2.0/token", false, $context);
            } catch (\Exception $e) {
                $data['title'] = 'Azure error';
                $data['Exception'] = $e;
                return $this->display_view('\User\errors\401error', $data);
            }

            if ($json === false){
                //Error received during Bearer token fetch
                return $this->errorhandler(
                    lang('user_lang.msg_err_azure_no_token').'.');
            }
            $authdata = json_decode($json, true);
            if (isset($authdata["error"])){
                //Bearer token fetch contained an error
                return $this->errorhandler();
            }
            
            //Fetching user information
            $options = array(
                "http" => array(  //Use "http" even if you send the request with https
                "method" => "GET",
                "header" => "Accept: application/json\r\n" .
                "Authorization: Bearer " . $authdata["access_token"] . "\r\n"
                )
            );
            $context = stream_context_create($options);
            $json = file_get_contents("https://graph.microsoft.com/v1.0/me", false, $context);
            if ($json === false) {
                // Error received during user data fetch.
                return $this->errorhandler(
                    lang('user_lang.msg_err_azure_no_token').'.');
            }

            $userdata = json_decode($json, true);

            if (isset($userdata["error"])) {
                // User data fetch contained an error.
                return $this->errorhandler();
            }

            // Setting up the session
            $_SESSION['logged_in'] = (bool)true;
            $_SESSION['azure_identification'] = (bool)true;

            // Mail correspondances

            // Definition of ci_user_azure
            $user_azure_mail = $userdata["mail"];
            $ci_user_azure = $this->user_model->where('azure_mail', $user_azure_mail)->first();

            // Seperate name and lastname from email for mail correspondances
            $nameAndLastname = strstr($user_azure_mail, '@', true); // True = before '@' and without '@'

            // Azure mail not found in DB
            if (empty($ci_user_azure)){

                $_SESSION['user_id'] = NULL;
                $_SESSION['username'] = $userdata['displayName'];
                $_SESSION['user_access'] = config("\User\Config\UserConfig")->azure_default_access_lvl;
                $_SESSION['azure_mail'] = $user_azure_mail;

                $correspondingUser = $this->user_model->where('email LIKE', $nameAndLastname . '%')->first();

                if ($correspondingUser == NULL){
                    $correspondingEmail = '';
                } else {
                    $correspondingEmail = $correspondingUser['email'];
                }

                $output = array(
                    'title' => lang('user_lang.title_page_login'),
                    'correspondingEmail' => $correspondingEmail,
                    'ci_user' => $ci_user_azure,
                    'userdata' => $userdata);
                    
                return $this->display_view('\User\auth\mail_form', $output); 
            
            // Azure mail found
            } else {
                $_SESSION['user_id'] = $ci_user_azure['id'];
                $_SESSION['username'] = $ci_user_azure['username'];
                $_SESSION['user_access'] = (int)$this->user_model->get_access_level($ci_user_azure);

                return redirect()->to($_SESSION['after_login_redirect']);
            }

        } else {
            // Returned states mismatch and no $_GET["error"] received.
            return $this->errorhandler(
                lang('user_lang.msg_err_azure_mismatch').'.');
        }
    }

    public function login(): string|Response
    {
        // If user is not already logged
        if(!(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)) {

            // Store the redirection URL in a session variable
            if (!is_null($this->request->getVar('after_login_redirect'))) {
                $_SESSION['after_login_redirect'] = $this->request->getVar('after_login_redirect');
            }
            // If no redirection URL is provided or the redirection URL is the
            // login form, redirect to site's root after login
            if (!isset($_SESSION['after_login_redirect'])
                    || $_SESSION['after_login_redirect'] == current_url()) {

                $_SESSION['after_login_redirect'] = base_url();
            }

            // Check if the form has been submitted, else check if Microsoft button submitted
            if (!is_null($this->request->getVar('btn_login'))) {

                // Define fields validation rules
                $validation_rules=[
                    'username'=>[
                    'label' => 'user_lang.field_username',
                    'rules' => 'trim|required|'
                        . 'min_length['.config("\User\Config\UserConfig")->username_min_length.']|'
                        . 'max_length['.config("\User\Config\UserConfig")->username_max_length.']'],
                    'password'=>[
                        'label' => 'user_lang.field_password',
                        'rules' => 'trim|required|'
                            . 'min_length['.config("\User\Config\UserConfig")->password_min_length.']|'
                            . 'max_length['.config("\User\Config\UserConfig")->password_max_length.']'
                    ]
                ];
                $this->validation->setRules($validation_rules);

                // Check fields validation rules
                if ($this->validation->withRequest($this->request)->run() == true) {
                    $input = $this->request->getVar('username');
                    $password = $this->request->getvar('password');
                    $ismail = $this->user_model->check_password_email($input, $password);
                    if ($ismail || $this->user_model->check_password_name($input, $password)) {
                        // Login success
                        $user = NULL;
                        // User is either logging in through an email or an username
                        // Even if an username is entered like an email, we're not grabbing it
                        if ($ismail) {
                            $user = $this->user_model->getWhere(['email'=>$input])->getRow();
                        } else {
                            $user = $this->user_model->getWhere(['username'=>$input])->getRow();
                        }
                
                        $_SESSION['user_id'] = (int)$user->id;
                        $_SESSION['username'] = (string)$user->username;
                        $_SESSION['user_access'] = (int)$this->user_model->get_access_level($user);
                        $_SESSION['logged_in'] = (bool)true;

                        // Send the user to the redirection URL
                        return redirect()->to($_SESSION['after_login_redirect']);

                    } else {
                        // Login failed
                        $this->session->setFlashdata('message-danger', lang('user_lang.msg_err_invalid_password'));
                    }
                    $this->session->setFlashdata('message-danger', lang('user_lang.msg_err_invalid_password'));
                }
            // Check if microsoft login button submitted, else, display login page
            } else if (!is_null($this->request->getPost('btn_login_microsoft'))) {
                return $this->azure_login();
            }
            //Display login page
            $output = array('title' => lang('user_lang.title_page_login'));
            return $this->display_view('\User\auth\login', $output);
        } else {
            return redirect()->to(base_url());
        }
    }
    
    /**
     * Logout and destroy session
     *
     * @return void
     */
    public function logout(): Response
    {
        // Restart session with empty parameters
        $_SESSION = [];
        session_reset();
        session_unset();

        return redirect()->to(base_url());
    }

    /**
     * Displays a form to let user change his password
     *
     * @return void
     */
    public function change_password(): Response|string 
    {
        // Check if access is allowed
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {

            // Get user from DB, redirect if user doesn't exist
            $user = $this->user_model->withDeleted()->find($_SESSION['user_id']);
            if (is_null($user)) return redirect()->to('/user/auth/login');

            // Empty errors message in output
            $output['errors'] = [];

            // Check if the form has been submitted, else just display the form
            if (!is_null($this->request->getVar('btn_change_password'))) {
                $old_password = $this->request->getVar('old_password');

                if($this->user_model->check_password_name($user['username'], $old_password)) {
                    $user['password'] = $this->request->getVar('new_password');
                    $user['password_confirm'] = $this->request->getVar('confirm_password');

                    $this->user_model->update($user['id'], $user);

                    if ($this->user_model->errors()==null) {
                        // No error happened, redirect
                        return redirect()->to(base_url());
                    } else {
                        // Display error messages
                        $output['errors'] = $this->user_model->errors();
                    }

                } else {
                    // Old password error
                    $output['errors'][] = lang('user_lang.msg_err_invalid_old_password');
                }
            }

            // Display the password change form
            $output['title'] = lang('user_lang.page_my_password_change');
            return $this->display_view('\User\auth\change_password', $output);

        } else {
            // Access is not allowed
            return redirect()->to('/user/auth/login');
        }
    }
}
