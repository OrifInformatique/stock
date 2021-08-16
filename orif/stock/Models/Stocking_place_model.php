<?php
/**
 * Model Stocking_place this represents the stocking_place table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use Stock\Models\MyModel;
use Stock\Models\Item_model;

class Stocking_place_model extends MyModel
{
    protected $table = 'stocking_place';
    protected $primaryKey = 'stocking_place_id';
    protected $allowedFields = ['name', 'short'];

    public function getItems($stocking_place_id)
    {
        $itemModel = new Item_model();

        return $itemModel->asArray()
                         ->where('stocking_place_id', $stocking_place_id)
                         ->findAll();
    }
}