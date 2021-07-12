<?php 

//if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Item group model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

namespace  Stock\Models;

use Stock\Models\MyModel;



class Item_group_model extends MyModel
{
    /* MY_Model variables definition */
    protected $table = 'item_group';
    protected $primaryKey = 'item_group_id';
    protected $protected_attributes = ['item_group_id'];
    protected $has_many = ['items'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}