<?php
/**
 * Model User_details this represents the user_details table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use Stock\Models\MyModel;
use User\Models\User_model;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;


class User_details_model extends MyModel
{
    protected $table = 'user_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['fk_user', 'lastname', 'firstname'];

    /**
     * Constructor
     */
    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }

    /**
     *  Gets the corresponding user with a foreign key
     *  
     *  @return array
     */
    public function getUser($fk_user)
    {
        if (is_null($this->User_model))
            $user_model = new User_model();

        return $user_model->asArray()
                          ->where('id', $fk_user)
                          ->first();
    }
}