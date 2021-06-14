<?php
/**
 * Model User_model_old this represents the user table (CI3)
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace Stock\Models;

class User_model_old extends \CodeIgniter\Model
{
    protected $table='user';
    protected $primaryKey='user_id';
    protected $allowedFields=['lastname', 'firstname', 'is_active'];
}