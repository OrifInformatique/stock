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

class Supplier_model extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $allowedFields = ['name', 'address_line1', 'address_line2', 'zip', 'city', 'country', 'tel', 'email'];
}