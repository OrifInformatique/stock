<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Item condition model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */
class Item_condition_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'item_condition';
    protected $primary_key = 'item_condition_id';
    protected $protected_attributes = ['item_condition_id'];
    protected $has_many = ['items'];

    /* MY_Model callback methods */
    protected $after_get = ['get_bootstrap_label'];

    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns a bootstrap <span> tag with class depending of the item condition
     *
     * Attribute name : bootstrap_label
     *
     * @param [type] $item_condition
     * @return void
     */
    protected function get_bootstrap_label($item_condition)
    {
        if ($item_condition->item_condition_id == 10)
        {
            $bootstrap_label = '<span class="label label-success">'; // ITEM DOES WORK
        } 
        elseif ($item_condition->item_condition_id == 30)
        {
            $bootstrap_label = '<span class="label label-warning">'; // ITEM DEFECTIVE
        } 
        elseif ($item_condition->item_condition_id == 40)
        {
            $bootstrap_label = '<span class="label label-danger">';}  // NO MORE ITEM
        else
        {
            $bootstrap_label = '<span>'; // UNKNOWNED VALUE
        }
        $bootstrap_label .= $item_condition->name.'</span>';

        $item_condition->bootstrap_label = $bootstrap_label;
        return $item_condition;
    }
}