<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Item group model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class Item_group_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'item_group';
    protected $primary_key = 'item_group_id';
    protected $has_many = ['items'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}