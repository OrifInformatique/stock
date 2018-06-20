<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Item model
 *
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class Item_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'item';
    protected $primary_key = 'item_id';
    protected $protected_attributes = ['item_id'];
    protected $belongs_to = ['supplier', 'stocking_place', 'item_condition', 'item_group',
                             'created_by_user' => ['primary_key' => 'created_by_user_id',
                                                   'model' => 'user_model'],
                             'modified_by_user' => ['primary_key' => 'modified_by_user_id',
                                                    'model' => 'user_model'],
                             'checked_by_user' => ['primary_key' => 'checked_by_user_id',
                                                   'model' => 'user_model']];
    protected $has_many = ['item_tag_links', 'loans', 'inventory_controls'];

    /* MY_Model callback methods */
    protected $after_get = ['get_inventory_id', 'get_inventory_number_complete', 
    						'get_image', 'get_warranty_status',
                            'get_current_loan', 'get_last_inventory_control',
                            'get_tags'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }

	/*
	 * Returns the id that will receive the next item
	 */
	public function get_future_id()
	{
		$connection = mysqli_connect("localhost","root","");
			$result = mysqli_query($connection, "SHOW TABLE STATUS FROM `stock` LIKE 'item'");
		mysqli_close($connection);

		while ($row = mysqli_fetch_array($result))
		{
			$value = $row['Auto_increment'];
		}

		return $value;
	}

	/*
	 * Returns the seconde part of inventory number : The ID with leading "0"
	 */
	public function get_inventory_id($item)
	{
		$inventory_id = "";

		if (!is_null($item)) {
			$inventory_id = $item->item_id;

	    	for( $i = strlen($inventory_id) ; $i < INVENTORY_NUMBER_CHARS; $i++) {
	        	$inventory_id = "0".$inventory_id;
	        }

	        $inventory_id = ".".$inventory_id;
    	}

    	$item->inventory_id = $inventory_id;
    	return $item;
	}

	/*
	 * Returns the complete inventory number,
	 * concatenation of inventory_number and inventory_id.
	 */
	public function get_inventory_number_complete($item)
	{
		$inventory_number_complete = "";

		if (!is_null($item)) {
			$inventory_number_complete = $item->inventory_number.$item->inventory_id;
    	}

    	$item->inventory_number_complete = $inventory_number_complete;
    	return $item;
	}

    /**
    * If no image is set, use "no_image.png"
    */
    protected function get_image($item)
    {		
        if (!is_null($item)) {
			if (is_null($item->image))
			{
				$item->image = 'no_image.png';
			}
		}

        return $item;
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
        if (!is_null($item)) {
			if (empty($item->buying_date) || empty($item->warranty_duration))
			{
				$item->warranty_status = 0;
			}
			else
			{
				$buying_date = new DateTime($item->buying_date);
				$current_date = new DateTime("now");

				$time_spent = $buying_date->diff($current_date);
				$months_spent = ($time_spent->y * 12) + $time_spent->m;

				$warranty_left = $item->warranty_duration - $months_spent;

				if ($warranty_left > 3)
				{
					// UNDER WARRANTY
					$item->warranty_status = 1;
				}
				elseif ($warranty_left > 0)
				{
					// WARRANTY EXPIRES SOON
					$item->warranty_status = 2;
				}
				else
				{
					// WARRANTY EXPIRED
					$item->warranty_status = 3;
				}
			}
        }

        return $item;
    }

    /**
    * Get current loan related to this item, if one exists
    * Also return a loan_bootstrap_label with color depending of loan status
    *
    * Attributes names : current_loan (NULL if item is currently not loaned)
    *                    loan_bootstrap_label (color depending of loan status)
    */
    protected function get_current_loan($item)
    {
        if (!is_null($item)) {
			$this->load->model('loan_model');
			$this->load->helper('date');

			$where = "item_id=".$item->item_id." AND ".
					 "date<='".mysqlDate('now')."' AND ".
					 "real_return_date IS NULL";

			$item->current_loan = $this->loan_model->get_by($where);

			if (is_null($item->current_loan)) {
				// ITEM IS NOT LOANED
				$bootstrap_label = '<span class="label label-success">'.html_escape($this->lang->line('lbl_loan_status_not_loaned')).'</span>';
			} else {
				// ITEM IS LOANED
				$bootstrap_label = '<span class="label label-warning">'.html_escape($this->lang->line('lbl_loan_status_loaned')).'</span>';
			}
			$item->loan_bootstrap_label = $bootstrap_label;
		}

        return $item;
    }

    /**
    * Get the last inventory control related to this item, if one exists
    *
    * Attributes names : last_inventory_control (NULL if none)
    */
    protected function get_last_inventory_control($item)
    {
        if (!is_null($item)) {
			$this->load->model('inventory_control_model');

			$where = "item_id=".$item->item_id;

			$inventory_controls = $this->inventory_control_model->with('controller')
																->get_many_by($where);
			$last_control = NULL;

			if (!is_null($inventory_controls)){
				foreach ($inventory_controls as $control) {
					// Select the last control (biggest date)
					if (is_null($last_control)) {
						$last_control = $control;
					} elseif ($control->date > $last_control->date) {
						$last_control = $control;
					}
				}
			}

			$item->last_inventory_control = $last_control;
		}

        return $item;
    }

    /**
    * Get the tags related to this item, formated in an array
    *
    * Attribute name : tags (NULL if no tag is related to this item)
    */
    protected function get_tags($item)
    {
		if (!is_null($item)) {
			$this->load->model('item_tag_link_model');

			$tag_links = $this->item_tag_link_model->with('item_tag')
                                               ->get_many_by('item_id', $item->item_id);

			if (!empty($tag_links))
			{
				foreach ($tag_links as $tag_link)
				{
					$tags_array[$tag_link->item_tag->item_tag_id] = $tag_link->item_tag->name;
				}

				$item->tags = $tags_array;
			}
			else
			{
				$item->tags = NULL;
			}
		}

        return $item;
    }
    
    /**
     * Searching item(s) on the database depending on filters
     * @param array ($_GET) $get The arrays of filters
     * @return array The array of item(s) found
     */
    function search_filter($get){
        $output['title'] = $this->lang->line('page_item_list');

        // Load list of elements to display as filters
        $this->load->model('item_tag_model');
        $output['item_tags'] = $this->item_tag_model->dropdown('name');
        $this->load->model('item_condition_model');
        $output['item_conditions'] = $this->item_condition_model->dropdown('name');
        $this->load->model('item_group_model');
        $output['item_groups'] = $this->item_group_model->dropdown('name');
        $this->load->model('stocking_place_model');
        $output['stocking_places'] = $this->stocking_place_model->dropdown('name');

        // Store URL to make possible to come back later (from item detail for example)
        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
          $_SESSION['items_list_url'] = current_url().'?'.$_SERVER['QUERY_STRING'];
        } else {
          $_SESSION['items_list_url'] = current_url();
        }

        // Initialize a global WHERE clause for filtering
        $where_itemsFilters = '';

        /*********************
        ** TEXT SEARCH FILTER
        **********************/
        $where_textSearchFilter = '';

        if (isset($get['ts'])) {
          $text_search_content = $get['ts'];

          // Getting the inventory_number and the item_id as separate variables (separate at '.')
          $inventory_id = explode('.',$text_search_content);
          $inventory_number = $inventory_id[0];
          $item_id = isset($inventory_id[1])?$inventory_id[1]:$inventory_id[0]; // If there is no '.', both variableshave the same values then

          // Prepare WHERE clause
          $where_textSearchFilter .= '(';
          $where_textSearchFilter .=
            "name LIKE '%".$text_search_content."%' "
           ."OR description LIKE '%".$text_search_content."%' "
           .($inventory_number  != ""?"OR inventory_number LIKE '%".$inventory_number."%' ":"") // If $inventory_number is empty, don't filter on invenotry_number (it will return *all* the items)
           ."OR item_id = ".intval($item_id)." "
           ."OR serial_number LIKE '%".$text_search_content."%'";
          $where_textSearchFilter .= ')';

          // Add this part of WHERE clause to the global WHERE clause
          if ($where_itemsFilters != '')
          {
            // Add new filter after existing filters
            $where_itemsFilters .= ' AND ';
          }
          $where_itemsFilters .= $where_textSearchFilter;

          // Send back the text search to keep it in input field
          $output['text_search_content'] = $text_search_content;

        } else {
          // No text submited for filtering
          $output['text_search_content'] = '';
        }

        /*********************
        ** ITEM CONDITION FILTER
        ** Default filtering for "functional" items
        **********************/
        $FUNCTIONAL_ITEM_CONDITION_ID = 10;
        $where_itemConditionFilter = '';

        if (isset($get['c'])) {
          $item_conditions_selection = $get['c'];

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

          // Send back the conditions selection to keep them selected
          $output['item_conditions_selection'] = $item_conditions_selection;

        } else {
          // No condition selected for filtering, default filtering for "functional" items
          if ($where_itemsFilters != '')
          {
            // Add new filter after existing filters
            $where_itemsFilters .= ' AND ';
          }
          $where_itemsFilters .= '(item_condition_id='.$FUNCTIONAL_ITEM_CONDITION_ID.')';

          // Send back the "functional" condition selection
          $output['item_conditions_selection'] = [$FUNCTIONAL_ITEM_CONDITION_ID];
        }

        /*********************
        ** ITEM GROUP FILTER
        **********************/
        $where_itemGroupFilter = '';

        if (isset($get['g'])) {
          $item_groups_selection = $get['g'];

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

          // Send back the groups selection to keep them selected
          $output['item_groups_selection'] = $item_groups_selection;

        } else {
          // No group selected for filtering
          $output['item_groups_selection'] = '';
        }

        /*********************
        ** STOCKING PLACE FILTER
        **********************/
        $where_stockingPlaceFilter = '';

        if (isset($get['s'])) {
          $stocking_places_selection = $get['s'];

          // Prepare WHERE clause
          $where_stockingPlaceFilter .= '(';
          foreach ($stocking_places_selection as $stocking_place_id) {
            $where_stockingPlaceFilter .= 'stocking_place_id='.$stocking_place_id.' OR ';
          }
          // Remove the last " OR "
          $where_stockingPlaceFilter = substr($where_stockingPlaceFilter, 0, -4);
          $where_stockingPlaceFilter .= ')';

          // Add this part of WHERE clause to the global WHERE clause
          if ($where_itemsFilters != '')
          {
            // Add new filter after existing filters
            $where_itemsFilters .= ' AND ';
          }
          $where_itemsFilters .= $where_stockingPlaceFilter;

          // Send back the stocking places selection to keep them selected
          $output['stocking_places_selection'] = $stocking_places_selection;

        } else {
          // No stocking place selected for filtering
          $output['stocking_places_selection'] = '';
        }

        /*********************
        ** ITEM TAGS FILTER
        **********************/
        $where_itemTagsFilter = '';

        if (isset($get['t'])) {
          // Get a list of item_tag_link elements
          $this->load->model('item_tag_link_model');
          $item_tags_selection = $get['t'];

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
          $where_itemTagsFilter = substr($where_itemTagsFilter, 0, -4);
          $where_itemTagsFilter .= ')';

          // Add this part of WHERE clause to the global WHERE clause
          if ($where_itemsFilters != '')
          {
            // Add new filter after existing filters
            $where_itemsFilters .= ' AND ';
          }
          $where_itemsFilters .= $where_itemTagsFilter;

          // Send back the tags selection to keep them selected
          $output['item_tags_selection'] = $item_tags_selection;

        } else {
          // No tags selected for filtering
          $output['item_tags_selection'] = '';
        }


        /*********************
        ** GET FILTERED ITEMS
        **********************/
        if ($where_itemsFilters == '')
        {
          // No filter, get all items
          $output["items"] = $this->with('stocking_place')
                                              ->with('item_condition')
                                              ->get_all();
        } else {
          // Get filtered items
          $output["items"] = $this->with('stocking_place')
                                              ->with('item_condition')
                                              ->get_many_by($where_itemsFilters);
        }
            return $output;
    }
}
