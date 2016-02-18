<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Supplier model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class Supplier_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'supplier';
    protected $primary_key = 'supplier_id';
    protected $has_many = ['items'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}