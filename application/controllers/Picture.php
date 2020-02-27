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
            
            if(!empty($_POST)){
                
                $extension = "";
                
                if(!empty($_FILES['original_file']['type'])){
                    $extension = $_FILES['original_file']['type'];
                }else if(isset($_SESSION['POST']['image'])){
                    $extension = "image/". substr($_SESSION['POST']['image'], strrpos($_SESSION['POST']['image'], '.') + 1);
                }
                
                $file_type_is_correct = (strpos($extension, "image/") !== false && !empty($extension));
                if($file_type_is_correct){
                    $picture_file = $_POST['cropped_file'];
                    $picture_name = $_SESSION['item_id']."_picture_tmp".IMAGE_EXTENSION;
                    file_put_contents("uploads/images/$picture_name", base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $picture_file)));
                    $_SESSION['picture_path'] = $picture_name;
                    redirect($_SESSION['picture_callback']);
                    exit();
                }else{
                    $error = "";
                    if(! $file_type_is_correct){
                        $error = 1;
                    }
                    redirect(base_url("picture/get_picture/$error"));
                    //redirect(base_url("picture/get_picture"));
                    exit();
                }
            }
            
        }else{
            redirect(base_url());
            exit();
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