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

      if (!empty($_POST)) {
        // VALIDATION

        //username: if changed,
        if ($_POST['username'] != get_object_vars($this->user_model->get($id))['username']) {
          $this->form_validation->set_rules('username', 'Identifiant', 'required|callback_unique_username', 'Un identifiant unique doit être fourni'); // not void and unique.
        }

        //email: void
        if (isset($_POST['email'])) {
          // or valid.
          $this->form_validation->set_rules('email', 'Mail', 'valid_email', 'Entrez une adresse email valide ou aucune.');
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
              } else {
				  $userArray["email"] = "";
			  }
            }
          }

          
          $this->user_model->update($id, $userArray);

          redirect("/admin/view_users/");
          exit();
        }
      // The values of the user are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      } else {
        $output = get_object_vars($this->user_model->get($id));
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
        $this->form_validation->set_rules('username', 'Identifiant', 'required|callback_unique_username', 'Un identifiant unique doit être fourni');

        //email: void
        if (isset($_POST['email'])) {
          // or valid
          $this->form_validation->set_rules('email', 'Mail', 'valid_email', 'Entrez une adresse email valide ou aucune.');
        }

        //Password: 6 chars or more, confirmed
        $this->form_validation->set_rules('pwd', 'Mot de passe', 'required|min_length[6]', 'Le mot de passe doit faire au moins 6 caractères');
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
    * Delete a user. 
    * If $action is NULL, a confirmation will be shown.
    * If it is "d", is_active will be set to 0.
    * If it is anything else, the user will be deleted. 
    */
    public function delete_user($id = NULL, $action = NULL) {
      $this->load->model('user_model');
      if (is_null($action)) {
        $output = get_object_vars($this->user_model->get($id));
        $output["users"] = $this->user_model->get_all();
        $this->display_view("admin/users/delete", $output);
      } else if($action == "d") {
        $this->user_model->update($id, array('is_active' => 0));
        redirect("/admin/view_users/");
      } else {
        $this->user_model->delete($id);
        redirect("/admin/view_users/");
      }
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
    * Delete an unused tag
    */
    public function delete_tag($id = NULL, $action = NULL) {		
      $this->load->model('item_tag_model');
      if (is_null($action)) {
        $output = get_object_vars($this->item_tag_model->get($id));
        $output["tags"] = $this->item_tag_model->get_all();
        $this->display_view("admin/tags/delete", $output);
      } else {
        $this->item_tag_model->delete($id);
        redirect("/admin/view_tags/");
      }
    }

    /**
    * Modify a tag
    */
    public function modify_tag($id = NULL)
    {
      $this->load->model('item_tag_model');

      if (!empty($_POST)) {
        // VALIDATION

        //name: if changed,
        if ($_POST['name'] != get_object_vars($this->item_tag_model->get($id))['name']) {
          $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_tagname', 'Un nom de tag doit être fourni'); // not void
        }

        if($this->form_validation->run() === TRUE)
		{
          foreach($_POST as $forminput => $formoutput) {
              $tagArray[$forminput] = $formoutput;
          }
		  
		  $this->item_tag_model->update($id, $tagArray);

        redirect("/admin/view_tags/");
        exit();
      }
	  
      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      } else {
        $output = get_object_vars($this->item_tag_model->get($id));
      }

      $this->load->model('item_tag_model');
      $output = get_object_vars($this->item_tag_model->get($id));
      $output["tags"] = $this->item_tag_model->get_all();	  
	  
      $this->display_view("admin/tags/form", $output);
    }

    /**
    * Create a new tag
    */
    public function new_tag()
    {
      if (!empty($_POST)) {
        // VALIDATION

        //name: not void
        $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_tagname', 'Un nom de tag unique doit être fourni');

        if($this->form_validation->run() === TRUE)
        {
          foreach($_POST as $forminput => $formoutput) {
              $tagArray[$forminput] = $formoutput;
          }

          $this->load->model('item_tag_model');
          $this->item_tag_model->insert($tagArray);

          redirect("/admin/view_tags/");
          exit();
        }
	  }

      $this->display_view("admin/tags/form");
    }

    public function unique_tagname($argName) {
      $this->load->model('item_tag_model');

      // Get this tag. If it fails, it doesn't exist, so the username is unique!
      $tag = $this->item_tag_model->get_by('name', $argName);
      
      if(isset($tag->item_tag_id)) {
        $this->form_validation->set_message('unique_tagname', 'Cet nom est déjà utilisé');
        return FALSE;
      } else {
        return TRUE;
      }
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
    * Delete an unused stocking_place
    */
    public function delete_stocking_place($id = NULL, $action = NULL) {		
      $this->load->model('stocking_place_model');
      if (is_null($action)) {
        $output = get_object_vars($this->stocking_place_model->get($id));
        $output["stocking_places"] = $this->stocking_place_model->get_all();
        $this->display_view("admin/stocking_places/delete", $output);
      } else {
        $this->stocking_place_model->delete($id);
        redirect("/admin/view_stocking_places/");
      }
    }


    /**
    * Modify a stocking_place
    */
    public function modify_stocking_place($id = NULL)
    {
      $this->load->model('stocking_place_model');

      if (!empty($_POST)) {
        // VALIDATION

        //name: if changed,
        if ($_POST['name'] != get_object_vars($this->stocking_place_model->get($id))['name']) {
          $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_stocking_place', 'Un nom de tag doit être fourni'); // not void
        }
		
		$this->form_validation->set_rules('short', 'court', 'required', 'Un nom court d emplacement doit être fourni');

        if($this->form_validation->run() === TRUE)
		{
          foreach($_POST as $forminput => $formoutput) {
              $spArray[$forminput] = $formoutput;
          }
		  
		  $this->stocking_place_model->update($id, $spArray);

        redirect("/admin/view_stocking_places/");
        exit();
      }
	  
      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      } else {
        $output = get_object_vars($this->stocking_place_model->get($id));
      }

      $this->load->model('stocking_place_model');
      $output = get_object_vars($this->stocking_place_model->get($id));
      $output["stocking_places"] = $this->stocking_place_model->get_all();	  
	  
      $this->display_view("admin/stocking_places/form", $output);
    }

    /**
    * Create a new stocking_place
    */
    public function new_stocking_place()
    {
      if (!empty($_POST)) {
        // VALIDATION

        //name: not void
        $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_stocking_place', 'Un nom d emplacement unique doit être fourni');
		$this->form_validation->set_rules('short', 'court', 'required', 'Un nom court d emplacement doit être fourni');

        if($this->form_validation->run() === TRUE)
        {
          foreach($_POST as $forminput => $formoutput) {
              $spArray[$forminput] = $formoutput;
          }

          $this->load->model('stocking_place_model');
          $this->stocking_place_model->insert($spArray);

          redirect("/admin/view_stocking_places/");
          exit();
        }
	  }

      $this->display_view("admin/stocking_places/form");
    }

    public function unique_stocking_place($argName) {
      $this->load->model('stocking_place_model');

      // Get this sp. If it fails, it doesn't exist, so the username is unique!
      $sp = $this->stocking_place_model->get_by('name', $argName);
      
      if(isset($sp->stocking_place_id)) {
        $this->form_validation->set_message('unique_stocking_place', 'Cet identifiant est déjà utilisé');
        return FALSE;
      } else {
        return TRUE;
      }
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
