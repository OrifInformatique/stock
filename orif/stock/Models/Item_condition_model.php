<?php
/**
 * Model Item_condition_model this represents the Item_condition table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */


namespace  Stock\Models;

use Stock\Models\MyModel;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;


class Item_condition_model extends MyModel
{
    protected $table = 'item_condition';
    protected $primaryKey = 'item_condition_id';
    protected $allowedFields = ['name'];

    /* MY_Model callback methods */
    protected $after_get = ['get_bootstrap_label'];

    /**
     * Constructor
     */
    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->Item_model = new Item_model();
    }

    /**
     * Returns a bootstrap <span> tag with class depending of the item condition
     *
     * Attribute name : bootstrap_label
     *
     * @param [type] $item_condition
     * @return void
     */
    public function get_bootstrap_label($item)
    {
        if ($item['item_condition_id'] == 10)
        {
            $bootstrap_label = '<span class="badge badge-success">'; // ITEM DOES WORK
        }
        elseif ($item['item_condition_id'] == 30)
        {
            $bootstrap_label = '<span class="badge badge-warning">'; // ITEM DEFECTIVE
        }
        elseif ($item['item_condition_id'] == 40)
        {
            $bootstrap_label = '<span class="badge badge-danger">';}  // NO MORE ITEM
        else
        {
            $bootstrap_label = '<span>'; // UNKNOWNED VALUE
        }
        $bootstrap_label .= $item['name'].'</span>';

        $item_condition['bootstrap_label'] = $bootstrap_label;
        return $item_condition;
    }

    /**
     *  Gets the corresponding items with the primary key
     *
     *  @return array
     */
    public function getItems($item_condition_id)
    {
        if (is_null($this->Item_model))
            $this->Item_model = new Item_model();

        return $this->Item_model->asArray()
                                ->where('item_condition_id', $item_condition_id)
                                ->findAll();
    }
}
