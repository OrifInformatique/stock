<?php 


//if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * The Loan model
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

namespace  Stock\Models;

use CodeIgniter\Model;
use User\Models\User_model;



class Loan_model extends BaseModel
{
    /* MY_Model variables definition */
    protected $table = 'loan';
    protected $primaryKey = 'loan_id';
    protected $item_model = null;
    protected $user_model = null;

  //  protected $protected_attributes = ['loan_id'];
  /*  protected $belongs_to = ['item',
                             // The user who registered this loan
                             'loan_by_user' => ['primary_key' => 'loan_by_user_id',
                                                'model' => 'User_model'],
                             // The user who borrowed the item
                             'loan_to_user' => ['primary_key' => 'loan_to_user_id',
                                                'model' => 'User_model']];

*/
    /**
    * Constructor
    */
    public function initialize()
    {
        $this->user_model = new User_model();
    }

    public function get_loaner($loan){
        if(is_null($this->user_model)){
            $this->user_model = new User_model();
        }
        var_dump($loan);
        $loan[0]->loaner = $this->user_model->asObject()->where(['id'=>$loan[0]->loan_by_user_id])->find();
        return $loan[0]->loaner;
    }
}