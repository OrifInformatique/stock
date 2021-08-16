<?php
/**
 * Model Iventory_control this represents the iventory_control table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use Stock\Models\MyModel;
use User\Models\User_model;
use Stock\Models\Item_model;

class Inventory_control_model extends MyModel
{
    protected $table='inventory_control';
    protected $primaryKey='inventory_control_id';
    protected $allowedFields=['item_id', 'controller_id', 'date', 'remarks'];

    public function getItem($fk_item)
    {
        $itemModel = new Item_model();

        return $itemModel->asArray()
                         ->where('item_id', $fk_item)
                         ->first();
    }

    public function getUser($fk_user)
    {
        $userModel = new User_model();

        return $userModel->asArray()
                         ->where('id', $fk_user)
                         ->first();
    }
}