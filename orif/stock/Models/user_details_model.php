<?php
/**
 * Model User_model_old this represents the user table (CI3)
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