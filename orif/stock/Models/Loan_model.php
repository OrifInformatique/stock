<?php
/**
 * Model Supplier_model this represents the supplier table
 *
 * @author      Orif (ViDi, AeDa, RoSi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Models;

use User\Models\User_model;
use Stock\Models\MyModel;
use CodeIgniter\I18n\Time;

class Loan_model extends MyModel
{
    protected $table = 'loan';
    protected $primaryKey = 'loan_id';
    protected $allowedFields = ['date', 'item_localisation', 'remarks', 'planned_return_date', 'real_return_date', 'item_id', 'loan_by_user_id', 'loan_to_user_id', 'borrower_email'];
    protected $item_model = null;
    protected $user_model = null;


    public function initialize()
    {
        if (!$this->user_model) {
            $this->user_model = new User_model();
        }
    }

    public function get_late_loans() {
        $now = new Time('now');
        $threeMonthsAgo = new Time('-3 month');

        // If no return date is specified, loan is considered as late after 3 months
        $late_condition = "(planned_return_date < '".$now->toDateString()."' or (planned_return_date IS NULL and date < '".$threeMonthsAgo->toDateString()."'))";

        $late_loans = $this->where('real_return_date', NULL)
                           ->where($late_condition)
                           ->findAll();

        return $late_loans;
    }

    public function get_late_loans_by_entity($entityId) {
        $now = new Time('now');
        $threeMonthsAgo = new Time('-3 month');

        // If no return date is specified, loan is considered as late after 3 months
        $late_condition = "(planned_return_date < '".$now->toDateString()."' or (planned_return_date IS NULL and date < '".$threeMonthsAgo->toDateString()."'))";

        $late_loans = $this->db->table('entity')
                        ->where('entity_id', $entityId)
                        ->where('real_return_date', null)
                        ->where($late_condition)
                        ->join('item_group', 'item_group.fk_entity_id = entity.entity_id', 'inner')
                        ->join('stocking_place', 'stocking_place.fk_entity_id = entity.entity_id', 'inner')
                        ->join('item', 'item.item_group_id = item_group.item_group_id AND item.stocking_place_id = stocking_place.stocking_place_id', 'inner')
                        ->join('loan', 'loan.item_id = item.item_id', 'inner')
                        ->select(['loan.loan_id', 'loan.date', 'loan.item_localisation', 'loan.remarks', 'loan.planned_return_date', 'loan.real_return_date', 'loan.item_id', 'loan.loan_by_user_id', 'loan.loan_to_user_id', 'loan.borrower_email'])
                        ->countAllResults();

        return $late_loans;
    }

    public function get_loaner($loan){
        if(is_null($this->user_model)){
            $this->user_model = new User_model();
        }
        $loan['loaner'] = $this->user_model->withDeleted()->asArray()->find($loan['loan_by_user_id']);
        return $loan['loaner'];
    }

    public function get_borrower($loan){
        if(is_null($this->user_model)){
            $this->user_model = new User_model();
        }
        $loan['borrower'] = $this->user_model->withDeleted()->asArray()->find($loan['loan_to_user_id']);
        return $loan['borrower'];
    }

    public function get_item($loan){
        if(is_null($this->item_model)){
            $this->item_model = new Item_model();
        }
        $loan['item'] = $this->item_model->asArray()->find($loan['item_id']);
        return $loan['item'];
    }

}
