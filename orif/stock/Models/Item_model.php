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

use CodeIgniter\Model;
use Stock\Models\MyModel;



class Item_model extends MyModel
{
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    /*
    protected $protected_attributes = ['item_id'];
    protected $belongs_to = ['supplier', 'stocking_place', 'item_condition', 'item_group',
                             'created_by_user' => ['primary_key' => 'created_by_user_id',
                                                   'model' => 'user_model'],
                             'modified_by_user' => ['primary_key' => 'modified_by_user_id',
                                                    'model' => 'user_model'],
                             'checked_by_user' => ['primary_key' => 'checked_by_user_id',
                                                   'model' => 'user_model']];
    protected $has_many = ['item_tag_links', 'loans', 'inventory_controls'];


    protected $after_get = ['get_inventory_number', 'get_image',
                            'get_warranty_status', 'get_current_loan',
                            'get_last_inventory_control', 'get_tags'];

    */
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
        // $this->allowedFields[] = 
    }

    
    protected function get_item_group_name($item, $short = false){
      if ($this->item_group_model==null){
        $this->item_group_model = new Item_group_model();
      }
      if ($short){
        $item->group = $this->item_group_model->getWhere(["item_group_id"=>$item->item_group_id])->getRow();
      }else{
        $item->group = $this->item_group_model->getWhere(["item_group_id"=>$item->item_group_id])->getRow()->name;
      }
      return $item->group;
    }

    protected function get_item_condition_name($item){

      if($this->item_condition_model==null){
        $this->item_condition_model = new Item_condition_model();
      }
      $item->condition = $this->item_condition_model->getWhere(["item_condition_id"=>$item->item_condition_id])->getRow();
      return $item->condition;
    }


    public function get_current_loan($item) {
      if(!is_null($item)) {
        if(is_null($this->loan_model)){
          $this->loan_model = new Loan_model();
        }
        helper('MY_date');
        
        $where = array('item_id'=>$item['item_id'], 'date<='=>mysqlDate('now'), 'real_return_date is NULL');

        $item['current_loan'] = $this->loan_model->asArray()->where($where)->find();

        /*
        if (is_null($item->current_loan)) {
          // ITEM IS NOT LOANED
          $bootstrap_label = '<span class="label label-success">'.html_escape($this->lang->line('lbl_loan_status_not_loaned')).'</span>';
        } else {
          // ITEM IS LOANED
          $bootstrap_label = '<span class="label label-warning">'.html_escape($this->lang->line('lbl_loan_status_loaned')).'</span>';
        } 
      
        $item->loan_bootstrap_label = $bootstrap_label;
      */

      }
        
      return $item['current_loan'];
      
    }

    protected function get_last_inventory_control($item)
    {
      if (!is_null($item)) {
        if(is_null($item->inventory_control_model)) {
          $this->inventory_control_model = new Inventory_control_model();
        }

        $query = $this->db->query("SELECT * FROM inventory_control WHERE item_id=" . $item->item_id);
        $item->inventory_controls = $query->getResultObject();
       // $inventory_controls->controller = $this->user_model->getResultObject()->where('');
    /*    $inventory_controls = $this->inventory_control_model->with('controller')
                                  ->get_many_by($where); */
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
    
    public function get_inventory_number($item)
    {
        $inventory_id = "";
        $inventory_number = "";

        if (!is_null($item)) {
            $inventory_id = $item['item_id'];
            
            // Add leading zeros to inventory_id
            for( $i = strlen($inventory_id) ; $i < INVENTORY_NUMBER_CHARS; $i++) {
                $inventory_id = "0".$inventory_id;
            }
            $inventory_id;

            $inventory_number = $item['inventory_prefix'].".".$inventory_id;
            $item['inventory_number'] = $inventory_number;
        }

        return $item['inventory_number'];
    }



}
