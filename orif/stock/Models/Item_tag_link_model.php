<?php 

//if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Item tag link model
 * 
 * @author      Didier Viret, Simão Romano Schindler
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

namespace  Stock\Models;

use CodeIgniter\Model;
use Stock\Models\MyModel;



class Item_tag_link_model extends MyModel
{
    /* MY_Model variables definition */
    protected $table = 'item_tag_link';
    protected $primaryKey = 'item_tag_link_id';
    protected $allowedFields = ['item_tag_id', 'item_id'];


    public function initialize()
    {
        $this->item_model = new Item_model();
        $this->item_tag_model = new Item_tag_model();
    }

    public function get_tags($item){
        if(is_null($this->item_tag_model)){
            $this->item_tag_model = new Item_tag_model();
        }
        $tags = array();
        $tagIDs = $this->asArray()->where(['item_id'=>$item['item_id']])->findColumn('item_tag_id');

        foreach ($tagIDs as $tagID){
            array_push($tags, $this->item_tag_model->asArray()->where(['item_tag_id'=>$tagID])->find());
        }
        
        return $tags;
    }

    public function get_items($tag){
        if(is_null($this->item_model)){
            $this->item_model = new Item_model();
        }
        $items = array();
        $itemsIDs = $this->asArray()->where(['item_tag_id'=>$tag['item_tag_id']])->findColumn('item_id');

        foreach ($itemsIDs as $itemID){
            array_push($items, $this->item_model->asArray()->where(['item_id'=>$itemID])->find());
        }
        
        return $items;
    }
}