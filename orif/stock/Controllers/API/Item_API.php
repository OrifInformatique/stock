<?php

namespace Stock\Controllers\API;

/**
 * A controller for API endpoints
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use PSR\Log\LoggerInterface;
use App\Controllers\BaseController;
use Stock\Models\Entity_model;
use Stock\Models\Inventory_control_model;
use Stock\Models\Item_model;
use Stock\Models\Loan_model;
use Stock\Models\Item_tag_model;
use Stock\Models\Item_condition_model;
use Stock\Models\Item_group_model;
use Stock\Models\Item_tag_link_model;
use Stock\Models\Stocking_place_model;
use Stock\Models\Supplier_model;
use Stock\Models\User_entity_model;
use Stock\Models\Item_common_model;
use User\Models\User_model;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\API\ResponseTrait;

class Item_API extends BaseController
{
    use ResponseTrait;

    /**
     * Constructor
     */
    public function initController(RequestInterface $request,
        ResponseInterface $response, LoggerInterface $logger)
    {
        // Set Access level before calling parent constructor
        // Accessibility reserved to admin users
        $this->access_level = "*";
        parent::initController($request, $response, $logger);

        // Load required helpers
        helper('sort');
        helper('form');
        helper('\Stock\Helpers\MY_date');

        // Load required models 
        $this->item_model = new Item_model();
        $this->loan_model = new Loan_model();
        $this->item_tag_link_model = new Item_tag_link_model();
        $this->inventory_control_model = new Inventory_control_model();
        $this->item_tag_model = new Item_tag_model();
        $this->item_condition_model = new Item_condition_model();
        $this->supplier_model = new Supplier_model();
        $this->item_group_model = new Item_group_model();
        $this->stocking_place_model = new Stocking_place_model();
        $this->entity_model = new Entity_model();
        $this->user_entity_model = new User_entity_model();
        $this->item_common_model = new Item_common_model();
        $this->user_model = new User_model();
        $this->config = config('\Stock\Config\StockConfig');

        // Initialize db for query builder
        $this->db = \Config\Database::connect();
    }

    public function show($id = 0)
    {
        $data = [
            [
                'id' => $id,
                'price' => 550.0,
                'name' => 'Ordinateur portable',
                'supplier' => 'Digitec'
            ]
        ];

        return $this->respond($data, 200);
    }
}