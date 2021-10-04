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
use Stock\Models\MyModel;

class Loan_model extends MyModel
{
    protected $table = 'loan';
    protected $primaryKey = 'loan_id';
    protected $allowedFields = ['date', 'item_localisation', 'remarks', 'planned_return_date', 'real_return_date', 'item_id', 'loan_by_user_id', 'loan_to_user_id'];
    protected $item_model = null;
    protected $user_model = null;


    public function initialize()
    {
        $this->user_model = new User_model();
    }

    public function get_loaner($loan){
        if(is_null($this->user_model)){
            $this->user_model = new User_model();
        }
        $loan['loaner'] = $this->user_model->asArray()->where(['id'=>$loan['loan_by_user_id']])->find();
        return $loan['loaner'];
    }

    public function get_borrower($loan){
        if(is_null($this->user_model)){
            $this->user_model = new User_model();
        }
        $loan['borrower'] = $this->user_model->asArray()->where(['id'=>$loan['loan_to_user_id']])->find();
        return $loan['borrower'];
    }

    public function get_item($loan){
        if(is_null($this->item_model)){
            $this->item_model = new Item_model();
        }
        $loan['item'] = $this->item_model->asArray()->where(['item_id'=>$loan['item_id']])->find();
        return $loan['item'];
    }
   
}