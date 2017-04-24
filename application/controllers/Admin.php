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
      $output = get_object_vars($this->user_model->get($id))

      if (!empty($_POST)) {
        // VALIDATION

        //username: not void, unique
        $this->form_validation->set_rules('username', 'Identifiant', 'required', 'Un identifiant doit être fourni');
        $this->form_validation->set_rules('username', 'Identifiant', 'callback_unique_username');

        //firstname: not void
        $this->form_validation->set_rules('firstname', 'Prénom', 'required', 'Le prénom doit être indiqué');

        //lastname: not void
        $this->form_validation->set_rules('lastname', 'Nom', 'required', 'Le nom doit être indiqué');

        //email: void
        if (isset($_POST['email'])) {
          // or valid
          $this->form_validation->set_rules('email', 'Nom', 'valid_email', 'Entrez une adresse email valide ou aucune.');
        }

        // If the password needs to be modified,
        if (isset($_POST['pwd'])) {
          // it needs to be long 6 chars or more and confirmed
          $this->form_validation->set_rules('pwd', 'Mot de passe', 'min_length[6]', 'Le mot de passe doit faire au moins 6 caractères');
          $this->form_validation->set_rules('pwdagain', 'Mot de passe', 'matches[pwd]', 'Le mot de passe a été mal confirmé');
        }

        if($this->form_validation->run() === TRUE)
        {
          $userArray["is_active"] = 0;

          foreach($_POST as $forminput => $formoutput) {
            // Password needs to be hashed first, so it's not the same thing as the other
            if ($forminput != "pwd" && $forminput != "pwdagain" && $forminput != "is_active" && $forminput != "email") {
              $userArray[$forminput] = $formoutput;
            // Do the hash only once…
            } else if ($forminput == "pwd" && $formoutput != "") {
              $userArray["password"] = password_hash($formoutput, PASSWORD_DEFAULT);
            } else if ($forminput == "is_active" && $formoutput == "TRUE") {
              $userArray["is_active"] = 1;
            } else if ($forminput == "email") {
              if ($formoutput != "") {
                $userArray["email"] = $formoutput;
              }
            }
          }

          $this->load->model('user_model');
          $this->user_model->update($id, $userArray);

          redirect("/admin/view_users/");
          exit();
        }
      }

      $this->load->model('user_model');
      $this->load->model('user_type_model');
      $output = get_object_vars($this->user_model->get($id));
      $output["users"] = $this->user_model->get_all();
      $output["user_types"] = $this->user_type_model->get_all();

      $this->display_view("admin/users/form", $output);
    }

    public function unique_username($argUsername) {
      $this->load->model('user_model');

      // Get this user. If it fails, it doesn't exist, so the username is unique!
      $user = $this->user_model->get_by('username', $argUsername);
      
      if(isset($user->user_id)) {
        $this->form_validation->set_message('unique_username', 'Cet identifiant est déjà utilisé');
        return FALSE;
      } else {
        return TRUE;
      }
    }

    /**
    * Create a new user
    */
    public function new_user()
    {
      if (!empty($_POST)) {
        // VALIDATION

        //username: not void, unique
        $this->form_validation->set_rules('username', 'Identifiant', 'required', 'Un identifiant doit être fourni');
        $this->form_validation->set_rules('username', 'Identifiant', 'callback_unique_username');

        //firstname: not void
        $this->form_validation->set_rules('firstname', 'Prénom', 'required', 'Le prénom doit être indiqué');

        //lastname: not void
        $this->form_validation->set_rules('lastname', 'Nom', 'required', 'Le nom doit être indiqué');

        //email: void
        if (isset($_POST['email'])) {
          // or valid
          $this->form_validation->set_rules('email', 'Nom', 'valid_email', 'Entrez une adresse email valide ou aucune.');
        }

        //Password: 6 chars or more, confirmed
        $this->form_validation->set_rules('pwd', 'Mot de passe', 'min_length[6]', 'Le mot de passe doit faire au moins 6 caractères');
        $this->form_validation->set_rules('pwdagain', 'Mot de passe', 'matches[pwd]', 'Le mot de passe a été mal confirmé');

        if($this->form_validation->run() === TRUE)
        {
          $userArray["is_active"] = 0;

          foreach($_POST as $forminput => $formoutput) {
            // Password needs to be hashed first, so it's not the same thing as the other
            if ($forminput != "pwd" && $forminput != "pwdagain" && $forminput != "is_active" && $forminput != "email") {
              $userArray[$forminput] = $formoutput;
            // Do the hash only once…
            } else if ($forminput == "pwd" && $formoutput != "") {
              $userArray["password"] = password_hash($formoutput, PASSWORD_DEFAULT);
            } else if ($forminput == "is_active" && $formoutput == "TRUE") {
              $userArray["is_active"] = 1;
            } else if ($forminput == "email") {
              if ($formoutput != "") {
                $userArray["email"] = $formoutput;
              }
            }

            // Why?
            //$this->$userArray;
          }

          $this->load->model('user_model');
          $this->user_model->insert($userArray);

          redirect("/admin/view_users/");
          exit();
        }
      }

      $this->load->model('user_type_model');
      $output["user_types"] = $this->user_type_model->get_all();

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
