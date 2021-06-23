<?php
/**
 * Model Supplier_model this represents the supplier table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use CodeIgniter\Model;

class Loan_model extends BaseModel
{
    protected $table = 'loan';
    protected $primaryKey = 'loan_id';
<<<<<<< HEAD
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
=======
    protected $allowedFields = ['date', 'item_localisation', 'remarks', 'planned_return_date', 'real_return_date', 'item_id', 'loan_by_user_id', 'loan_to_user_id'];
>>>>>>> 6b278f5c3447a32b2e99b4df7a75b4ccb03bc5ce
}