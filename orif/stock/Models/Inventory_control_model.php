<?php
/**
 * Model Supplier_model this represents the supplier table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;

class Inventory_control_model extends Model
{
    protected $table='inventory_control';
    protected $primaryKey='inventory_control_id';
    protected $allowedFields=['item_id', 'controller_id', 'date', 'remarks'];
}