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
    protected $after_get = ['get_image', 'get_warranty_status',
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
}
