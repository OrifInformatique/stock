<?php

namespace Stock\Controllers;

/**
 * A controller for items API endpoints
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
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
        // Set Access level before calling parent constructor
        // Accessibility reserved to admin users
        $this->access_level = "*";
        parent::initController($request, $response, $logger);

        // Load required models 
        $this->item_model = new Item_model();
        $this->loan_model = new Loan_model();
        $this->item_condition_model = new Item_condition_model();
        $this->item_common_model = new Item_common_model();
        $this->entity_model = new Entity_model();
        $this->config = config('\Stock\Config\StockConfig');

        // Initialize db for query builder
        $this->db = \Config\Database::connect();
    }

    public function show_item($id = 0)
    {
        // Get database entity
        $item = $this->item_model->find($id);

        // Get data for endpoint
        $data = ['item' => null];

        if ($item) {
            $inventory_nb = $this->item_model->getInventoryNumber($item);

            $condition = $this->item_condition_model
                ->find($item['item_condition_id']);
            $condition = $condition ? $condition['name'] : null;

            $loan = $this->loan_model
                ->where('item_id', $id)
                ->where('real_return_date', null, false)
                ->first();

            $current_loan = [
                'state' => lang('MY_application.lbl_loan_status_not_loaned'),
                'borrower_email'        => null,
                'item_localisation'     => null,
                'planned_return_date'   => null,
            ];

            // Check if there is a current loan
            if (!is_null($loan)) {
                $current_loan = [
                    'state' => lang('MY_application.lbl_loan_status_loaned'),
                    'borrower_email'        => $loan['borrower_email'],
                    'item_localisation'     => $loan['item_localisation'],
                    'planned_return_date'   => $loan['planned_return_date'],
                ];

                // Check if current loan is late
                $end = new DateTime($loan['planned_return_date']);
                $now = new DateTime();

                if ($end < $now) {
                    $current_loan['state'] =
                        lang('MY_application.lbl_loan_status_late');
                }
            }

            $control = $this->item_model->getLastInventoryControl($item);
            $last_control = null;

            if ($control) {
                $last_control = [
                    'date'          => $control['date'],
                    'controller'    => $control['controller']['username'],
                    'remarks'       => $control['remarks'],
                ];
            }

            $supplier = $this->item_model->getSupplier($item);
            $supplier = $supplier ? $supplier['name'] : null;

            $stocking_place = $this->item_model->getStockingPlace($item);
            $stocking_place = $stocking_place ? $stocking_place['name'] : null;

            // Data to send
            $data = [
                'item' => [
                    'id'                => $id,
                    'inventory_nb'      => $inventory_nb,
                    'serial_nb'         => $item['serial_number'],
                    'condition'         => $condition,
                    'current_loan'      => $current_loan,
                    'buying_price'      => $item['buying_price'],
                    'buying_date'       => $item['buying_date'],
                    'warranty_duration' => $item['warranty_duration'],
                    'remarks'           => $item['remarks'],
                    'supplier'          => $supplier,
                    'supplier_ref'      => $item['supplier_ref'],
                    'stocking_place'    => $stocking_place,
                    'last_control'      => $last_control,
                ]
            ];
        }

        // API Response
        return $this->respond($data, 200);
    }

    public function show_item_common($id = 0)
    {
        // Get database entity
        $item_common = $this->item_common_model->find($id);

        // Get data for endpoint
        $data = ['item_common' => null];

        if ($item_common) {
            $item_group = $this->item_common_model->getItemGroup($item_common);
            $group = $item_group ? $item_group['name'] : null;

            $image_path = base_url() . $this->item_common_model
                ->getImagePath($item_common);

            $entity = $this->entity_model
                ->where('entity_id', $item_group['fk_entity_id'])
                ->first();
            $entity = $entity ? $entity['name'] : null;

            $tags = $this->item_common_model->getTags($item_common);

            if (!empty($tags)) {
                foreach ($tags as &$tag) {
                    $tag = $tag[0]['name'];
                }
                unset($tag);
            } else {
                $tags = null;
            }

            // Data to send
            $data = [
                'item_common' => [
                    'id'            => $id,
                    'name'          => $item_common['name'],
                    'image_path'    => $image_path,
                    'description'   => $item_common['description'],
                    'group'         => $group,
                    'entity'        => $entity,
                    'tags'          => $tags,
                ]
            ];
        }

        // API Response
        return $this->respond($data, 200);
    }
}