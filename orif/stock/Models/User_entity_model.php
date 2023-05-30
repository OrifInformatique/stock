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
}
