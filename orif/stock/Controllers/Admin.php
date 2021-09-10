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
use Stock\Models\Item_tag_link_model;
use Stock\Models\Stocking_place_model;
use Stock\Models\Supplier_model;
use Stock\Models\Item_group_model;
use Stock\Models\Item_model;


class Admin extends BaseController
{
    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Set Access level before calling parent constructor
        // Accessibility reserved to admin users
        $this->access_level=config('\User\Config\UserConfig')->access_lvl_admin;

        // Set Access level before calling parent constructor
        parent::initController($request,$response,$logger);

        // Load required helpers
        helper('form');

        // Load required services
        $this->validation = \Config\Services::validation();

        // Load required models
        $this->item_tag_model         = new Item_tag_model();
        $this->item_tag_link_model    = new Item_tag_link_model();
        $this->stocking_place_model   = new Stocking_place_model();
        $this->supplier_model         = new Supplier_model();
        $this->item_group_model       = new Item_group_model();
        $this->item_model             = new Item_model();

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
      if(is_null($this->item_tag_model->withDeleted()->find($id))) 
      {
        return redirect()->to("/stock/admin/view_tags");
      }

      if (!empty($_POST)) 
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[item_tag.name,item_tag_id,{item_tag_id}]',
          'short_name'      => 'required|max_length[3]|is_unique[item_tag.short_name,item_tag_id,{item_tag_id}]'
          ];

        if($this->validate($validationRules)) 
        {
            $this->item_tag_model->update($id, $_POST);
            
            return redirect()->to('/stock/admin/view_tags');
        }
	  
      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      } 
      else 
      {
        $output['tag'] = $this->item_tag_model->withDeleted()->find($id);
      }

      if(!is_null($this->item_tag_model->withDeleted()->find($id)))
      {
        $output['tag'] = $this->item_tag_model->withDeleted()->find($id);
      } 
      else 
      {
        $output["missing_tag"] = TRUE;
      }

      $this->display_view('Stock\admin\tags\form', $output);
    }

    /**
    * Create a new tag
    */
    public function new_tag()
    {
      if (!empty($_POST)) 
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[item_tag.name]',
          'short_name'      => 'required|max_length[3]|is_unique[item_tag.short_name]'
          ];

        if($this->validate($validationRules))
        {
          $this->item_tag_model->insert($_POST);

          return redirect()->to("/stock/admin/view_tags/");
        }
	    }

      $this->display_view('Stock\admin\tags\form');
    }
    
    /**
    * Delete a tag. 
    * If $action is NULL, a confirmation will be shown. If it is anything else, the tag will be deleted.
    */
    public function delete_tag($id = NULL, $action = 0) 
    {
      if(is_null($this->item_tag_model->withDeleted()->find($id))) 
      {
        return redirect()->to('/stock/admin/view_tags');
      }

      switch ($action)
      {
        case 0:
          $output = array(
            'tag' => $this->item_tag_model->withDeleted()->find($id)
          );
          $this->display_view('\Stock\admin\tags\delete', $output);
          break;
          
          case 1: // Soft Delete item_tag
            $this->item_tag_model->delete($id, FALSE);
            return redirect()->to('/stock/admin/view_tags');
            break;

          case 2: // Delete item_tag_link and item_tag
            $this->item_tag_link_model->where('item_tag_id', $id)->delete();
            $this->item_tag_model->delete($id, TRUE);
            return redirect()->to('/stock/admin/view_tags');
          
          default: // Do nothing
            return redirect()->to('/stock/admin/view_tags');
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
      if (is_null($this->stocking_place_model->find($id))) 
      {
        redirect()->to("/admin/view_stocking_places");
      }

      if ( ! empty($_POST)) 
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[stocking_place.name,name,{name}]',
          'short'           => 'required|max_length[10]|is_unique[stocking_place.short,short,{short}]'
          ];

        if ($this->validate($validationRules)) 
        {
            $this->stocking_place_model->update($id, $_POST);
            
            return redirect()->to('/stock/admin/view_stocking_places');
        }
	  
      // The values of the tag are loaded only if no form is submitted, otherwise we don't need them and it would disturb the form re-population
      } 
      else 
      {
        $output['stocking_place'] = $this->stocking_place_model->withDeleted()->find($id);
      }

      if(!is_null($this->stocking_place_model->withDeleted()->find($id)))
      {
        $output['stocking_place'] = $this->stocking_place_model->withDeleted()->find($id);
      } 
      else 
      {
        $output["missing_stocking_place"] = TRUE;
      }

      $this->display_view('Stock\admin\stocking_places\form', $output);
    }

    /**
    * Create a new stocking_place
    */
    public function new_stocking_place()
    {
      if (!empty($_POST)) 
      {
        // VALIDATION
        $validationRules = [
          'name'            => 'required|min_length[3]|max_length[45]|is_unique[stocking_place.name]',
          'short'           => 'required|max_length[10]|is_unique[stocking_place.short]'
          ];

        if($this->validate($validationRules))
        {
          $this->stocking_place_model->insert($_POST);

          return redirect()->to("/stock/admin/view_stocking_places");
        }
	    }

      $this->display_view('Stock\admin\stocking_places\form');
    }
    
    /**
    * Delete the stocking place $id. If $action is null, a confirmation will be shown
    */
    public function delete_stocking_place($id = NULL, $action = 0)
    {
      if(is_null($this->stocking_place_model->withDeleted()->find($id))) 
      {
        return redirect()->to('/stock/admin/view_stocking_places');
      }

      switch ($action)
      {
        case 0:
          $output = array(
            'stocking_place' => $this->stocking_place_model->withDeleted()->find($id)
          );
          $this->display_view('\Stock\admin\stocking_places\delete', $output);
          break;
          
          case 1: // Soft Delete item_tag
            $this->stocking_place_model->delete($id, FALSE);
            return redirect()->to('/stock/admin/view_stocking_places');
            break;

          case 2: // Delete item_tag_link and item_tag
            $this->stocking_place_model->delete($id, TRUE);
            return redirect()->to('/stock/admin/view_stocking_places');
          
          default: // Do nothing
            return redirect()->to('/stock/admin/view_stocking_places');
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
