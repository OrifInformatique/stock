<?php
/**
 * Model Stocking_place this represents the stocking_place table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;

class Stocking_place_model extends Model
{
    protected $table='stocking_place';
    protected $primaryKey='stocking_place_id';
    protected $allowedFields=['name', 'short'];
}