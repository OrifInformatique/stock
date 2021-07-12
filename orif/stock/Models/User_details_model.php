<?php
/**
 * Model User_details this represents the user_details table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;
use Stock\Models\MyModel;

class User_details_model extends MyModel
{
    protected $table = 'user_details';
    protected $primaryKey = 'fk_user';
    protected $allowedFields = ['lastname', 'firstname'];
}