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
    protected $has_many = ['item_tag_links', 'loans'];

    /* MY_Model callback methods */
    protected $after_get = ['get_image', 'get_warranty_status'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * If no image is set, use "no_image.png"
    */
    protected function get_image($item)
    {
        if (is_null($item->image))
        {
            $item->image = 'no_image.png';
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

        return $item;
    }


/*****************************************************/
/*** TO BE REPLACED (COPIED FROM OLD MODEL) **********/
/*****************************************************/
  
    /* *** Updates item's image in database *** */
    
    public function set_image($id, $image_file_name)
    {
        
        $update_array = array(
                'image' => $image_file_name
        );
        
        $this->db->where('item_id', $id);
        $this->db->update('item', $update_array);
        
            
    }
    
    /* *** Delete tag from database *** */
    
    public function delete_tag($id)
    {
        $this->db->where('item_tag_link_id', $id);
        $this->db->delete('item_tag_link');  
    
    }
    
    /* *** Create tag in database *** */
    
    public function create_tag($id, $tag_id)
    {
        
        $query = $this->db->get_where('item_tag_link',  array('item_id' => $id, 'item_tag_id' => $tag_id));
        
        if($query->num_rows() > 0) 
            return false;
        
        $array_create = array(
                'item_id' => $id,
                'item_tag_id' => $tag_id
        );
        
        $this->db->insert('item_tag_link', $array_create);
    }
    
    /* *** Check date format *** */
    
    function _validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') == $date;
    }
}