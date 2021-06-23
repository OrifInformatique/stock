<?php 
/**
 * Model Item tag this represents the item_tag table
 *
 * @author      Orif (ViDi,AeDa,)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;

class Item_tag_model extends Model
{
    protected $table = 'item_tag';
    protected $primaryKey = 'item_tag_id';
    protected $allowedFields = ['name', 'short_name'];
}