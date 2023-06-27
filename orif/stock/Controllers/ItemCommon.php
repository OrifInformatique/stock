<?php

namespace  Stock\Controllers;


/*
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
*/


/**
 * A controller to display and manage items
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

class ItemCommon extends BaseController {

    // Properties
    protected $access_level = "*";
    protected Item_model $item_model;
    protected Loan_model $loan_model;
    protected Item_tag_link_model $item_tag_link_model;
    protected Inventory_control_model $inventory_control_model;
    protected Item_tag_model $item_tag_model;
    protected Item_condition_model $item_condition_model;
    protected Item_group_model $item_group_model;
    protected Stocking_place_model $stocking_place_model;
    protected Supplier_model $supplier_model;
    protected User_model $user_model;
    protected Entity_model $entity_model;
    protected User_entity_model $user_entity_model;
    protected Item_common_model $item_common_model;
    protected $config;
    protected BaseConnection $db;

    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
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
        $this->config = config('\Stock\Config\StockConfig');

        // Initialize db for query builder
        $this->db = \Config\Database::connect();
    }

    public function modify($id) {
        // Check if access is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_common_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) 
        {

            // Define image path variables
            $_SESSION['picture_prefix'] = str_pad($id, $this->config->inventory_number_chars, "0", STR_PAD_LEFT);

            if (!is_null($this->request->getVar('btn_submit'))) {
                dd($_POST);
            } else if (!is_null($this->request->getVar('btn_submit_photo'))) {
                $_SESSION['POST'] = $_POST;
                return redirect()->to(base_url("picture/select_picture"));
            }

            $item_common = $this->item_common_model->find($id);
            $entity_id = $this->item_group_model->where('item_group_id', $item_common['item_group_id'])->findColumn('fk_entity_id');
            $item_groups = $this->item_group_model->where('fk_entity_id', reset($entity_id))->findAll();
            $item_tags = $this->item_tag_model->findAll();
            $item_tag_ids = $this->item_tag_link_model->where('item_common_id', $id)->findColumn('item_tag_id');

            $output['item_common'] = $item_common;
            $output['item_groups'] = $this->dropdown($item_groups, 'item_group_id');
            $output['item_tags'] = $this->dropdown($item_tags, 'item_tag_id');
            $output['item_tag_ids'] = $item_tag_ids;
            $output['config'] = config('\Stock\Config\StockConfig');
            $output['title'] = 'Test';

            if (isset($_SESSION['POST'])) {
                foreach ($_SESSION['POST'] as $key => $value) {
                    // If it is a tag
                    if (substr($key, 0, 3) == "tag") {
                        // put it in the output array
                        $tag_link = [];
                        $tag_link['item_tag_id'] = substr($key, 3);
                        $output['item_tag_ids'][] = $tag_link;
                    }else{
                        $output[$key] = $value;
                    }
                }
            }
            unset($_SESSION['POST']);

            $this->display_view('Stock\Views\item_common\form', $output);
        } else {
            // Access not allowed
            return redirect()->to(base_url());
        }
    }
}
