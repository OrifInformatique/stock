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
    protected $access_level = "*";

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The Controller's index, redirect to get_picture
     */
    public function index(){
        $this->get_picture();
        $this->load->library('form_validation');
    }
    
    /**
     * Show the image selection and cropping view
     * 
     * @return void
     */
    public function get_picture(){
        
        $this->display_view("item/select_photo");
    }
    
    /**
     * Redirect to the previous page with the cropped image's data
     * 
     * @return void
     */
    public function add_picture(){
        
        if(isset($_POST) && !empty($_POST['original_file']) && !empty($_POST['cropped_file'])){
            $this->set_validation_rules();
            
            if($this->form_validation->run()){
                
                $_SESSION['picture_path'] = $_POST['cropped_file'];
                $_SESSION['picture_name'] = $_POST['original_file'];
                
                redirect($_SESSION['picture_callback']);
                exit();
                
            }else{
                $data['upload_error'] = $lang->lang->line('msg_err_photo_upload');
                
                $this->load->view('item/select_photo', $data);
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
    }
}