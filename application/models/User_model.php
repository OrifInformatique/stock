<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The User model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class User_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'user';
    protected $primary_key = 'user_id';
    protected $belongs_to = ['user_type'];
    protected $has_many = ['items_created' => ['model' => 'Item_model',
                                               'primary_key' => 'created_by_user_id'],
                           'items_modified' => ['model' => 'Item_model',
                                                'primary_key' => 'modified_by_user_id'],
                           'items_checked' => ['model' => 'Item_model',
                                               'primary_key' => 'checked_by_user_id'],
                           // Loans registered by this user for another user
                           'loans_registered' => ['model' => 'Loan_model',
                                                  'primary_key' => 'loan_by_user_id'],
                           // Loans for this user
                           'loans_made' => ['model' => 'Loan_model',
                                            'primary_key' => 'loan_to_user_id']];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}