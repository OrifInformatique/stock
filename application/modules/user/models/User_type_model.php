<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User model is used to give access to the application.
 * User_type is used to give different access rights (defining an access level).
 *
 * @author      Orif (UlSi, ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c) Orif (https://www.orif.ch)
 */
class user_type_model extends MY_Model
{
    /* Set MY_Model variables */
    protected $_table = 'user_type';
    protected $primary_key = 'user_type_id';
    protected $protected_attributes = ['user_type_id'];
    protected $has_many = ['users' => ['primary_key' => 'user_type_id',
                                       'model' => 'user_model']];

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
}