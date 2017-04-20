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
      $this->load->model('user_type_model');
      $output["users"] = $this->user_model->with("user_type")
                                          ->get_all();

      $this->display_view("admin/users/list", $output);
    }

    /**
    * Modify a user
    */
    public function modify_user($id = NULL)
    {
      $this->load->model('user_model');
      $this->load->model('user_type_model');
      $output = get_object_vars($this->user_model->get($id));
      $output["users"] = $this->user_model->get_all();
      $output["user_types"] = $this->user_type_model->get_all();

      $this->display_view("admin/users/form", $output);
    }

    /**
    * Create a new user
    */
    public function new_user()
    {
      if (!empty(users)) {
        //username: unique and not void
        $this->form_validation->set_rules();

        //Password: 6 chars or more
        $this->form_validation->set_rules();

        if($this->form_validation->run() === TRUE)
        {
          redirect("/admin/view_users/");
          exit();
        } else {
          $this->load->model('user_type_model');
          $output["user_types"] = $this->user_type_model->get_all();
        }
      }

      $this->display_view("admin/users/form", $output);
    }

    /**
    * As the name says, view the tags.
    */
    public function view_tags()
    {
      $this->load->model('item_tag_model');
      $output["tags"] = $this->item_tag_model->get_all();

      $this->display_view("admin/tags/list", $output);
    }

    /**
    * As the name says, view the stocking places.
    */
    public function view_stocking_places()
    {
      $this->load->model('stocking_place_model');
      $output["stocking_places"] = $this->stocking_place_model->get_all();

      $this->display_view("admin/stocking_places/list", $output);
    }

    /**
    * As the name says, view the suppliers.
    */
    public function view_suppliers()
    {
      $this->load->model('supplier_model');
      $output["suppliers"] = $this->supplier_model->get_all();

      $this->display_view("admin/suppliers/list", $output);
    }

    /**
    * As the name says, view the item groups.
    */
    public function view_item_groups()
    {
      $this->load->model('item_group_model');
      $output["item_groups"] = $this->item_group_model->get_all();

      $this->display_view("admin/item_groups/list", $output);
    }
}
