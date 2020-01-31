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
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
    }

    /**
    * Menu for admin privileges
    */
    public function index()
    {
      $this->view_generic('user');
    }

    /* *********************************************************************************************************
    USERS
    ********************************************************************************************************* */

    /**
    * As the name says, view the users.
    * @deprecated use view_generic('user')
    */
    public function view_users(){

      $this->load->model('user_model');
      $this->load->model('user_type_model');
      $output["users"] = $this->user_model->with("user_type")->get_all();
      $this->display_view("admin/users/list", $output);
    }

    /**
    * Modify a user
    * @deprecated use form_generic('user', $id)
    */
    public function modify_user($id = NULL)
    {
      $this->load->model('user_model');

      if(is_null($this->user_model->get($id))) {
        redirect("/admin/view_users/");
      }

      if (!empty($_POST)) {
        // VALIDATION

        //username: if changed,
        if ($_POST['username'] != get_object_vars($this->user_model->get($id))['username']) {
          $this->form_validation->set_rules('username', $this->lang->line('field_username'), "required|callback_unique_username[$id]", $this->lang->line('msg_id_needed')); // not void and unique.
        }

        //email: void
        if (isset($_POST['email'])) {
          // or valid.
          $this->form_validation->set_rules('email', $this->lang->line('field_mail'), 'valid_email', $this->lang->line('msg_err_email'));
        }

        // If the password needs to be modified,
        if (isset($_POST['pwd'])) {
          // it needs to be long 6 chars or more and confirmed
          $this->form_validation->set_rules('pwd', $this->lang->line('field_password'), 'min_length[6]', $this->lang->line('msg_err_pwd_length'));
          $this->form_validation->set_rules('pwdagain', $this->lang->line('field_password'), 'matches[pwd]', $this->lang->line('msg_err_pwg_wrong'));
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
              $userArray["password"] = password_hash($formoutput, PASSWORD_HASH_ALGORITHM);
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

    public function unique_username($newUsername, $userID) {
      $this->load->model('user_model');

      // Get this user. If it fails, it doesn't exist, so the username is unique!
      $user = $this->user_model->get_by('username', $newUsername);
      
      if(isset($user->user_id) && $user->user_id != $userID) {
        $this->form_validation->set_message('unique_username', $this->lang->line('msg_err_id_used'));
        return FALSE;
      } else {
        return TRUE;
      }
    }

    /**
    * Create a new user
    * @deprecated use form_generic('user')
    */
    public function new_user()
    {
      if (!empty($_POST)) {
        // VALIDATION

        //username: not void, unique
        $this->form_validation->set_rules('username', $this->lang->line('field_username'), 'required|callback_unique_username', $this->lang->line('msg_err_id_needed'));

        //email: void
        if (isset($_POST['email'])) {
          // or valid
          $this->form_validation->set_rules('email', $this->lang->line('field_mail'), 'valid_email', $this->lang->line('msg_err_email'));
        }

        //Password: 6 chars or more, confirmed
        $this->form_validation->set_rules('pwd', $this->lang->line('field_password'), 'required|min_length[6]', $this->lang->line('msg_err_pwd_length'));
        $this->form_validation->set_rules('pwdagain', $this->lang->line('field_password'), 'matches[pwd]', $this->lang->line('msg_err_pwg_wrong'));

        if($this->form_validation->run() === TRUE)
        {
          $userArray["is_active"] = 0;

          foreach($_POST as $forminput => $formoutput) {
            // Password needs to be hashed first, so it's not the same thing as the other
            if ($forminput != "pwd" && $forminput != "pwdagain" && $forminput != "is_active" && $forminput != "email") {
              $userArray[$forminput] = $formoutput;
            // Do the hash only once…
            } else if ($forminput == "pwd" && $formoutput != "") {
              $userArray["password"] = password_hash($formoutput, PASSWORD_HASH_ALGORITHM);
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
    * If $action is "disable", is_active will be set to 0.
    * If it is "delete", the user will be deleted.
    * If it is anything else or NULL, a confirmation will be shown.
    * @deprecated use delete_generic('user', $id, $action)
    */
    public function delete_user($id, $action = NULL) {
      $this->load->model(['stocking_place_model','user_model']);
      $deletion_allowed = true;
      $linked_items = [];
      $linked_loans = [];

      // Check if there is an user with $id
      if(is_null($this->user_model->get($id))) {
        redirect("/admin/view_users/");
      } elseif($action == "disable") {
        // User still exists, so there is no need to remove item connections
        $this->user_model->update($id, array('is_active' => 0));
        redirect("/admin/view_users/");
      }

      // Get user with links to other objects
      $user = $this->user_model->with_all()->get($id);

      // Store linked objects in variable
      $linked_items = array_merge($user->items_created, $user->items_modified, $user->items_checked);
      $linked_loans = array_merge($user->loans_registered, $user->loans_made);

      // Make sure that all variables are empty
      $deletion_allowed = empty($linked_items + $linked_loans);

      if($deletion_allowed && $action == "delete") {
        $this->user_model->delete($id);
        redirect("/admin/view_users/");
      }

      $output = get_object_vars($this->user_model->get($id));

      // Removes duplicates from the linked objects
      $linked_items = array_unique($linked_items, SORT_REGULAR);
      $linked_loans = array_unique($linked_loans, SORT_REGULAR);

      $output['stocking_places'] = $this->stocking_place_model->get_all();
      $output['users'] = $this->user_model->get_all();
      $output['items'] = $linked_items;
      $output['loans'] = $linked_loans;
      $output['deletion_allowed'] = $deletion_allowed;

      $this->display_view("admin/users/delete", $output);
    }

    /**
    * Unlinks an user and the items linked.
    */
    public function unlink_user_items($id, $action = NULL) {
      $this->load->model(['user_model','item_model']);

      // Check if there is an user with $id
      if(is_null($this->user_model->get($id))) {
        redirect("/admin/view_users/");
      }

      if(is_null($action)) {
        $output = get_object_vars($this->user_model->get($id));
        $this->display_view('admin/users/unlink_items', $output);
      } else {
        $this->item_model->update_by('created_by_user_id='.$id, array('created_by_user_id' => NULL));
        $this->item_model->update_by('modified_by_user_id='.$id, array('modified_by_user_id' => NULL));
        $this->item_model->update_by('checked_by_user_id='.$id, array('checked_by_user_id' => NULL));
        redirect('admin/delete_user/'.$id);
      }
    }

    /**
    * Unlinks an user and the loans linked.
    */
    public function unlink_user_loans($id) {
      $this->load->model(['user_model','loan_model']);

      // Check if there is an user with $id
      if(is_null($this->user_model->get($id))) {
        redirect("/admin/view_users/");
      }

      // Don't directly access $_POST
      $post = $_POST;
      $new_user = (isset($post['new_user']) ? $post['new_user'] : -1);

      if($new_user == -1) {
        $output = get_object_vars($this->user_model->get($id));
        $output['user'] = $this->user_model->get($id);
        $output['new_users'] = $this->user_model->get_all();
        $this->display_view('admin/users/unlink_loans', $output);
      } else if(ctype_digit($new_user)) {
        $this->loan_model->update_by('loan_by_user_id='.$id, array('loan_by_user_id' => $new_user));
        $this->loan_model->update_by('loan_to_user_id='.$id, array('loan_to_user_id' => $new_user));
        redirect('admin/delete_user/'.$id);
      }
    }

    /* *********************************************************************************************************
    TAGS
    ********************************************************************************************************* */

    /**
    * As the name says, view the tags.
    * @deprecated use view_generic('tag')
    */
    public function view_tags()
    {
      $this->load->model('item_tag_model');
      $output["tags"] = $this->item_tag_model->get_all();

      $this->display_view("admin/tags/list", $output);
    }

    /**
    * Modify a tag
    * @deprecated use form_generic('tag', $id)
    */
    public function modify_tag($id = NULL)
    {
      $this->load->model('item_tag_model');

      if(is_null($this->item_tag_model->get($id))) {
        redirect("/admin/view_tags/");
      }

      if (!empty($_POST)) {
        // VALIDATION

        //name: if changed,
          $this->form_validation->set_rules('name', $this->lang->line('field_username'), "required|callback_unique_tagname[$id]", $this->lang->line('msg_err_tag_name_needed')); // not void
        
        //short_name: if changed,
          $this->form_validation->set_rules('short_name', $this->lang->line('field_abbreviation'), "required|callback_unique_tagshort[$id]", $this->lang->line('msg_err_abbreviation')); // not void
        
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
      if(!is_null($this->item_tag_model->get($id))){
        $output = get_object_vars($this->item_tag_model->get($id));
        $output["tags"] = $this->item_tag_model->get_all();
      } else {
        $output["missing_tag"] = TRUE;
      }

      $this->display_view("admin/tags/form", $output);
    }

    /**
    * Create a new tag
    * @deprecated use form_generic('tag')
    */
    public function new_tag()
    {
      if (!empty($_POST)) {
        // VALIDATION

        //name: not void
        $this->form_validation->set_rules('name', $this->lang->line('field_username'), 'required|callback_unique_tagname', $this->lang->line('msg_err_tag_name_needed'));
        
        //short_name: not void
        $this->form_validation->set_rules('short_name', $this->lang->line('field_abbreviation'), 'required|callback_unique_tagshort', $this->lang->line('msg_err_abbreviation'));

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

    public function unique_tagname($newName, $tagID) {
      $this->load->model('item_tag_model');

      // Get this tag. If it fails, it doesn't exist, so the name is unique!
      $tag = $this->item_tag_model->get_by('name', $newName);
      
      if(isset($tag->item_tag_id) && $tag->item_tag_id != $tagID) {
        $this->form_validation->set_message('unique_tagname', $this->lang->line('msg_err_username_used'));
        return FALSE;
      } else {
        return TRUE;
      }
    }
	
    public function unique_tagshort($newShort, $tagID) {
      $this->load->model('item_tag_model');

      // Get this tag. If it fails, it doesn't exist, so the name is unique!
      $tag = $this->item_tag_model->get_by('short_name', $newShort);
      
      if(isset($tag->item_tag_id) && $tag->item_tag_id != $tagID) {
        $this->form_validation->set_message('unique_tagshort', $this->lang->line('msg_err_unique_shortname'));
        return FALSE;
      } else {
        return TRUE;
      }
    }

    /**
    * Delete a tag. 
    * If $action is NULL, a confirmation will be shown. If it is anything else, the tag will be deleted.
    * @deprecated use delete_generic('tag', $id, $action)
    */
    public function delete_tag($id, $action = NULL) {
      $this->load->model(['stocking_place_model','item_tag_model','item_tag_link_model','item_model']);

      // Check if there is a tag with $id
      if(is_null($this->item_tag_model->get($id))) {
        redirect("/admin/view_tags");
      }

      $items = $this->item_model->get_filtered(["t" => [$id]]);
      $deletion_allowed = !(sizeof($items) > 0);

      if (is_null($action) || !$deletion_allowed) {
        // Display a message to confirm the action
        $output = get_object_vars($this->item_tag_model->get($id));
        $output['stocking_places'] = $this->stocking_place_model->get_all();
        $output['items'] = $items;
        $output["deletion_allowed"] = $deletion_allowed;
        $output["amount"] = sizeof($items);
        $output["tags"] = $this->item_tag_model->get_all();

        $this->display_view("admin/tags/delete", $output);
      } else {
        // Action confirmed : delete tag
        $this->item_tag_link_model->delete_by('item_tag_id='.$id);
        $this->item_tag_model->delete($id);
        redirect("/admin/view_tags/");
      }
    }

    /**
    * Unlinks a tag.
    * If $action is NULL, a confirmation will be shown. Otherwise, the tag will be unlinked.
    */
    public function unlink_tag($id, $action = NULL) {
      $this->load->model(['item_tag_model','item_tag_link_model']);

      // Check if there is a tag with $id
      if(is_null($this->item_tag_model->get($id))) {
        redirect("/admin/view_tags");
      }

      if(is_null($action)) {
        $output = get_object_vars($this->item_tag_model->get($id));
        $this->display_view('admin/tags/unlink', $output);
      } else {
        // Delete all links and go back to deletion
        $this->item_tag_link_model->delete_by('item_tag_id='.$id);
        redirect("/admin/delete_tag/".$id);
      }
    }

    /* *********************************************************************************************************
    STOCKING PLACES
    ********************************************************************************************************* */

    /**
    * As the name says, view the stocking places.
    * @deprecated use view_generic('stocking_place')
    */
    public function view_stocking_places()
    {
      $this->load->model('stocking_place_model');
      $output["stocking_places"] = $this->stocking_place_model->get_all();

      $this->display_view("admin/stocking_places/list", $output);
    }

    /**
    * As the name says, modify a stocking place, which id is $id
    * @deprecated use form_generic('stocking_place', $id)
    */
    public function modify_stocking_place($id = NULL)
    {
      $this->load->model('stocking_place_model');

      if(is_null($this->stocking_place_model->get($id))){
        redirect("/admin/view_stocking_places/");
      }

      if (!empty($_POST)) {
        $this->form_validation->set_rules('short', $this->lang->line('field_short_name'), "required|callback_unique_stocking_short[$id]", $this->lang->line('msg_storage_short_needed'));
        $this->form_validation->set_rules('name', $this->lang->line('field_long_name'), "required|callback_unique_stocking_name[$id]", $this->lang->line('msg_err_storage_long_needed'));

        if ($this->form_validation->run() === TRUE)
        {
          $this->stocking_place_model->update($id, $_POST);

          redirect("/admin/view_stocking_places/");
          exit();
        }
      } else {
        $output = get_object_vars($this->stocking_place_model->get($id));
      }
      if(!is_null($this->stocking_place_model->get($id))) {
        $output = get_object_vars($this->stocking_place_model->get($id));
        $output["stocking_places"] = $this->stocking_place_model->get_all();
      }else{
        $output["missing_stocking_place"] = TRUE;
      }

      $this->display_view("admin/stocking_places/form", $output);
    }

    /**
    * Create a new stocking_place
    * @deprecated use form_generic('stocking_place')
    */
    public function new_stocking_place()
    {
      if (!empty($_POST)) {
        // VALIDATION

        //name: not void
        $this->form_validation->set_rules('name', $this->lang->line('field_username'), 'required|callback_unique_stocking_name', $this->lang->line('msg_err_stocking_needed'));
        $this->form_validation->set_rules('short', $this->lang->line('field_short'), 'required|callback_unique_stocking_short', $this->lang->line('msg_err_stocking_short'));


        if ($this->form_validation->run() === TRUE)
        {
          $this->stocking_place_model->insert($_POST);

          redirect("/admin/view_stocking_places/");
          exit();
        }
      }

      $this->display_view("admin/stocking_places/form");
    }
          
    public function unique_stocking_name($newName, $stockID) {
      $this->load->model('stocking_place_model');

      // Search if another group has the same name
      $group = $this->stocking_place_model->get_by('name', $newName);
      
      if(isset($group->stocking_place_id) && $group->stocking_place_id != $stockID) {
        $this->form_validation->set_message('unique_stocking_name', $this->lang->line('msg_err_stocking_unique'));
        return FALSE;
      } else {
        return TRUE;
      }
    }

    public function unique_stocking_short($newShort, $stockID) {
      $this->load->model('stocking_place_model');

      // Search if another group has the same name
      $group = $this->stocking_place_model->get_by('name', $newShort);
      
      if(isset($group->stocking_place_id) && $group->stocking_place_id != $stockID) {
        $this->form_validation->set_message('unique_stocking_short', $this->lang->line('msg_err_stocking_short_unique'));
        return FALSE;
      } else {
        return TRUE;
      }
    }

    /**
    * Delete the stocking place $id. If $action is null, a confirmation will be shown
    * @deprecated use delete_generic('stocking_place', $id)
    */
    public function delete_stocking_place($id, $action = NULL)
    {
      $this->load->model(['stocking_place_model','item_model']);

      // Check if there is a stocking place with $id
      if(is_null($this->stocking_place_model->get($id))) {
        redirect("/admin/view_stocking_places/");
      }

      $items = $this->item_model->get_many_by('stocking_place_id='.$id);
      $deletion_allowed = sizeof($items) <= 0;

      if (is_null($action) || !$deletion_allowed) {
        $output = get_object_vars($this->stocking_place_model->get($id));
        $output['items'] = $items;
        $output["stocking_places"] = $this->stocking_place_model->get_all();
        $output["deletion_allowed"] = $deletion_allowed;
        $output["amount"] = sizeof($items);

        $this->display_view("admin/stocking_places/delete", $output);
      } else {
        $this->stocking_place_model->delete($id);
        redirect("/admin/view_stocking_places/");
      }
    }

    /**
    * Unlinks a stocking place.
    * If $action is NULL, a confirmation will be shown. Otherwise, the stocking place will be unlinked.
    */
    public function unlink_stocking_place($id, $action = NULL) {
      $this->load->model(['stocking_place_model','item_model']);

      // Check if there is a stocking place with $id
      if(is_null($this->stocking_place_model->get($id))) {
        redirect("/admin/view_stocking_places/");
      }

      if(is_null($action)) {
        $output = get_object_vars($this->stocking_place_model->get($id));
        $this->display_view('admin/stocking_places/unlink', $output);
      } else {
        // Set them all to NULL and go back to deletion
        $this->item_model->update_by('stocking_place_id='.$id, array('stocking_place_id' => NULL));
        redirect('/admin/delete_stocking_place/'.$id);
      }
    }

    /* *********************************************************************************************************
    SUPPLIERS
    ********************************************************************************************************* */
          
    /**
    * As the name says, view the suppliers.
    * @deprecated use view_generic('supplier')
    */
    public function view_suppliers()
    {
      $this->load->model('supplier_model');
      $output["suppliers"] = $this->supplier_model->get_all();

      $this->display_view("admin/suppliers/list", $output);
    }

    /**
    * Modify a supplier
    * @deprecated use form_generic('supplier', $id)
    */
    public function modify_supplier($id = NULL)
    {
      $this->load->model('supplier_model');

      if(is_null($this->supplier_model->get($id))) {
        redirect("/admin/view_suppliers/");
      }

      if (!empty($_POST)) {
        // VALIDATION

        //name: if changed,
        $this->form_validation->set_rules('name', $this->lang->line('field_name'), "required|callback_unique_supplier[$id]", $this->lang->line('msg_err_supplier_needed')); // not void

        if (isset($_POST['email'])) {
          // or valid.
          $this->form_validation->set_rules('email', $this->lang->line('field_mail'), 'valid_email', $this->lang->line('msg_err_email'));
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
      
      if(!is_null($this->supplier_model->get($id))){
        $output = get_object_vars($this->supplier_model->get($id));
        $output["suppliers"] = $this->supplier_model->get_all();
      }else{
        $output["missing_supplier"] = TRUE;
      }
	  
      $this->display_view("admin/suppliers/form", $output);
    }
	
    /**
    * Create a new supplier
    * @deprecated use form_generic('supplier')
    */
    public function new_supplier()
    {
      $this->load->model('supplier_model');

      if (!empty($_POST)) {
        // VALIDATION

        //name: not void
        $this->form_validation->set_rules('name', $this->lang->line('field_name'), 'required|callback_unique_supplier', $this->lang->line('msg_err_supplier_needed'));

        //email: void
        if (isset($_POST['email'])) {
          // or valid
          $this->form_validation->set_rules('email', $this->lang->line('field_mail'), 'valid_email', $this->lang->line('msg_err_email'));
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
    * @deprecated use delete_generic('supplier', $id)
    */
    public function delete_supplier($id, $action = NULL)
    {
      $this->load->model(['supplier_model','stocking_place_model','item_model']);

      // Check if there is a supplier with $id
      if(is_null($this->supplier_model->get($id))) {
        redirect("/admin/view_suppliers/");
      }
      
      // Prevent deletion if this supplier is used
      $items = $this->item_model->get_many_by("supplier_id = ".$id);
      $deletion_allowed = (count($items) < 1);

      if (!isset($action) || !$deletion_allowed) {
        $output = get_object_vars($this->supplier_model->get($id));
        $output['items'] = $items;
        $output['stocking_places'] = $this->stocking_place_model->get_all();
        $output["deletion_allowed"] = $deletion_allowed;

        $this->display_view("admin/suppliers/delete", $output);
      } else {
        // delete it!
        $this->supplier_model->delete($id);
        
        // redirect the user to the updated table
        redirect("/admin/view_suppliers/");
      }
    }

    /**
    * Unlinks a supplier.
    * If $action is NULL, a confirmation will be shown. Otherwise, the supplier will be unlinked.
    */
    public function unlink_supplier($id, $action = NULL) {
      $this->load->model(['supplier_model','item_model']);

      // Check if there is a supplier with $id
      if(is_null($this->supplier_model->get($id))) {
        redirect("/admin/view_suppliers/");
      }

      if(is_null($action)) {
        $output = get_object_vars($this->supplier_model->get($id));
        $this->display_view('admin/suppliers/unlink', $output);
      } else {
        // Set them all to NULL and go back to deletion
        $this->item_model->update_by('supplier_id='.$id, array('supplier_id' => NULL));
        redirect('/admin/delete_supplier/'.$id);
      }
    }

    public function unique_supplier($newName, $supplierID) {
      $this->load->model('supplier_model');

      // Search if another group has the same name
      $group = $this->supplier_model->get_by('name', $newName);
      
      if(isset($group->supplier_id) && $group->supplier_id != $supplierID) {
        $this->form_validation->set_message('unique_supplier', $this->lang->line('msg_err_supplier_unique'));
        return FALSE;
      } else {
        return TRUE;
      }
    }

    /* *********************************************************************************************************
    ITEM GROUPS
    ********************************************************************************************************* */

    /**
    * As the name says, view the item groups.
    * @deprecated use view_generic('item_group')
    */
    public function view_item_groups()
    {
      $this->load->model('item_group_model');
      $output["item_groups"] = $this->item_group_model->get_all();

      $this->display_view("admin/item_groups/list", $output);
    }

    /**
    * Modify a group
    * @deprecated use form_generic('item_group', $id)
    */
    public function modify_item_group($id = NULL)
    {
      $this->load->model('item_group_model');

      if(is_null($this->item_group_model->get($id))) {
        redirect("/admin/view_item_groups/");
      }

      if (!empty($_POST)) {
        $this->form_validation->set_rules('name', lang('field_name'), "required|callback_unique_groupname[$id]", lang('msg_err_item_group_needed'));
        $this->form_validation->set_rules('short_name', $this->lang->line('field_abbreviation'), "required|callback_unique_groupshort[$id]", $this->lang->line('msg_err_item_group_short'));

        if ($this->form_validation->run() === TRUE) {
          $this->item_group_model->update($id, $_POST);

          redirect("/admin/view_item_groups/");
          exit();
        }
      } else {
        if(!is_null($this->item_group_model->get($id))) {
          $output = get_object_vars($this->item_group_model->get($id));
        }
      }
      
      if(!is_null($this->item_group_model->get($id))) {
        $output["item_groups"] = $this->item_group_model->get_all();
      }else{
        $output["missing_item_group"] = TRUE;
      }
      $this->display_view("admin/item_groups/form", $output);
    }

    /**
    * Create a new group
    * @deprecated use form_generic('item_group')
    */
    public function new_item_group()
    {
      $this->load->model('item_group_model');

      if (!empty($_POST)) {
        $this->form_validation->set_rules('name', $this->lang->line('field_username'), 'required|callback_unique_groupname', $this->lang->line('msg_err_unique_groupname'));
        $this->form_validation->set_rules('short_name', $this->lang->line('field_abbreviation'), 'required|callback_unique_groupshort', $this->lang->line('msg_err_unique_shortname'));

        if ($this->form_validation->run() === TRUE)
        {
          $this->item_group_model->insert($_POST);

          redirect("/admin/view_item_groups/");
          exit();
        }
      }

      $this->display_view("admin/item_groups/form");
    }

    public function unique_groupname($newName, $groupID) {
      $this->load->model('item_group_model');

      // Search if another group has the same name
      $group = $this->item_group_model->get_by('name', $newName);
      
      if(isset($group->item_group_id) && $group->item_group_id != $groupID) {
        $this->form_validation->set_message('unique_groupname', $this->lang->line('msg_err_username_used'));
        return FALSE;
      } else {
        return TRUE;
      }
    }
    
    public function unique_groupshort($newShortName, $groupID) {
      $this->load->model('item_group_model');

      // Search if another group has the same short name
      $group = $this->item_group_model->get_by('short_name', $newShortName);
      
      if(isset($group->item_group_id) && $group->item_group_id != $groupID) {
        $this->form_validation->set_message('unique_groupshort', $this->lang->line('msg_err_unique_shortname'));
        return FALSE;
      } else {
        return TRUE;
      }
    }

    /**
    * Delete an unused item group
    * @deprecated use delete_generic('item_group', $id, $action)
    */
    public function delete_item_group($id, $action = NULL)
    {
      $this->load->model(['item_group_model','stocking_place_model','item_model']);

      // Check if there is an item group with $id
      if(is_null($this->item_group_model->get($id))) {
        redirect("/admin/view_item_groups/");
      }

      $items = $this->item_model->get_many_by('item_group_id='.$id);
      $deletion_allowed = (sizeof($items) == 0);

      if (!isset($action) || !$deletion_allowed) {
        $output = get_object_vars($this->item_group_model->get($id));
        $output['items'] = $items;
        $output['stocking_places'] = $this->stocking_place_model->get_all();
        $output["item_groups"] = $this->item_group_model->get_all();
        $output["deletion_allowed"] = $deletion_allowed;
        $output["amount"] = sizeof($items);

        $this->display_view("admin/item_groups/delete", $output);
      } else {
        // delete it!
        $this->item_group_model->delete($id);
        
        // redirect the user to the updated table
        redirect("/admin/view_item_groups/");
      }
    }

    /**
    * Unlinks an item group.
    * If $action is NULL, a confirmation will be shown. Otherwise, the item group will be unlinked.
    */
    public function unlink_item_group($id, $action = NULL) {
      $this->load->model(['item_group_model','item_model']);

      // Check if there is an item group with $id
      if(is_null($this->item_group_model->get($id))) {
        redirect("/admin/view_item_groups/");
      }

      if(is_null($action)) {
        $output = get_object_vars($this->item_group_model->get($id));
        $this->display_view('admin/item_groups/unlink', $output);
      } else {
        $this->item_model->update_by('item_group_id='.$id, array('item_group_id' => NULL));
        redirect('/admin/delete_item_group/'.$id);
      }
    }

    /* *********************************************************************************************************
    GENERIC (FOR EVERYTHING)
    ********************************************************************************************************* */
    /**
     * As the name and section suggest, shows one of the lists of items
     * @param string $category The type of things wanted.
     *     Accepts any string on the first line.
     */
    public function view_generic($category = 'user') {
      $admin_menus = ['user', 'tag', 'stocking_place', 'supplier', 'item_group'];
      if(!in_array($category, $admin_menus)) {
        $category = 'user';
      }

      $things = $this->{"generic_get_{$category}s"}();
      $headers = $things['headers'];
      $current_items = $things['current_items'];

      $output['headers'] = $headers;
      $output['admin_menus'] = $admin_menus;
      $output['current_menu'] = $category;
      $output['current_items'] = $current_items;
      $this->display_view('/admin/listgeneric', $output);
    }

    /**
     * As the name and section suggest, opens a form for a type of item
     * @param string $category The type of things wanted.
     *    Accepts any string on the first line.
     * @param integer $id The id of the item to modify.
     *    Set to 0 for new item.
     */
    public function form_generic($category, $id = 0) {
      $admin_menus = ['user', 'tag', 'stocking_place', 'supplier', 'item_group'];
      if(!in_array($category, $admin_menus)) {
        redirect('/admin');
      }

      if(!empty($_POST)) {
        $this->check_form_generic();
      } else {
        $fields = $this->{"generic_get_{$category}s_fields"}($id);
        $selects = $this->generic_get_selects();

        $output['admin_menus'] = $admin_menus;
        $output['current_menu'] = $category;
        $output['fields'] = $fields;
        $output['selects'] = $selects;
        $output['update'] = ($id > 0);
        $this->display_view('/admin/formgeneric', $output);
      }
    }

    /**
     * Checks that the generic form was filled correctly.
     */
    public function check_form_generic() {
      $data = $_POST['field'];
      $category = $_POST['category'];
      $update = FALSE;
      $id = -1;
      if(isset($_POST['id'])) {
        $update = TRUE;
        $id = $_POST['id'];
      }

      // Choosing which model to load
      if($category === 'tag') {
        $current_model = 'item_tag_model';
      } else {
        $current_model = "{$category}_model";
      }

      // Setting the validation rules
      switch($category) {
        case 'user':
          $pwd_rules = ($update ? '' : 'required|').'min_length[6]';
          $this->form_validation->set_rules('field[username]', $this->lang->line('field_username'), "required|callback_unique_username[$id]", $this->lang->line('msg_id_needed'));
          $this->form_validation->set_rules('field[email]', $this->lang->line('field_mail'), 'valid_email', $this->lang->line('msg_err_email'));
          if(!empty($data['pwd']) || !empty($data['pwdagain']) || $update) {
            $pwd = $data['pwd'];
            $this->form_validation->set_rules('field[pwd]', $this->lang->line('field_password'), $pwd_rules, $this->lang->line('msg_err_pwd_length'));
            $this->form_validation->set_rules('field[pwdagain]', $this->lang->line('field_password'), "in_list[".$pwd."]", $this->lang->line('msg_err_pwg_wrong'));
          }
          break;
        case 'tag':
          $this->form_validation->set_rules('field[name]', $this->lang->line('field_username'), "required|callback_unique_tagname[$id]", $this->lang->line('msg_err_tag_name_needed'));
          $this->form_validation->set_rules('field[short_name]', $this->lang->line('field_abbreviation'), "required|callback_unique_tagshort[$id]", $this->lang->line('msg_err_abbreviation'));
          break;
        case 'stocking_place':
          $this->form_validation->set_rules('field[short]', $this->lang->line('field_short_name'), "required|callback_unique_stocking_short[$id]", $this->lang->line('msg_err_storage_short_needed'));
          $this->form_validation->set_rules('field[name]', $this->lang->line('field_long_name'), "required|callback_unique_stocking_name[$id]", $this->lang->line('msg_err_storage_long_needed'));
          break;
        case 'supplier':
          $this->form_validation->set_rules('field[name]', $this->lang->line('field_name'), "required|callback_unique_supplier[$id]", $this->lang->line('msg_err_supplier_needed'));
          $this->form_validation->set_rules('field[email]', $this->lang->line('field_mail'), 'valid_email', $this->lang->line('msg_err_email'));
          break;
        case 'item_group':
          $this->form_validation->set_rules('field[name]', $this->lang->line('field_username'), "required|callback_unique_groupname[$id]", lang('msg_err_item_group_needed'));
          $this->form_validation->set_rules('field[short_name]', $this->lang->line('field_abbreviation'), "required|callback_unique_groupshort[$id]", $this->lang->line('msg_err_item_group_short'));
          break;
      }

      if($category == 'user') {
        $data['is_active'] = isset($data['is_active']);
        if(!$update || !empty($data['pwd'])) {
          $data['password'] = password_hash($data['pwd'], PASSWORD_HASH_ALGORITHM);
        }
      }
      if(!isset($data['email']) || empty($data['email'])) {
        unset($data['email']);
      }

      $this->load->model($current_model);

      if($this->form_validation->run()) {
        unset($data['pwd']);
        unset($data['pwdagain']);
        if($update) {
          $this->{$current_model}->update($id, $data);
        } else {
          $res = $this->{$current_model}->insert($data);
        }
        redirect("admin/view_generic/".$category);
      } else {
        $this->form_generic($category,$id);
      }
    }

    /**
     * As the name and section suggest, opens a view for item deletion.
     * @param string $category
     *    The category of item to delete.
     * @param integer $id
     *    The id of the item to delete.
     * @param string $command
     *    The command to do. "delete" will delete the item, "disable" will disable the user, NULL will ask for confirmation.
     */
    public function delete_generic($category, $id, $command = NULL) {
      $admin_menus = ['user', 'tag', 'stocking_place', 'supplier', 'item_group'];
      if(!in_array($category, $admin_menus)) {
        redirect('/admin');
      }

      // Choosing which model to load
      switch($category) {
        case 'user':
          $current_model = 'user_model';
          break;
        case 'tag':
          $current_model = 'item_tag_model';
          break;
        case 'stocking_place':
          $current_model = 'stocking_place_model';
          break;
        case 'supplier':
          $current_model = 'supplier_model';
          break;
        case 'item_group':
          $current_model = 'item_group_model';
          break;
      }
      $current_models = ['item_model', $current_model];
      $this->load->model($current_models);
      if(is_null($this->{$current_model}->get($id))) {
        redirect('/admin');
      }
      $item = $this->{$current_model}->with_all()->get($id);

      // Set name and is_active
      $itemname = "";
      if($category === 'user') {
        $itemname = $item->username;
        $is_active = $item->is_active;
      } else {
        $itemname = $item->name;
        $is_active = FALSE;
      }

      // Get linked items and loans
      $linked_items = [];
      $linked_loans = [];
      if($category === 'user') {
        $linked_items = array_merge($item->items_created, $item->items_modified, $item->items_checked);
        $linked_loans = array_merge($item->loans_registered, $item->loans_made);
      } elseif($category === 'tag') {
        $linked_items = $this->item_model->get_filtered(["t" => [$id]]);
      } else {
        $linked_items = $this->item_model->get_many_by("{$category}_id=".$id);
      }
      $linked_items = $this->generic_format_items($linked_items);
      $linked_loans = $this->generic_format_loans($linked_loans);
      $linked_items = array_unique($linked_items, SORT_REGULAR);
      $linked_loans = array_unique($linked_loans, SORT_REGULAR);

      $deletion_allowed = (empty($linked_loans) && empty($linked_items));

      // Lists headers
      $header_items = [
        $this->lang->line('header_item_name'),
        $this->lang->line('header_stocking_place'),
        $this->lang->line('header_inventory_nb').'<br>'.$this->lang->line('header_serial_nb')
      ];
      $header_loans = [
        $this->lang->line('header_loan_date'),
        $this->lang->line('header_loan_planned_return'),
        $this->lang->line('header_loan_real_return'),
        $this->lang->line('header_loan_localisation'),
        $this->lang->line('header_loan_by_user'),
        $this->lang->line('header_loan_to_user'),
      ];

      if(is_null($command)) {
        $output['admin_menus'] = $admin_menus;
        $output['current_menu'] = $category;
        $output['deletion_allowed'] = $deletion_allowed;
        $output['header_items'] = $header_items;
        $output['header_loans'] = $header_loans;
        $output['linked_items'] = $linked_items;
        $output['linked_loans'] = $linked_loans;
        $output['is_active'] = $is_active;
        $output['name'] = $itemname;
        $output['current_id'] = $id;
        $this->display_view('/admin/deletegeneric', $output);
      } else {
        if($command === 'delete' && $deletion_allowed) {
          $this->{$current_model}->delete($id);
        } elseif($deletion_allowed && $category === 'user' && $command === 'disable') {
          $this->user_model->update($id, ['is_active' => 0]);
        }

        redirect("admin/view_generic/{$category}");
      }
    }

    /**
     * Returns the items and the headers for the list.
     * Items are modified to allow a simpler list.
     * @return array: The list headers and items
     */
    private function generic_get_users() {
      $output['headers'] = [
        'header_username', 'header_lastname',
        'header_firstname', 'header_email',
        'header_user_type', 'header_is_active'
      ];

      $this->load->model('user_model');
      $current_items = $this->user_model->with('user_type')->get_all();

      foreach($current_items as &$current_item) {
        $current_id = $current_item->user_id;
        $temp = [
          'username' => "<a href='".base_url("admin/form_generic/user/{$current_id}")."'>{$current_item->username}</a>",
          'lastname' => $current_item->lastname,
          'firstname' => $current_item->firstname,
          'email' => $current_item->email,
          'status' => $current_item->user_type->name,
          'is_active' => ($current_item->is_active == 1 ? lang('text_yes') : lang('text_no')),
          'delete' => "<a href='".base_url("/admin/delete_generic/user/{$current_id}")."' class='close'>x</a>"
        ];
        $current_item = $temp;
      }

      unset($current_item);

      $output['current_items'] = $current_items;
      return $output;
    }
    /**
     * Returns the tags and the headers for the list.
     * Tags are modified to allow a simpler list.
     * @return array: The list headers and tags
     */
    private function generic_get_tags() {
      $output['headers'] =  NULL;

      $this->load->model('item_tag_model');
      $current_items = $this->item_tag_model->get_all();

      foreach($current_items as &$current_item) {
        $current_id = $current_item->item_tag_id;

        $temp = [
          'name' => "<a href='".base_url("admin/form_generic/tag/{$current_id}")."'>{$current_item->name}</a> {$current_item->short_name}",
          'delete' => "<a href='".base_url("/admin/delete_generic/tag/{$current_id}")."' class='close'>x</a>"
        ];

        $current_item = $temp;
      }

      unset($current_item);

      $output['current_items'] = $current_items;
      return $output;
    }
    /**
     * Returns the stocking places and the headers for the list.
     * Stocking places are modified to allow a simpler list.
     * @return array: The list headers and stocking places
     */
    private function generic_get_stocking_places() {
      $output['headers'] = ['field_short_name', 'field_long_name'];

      $this->load->model('stocking_place_model');
      $current_items = $this->stocking_place_model->get_all();

      foreach($current_items as &$current_item) {
        $current_id = $current_item->stocking_place_id;

        $temp = [
          'short' => '<a href=\''.base_url("admin/form_generic/stocking_place/{$current_id}")."'>{$current_item->short}</a>",
          'long' => $current_item->name,
          'delete' => "<a href='".base_url("/admin/delete_generic/stocking_place/{$current_id}")."' class='close'>x</a>"
        ];

        $current_item = $temp;
      }

      unset($current_item);

      $output['current_items'] = $current_items;
      return $output;
    }
    /**
     * Returns the suppliers and the headers for the list.
     * Suppliers are modified to allow a simpler list.
     * @return array: The list headers and suppliers
     */
    private function generic_get_suppliers() {
      $output['headers'] = [
        'header_suppliers_name', 'header_suppliers_address_1',
        'header_suppliers_address_2', 'header_suppliers_NPA',
        'header_suppliers_city', 'header_suppliers_country',
        'header_suppliers_phone', 'header_suppliers_email'
      ];

      $this->load->model('supplier_model');
      $current_items = $this->supplier_model->get_all();

      foreach($current_items as &$current_item) {
        $current_id = $current_item->supplier_id;

        $temp = [
          'name' => '<a href=\''.base_url("admin/form_generic/supplier/{$current_id}")."'>{$current_item->name}</a>",
          'address_line1' => $current_item->address_line1,
          'address_line2' => $current_item->address_line2,
          'zip' => $current_item->zip,
          'city' => $current_item->city,
          'country' => $current_item->country,
          'tel' => $current_item->tel,
          'email' => $current_item->email,
          'delete' => "<a href='".base_url("/admin/delete_generic/supplier/{$current_id}")."' class='close'>x</a>"
        ];

        $current_item = $temp;
      }

      unset($current_item);

      $output['current_items'] = $current_items;
      return $output;
    }
    /**
     * Returns the item groups and the headers for the list.
     * Item groups are modified to allow a simpler list.
     * @return array: The list headers and item groups
     */
    private function generic_get_item_groups() {
      $output['headers'] = NULL;

      $this->load->model('item_group_model');
      $current_items = $this->item_group_model->get_all();

      foreach($current_items as &$current_item) {
        $current_id = $current_item->item_group_id;

        $temp = [
          'name' => '<a href=\''.base_url("admin/form_generic/item_group/{$current_id}")."'>{$current_item->name}</a>",
          'short_name' => $current_item->short_name,
          'delete' => "<a href='".base_url("/admin/delete_generic/item_group/{$current_id}")."' class='close'>x</a>"
        ];

        $current_item = $temp;
      }

      unset($current_item);

      $output['current_items'] = $current_items;
      return $output;
    }

    /**
     * Returns the fields for the users with the data.
     * @param integer $id
     *    The id of the user to get.
     * @return array: fields for the item groups, already containing data.
     */
    private function generic_get_users_fields($id = 0){
      $this->load->model('user_model');
      if(!is_null($this->user_model->get($id)) && $id !== 0) {
        $user = $this->user_model->get($id);
      }

      $is_active = (isset($user) && $user->is_active == 1);

      $fields = [
        $this->generic_get_field_object('field_username', 'text', 'field[username]', (isset($user->username) ? $user->username : NULL)),
        $this->generic_get_field_object('field_lastname', 'text', 'field[lastname]', (isset($user->lastname) ? $user->lastname : NULL)),
        $this->generic_get_field_object('field_firstname', 'text', 'field[firstname]', (isset($user->firstname) ? $user->firstname : NULL)),
        $this->generic_get_field_object('field_email', 'text', 'field[email]', (isset($user->email) ? $user->email : NULL)),
        $this->generic_get_field_object('field_status', 'select', 'field[user_type_id]', (isset($user->user_type_id) ? $user->user_type_id : NULL)),
        $this->generic_get_field_object('field_password', 'password', 'field[pwd]', NULL, 'placeholder="Au moins 6 caractères"'),
        $this->generic_get_field_object('field_password_confirm', 'password', 'field[pwdagain]', NULL),
        $this->generic_get_field_object(NULL , 'checkbox', 'field[is_active]', $is_active)
      ];
      $fields[7]->text = 'Activé ';

      if(isset($user)) {
        $fields[] = $this->generic_get_field_object(NULL, 'hidden', 'id', $id);
      }

      return $fields;
    }
    /**
     * Returns the fields for the tags with the data.
     * @param integer $id
     *    The id of the tag to get.
     * @return array: fields for the item groups, already containing data.
     */
    private function generic_get_tags_fields($id = 0){
      $this->load->model('item_tag_model');
      if(!is_null($this->item_tag_model->get($id)) && $id !== 0) {
        $item_tag = $this->item_tag_model->get($id);
      }

      $fields = [
        $this->generic_get_field_object('field_abbreviation', 'text', 'field[short_name]', (isset($item_tag->short_name) ? $item_tag->short_name : NULL), 'maxlength="3"'),
        $this->generic_get_field_object('field_tag', 'text', 'field[name]', (isset($item_tag->name) ? $item_tag->name : NULL)),
      ];

      if(isset($item_tag)) {
        $fields[] = $this->generic_get_field_object(NULL, 'hidden', 'id', $id);
      }

      return $fields;
    }
    /**
     * Returns the fields for the stocking places with the data.
     * @param integer $id
     *    The id of the stocking place to get.
     * @return array: fields for the item groups, already containing data.
     */
    private function generic_get_stocking_places_fields($id = 0){
      $this->load->model('stocking_place_model');
      if(!is_null($this->stocking_place_model->get($id)) && $id !== 0) {
        $stocking_place = $this->stocking_place_model->get($id);
      }

      $fields = [
        $this->generic_get_field_object('field_short_name', 'text', 'field[short]', (isset($stocking_place->short) ? $stocking_place->short : NULL)),
        $this->generic_get_field_object('field_long_name', 'text', 'field[name]', (isset($stocking_place->name) ? $stocking_place->name : NULL))
      ];

      if(isset($stocking_place)) {
        $fields[] = $this->generic_get_field_object(NULL, 'hidden', 'id', $id);
      }

      return $fields;
    }
    /**
     * Returns the fields for the suppliers with the data.
     * @param integer $id
     *    The id of the supplier to get.
     * @return array: fields for the item groups, already containing data.
     */
    private function generic_get_suppliers_fields($id = 0){
      $this->load->model('supplier_model');
      if(!is_null($this->supplier_model->get($id)) && $id !== 0) {
        $supplier = $this->supplier_model->get($id);
      }

      $fields = [
        $this->generic_get_field_object('field_name', 'text', 'field[name]', (isset($supplier->name) ? $supplier->name : NULL)),
        $this->generic_get_field_object('field_first_adress', 'text', 'field[address_line1]', (isset($supplier->address_line1) ? $supplier->address_line1 : NULL)),
        $this->generic_get_field_object('field_second_adress', 'text', 'field[address_line2]', (isset($supplier->address_line2) ? $supplier->address_line2 : NULL)),
        $this->generic_get_field_object('field_postal_code', 'number', 'field[zip]', (isset($supplier->zip) ? $supplier->zip : NULL)),
        $this->generic_get_field_object('field_city', 'text', 'field[city]', (isset($supplier->city) ? $supplier->city : NULL)),
        $this->generic_get_field_object('field_tel', 'text', 'field[tel]', (isset($supplier->tel) ? $supplier->tel : NULL)),
        $this->generic_get_field_object('field_email', 'text', 'field[email]', (isset($supplier->email) ? $supplier->email : NULL))
      ];

      if(isset($supplier)) {
        $fields[] = $this->generic_get_field_object(NULL, 'hidden', 'id', $id);
      }

      return $fields;
    }
    /**
     * Returns the fields for the item groups with the data.
     * @param integer $id
     *    The id of the item group to get.
     * @return array: fields for the item groups, already containing data.
     */
    private function generic_get_item_groups_fields($id = 0) {
      $this->load->model('item_group_model');
      if(!is_null($this->item_group_model->get($id)) && $id !== 0) {
        $item_group = $this->item_group_model->get($id);
      }

      $fields = [
        $this->generic_get_field_object('field_abbreviation', 'text', 'field[short_name]', (isset($item_group->short_name) ? $item_group->short_name : NULL)),
        $this->generic_get_field_object('field_name', 'text', 'field[name]', (isset($item_group->name) ? $item_group->name : NULL))
      ];

      if(isset($item_group)) {
        $fields[] = $this->generic_get_field_object(NULL, 'hidden', 'item_group_id', $id);
      }

      return $fields;
    }

    /**
     * Formats the input items in an array for a generic list.
     * @param array $items
     *    The array of items to reformat.
     * @return array
     *    A ready-to-use array for a generic list.
     */
    private function generic_format_items($items) {
      if(empty($items) || is_null($items))
        return [];

      $stocking_places = $this->generic_get_stocking_places_as_array();

      foreach($items as &$item) {
        $temp = [
          'name' => "<a style='display: block;' href=".base_url("item/view/{$item->item_id}").">{$item->name}</a>".
            "<h6>{$item->description}</h6>",
          'stocking_place' => $stocking_places[$item->stocking_place_id],
          'inventory_number' => "<a href='".base_url("item/view/{$item->item_id}")."'>".
            "<div>{$item->inventory_number}</div><div>{$item->serial_number}</div>",
          'delete' => "<a href='".base_url("item/delete/{$item->item_id}"."' class='close' title='".html_escape($this->lang->line('admin_delete_item'))."'>x</a>")
        ];

        $item = $temp;
      }
      unset($item);

      return $items;
    }
    /**
     * Formats the input loans in an array for a generic list.
     * @param array $loans
     *    The array of loans to reformat.
     * @return array
     *    A ready-to-use array for a generic list.
     */
    private function generic_format_loans($loans) {
      if(empty($loans) || is_null($loans))
        return [];

      $users = $this->generic_get_users_as_array();

      foreach($loans as &$loan) {
        $temp = [
          'date' => "<a href='".base_url('/item/modify_loan/{$loan->loan_id}')."'>{$loan->date}</a>",
          'planned_return_date' => $loan->planned_return_date,
          'real_return_date' => $loan->real_return_date,
          'item_localisation' => $loan->item_localisation,
          'loan_by_user_id' => $users[$loan->loan_by_user_id],
          'loan_to_user_id' => $users[$loan->loan_to_user_id],
          'delete' => "<a href='".base_url("item/delete_loan/{$loan->loan_id}")."' class='close' title='".$this->lang->line('admin_delete_loan')."'>x</a>"
        ];

        $loan = $temp;
      }
      unset($loan);

      return $loans;
    }

    /**
     * Returns the selects for the users with the data.
     * @param integer $id
     *    The id of the user's user type.
     * @return array: fields for the item groups, already containing data.
     */
    private function generic_get_selects($id = 0) {
      $selects = [];

      $this->load->model('user_type_model');
      $selects[0] = $this->user_type_model->get_all();
      foreach($selects[0] as &$select) {
        $temp = (object) [
          'value' => $select->user_type_id,
          'text' => $select->name,
          'selected' => ($select->user_type_id == $id),
        ];
        $select = $temp;
      }

      unset($select);

      return $selects;
    }
    /**
     * Returns a field ready to be used in generic forms.
     * @param string $text
     *    The lang line to display.
     * @param string $type
     *    The type of field.
     * @param string $name
     *    The field's name.
     * @param string $value
     *    The field's value.
     * @param array|string $other
     *    The other things to add to the field.
     * @return object
     *    An object with the attributes ready to be put in the generic form.
     */
    private function generic_get_field_object($text, $type, $name, $value = NULL, $other = NULL) {
      $otherhtml = "";
      if(is_array($other)) {
        foreach($other as $param) {
          $otherhtml .= $param." ";
        }
      } else {
        $otherhtml = $other;
      }
      $field = (object) [
        'text' => $this->lang->line($text),
        'type' => $type,
        'name' => $name,
        'value' => $value,
      ];

      if(!is_null($other)) {
        $field->other = $otherhtml;
      }

      return $field;
    }
    /**
     * Function to make your life easier.
     * Returns all stocking places as an array with $stocking_place->id => $stocking_place->name
     */
    private function generic_get_stocking_places_as_array() {
      $this->load->model('stocking_place_model');

      $stocking_places = $this->stocking_place_model->get_all();
      $output = [];
      foreach($stocking_places as $stocking_place) {
        $output[$stocking_place->stocking_place_id] = $stocking_place->name;
      }
      return $output;
    }
    /**
     * Function to make your life easier.
     * Returns all users as an array with $user->id => $user->name
     */
    private function generic_get_users_as_array() {
      $this->load->model('user_model');

      $users = $this->user_model->get_all();
      $output = [];
      foreach($users as $user) {
        $output[$user->user_id] = $user->username;
      }
      return $output;
    }
}
