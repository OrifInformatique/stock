<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The Item tag link model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class Item_tag_link_model extends MY_Model
{
    /* MY_Model variables definition */
    protected $_table = 'item_tag_link';
    protected $primary_key = 'item_tag_link_id';
    protected $belongs_to = ['item', 'item_tag'];


    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();
    }
}