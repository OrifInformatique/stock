<?php
/**
 * Admin controller
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace Stock\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Stock\Models\Item_tag_model;
use Stock\Models\Stocking_place_model;
use Stock\Models\Supplier_model;
use Stock\Models\Item_group_model;


class Admin extends BaseController
{
    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Set Access level before calling parent constructor
        parent::initController($request,$response,$logger);

        // Load required helpers
        helper('form');

        // Load required services
        $this->validation = \Config\Services::validation();

        // Load required models
        $this->item_tag_model         = new Item_tag_model();
        $this->stocking_place_model   = new Stocking_place_model();
        $this->supplier_model         = new Supplier_model();
        $this->item_group_model       = new Item_group_model();

        //get db instance
        $this->db = \CodeIgniter\Database\Config::connect();

    }
    

    /* *********************************************************************************************************
    TAGS
    ********************************************************************************************************* */

    /**
    * As the name says, view the tags.
    */
    public function view_tags()
    {
      $data['items'] = [];
      $tags = $this->item_tag_model->findAll();

      $data['list_title'] = lang('stock_lang.title_tags');
        
      $data['columns'] = ['name' => lang('stock_lang.field_name'),
                          'short_name' => lang('stock_lang.field_short_name')
                         ];
                          
      foreach ($tags as $tag)
      {
        array_push($data['items'], ['item_tag_id' => $tag['item_tag_id'], 'name' => $tag['name'], 'short_name' => $tag['short_name']]);
      }

      $data['primary_key_field']  = 'item_tag_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_tag');
      $data['url_update'] = "stock/admin/modify_tag/";
      $data['url_delete'] = "stock/admin/delete_tag/";
      $data['url_create'] = "stock/admin/new_tag";

      return $this->display_view('Common\Views\items_list', $data);
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
      $data['items'] = [];
      $stockingPlaces = $this->stocking_place_model->findAll();

      $data['list_title'] = lang('stock_lang.title_stocking_places');
        
      $data['columns'] = ['name' => lang('stock_lang.field_name'),
                          'short_name' => lang('stock_lang.field_short_name')
                         ];
                          
      foreach ($stockingPlaces as $stockingPlace)
      {
        array_push($data['items'], ['stocking_place_id' => $stockingPlace['stocking_place_id'], 'name' => $stockingPlace['name'], 'short_name' => $stockingPlace['short']]);
      }

      $data['primary_key_field']  = 'stocking_place_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_stocking_place');
      $data['url_update'] = "stock/admin/modify_stocking_place/";
      $data['url_delete'] = "stock/admin/delete_stocking_place/";
      $data['url_create'] = "stock/admin/new_stocking_place";

      return $this->display_view('Common\Views\items_list', $data);
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
      $data['items'] = [];
      $suppliers = $this->supplier_model->findAll();

      $data['list_title'] = lang('stock_lang.title_suppliers');
        
      $data['columns'] = ['name'            => lang('stock_lang.field_name'),
                          'address_line1'   => lang('stock_lang.field_first_address_line'),
                          'address_line2'   => lang('stock_lang.field_second_address_line'),
                          'zip'             => lang('stock_lang.field_zip'),
                          'city'            => lang('stock_lang.field_city'),
                          'country'         => lang('stock_lang.field_country'),
                          'tel'             => lang('stock_lang.field_tel'),
                          'email'           => lang('stock_lang.field_email')
                         ];
                          
      foreach ($suppliers as $supplier)
      {
        array_push($data['items'], [
            'supplier_id'     => $supplier['supplier_id'], 
            'name'            => $supplier['name'], 
            'address_line1'   => $supplier['address_line1'],
            'address_line2'   => $supplier['address_line2'],
            'zip'             => $supplier['zip'],
            'city'            => $supplier['city'],
            'country'         => $supplier['country'],
            'tel'             => $supplier['tel'],
            'email'           => $supplier['email']
        ]);
      }

      $data['primary_key_field']  = 'supplier_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_supplier');
      $data['url_update'] = "stock/admin/modify_supplier/";
      $data['url_delete'] = "stock/admin/delete_supplier/";
      $data['url_create'] = "stock/admin/new_supplier";

      return $this->display_view('Common\Views\items_list', $data);
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
      $data['items'] = [];
      $itemGroups = $this->item_group_model->findAll();

      $data['list_title'] = lang('stock_lang.title_item_groups');
        
      $data['columns'] = ['name' => lang('stock_lang.field_name'),
                          'short_name' => lang('stock_lang.field_short_name')
                         ];
                          
      foreach ($itemGroups as $itemGroup)
      {
        array_push($data['items'], ['item_group_id' => $itemGroup['item_group_id'], 'name' => $itemGroup['name'], 'short_name' => $itemGroup['short_name']]);
      }

      $data['primary_key_field']  = 'item_group_id';
      $data['btn_create_label']   = lang('stock_lang.btn_add_item_group');
      $data['url_update'] = "stock/admin/modify_item_group/";
      $data['url_delete'] = "stock/admin/delete_item_group/";
      $data['url_create'] = "stock/admin/new_item_group";

      return $this->display_view('Common\Views\items_list', $data);
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
