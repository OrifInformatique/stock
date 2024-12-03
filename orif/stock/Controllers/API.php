<?php

namespace Stock\Controllers;

/**
 * A controller for items API endpoints
 *
 * @author      Orif (PeDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c) 2024, Orif <http://www.orif.ch>
 */

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use PSR\Log\LoggerInterface;
use App\Controllers\BaseController;
use Stock\Models\Item_model;
use Stock\Models\Loan_model;
use Stock\Models\Item_condition_model;
use Stock\Models\Item_common_model;
use Stock\Models\Entity_model;
use Stock\Models\Inventory_control_model;
use \DateInterval;
use \DateTime;

class API extends BaseController
{
    use ResponseTrait;

    /**
     * Constructor
     */
    public function initController(RequestInterface $request,
        ResponseInterface $response, LoggerInterface $logger)
    {
        // Call parent constructor
        parent::initController($request, $response, $logger);

        // Load required models 
        $this->item_model = new Item_model();
        $this->loan_model = new Loan_model();
        $this->item_condition_model = new Item_condition_model();
        $this->item_common_model = new Item_common_model();
        $this->entity_model = new Entity_model();
        $this->inventory_control_model = new Inventory_control_model();
    }

    /**
     * Endpoint containing item information
     * 
     * @param integer $id : The ID of the item
     * @return CodeIgniter\HTTP\Response
     */
    public function show_item($id = 0)
    {
        $data = ['item' => null];

        // Get database entity
        $item = $this->item_model->find($id);

        // Get data for endpoint
        if ($item) {
            $inventory_nb = $this->item_model->getInventoryNumber($item);

            $warranty_status_i = $this->item_model->getWarrantyStatus($item);
            $warranty_status = lang(
                'MY_application.text_warranty_status')[$warranty_status_i];

            $condition = $this->item_condition_model
                ->find($item['item_condition_id']);

            $loan = $this->loan_model
                ->where('item_id', $id)
                ->where('real_return_date', null, false)
                ->first();

            $current_loan = [
                'loan_id'           => null,
                'status' => lang('MY_application.lbl_loan_status_not_loaned'),
                'borrower_email'    => null,
                'item_location'     => null,
                'planned_return'    => null,
            ];

            // Check if there is a current loan
            if (!is_null($loan)) {
                $current_loan = [
                    'loan_id'           => $loan['loan_id'],
                    'status' => lang('MY_application.lbl_loan_status_loaned'),
                    'borrower_email'    => $loan['borrower_email'],
                    'item_location'     => $loan['item_localisation'],
                    'planned_return'    => $loan['planned_return_date'],
                ];

                // Check if current loan is late
                $end = new DateTime($loan['planned_return_date']);
                $now = new DateTime();

                if ($end < $now) {
                    $current_loan['status'] =
                        lang('MY_application.lbl_loan_status_late');
                }
            }

            $supplier = $this->item_model->getSupplier($item);
            $supplier = $supplier ? array(
                'supplier_id'   => $supplier['supplier_id'],
                'name'          => $supplier['name'],
            ) : null;

            $stocking_place = $this->item_model->getStockingPlace($item);
            $stocking_place = $stocking_place ? array(
                'stocking_place_id' => $stocking_place['stocking_place_id'],
                'name'              => $stocking_place['name'],
            ) : null;

            $control = $this->item_model->getLastInventoryControl($item);
            $last_control = null;

            if ($control) {
                $controller = $this->inventory_control_model
                    ->getUser($control['controller_id']);

                $last_control = [
                    'inventory_control_id'  => $control['inventory_control_id'],
                    'date'                  => $control['date'],
                    'controller' => [
                        'controller_id' => $controller['id'],
                        'username'      => $controller['username'],
                    ],
                    'remarks' => $control['remarks'],
                ];
            }

            $item['inventory_nb'] = $inventory_nb;
            $item['warranty_status'] = $warranty_status;
            $item['condition'] = $condition;
            $item['current_loan'] = $current_loan;
            $item['supplier'] = $supplier;
            $item['stocking_place'] = $stocking_place;
            $item['last_control'] = $last_control;

            // Data to send
            $data['item'] = $item;
        }

        // API Response
        return $this->respond($data, 200);
    }

    /**
     * Endpoint containing item common information for a given item
     * 
     * @param integer $id : The ID of the item
     * @return CodeIgniter\HTTP\Response
     */
    public function show_item_common($id = 0)
    {
        $data = ['item_common' => null];

        // Get database entity
        $item_common = $this->item_common_model->find($id);

        // Get data for endpoint
        if ($item_common) {
            $image_path = base_url() . $this->item_common_model
                ->getImagePath($item_common);

            $item_group = $this->item_common_model->getItemGroup($item_common);
            $group = $item_group ? array(
                'item_group_id' => $item_group['item_group_id'],
                'name'          => $item_group['name'],
            ) : null;

            $entity = $this->entity_model
                ->where('entity_id', $item_group['fk_entity_id'])
                ->first();
            $entity = $entity ? array(
                'entity_id' => $entity['entity_id'],
                'name'      => $entity['name'],
            ) : null;

            $tags = $this->item_common_model->getTags($item_common);

            if (!empty($tags)) {
                foreach ($tags as &$tag) {
                    $tag = array(
                        'item_tag_id'   => $tag[0]['item_tag_id'],
                        'name'          => $tag[0]['name'],
                    );
                }
                unset($tag);
            } else {
                $tags = null;
            }

            $item_common['image_path'] = $image_path;
            $item_common['group'] = $group;
            $item_common['entity'] = $entity;
            $item_common['tags'] = $tags;

            // Data to send
            $data['item_common'] = $item_common;
        }

        // API Response
        return $this->respond($data, 200);
    }

    /**
     * Endpoint containing loan and control history information for a given item
     * 
     * @param integer $id : The ID of the item
     * @return CodeIgniter\HTTP\Response
     */
    public function show_item_history($id = 0)
    {
        $data = [
            'loans_history'     => null,
            'controls_history'  => null,
        ];

        // Get database entity
        $item = $this->item_model->find($id);
        if ($item) {
            $loans = $this->loan_model
                ->where('item_id', $id)
                ->findAll();
            $controls = $this->inventory_control_model
                ->where('item_id', $id)
                ->findAll();
        }

        // Get loans data for endpoint
        if (!empty($loans)) {
            $data['loans_history'] = array();

            foreach ($loans as $loan) {
                // Preparing data
                $loaner = $this->loan_model->get_loaner($loan);
                $loaner = $loaner ? $loaner['username'] : null;

                $borrower_info = [
                    'username'  => null,
                    'email'     => $loan['borrower_email'],
                ];

                if ($loan['loan_to_user_id']) {
                    $borrower = $this->loan_model->get_borrower($loan);
                    $borrower_info['username'] = $borrower
                        ? $borrower['username'] : null;
                }

                // Data to send
                $loan_data = [
                    'id'                => $loan['loan_id'],
                    'date'              => $loan['date'],
                    'planned_return'    => $loan['planned_return_date'],
                    'real_return'       => $loan['real_return_date'],
                    'item_location'     => $loan['item_localisation'],
                    'lent_by'           => $loaner,
                    'borrower'          => $borrower_info,
                ];

                array_push($data['loans_history'], $loan_data);
            }
        }

        // Get controls data for endpoint
        if (!empty($controls)) {
            $data['controls_history'] = array();

            foreach ($controls as $control) {
                // Preparing data
                $controller = $this->inventory_control_model
                    ->getUser($control['controller_id']);
                $controller = $controller ? $controller['username'] : null;

                // Data to send
                $control_data = [
                    'id'            => $control['inventory_control_id'],
                    'date'          => $control['date'],
                    'controller'    => $controller,
                    'remarks'       => $control['remarks'],
                ];

                array_push($data['controls_history'], $control_data);
            }
        }

        // API Response
        return $this->respond($data, 200);
    }
}