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

use Stock\Models\MyModel;

class Item_tag_link_model extends MyModel
{
    /* MY_Model variables definition */
    protected $table = 'item_tag_link';
    protected $primaryKey = 'item_tag_link_id';
    protected $allowedFields = ['item_tag_id', 'item_common_id'];

    public function getTags($item_common){
        $item_tag_model = new Item_tag_model();

        $tags = array();
        $tagIDs = $this->asArray()->where(['item_common_id'=>$item_common['item_common_id']])->findColumn('item_tag_id');

        if (!is_null($tagIDs)) {
            foreach ($tagIDs as $tagID){
                array_push($tags, $item_tag_model->asArray()->where(['item_tag_id'=>$tagID])->find());
            }
        }

        return $tags;
    }

    public function get_items($tag){
        $item_model = new Item_model();

        $items = array();
        $itemsCommonIDs = $this->asArray()->where(['item_tag_id'=>$tag['item_tag_id']])->findColumn('item_common_id');

        if (!is_null($itemsCommonIDs)) {
            foreach ($itemsCommonIDs as $itemCommonID){
                array_push($items, $item_model->asArray()->where(['item_common_id'=>$itemCommonID])->find());
            }
        }

        return $items;
    }
}
