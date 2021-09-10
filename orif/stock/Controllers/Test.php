<?php

namespace Stock\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use Stock\Controllers\Item;
use Stock\Models\Item_model;
use Stock\Models\Loan_model;

class Test extends BaseController {

    protected $item_model, $loan_model;




    public function index()
    {
        $this->item_model = new Item_model();
    
        $this->loan_model = new Loan_model(); 


        $item = $this->item_model->asArray()->first();

        $current_loan = $this->item_model->get_current_loan($item);

        var_dump($current_loan['item_localisation']);


    }

   
}