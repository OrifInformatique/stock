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
        $this->load->model('item_model');
        $this->load->model('loan_model');
        $this->load->helper('sort');
    }

    /**
     * The Controller's index, redirect to get_picture
     */
    public function index(){
        $this->get_picture();
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
        
    }
}