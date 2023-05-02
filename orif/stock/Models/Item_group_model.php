<?php
/**
 * Model Item_group_model this represents the item_group table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace  Stock\Models;

use Stock\Models\MyModel;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;


class Item_group_model extends MyModel
{
    /* MY_Model variables definition */
    protected $table = 'item_group';
    protected $primaryKey = 'item_group_id';
    protected $allowedFields = ['fk_entity_id','name', 'short_name', 'archive'];
    protected $useSoftDeletes = true;
    protected $deletedField = 'archive';

    /**
     * Constructor
     */
    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->Item_model = new Item_model();
    }

    /**
     *  Gets the corresponding items with the primary key
     *  
     *  @return array
     */
    public function getItems($item_group_id)
    {
        if (is_null($this->Item_model))
            $this->Item_model = new Item_model();

        return $this->Item_model->asArray()
                                ->where('item_group_id', $item_group_id)
                                ->findAll();
    }
}