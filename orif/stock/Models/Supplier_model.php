<?php
/**
 * Model Supplier_model this represents the supplier table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use Stock\Models\MyModel;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;


class Supplier_model extends MyModel
{
    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $allowedFields = ['name', 'address_line1', 'address_line2', 'zip', 'city', 'country', 'tel', 'email', 'archive'];
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
    public function getItems($supplier_id)
    {
        $item_model = new Item_model();

        return $item_model->asArray()
                          ->where('supplier_id', $supplier_id)
                          ->findAll();
    }
}