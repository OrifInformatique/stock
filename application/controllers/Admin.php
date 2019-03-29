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
      $this->view_users();
    }

    /* *********************************************************************************************************
    USERS
    ********************************************************************************************************* */

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
    */
    public function delete_user($id = NULL, $action = NULL) {
      $this->load->model(['stocking_place_model','user_model']);
      $deletion_allowed = true;
      $linked_items = [];
      $linked_loans = [];

      if(is_null($this->user_model->get($id))) {
        redirect("/admin/view_users/");
      }

      // Check if user is linked to other objects
      $user = $this->user_model->with_all()->get($id);

      if (!empty($user->items_created) || !empty($user->items_modified) || !empty($user->items_checked)) {
        if(is_array($user->items_created))
          $linked_items = array_merge($linked_items, $user->items_created);
        else
          array_push($linked_items, $user->items_created);

        if(is_array($user->items_modified))
          $linked_items = array_merge($linked_items, $user->items_modified);
        else
          array_push($linked_items, $user->items_modified);

        if(is_array($user->items_checked))
          $linked_items = array_merge($linked_items, $user->items_checked);
        else
          array_push($linked_items, $user->items_checked);

        $deletion_allowed = false;
      }
      if (!empty($user->loans_registered)) {
        if(is_array($user->loans_registered))
          $linked_loans = array_merge($linked_loans, $user->loans_registered);
        else
          array_push($linked_loans, $user->loans_registered);

        $deletion_allowed = false;
      }
      if (!empty($user->loans_made)) {
        if(is_array($user->loans_made))
          $linked_loans = array_merge($linked_loans, $user->loans_made);
        else
          array_push($linked_loans, $user->loans_made);

        $deletion_allowed = false;
      }

      if($deletion_allowed && $action == "disable") {
        $this->user_model->update($id, array('is_active' => 0));
        redirect("/admin/view_users/");

      } else if($deletion_allowed && $action == "delete") {
        $this->user_model->delete($id);
        redirect("/admin/view_users/");
      }

      $output = get_object_vars($this->user_model->get($id));

      $linked_items = $this->remove_array_duplicates($linked_items);
      $linked_loans = $this->remove_array_duplicates($linked_loans);
      $output['stocking_places'] = $this->stocking_place_model->get_all();
      $output['users'] = $this->user_model->get_all();
      $output['items'] = $linked_items;
      $output['loans'] = $linked_loans;
      $output["deletion_allowed"] = $deletion_allowed;
      $output["action"] = $action;

      $this->display_view("admin/users/delete", $output);
    }

    /**
    * Unlinks an user and the items linked.
    */
    public function unlink_user_items($id, $action = NULL) {
      $this->load->model(['user_model','item_model']);
      if(is_null($this->user_model->get($id))) {
        redirect("/admin/view_users/");
      }
      $user = $this->user_model->with_all()->get($id);

      if(is_null($action)) {
        $output = get_object_vars($this->user_model->get($id));
        $this->display_view('admin/users/unlink_items', $output);
      } else {
        $items_created = $user->items_created;
        $items_modified = $user->items_modified;
        $items_checked = $user->items_checked;
        foreach ($items_created as $created) {
          $this->item_model->update($created->item_id, array("created_by_user_id" => NULL));
        }
        foreach ($items_modified as $modified) {
          $this->item_model->update($modified->item_id, array("modified_by_user_id" => NULL));
        }
        foreach ($items_checked as $checked) {
          $this->item_model->update($checked->item_id, array("checked_by_user_id" => NULL));
        }
      }
    }

    /**
    * Unlinks an user and the loans linked.
    * If $action is NULL, a confirmation will be shown. Otherwise, the loans will be unlinked.
    */
    public function unlink_user_loans($id) {
      $this->load->model(['user_model','item_model','loan_model']);
      if(is_null($this->user_model->get($id))) {
        redirect("/admin/view_users/");
      }
      $user = $this->user_model->with_all()->get($id);

      $post = $_POST;
      if(!isset($post['new_user'])) {
        $output = get_object_vars($this->user_model->get($id));
        $output['user'] = $this->user_model->get($id);
        $output['new_users'] = $this->user_model->get_all();
        $this->display_view('admin/users/unlink_loans', $output);
      } else {
        $new_user = $post['new_user'];
        $loans_registered = $user->loans_registered;
        $loans_made = $user->loans_made;
        foreach($loans_registered as $registered) {
          $this->loan_model->update($registered->loan_id, array("loan_by_user_id" => $new_user));
        }
        foreach($loans_made as $made) {
          $this->loan_model->update($made->loan_id, array("loan_to_user_id" => $new_user));
        }
        redirect('admin/delete_user/'.$id);
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
    */
    public function delete_tag($id = NULL, $action = NULL) {
      $this->load->model(['stocking_place_model','item_tag_model','item_tag_link_model','item_model']);

      if(is_null($this->item_tag_model->get($id))) {
        redirect("/admin/view_tags");
      }

      $filter = array("t" => array($id));
      $items = $this->item_model->get_filtered($filter);

      if (is_null($action)) {
        // Display a message to confirm the action
        $output = get_object_vars($this->item_tag_model->get($id));
        $output['stocking_places'] = $this->stocking_place_model->get_all();
        $output['items'] = $items;
        $output["deletion_allowed"] = !(sizeof($items) > 0 && sizeof($items) < 500); // Do not make the number bigger than the amount of items
        $output["amount"] = sizeof($items);
        $output["tags"] = $this->item_tag_model->get_all();
        $this->display_view("admin/tags/delete", $output);
      
      } else {
        // Action confirmed : delete links and delete tag
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
      $this->load->model(['item_tag_model','item_tag_link_model','item_model']);

      if(is_null($action)) {
        $output = get_object_vars($this->item_tag_model->get($id));
        $this->display_view('admin/tags/unlink', $output);
      } else {
        $this->item_tag_link_model->delete_by('item_tag_id='.$id);
        redirect("/admin/delete_tag/".$id);
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
    */
    public function delete_stocking_place($id = NULL, $action = NULL)
    {
      $this->load->model(['stocking_place_model','item_model']);

      if(is_null($this->stocking_place_model->get($id))) {
        redirect("/admin/view_stocking_places/");
      }

      $filter = array('s' => array($id));
      $items = $this->item_model->get_filtered($filter);

      if (is_null($action)) {
        $output = get_object_vars($this->stocking_place_model->get($id));
        $output['items'] = $items;
        $output["stocking_places"] = $this->stocking_place_model->get_all();
        $output["deletion_allowed"] = (sizeof($items) == 0);
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

      if(is_null($this->stocking_place_model->get($id))) {
        redirect("/admin/view_stocking_places/");
      }

      $filter = array('s' => array($id));
      $items = $this->item_model->get_filtered($filter);

      if(is_null($action)) {
        $output = get_object_vars($this->stocking_place_model->get($id));
        $this->display_view('admin/stocking_places/unlink', $output);
      } else {
        foreach($items as $item) {
          $this->item_model->update($item->item_id, array('stocking_place_id' => NULL));
        }
        redirect('/admin/delete_stocking_place/'.$id);
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
    */
    public function delete_supplier($id = NULL, $action = NULL)
    {
      $this->load->model(['supplier_model','stocking_place_model','item_model']);

      if(is_null($this->supplier_model->get($id))) {
        redirect("/admin/view_suppliers/");
      }
      
      // Block deletion if this supplier is used
      $items = $this->item_model->get_many_by("supplier_id = ".$id);
      $amount = count($items);

      if (!isset($action)) {
        $output = get_object_vars($this->supplier_model->get($id));
        $output['items'] = $items;
        $output['stocking_places'] = $this->stocking_place_model->get_all();
        $output["deletion_allowed"] = ($amount < 1);
        $output["amount"] = $amount;

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

      if(is_null($this->supplier_model->get($id))) {
        redirect("/admin/view_suppliers/");
      }

      $items = $this->item_model->get_many_by("supplier_id = ".$id);

      if(is_null($action)) {
        $output = get_object_vars($this->supplier_model->get($id));
        $this->display_view('admin/suppliers/unlink', $output);
      } else {
        foreach($items as $item) {
          $this->item_model->update($item->item_id, array('supplier_id' => NULL));
        }
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
    */
    public function delete_item_group($id = NULL, $action = NULL)
    {
      $this->load->model(['item_group_model','stocking_place_model','item_model']);

      if(is_null($this->item_group_model->get($id))) {
        redirect("/admin/view_item_groups/");
      }

      $filter = array("g" => array($id));
      $items = $this->item_model->get_filtered($filter);

      if (!isset($action)) {
        $output = get_object_vars($this->item_group_model->get($id));
        $output['items'] = $items;
        $output['stocking_places'] = $this->stocking_place_model->get_all();
        $output["item_groups"] = $this->item_group_model->get_all();
        $output["deletion_allowed"] = (sizeof($items) == 0);
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

      if(is_null($this->item_group_model->get($id))) {
        redirect("/admin/view_item_groups/");
      }

      $items = $this->item_model->get_many_by("item_group_id = ".$id);

      if(is_null($action)) {
        $output = get_object_vars($this->item_group_model->get($id));
        $this->display_view('admin/item_groups/unlink', $output);
      } else {
        foreach($items as $item) {
          $this->item_model->update($item->item_id, array('item_group_id' => NULL));
        }
        redirect('/admin/delete_item_group/'.$id);
      }
    }

  /**
  * Removes duplicates in an array.
  * Better than array_unique, as it takes things that cannot be converted to string.
  * @param array $array
  *   Array that needs its duplicates removed.
  * @return array
  *   The array without any duplicates.
  */
  private function remove_array_duplicates(array $array) : array {
    $result = array();
    foreach ($array as $key => $value){
      if(!in_array($value, $result))
        $result[$key] = $value;
    }
    return $result;
  }
}
