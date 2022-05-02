<?php

namespace Stock\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class Entity extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'entity';
	protected $primaryKey           = 'entity_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes        = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['name','address','zip','locality','shortname','archive'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $deletedField         = 'archive';

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
	public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->validationRules=[
            'name'=>['label'=>lang('stock_lang.name'),'rules'=>'required|max_length[50]'],
            'address'=>['label'=>lang('stock_lang.address'),'rules'=>'required|max_length[100]'],
            'zip'=>['label'=>lang('stock_lang.zip_code'),'rules'=>'required|max_length[10]'],
            'locality'=>['label'=>lang('stock_lang.locality'),'rules'=>'required|max_length[100]'],
            'shortname'=>['label'=>lang('stock_lang.tagname'),'rules'=>'max_length[3]']
    ];
    }
}
