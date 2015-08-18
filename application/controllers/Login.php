<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ********************************************************************************************
 * Login : Authentification controller
 *
 *
 *
 *********************************************************************************************/

class Login extends CI_Controller{
    
    function __construct(){
        parent::__construct();
    }
    
    /* *** Base *** */
    
    public function index($msg = NULL){

    	// If a message has to be passed to the view
        $data['msg'] = $msg;
        $this->load->view('login_view', $data);
    }
    
    /* *** Test credentials *** */
    
    public function process(){
        // Load the model
        $this->load->model('login_model');
        // Validate the user can login
        $result = $this->login_model->validate();
        // Now we verify the result
        if(! $result){
            // If user did not validate, then show them login page again
            $msg = '<font color=red>Nom d\'utilisateur ou mot de passe incorrect</font><br />';
            $this->index($msg);
        }else{
            // If user did validate, 
            // Send them to members area
            redirect('item');
        }        
    }
    
    /* *** Logout *** */
    
    public function logout(){

    	$this->load->model('login_model');
    	$result = $this->login_model->unset_session();
   		redirect('item');

    }
    
}

?>