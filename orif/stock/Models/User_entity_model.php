<?php

namespace Stock\Models;

use Stock\Models\MyModel;

class User_entity_model extends MyModel
{
	protected $DBGroup              = 'default';
	protected $table                = 'user_entity';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $protectFields        = true;
	protected $allowedFields        = ['fk_entity_id','fk_user_id', 'default'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

    // Properties
    protected Item_model $item_model;
    protected Stocking_place_model $stocking_place_model;
    protected Item_group_model $item_group_model;
    protected Loan_model $loan_model;
    protected Item_common_model $item_common_model;

    /**
     * Check if user has the provided entity
     *
     * @param  mixed $user_id
     * @param  mixed $entity_id
     * @return bool
     */
    public function check_user_entity($user_id, $entity_id): bool {
        $user_entity = $this->where('fk_user_id', $user_id)->where('fk_entity_id', $entity_id)->find();

        return !empty($user_entity);
    }

    /**
     * Check if user and item share the same entity
     *
     * @param  mixed $user_id
     * @param  mixed $item
     * @return bool
     */
    public function check_user_item_entity($user_id, $item_id): bool {
        $this->item_model = new Item_model();
        $this->stocking_place_model = new Stocking_place_model();
        $item = $this->item_model->find($item_id);
        if (!is_null($item)) {
            $user_entities = $this->where('fk_user_id', $user_id)->findColumn('fk_entity_id');
            $item_entity = $this->stocking_place_model->where('stocking_place_id', $this->item_model->where('item_id', $item['item_id'])->findColumn('stocking_place_id'))->findColumn('fk_entity_id');
    
            return in_array(reset($item_entity), $user_entities);
        } else {
            return false;
        }
    }

    /**
     * Check if user and item_common share the same entity
     *
     * @param  mixed $user_id
     * @param  mixed $item
     * @return bool
     */
    public function check_user_item_common_entity($user_id, $item_common_id): bool {
        $this->item_common_model = new Item_common_model();
        $this->item_group_model = new Item_group_model();
        $item_common = $this->item_common_model->find($item_common_id);
        if (!is_null($item_common)) {
            $user_entities = $this->where('fk_user_id', $user_id)->findColumn('fk_entity_id');
            $item_entity = $this->item_group_model->where('item_group_id', $this->item_common_model->where('item_common_id', $item_common['item_common_id'])->findColumn('item_group_id'))->findColumn('fk_entity_id');
    
            return in_array(reset($item_entity), $user_entities);
        } else {
            return false;
        }
    }

    /**
     * Check if user and item share the same entity
     *
     * @param  mixed $user_id
     * @param  mixed $item
     * @return bool
     */
    public function check_user_loan_entity($user_id, $loan_id): bool {
        $this->loan_model = new Loan_model();
        $item_id = $this->loan_model->where('loan_id', $loan_id)->findColumn('item_id');

        return $this->check_user_item_entity($user_id, reset($item_id));
    }
}
