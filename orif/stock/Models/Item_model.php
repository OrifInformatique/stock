<?php 
namespace  Stock\Models;

//if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * The Item model
 *
 * @author      Didier Viret, Simão Romano Schindler
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

use Stock\Models\Item_condition_model;
use Stock\Models\Item_group_model;
use Stock\Models\Supplier_model;
use Stock\Models\Stocking_place_model;
use User\Models\User_model;
use Stock\Models\Loan_model;
use Stock\Models\Inventory_control_model;
use \DateTime;

use CodeIgniter\Model;
use Stock\Models\MyModel;



class Item_model extends MyModel
{
    protected $table = 'item';
    protected $primaryKey = 'item_id';


    /**
    * Constructor
    */
    public function initialize()
    {
        $this->user_model = new User_model();
        $this->supplier_model = new Supplier_model();
        $this->stocking_place_model = new Stocking_place_model();
        $this->item_condition_model = new Item_condition_model();
        $this->item_group_model = new Item_group_model();
        $this->loan_model = new Loan_model();
        $this->inventory_control_model = new Inventory_control_model();
    }


    /*
     * Returns the id that will receive the next item
     */
    public function get_future_id()
    {
      $query = $this->db->query("SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'item'");

      return $query;
    }

    
    protected function get_item_group($item){
      if ($this->item_group_model==null){
        $this->item_group_model = new Item_group_model();
      }
      $itemGroup = $this->item_group_model->asArray()->where(["item_group_id"=>$item->item_group_id])->first();
      return $itemGroup;
    }

    protected function get_item_condition($item){

      if($this->item_condition_model==null){
        $this->item_condition_model = new Item_condition_model();
      }
      $itemCondition = $this->item_condition_model->get_bootstrap_label($this->item_condition_model->asArray()->where(["item_condition_id"=>$item['item_condition_id']])->first());


      return $itemCondition;
    }


    public function get_current_loan($item) {

        if(is_null($this->loan_model)){
          $this->loan_model = new Loan_model();
        }
        helper('MY_date');
        
        $where = array('item_id'=>$item['item_id'], 'date<='=>mysqlDate('now'), 'real_return_date is NULL');

        $current_loan = $this->loan_model->asArray()->where($where)->first();

        
        if (is_null($current_loan)) {
          // ITEM IS NOT LOANED
          $current_loan['bootstrap_label'] = '<span class="label label-success">'.htmlspecialchars(lang('MY_application.lbl_loan_status_not_loaned')).'</span>';
        } else {
          // ITEM IS LOANED
          $current_loan['bootstrap_label'] = '<span class="label label-warning">'.htmlspecialchars(lang('MY_application.lbl_loan_status_loaned')).'</span>';
        } 
      
      return $current_loan;
      
    }


    protected function get_last_inventory_control($item)
    {
      if (!is_null($item)) 
      {
        if(is_null($this->inventory_control_model)) 
        {
          $this->inventory_control_model = new Inventory_control_model();
        }

        $query = $this->db->query("SELECT * FROM inventory_control WHERE item_id =" . $item['item_id']);
        $item['inventory_controls'] = $query->getResultObject();
        $inventory_controls = $item['inventory_controls'];

        $last_control = NULL;

        if (!is_null($inventory_controls))
        {
          foreach ($inventory_controls as $control) 
          {
            // Select the last control (biggest date)
            if (is_null($last_control)) 
            {
              $last_control = $control;
            } 
            else if ($control['date'] > $last_control['date']) 
            {
              $last_control = $control;
            }
          }
        }

        $item['last_inventory_control'] = $last_control;
      }
      return $item;
    }


    protected function get_tags($item){
      if(is_null($this->item_tag_link_model)){
        $this->item_tag_link_model = new Item_tag_link_model();
      }
      $tag_links = $this->item_tag_link_model->get_tags($item);

    }


    public function get_image($item)
    {		
        if (!is_null($item) && is_null($item['image']))
        {
            $item['image'] = ITEM_NO_IMAGE;
        }

        return $item['image'];
    }

      
    /**
    * Calculate a warranty status based on buying date and warranty duration
    *
    * Attribute name : warranty_status
    *
    * Values :
    *           0 : NO WARRANTY STATUS (buying date or warranty duration is not set)
    *           1 : UNDER WARRANTY
    *           2 : WARRANTY EXPIRES SOON (less than 3 months)
    *           3 : WARRANTY EXPIRED
    */
    protected function get_warranty_status($item)
    {
      if (!is_null($item)) 
      {
        if (empty($item['buying_date']) || empty($item['warranty_duration']))
        {
          $item['warranty_status'] = 0;
        }
        else
        {
          $buying_date = new DateTime($item['buying_date']);
          $current_date = new DateTime("now");

          $time_spent = $buying_date->diff($current_date);
          $months_spent = ($time_spent->y * 12) + $time_spent->m;

          $warranty_left = $item['warranty_duration'] - $months_spent;

          if ($warranty_left > 3)
          {
            // UNDER WARRANTY
            $item['warranty_status'] = 1;
          }
          elseif ($warranty_left > 0)
          {
            // WARRANTY EXPIRES SOON
            $item['warranty_status'] = 2;
          }
          else
          {
            // WARRANTY EXPIRED
            $item['warranty_status'] = 3;
          }
        }
      }
      return $item;
    }
  


    /**
     * Searching item(s) in the database depending on filters
     * @param array $filters The array of filters
     * @return An array of corresponding items
     */
    public function get_filtered($filters){

      if (is_null($this->stocking_place_model)){
        $this->stocking_place_model = new Stocking_place_model();
      } 

      if(is_null($this->item_condition_model)){
        $this->item_condition_model = new Item_condition_model();
      }

      // Initialize a global WHERE clause for filtering
      $where_itemsFilters = '';

      /*********************
      ** TEXT SEARCH FILTER
      **********************/
      $where_textSearchFilter = '';

      if (isset($filters['ts']) && $filters['ts']!='') {
        $text_search_content = $filters['ts'];

        // If the search text is an inventory number, separate the ID from the rest (ID is after the last '.')
        $inventory_exploded = explode('.', $text_search_content);
        $inventory_lastPart = end($inventory_exploded);

        if (is_numeric($inventory_lastPart)) {
          // The last part of the search text is probably the item ID
          $item_id = intval($inventory_lastPart);

          // The other part(s) compose the inventory_number
          $inventory_number = '';
          for ($i = 0; $i < (count($inventory_exploded) - 1); $i++) {
            if ($i > 0) {
              $inventory_number .= '.';
            }
            $inventory_number .= $inventory_exploded[$i];
          }

        } else {
          // The item ID is probably not in the search text.
          $inventory_number = $text_search_content;
        }

        // Prepare WHERE clause
        $where_textSearchFilter .= '(';
        $where_textSearchFilter .=
          "name LIKE '%".$text_search_content."%' "
          ."OR description LIKE '%".$text_search_content."%' "
          ."OR serial_number LIKE '%".$text_search_content."%' ";

        if (isset($item_id)) {
          if (isset($inventory_number) && $inventory_number != '') {
            $where_textSearchFilter .= "OR (item_id = ".$item_id." AND inventory_prefix LIKE '%".$inventory_number."%') ";
          } else {
            $where_textSearchFilter .= "OR item_id = ".$item_id." ";
          }
        } else {
          $where_textSearchFilter .= "OR inventory_prefix LIKE '%".$text_search_content."%' ";
        }
        $where_textSearchFilter .= ')';

        // Add this part of WHERE clause to the global WHERE clause
        if ($where_itemsFilters != '')
        {
          // Add new filter after existing filters
          $where_itemsFilters .= ' AND ';
        }
        $where_itemsFilters .= $where_textSearchFilter;
      }

      /*********************
      ** ITEM CONDITION FILTER
      ** Default filtering for "functional" items
      **********************/
      $where_itemConditionFilter = '';

      if (isset($filters['c'])) {
        $item_conditions_selection = $filters['c'];

        // Prepare WHERE clause
        $where_itemConditionFilter .= '(';
        foreach ($item_conditions_selection as $item_condition_id) {
          $where_itemConditionFilter .= 'item_condition_id='.$item_condition_id.' OR ';
        }
        // Remove the last " OR "
        $where_itemConditionFilter = substr($where_itemConditionFilter, 0, -4);
        $where_itemConditionFilter .= ')';

        // Add this part of WHERE clause to the global WHERE clause
        if ($where_itemsFilters != '')
        {
          // Add new filter after existing filters
          $where_itemsFilters .= ' AND ';
        }
        $where_itemsFilters .= $where_itemConditionFilter;
      }

      /*********************
      ** ITEM GROUP FILTER
      **********************/
      $where_itemGroupFilter = '';

      if (isset($filters['g'])) {
        $item_groups_selection = $filters['g'];

        // Prepare WHERE clause
        $where_itemGroupFilter .= '(';
        foreach ($item_groups_selection as $item_group_id) {
          $where_itemGroupFilter .= 'item_group_id='.$item_group_id.' OR ';
        }
        // Remove the last " OR "
        $where_itemGroupFilter = substr($where_itemGroupFilter, 0, -4);
        $where_itemGroupFilter .= ')';

        // Add this part of WHERE clause to the global WHERE clause
        if ($where_itemsFilters != '')
        {
          // Add new filter after existing filters
          $where_itemsFilters .= ' AND ';
        }
        $where_itemsFilters .= $where_itemGroupFilter;
      }

      /*********************
      ** STOCKING PLACE FILTER
      **********************/
      $where_stockingPlaceFilter = '';
      if (isset($filters['s'])) {
        $stocking_places_selection = $filters['s'];

        // Prepare WHERE clause
        $where_stockingPlaceFilter .= '(';
        foreach ($stocking_places_selection as $stocking_place_id) {
          $where_stockingPlaceFilter .= 'stocking_place_id='.$stocking_place_id.' OR ';
        }
        // Remove the last " OR "
        if($where_stockingPlaceFilter != "(") {
          $where_stockingPlaceFilter = substr($where_stockingPlaceFilter, 0, -4);
          $where_stockingPlaceFilter .= ')';
        } else {
          $where_stockingPlaceFilter .= '';
        }

        // Add this part of WHERE clause to the global WHERE clause
        if ($where_itemsFilters != '')
        {
          // Add new filter after existing filters
          $where_itemsFilters .= ' AND ';
        }
        $where_itemsFilters .= $where_stockingPlaceFilter;
      }

      /*********************
      ** ITEM TAGS FILTER
      **********************/
      $where_itemTagsFilter = '';

      if (isset($filters['t'])) {
        // Get a list of item_tag_link elements
        $this->load->model('item_tag_link_model');
        $item_tags_selection = $filters['t'];

        $where_itemTagLinks = '';
        foreach ($item_tags_selection as $item_tag) {
          $where_itemTagLinks .= 'item_tag_id='.$item_tag.' OR ';
        }
        // Remove the last " OR "
        $where_itemTagLinks = substr($where_itemTagLinks, 0, -4);

        $item_tag_links = $this->item_tag_link_model->get_many_by($where_itemTagLinks);

        // Prepare WHERE clause for all corresponding items
        $where_itemTagsFilter .= '(';
        foreach ($item_tag_links as $item_tag_link) {
          $where_itemTagsFilter .= 'item_id='.$item_tag_link->item_id.' OR ';
        }
        // Remove the last " OR "
        if($where_itemTagsFilter != "(") {
          $where_itemTagsFilter = substr($where_itemTagsFilter, 0, -4);
          $where_itemTagsFilter .= ')';
        } else {
          // No item_tag_link found : no item correspond to the filter.
          // We use "item_id=-1" filter to return no item.
          $where_itemTagsFilter = 'item_id=-1';
        }

        // Add this part of WHERE clause to the global WHERE clause
        if ($where_itemsFilters != '')
        {
          // Add new filter after existing filters
          $where_itemsFilters .= ' AND ';
        }
        $where_itemsFilters .= $where_itemTagsFilter;
      }


      /*********************
      ** GET FILTERED ITEMS
      **********************/
      if ($where_itemsFilters == '')
      {
        // No filter, get all items
        $items = $this->asArray()->find();
      } else {
        // Get filtered items
        $items = $this->asArray()->where($where_itemsFilters)->find();
      }


      foreach ($items as &$item){
        $item['stocking_place'] = $this->stocking_place_model->asArray()->where(['stocking_place_id'=>$item['stocking_place_id']])->first();
        $item['item_condition'] = $this->item_condition_model->asArray()->where(['item_condition_id'=>$item['item_condition_id']])->first();
        $item['condition'] = $this->get_item_condition($item);
        $item['current_loan'] = $this->get_current_loan($item);
      }

      
      return $items;
  }


} 
