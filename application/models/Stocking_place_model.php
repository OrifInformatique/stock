<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Stocking place model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class Stocking_place_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'stocking_place';
    protected $primary_key = 'stocking_place_id';
    protected $has_many = ['items'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}