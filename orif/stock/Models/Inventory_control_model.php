<?php
/**
 * Model Iventory_control this represents the iventory_control table
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

class Inventory_control_model extends MyModel
{
    protected $table='inventory_control';
    protected $primaryKey='inventory_control_id';
    protected $allowedFields=['item_id', 'controller_id', 'date', 'remarks'];

    /**
     * Constructor
     */
    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->Item_model = new Item_model();
        $this->User_model = new User_model();
    }

    /**
     *  Gets the corresponding item with a foreign key
     *  
     *  @return array
     */
    public function getItem($fk_item)
    {
        if (is_null($this->Item_model))
            $this->Item_model = new Item_model();

        return $this->Item_model->asArray()
                                ->where('item_id', $fk_item)
                                ->first();
    }

    /**
     *  Gets the corresponding user with a foreign key
     *  
     *  @return array
     */
    public function getUser($fk_user)
    {
        if (is_null($this->User_model))
            $this->User_model = new User_model();

        return $this->User_model->asArray()
                                ->where('id', $fk_user)
                                ->first();
    }
}