<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication System
 *
 * @author      Jeffrey Mostroso
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */
class Admin extends MY_Controller
{
    /* MY_Controller variables definition */
    protected $access_level = "8";


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();


        $this->load->model('user_type_model');
        $this->load->library('form_validation');
    }

    /**
    * Menu for admin privileges
    */
    public function index()
    {
      $this->display_view("admin/menu");
    }

    /**
    * As the name says, view the users.
    */
    public function view_users()
    {
      $this->load->model('user_model');
      $output["users"] = $this->user_model->with("user_type")
                                          ->get_all();

      $this->display_view("admin/users/list", $output);
    }
}
