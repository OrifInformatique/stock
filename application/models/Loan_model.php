<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Loan model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class Loan_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'loan';
    protected $primary_key = 'loan_id';
    protected $protected_attributes = ['loan_id'];
    protected $belongs_to = ['item',
                             // The user who registered this loan
                             'loan_by_user' => ['primary_key' => 'loan_by_user_id',
                                                'model' => 'user/User_model'],
                             // The user who borrowed the item
                             'loan_to_user' => ['primary_key' => 'loan_to_user_id',
                                                'model' => 'user/User_model']];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}