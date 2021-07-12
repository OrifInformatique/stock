<?php 
/**
 * Model Item tag this represents the item_tag table
 *
 * @author      Orif (ViDi,AeDa,RoSi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;
use Stock\Models\MyModel;

class Item_tag_model extends MyModel
{
    protected $table = 'item_tag';
    protected $primaryKey = 'item_tag_id';
    protected $allowedFields = ['name', 'short_name'];

    public function initialize(){
        $this->item_tag_link_model = new Item_tag_link_model();
        $this->item_model = new Item_model();
    }

    public function get_items($tag){
        if(is_null($this->item_tag_link_model)){
            $this->item_tag_link_model = new Item_tag_link_model();
        }
        $items = $this->item_tag_link_model->get_items($tag);
        return $items;
    }

}