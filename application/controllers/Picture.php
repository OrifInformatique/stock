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
    protected $access_level = ACCESS_LVL_OBSERVATION;

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
        
        switch($errorId)
        {
            case 1:
                $data['upload_error'] = $this->lang->line('msg_err_photo_upload');
                break;
            case 0:
            default:
                break;
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
            if(!empty($_POST && $_POST['cropped_file'] != NULL)){
                $picture_file = $_POST['cropped_file'];
                $picture_name = $_SESSION['picture_prefix'].IMAGE_PICTURE_SUFFIX.IMAGE_TMP_SUFFIX.IMAGE_EXTENSION;
                file_put_contents(IMAGES_UPLOAD_PATH.$picture_name, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $picture_file)));
                redirect($_SESSION['picture_callback']);
            }else{
                redirect(base_url('picture/get_picture/1'));
            }
        }else{
            redirect(base_url());
        }
    }
    
    /**
     * Save previous url, then redirect to Picture/get_picture
     * 
     * @param string $url the origin url
     * @return void
     */
    public function select_picture(){
        $_SESSION['picture_callback'] = $_SERVER['HTTP_REFERER'];
        
        redirect(base_url('picture/get_picture'));
    }
}