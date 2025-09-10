<?php
/**
 * Model Stocking_place this represents the stocking_place table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use Stock\Models\MyModel;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;


class Stocking_place_model extends MyModel
{
    protected $table = 'stocking_place';
    protected $primaryKey = 'stocking_place_id';
    protected $allowedFields = ['fk_entity_id','name', 'short', 'archive'];
    protected $useSoftDeletes = true;
    protected $deletedField = 'archive';

    /**
     * Constructor
     */
    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
    }

    /**
     *  Gets the corresponding items with the primary key
     *  
     *  @return array
     */
    public function getItems($stocking_place_id)
    {
        $item_model = new Item_model();

        return $item_model->asArray()
                          ->where('stocking_place_id', $stocking_place_id)
                          ->findAll();
    }
}