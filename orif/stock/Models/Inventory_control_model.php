<?php 

//if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Inventory control model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2018, Orif <http://www.orif.ch>
 */


namespace  Stock\Models;

use CodeIgniter\Model;


class Inventory_control_model extends BaseModel
{
    /* MY_Model variables definition */
    protected $table = 'inventory_control';
    protected $primaryKey = 'inventory_control_id';
    protected $protected_attributes = ['inventory_control_id'];
    protected $belongs_to = ['item','controller' => ['primary_key' => 'controller_id', 'model' => 'User_model']];
    //                               ^        ^ The user who controlled the inventory

    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}