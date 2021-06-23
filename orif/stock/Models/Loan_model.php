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

class Loan_model extends Model
{
    protected $table = 'loan';
    protected $primaryKey = 'loan_id';
    protected $allowedFields = ['date', 'item_localisation', 'remarks', 'planned_return_date', 'real_return_date', 'item_id', 'loan_by_user_id', 'loan_to_user_id'];
}