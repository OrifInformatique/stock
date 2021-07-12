<?php
/**
 * Model Iventory_control this represents the iventory_control table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;
use Stock\Models\MyModel;

class Inventory_control_model extends MyModel
{
    protected $table='inventory_control';
    protected $primaryKey='inventory_control_id';
    protected $allowedFields=['item_id', 'controller_id', 'date', 'remarks'];
}