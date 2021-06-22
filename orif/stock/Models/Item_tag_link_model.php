<?php 

//if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * The Item tag link model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

namespace  Stock\Models;

use CodeIgniter\Model;



class Item_tag_link_model extends BaseModel
{
    /* MY_Model variables definition */
    protected $table = 'item_tag_link';
    protected $primaryKey = 'item_tag_link_id';
    protected $protected_attributes = ['item_tag_link_id'];
    protected $belongs_to = ['item', 'item_tag'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}