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

    /**
    * Constructor
    */
    public function __construct(){
        $this->access_level = $this->config->item('access_lvl_msp');
        parent::__construct();
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;
    }

    /**
    * Menu for admin privileges
    */
    public function index()
    {
      $this->view_tags();
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
      $this->load->model('item_tag_model');
      $this->load->model('item_tag_link_model');
      $this->load->model('item_model');

      if(is_null($this->item_tag_model->get($id))) {
        redirect("/admin/view_tags");
      }

      $filter = array("t" => array($id));
      $items = $this->item_model->get_filtered($filter);

      if (is_null($action)) {
        // Display a message to confirm the action
        $output = get_object_vars($this->item_tag_model->get($id));
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
      $this->load->model('stocking_place_model');
      $this->load->model('item_model');

      if(is_null($this->stocking_place_model->get($id))) {
        redirect("/admin/view_stocking_places/");
      }
      
      $filter = array('s' => array($id));
      $items = $this->item_model->get_filtered($filter);

      if (is_null($action)) {
        $output = get_object_vars($this->stocking_place_model->get($id));
        $output["stocking_places"] = $this->stocking_place_model->get_all();
        $output["deletion_allowed"] = (sizeof($items) == 0);
        $output["amount"] = sizeof($items);

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
      $this->load->model('supplier_model');
      $this->load->model('item_model');

      if(is_null($this->supplier_model->get($id))) {
        redirect("/admin/view_suppliers/");
      }
      
      // Block deletion if this supplier is used
      $items = $this->item_model->get_many_by("supplier_id = ".$id);
      $amount = count($items);

      if (!isset($action)) {
        $output = get_object_vars($this->supplier_model->get($id));
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
      $this->load->model('item_group_model');
      $this->load->model('item_model');

      if(is_null($this->item_group_model->get($id))) {
        redirect("/admin/view_item_groups/");
      }

      $filter = array("g" => array($id));
      $items = $this->item_model->get_filtered($filter);

      if (!isset($action)) {
        $output = get_object_vars($this->item_group_model->get($id));
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
}
