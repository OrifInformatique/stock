<?php
/**
 * Model Supplier_model this represents the supplier table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use Stock\Models\MyModel;
use Stock\Models\Item_model;

class Supplier_model extends MyModel
{
    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $allowedFields = ['name', 'address_line1', 'address_line2', 'zip', 'city', 'country', 'tel', 'email'];

    public function getItems($supplier_id)
    {
        $itemModel = new Item_model();

        return $itemModel->asArray()
                         ->where('supplier_id', $supplier_id)
                         ->findAll();
    }
}