<?php 

//if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Stocking place model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

namespace  Stock\Models;

use CodeIgniter\Model;



class Stocking_place_model extends BaseModel
{
    /* MY_Model variables definition */
    protected $table = 'stocking_place';
    protected $primaryKey = 'stocking_place_id';
    protected $protected_attributes = ['stocking_place_id'];
    protected $has_many = ['items'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}