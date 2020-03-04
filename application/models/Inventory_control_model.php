<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Inventory control model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2018, Orif <http://www.orif.ch>
 */
class Inventory_control_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'inventory_control';
    protected $primary_key = 'inventory_control_id';
    protected $protected_attributes = ['inventory_control_id'];
    protected $belongs_to = ['item','controller' => ['primary_key' => 'controller_id', 'model' => 'user/User_model']];
    //                               ^        ^ The user who controlled the inventory

    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}