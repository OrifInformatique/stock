<?php
/**
 * Model Supplier_model this represents the supplier table
 *
 * @author      Orif (ViDi, AeDa, RoSi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;
use User\Models\User_model;

class Loan_model extends BaseModel
{
    protected $table = 'loan';
    protected $primaryKey = 'loan_id';
    protected $allowedFields = ['date', 'item_localisation', 'remarks', 'planned_return_date', 'real_return_date', 'item_id', 'loan_by_user_id', 'loan_to_user_id'];
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
        $loan->loaner = $this->user_model->asObject()->where(['id'=>$loan->loan_by_user_id])->find();
        return $loan->loaner;
    }



}