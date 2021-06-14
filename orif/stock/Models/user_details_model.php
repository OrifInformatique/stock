<?php
/**
 * Model User_details this represents the user_details table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

class User_details_model extends \CodeIgniter\Model
{
    protected $table='user_details';
    protected $primaryKey='id';
    protected $allowedFields=['lastname', 'firstname'];
}