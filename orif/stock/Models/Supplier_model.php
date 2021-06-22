<?php 

//if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Supplier model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

namespace  Stock\Models;

use CodeIgniter\Model;



class Supplier_model extends BaseModel
{
    /* MY_Model variables definition */
    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $protected_attributes = ['supplier_id'];
    protected $has_many = ['items'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}