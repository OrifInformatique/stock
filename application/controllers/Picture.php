<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * A controller to display and manage items
 *
 * @author      Tombez Rémy
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2019, Orif <http://www.orif.ch>
 */
class Picture extends MY_Controller {

    
    /* MY_Controller variables definition */
    protected $access_level = "@";

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    /**
     * Show the image selection and cropping view
     * 
     * @return void
     */
    public function get_picture($errorId = 0){
        
        $data = array();
        
        if($errorId == 1){
            $data['upload_error'] = $this->lang->line('msg_err_photo_upload');
        }
        
        $this->display_view("item/select_photo", $data);
    }
    
    /**
     * Redirect to the previous page with the cropped image's data
     * 
     * @return void
     */
    public function add_picture(){
        
        if(isset($_POST)){
            $this->set_validation_rules();
            
            if($this->form_validation->run()){
                
                $_SESSION['picture_path'] = $_POST['cropped_file'];
                $_SESSION['picture_name'] = $_POST['original_file'];
                redirect($_SESSION['picture_callback']);
                exit();
                
            }else{
                redirect(base_url('picture/get_picture/1'));
                exit();
            }
            
        }else{
            redirect(base_url());
            exit();
        }
    }
    
    /**
     * Check if there is a named file send
     * 
     * @return void
     */
    private function set_validation_rules(){
        $config = array(
            array(
                'field' => 'original_file',
                'label' => $this->lang->line('field_full_photo'),
                'rules' => 'required'
            ),
            array(
                'field' => 'cropped_file',
                'label' => $this->lang->line('field_cropped_photo'),
                'rules' => 'required'
            )
        );
        
        $this->form_validation->set_rules($config);
    }
}