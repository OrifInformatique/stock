<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The User type model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class User_type_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'user_type';
    protected $primary_key = 'user_type_id';
    protected $protected_attributes = ['user_type_id'];
    protected $has_many = ['users'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}