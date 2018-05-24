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
    protected $access_level = ACCESS_LVL_MSP;


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

    /* *********************************************************************************************************
    USERS
    ********************************************************************************************************* */

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
          $this->form_validation->set_rules('username', 'Identifiant', 'required|callback_unique_username', $this->lang->line('msg_id_needed')); // not void and unique.
        }

        //email: void
        if (isset($_POST['email'])) {
          // or valid.
          $this->form_validation->set_rules('email', 'Mail', 'valid_email', $this->lang->line('msg_err_email'));
        }

        // If the password needs to be modified,
        if (isset($_POST['pwd'])) {
          // it needs to be long 6 chars or more and confirmed
          $this->form_validation->set_rules('pwd', 'Mot de passe', 'min_length[6]', $this->lang->line('msg_err_pwd_length'));
          $this->form_validation->set_rules('pwdagain', 'Mot de passe', 'matches[pwd]', $this->lang->line('msg_err_pwg_wrong'));
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
        $this->form_validation->set_message('unique_username', $this->lang->line('msg_err_id_used'));
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
        $this->form_validation->set_rules('username', 'Identifiant', 'required|callback_unique_username', $this->lang->line('msg_err_id_needed'));

        //email: void
        if (isset($_POST['email'])) {
          // or valid
          $this->form_validation->set_rules('email', 'Mail', 'valid_email', $this->lang->line('msg_err_email'));
        }

        //Password: 6 chars or more, confirmed
        $this->form_validation->set_rules('pwd', 'Mot de passe', 'required|min_length[6]', $this->lang->line('msg_err_pwd_length'));
        $this->form_validation->set_rules('pwdagain', 'Mot de passe', 'matches[pwd]', $this->lang->line('msg_err_pwg_wrong'));

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

    /* *********************************************************************************************************
    TAGS
    ********************************************************************************************************* */

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
    * Modify a tag
    */
    public function modify_tag($id = NULL)
    {
      $this->load->model('item_tag_model');

      if (!empty($_POST)) {
        // VALIDATION

        //name: if changed,
        if ($_POST['name'] != get_object_vars($this->item_tag_model->get($id))['name']) {
          $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_tagname', $this->lang->line('msg_err_tag_name_needed')); // not void
        }

        //short_name: if changed,
        if ($_POST['short_name'] != get_object_vars($this->item_tag_model->get($id))['short_name']) {
          $this->form_validation->set_rules('short_name', 'Abrévation', 'required|callback_unique_tagshort', $this->lang->line('msg_err_abbreviation')); // not void
        }
        
        if($this->form_validation->run() === TRUE) {
		      $this->item_tag_model->update($id, $_POST);

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
        $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_tagname', $this->lang->line('msg_err_tag_name_needed'));
        
        //short_name: not void
        $this->form_validation->set_rules('short_name', 'Abrévation', 'required|callback_unique_tagshort', $this->lang->line('msg_err_abbreviation'));

        if($this->form_validation->run() === TRUE)
        {

          $this->load->model('item_tag_model');
          $this->item_tag_model->insert($_POST);

          redirect("/admin/view_tags/");
          exit();
        }
	  }

      $this->display_view("admin/tags/form");
    }

    public function unique_tagname($argName) {
      $this->load->model('item_tag_model');

      // Get this tag. If it fails, it doesn't exist, so the name is unique!
      $tag = $this->item_tag_model->get_by('name', $argName);
      
      if(isset($tag->item_tag_id)) {
        $this->form_validation->set_message('unique_tagname', $this->lang->line('msg_err_username_used'));
        return FALSE;
      } else {
        return TRUE;
      }
    }
	
    public function unique_tagshort($argShort) {
      $this->load->model('item_tag_model');

      // Get this tag. If it fails, it doesn't exist, so the name is unique!
      $tag = $this->item_tag_model->get_by('short_name', $argShort);
      
      if(isset($tag->item_tag_id)) {
        $this->form_validation->set_message('unique_tagshort', $this->lang->line('msg_err_abbreviation'));
        return FALSE;
      } else {
        return TRUE;
      }
    }
    
    /**
    * Delete a tag. 
    * If $action is NULL, a confirmation will be shown. If it is anything else, the tag will be deleted.
    */
    public function delete_tag($id = NULL, $action = NULL) {
      $this->load->model('item_tag_model');
      $this->load->model('item_tag_link_model');

      if (is_null($action)) {
        // Display a message to confirm the action
        $output = get_object_vars($this->item_tag_model->get($id));
        $output["tags"] = $this->item_tag_model->get_all();
        $this->display_view("admin/tags/delete", $output);
      
      } else {
        // Action confirmed : delete links and delete tag
        $this->item_tag_link_model->delete_by('item_tag_id='.$id);
        $this->item_tag_model->delete($id);
        redirect("/admin/view_tags/");
      }
    }

    /* *********************************************************************************************************
    STOCKING PLACES
    ********************************************************************************************************* */

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
    * As the name says, modify a stocking place, which id is $id
    */
    public function modify_stocking_place($id = NULL)
    {
      $this->load->model('stocking_place_model');

      if (!empty($_POST)) {
        $this->form_validation->set_rules('short', 'Nom court', 'required', $this->lang->line('msg_storage_short_needed'));
        $this->form_validation->set_rules('name', 'Nom long', 'required', $this->lang->line('msg_err_storage_long_needed'));

        if ($this->form_validation->run() === TRUE)
        {
          $this->stocking_place_model->update($id, $_POST);

          redirect("/admin/view_stocking_places/");
          exit();
        }
      } else {
        $output = get_object_vars($this->stocking_place_model->get($id));
      }

      $this->load->model('stocking_place_model');
      $output = get_object_vars($this->stocking_place_model->get($id));
      $output["stocking_places"] = $this->stocking_place_model->get_all();	  
	  
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
        $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_stocking_place', $this->lang->line('msg_err_unique_stocking_needed'));
		$this->form_validation->set_rules('short', 'court', 'required', $this->lang->line('msg_err_unique_stocking_short'));


        if ($this->form_validation->run() === TRUE)
        {
          $this->stocking_place_model->insert($_POST);

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
        $this->form_validation->set_message('unique_stocking_place', $this->lang->line('msg_err_id_used'));
        return FALSE;
      } else {
        return TRUE;
      }
    }
	
    /**
    * Delete the stocking place $id. If $action is null, a confirmation will be shown
    */
    public function delete_stocking_place($id = NULL, $action = NULL)
    {
      $this->load->model('stocking_place_model');

      if (is_null($action)) {
        $output["stocking_places"] = $this->stocking_place_model->get_all();
        $output = get_object_vars($this->stocking_place_model->get($id));

        $this->display_view("admin/stocking_places/delete", $output);
      } else {
        $this->stocking_place_model->delete($id);
        redirect("/admin/view_stocking_places/");
      }

    }

    /* *********************************************************************************************************
    SUPPLIERS
    ********************************************************************************************************* */
          
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
    * Modify a supplier
    */
    public function modify_supplier($id = NULL)
    {
      $this->load->model('supplier_model');

      if (!empty($_POST)) {
        // VALIDATION

        //name: if changed,
        $this->form_validation->set_rules('name', 'Identifiant', 'required', $this->lang->line('msg_err_supplier_needed')); // not void

        if (isset($_POST['email'])) {
          // or valid.
          $this->form_validation->set_rules('email', 'Mail', 'valid_email', $this->lang->line('msg_err_email'));
        }

        if ($this->form_validation->run() === TRUE)
        {
          $this->supplier_model->update($id, $_POST);

          redirect("/admin/view_suppliers/");
          exit();
        }
      } else {
        $output = get_object_vars($this->supplier_model->get($id));
      }
      
      $this->load->model('supplier_model');
      $output = get_object_vars($this->supplier_model->get($id));
      $output["suppliers"] = $this->supplier_model->get_all();	  
	  
      $this->display_view("admin/suppliers/form", $output);
    }
	
    /**
    * Create a new supplier
    */
    public function new_supplier()
    {
      $this->load->model('supplier_model');

      if (!empty($_POST)) {
        // VALIDATION

        //name: not void
        $this->form_validation->set_rules('name', 'Identifiant', 'required', $this->lang->line('msg_err_supplier_needed'));

        //email: void
        if (isset($_POST['email'])) {
          // or valid
          $this->form_validation->set_rules('email', 'Mail', 'valid_email', $this->lang->line('msg_err_email'));
        }

        if ($this->form_validation->run() === TRUE)
        {
          $this->supplier_model->insert($_POST);

          redirect("/admin/view_suppliers/");
          exit();
        }
      }

      $this->display_view("admin/suppliers/form");
    }

    /**
    * Delete a supplier
    */
    public function delete_supplier($id = NULL, $action = NULL)
    {
      $this->load->model('supplier_model');

      if (!isset($action)) {
        $output = get_object_vars($this->supplier_model->get($id));
        $output["suppliers"] = $this->supplier_model->get_all();

        $this->display_view("admin/suppliers/delete", $output);
      } else {
        // delete it!
        $this->supplier_model->delete($id);
        
        // redirect the user to the updated table
        redirect("/admin/view_suppliers/");
      }
    }

    /* *********************************************************************************************************
    ITEM GROUPS
    ********************************************************************************************************* */

    /**
    * As the name says, view the item groups.
    */
    public function view_item_groups()
    {
      $this->load->model('item_group_model');
      $output["item_groups"] = $this->item_group_model->get_all();

      $this->display_view("admin/item_groups/list", $output);
    }

    /**
    * Modify a group
    */
    public function modify_item_group($id = NULL)
    {
      $this->load->model('item_group_model');

      if (!empty($_POST)) {
        $this->form_validation->set_rules('name', 'Nom', 'required|callback_unique_groupname', $this->lang->line('msg_err_item_group_needed'));
        $this->form_validation->set_rules('short_name', 'Abrévation', 'required|callback_unique_groupshort', $this->lang->line('msg_err_item_group_short'));

        if ($this->form_validation->run() === TRUE) {
          $this->item_group_model->update($id, $_POST);

          redirect("/admin/view_item_groups/");
          exit();
        }
      } else {
        $output = get_object_vars($this->item_group_model->get($id));
      }
      
      $output["item_groups"] = $this->item_group_model->get_all();
      $this->display_view("admin/item_groups/form", $output);
    }

    /**
    * Create a new group
    */
    public function new_item_group()
    {
      $this->load->model('item_group_model');

      if (!empty($_POST)) {
        $this->form_validation->set_rules('name', 'Identifiant', 'required|callback_unique_groupname', $this->lang->line('msg_err_unique_groupname'));
        $this->form_validation->set_rules('short_name', 'Abrévation', 'required|callback_unique_groupshort', $this->lang->line('msg_err_unique_groupshort'));

        if ($this->form_validation->run() === TRUE)
        {
          $this->item_group_model->insert($_POST);

          redirect("/admin/view_item_groups/");
          exit();
        }
      }

      $this->display_view("admin/item_groups/form");
    }


    public function unique_groupname($argName) {
      $this->load->model('item_group_model');

      // Get this group. If it fails, it doesn't exist, so the username is unique!
      $group = $this->item_group_model->get_by('name', $argName);
      
      if(isset($group->item_group_id)) {
        $this->form_validation->set_message('unique_groupname', $this->lang->line('msg_err_username_used'));
        return FALSE;
      } else {
        return TRUE;
      }
    }
    
    public function unique_groupshort($argShort) {
      $this->load->model('item_group_model');

      // Get this group. If it fails, it doesn't exist, so the username is unique!
      $group = $this->item_group_model->get_by('short_name', $argShort);
      
      if(isset($group->item_group_id)) {
        $this->form_validation->set_message('unique_groupshort', $this->lang->line('msg_err_unique_shortname'));
        return FALSE;
      } else {
        return TRUE;
      }
    }
	
    /**
    * Delete an unused item group
    */
    public function delete_item_group($id = NULL, $action = NULL)
    {
      $this->load->model('item_group_model');

      if (!isset($action)) {
        $output = get_object_vars($this->item_group_model->get($id));
        $output["item_groups"] = $this->item_group_model->get_all();

        $this->display_view("admin/item_groups/delete", $output);
      } else {
        // delete it!
        $this->item_group_model->delete($id);
        
        // redirect the user to the updated table
        redirect("/admin/view_item_groups/");
      }
    }
}
