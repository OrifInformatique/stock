<?php

/**
 * Model Item_model this represents the Item table
 *
 * @author      Orif (ViDi,RoSi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace  Stock\Models;

use \DateInterval;
use \DateTime;
use User\Models\User_model;

use Stock\Models\MyModel;


class Item_model extends MyModel
{
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    protected $allowedFields = [
        'item_common_id',
        'inventory_prefix',
        'serial_number',
        'buying_price',
        'buying_date',
        'warranty_duration',
        'remarks',
        'supplier_id',
        'supplier_ref',
        'created_by_user_id',
        'created_date',
        'modified_by_user_id',
        'modified_date',
        'checked_by_user_id',
        'checked_date',
        'stocking_place_id',
        'item_condition_id',
    ];

    protected User_model $user_model;
    protected Loan_model $loan_model;
    protected Supplier_model $supplier_model;
    protected Item_group_model $item_group_model;
    protected Stocking_place_model $stocking_place_model;
    protected Item_condition_model $item_condition_model;
    protected Inventory_control_model $inventory_control_model;
    protected Item_tag_link_model $item_tag_link_model;
    protected Item_common_model $item_common_model;

    /**
     * Constructor
     */
    public function initialize()
    {
        $this->user_model = new User_model();
        $this->loan_model = new Loan_model();
        $this->supplier_model = new Supplier_model();
        $this->item_group_model = new Item_group_model();
        $this->stocking_place_model = new Stocking_place_model();
        $this->item_condition_model = new Item_condition_model();
        $this->inventory_control_model = new Inventory_control_model();
        $this->item_tag_link_model = new Item_tag_link_model();
        $this->item_common_model = new Item_common_model();

        $this->db = \Config\Database::connect();
    }

    /*
     * Returns the id that will receive the next item
     */
    public function getFutureId()
    {
        $query = $this->db->query("SHOW TABLE STATUS LIKE 'item'");
        $row = $query->getRow();
        $nextId = $row->Auto_increment;
        return $nextId;
    }

    public function getItemCondition($item)
    {

        if ($this->item_condition_model == null) {
            $this->item_condition_model = new Item_condition_model();
        }
        $itemCondition = $this->item_condition_model->get_bootstrap_label($this->item_condition_model->asArray()->where(["item_condition_id" => $item['item_condition_id']])->first());


        return $itemCondition;
    }

    public function getCurrentLoan($item)
    {
        if (is_null($this->loan_model)) {
            $this->loan_model = new Loan_model();
        }
        helper('MY_date');

        $current_loan = $this->loan_model->asArray()
            ->where('item_id', $item['item_id'])
            ->where('date <=', mysqlDate('now'))
            ->where('real_return_date is NULL')
            ->first();

        if (is_null($current_loan)) {
            // ITEM IS NOT LOANED
            $current_loan['bootstrap_label'] = '<span class="badge badge-success">' . htmlspecialchars(lang('MY_application.lbl_loan_status_not_loaned')) . '</span>';
            $current_loan['is_late'] = false;
        } else {
            // ITEM IS LOANED
            if (isset($current_loan['planned_return_date']) && !is_null($current_loan['planned_return_date'])) {
                $end = new DateTime($current_loan['planned_return_date']);
            } else {
                $end = new DateTime($current_loan['date']);
                $end = $end->add(new DateInterval('P3M'));
            }

            // Use only current date without time
            $now = new DateTime();
            $now->setTime(0, 0);

            if ($end < $now) {
                // LOAN IS LATE
                $current_loan['bootstrap_label'] = '<span class="badge badge-danger">' . htmlspecialchars(lang('MY_application.lbl_loan_status_late')) . '</span>';
                $current_loan['is_late'] = true;
            } else {
                // LOAN IS NOT LATE
                $current_loan['bootstrap_label'] = '<span class="badge badge-warning">' . htmlspecialchars(lang('MY_application.lbl_loan_status_loaned')) . '</span>';
                $current_loan['is_late'] = false;
            }
        }

        return $current_loan;
    }

    public function getLastInventoryControl($item)
    {
        if (!is_null($item)) {
            if (is_null($this->inventory_control_model)) {
                $this->inventory_control_model = new Inventory_control_model();
            }

            $inventory_controls = $this->inventory_control_model->asArray()->where('item_id', $item["item_id"])->find();

            $last_control = NULL;

            if (!is_null($inventory_controls)) {
                foreach ($inventory_controls as $control) {
                    // Select the last control (biggest date)
                    if (is_null($last_control)) {
                        $last_control = $control;
                    } else if ($control['date'] > $last_control['date']) {
                        $last_control = $control;
                        $last_control['controller'] = $this->inventory_control_model->getUser($last_control['controller_id']);
                    }
                }
            }
        }

        return $last_control;
    }

    /**
     * Calculate a warranty status based on buying date and warranty duration
     *
     * Attribute name : warranty_status
     *
     * Values :
     *           0 : NO WARRANTY STATUS (buying date or warranty duration is not set)
     *           1 : UNDER WARRANTY
     *           2 : WARRANTY EXPIRES SOON (less than 3 months)
     *           3 : WARRANTY EXPIRED
     */
    public function getWarrantyStatus($item)
    {
        if (!is_null($item)) {
            if (empty($item['buying_date']) || empty($item['warranty_duration'])) {
                $warrantyStatus = 0;
            } else {
                $buying_date = new DateTime($item['buying_date']);
                $current_date = new DateTime("now");

                $time_spent = $buying_date->diff($current_date);
                $months_spent = ($time_spent->y * 12) + $time_spent->m;

                $warranty_left = $item['warranty_duration'] - $months_spent;

                if ($warranty_left > 3) {
                    // UNDER WARRANTY
                    $warrantyStatus = 1;
                } elseif ($warranty_left > 0) {
                    // WARRANTY EXPIRES SOON
                    $warrantyStatus = 2;
                } else {
                    // WARRANTY EXPIRED
                    $warrantyStatus = 3;
                }
            }
        }
        return $warrantyStatus;
    }



    /**
     * Searching item(s) in the database depending on filters
     * 
     * @param array $filters The array of filters
     * @return array array of corresponding items and items count
     */
    public function getFiltered($filters, $page): array {
        // Initialize a global query for filtering
        $queryBuilder = $this->join('item_common', 'item.item_common_id = item_common.item_common_id', 'inner')
            ->join('item_tag_link', 'item_tag_link.item_common_id = item_common.item_common_id', 'left')
            ->join('item_group', 'item_common.item_group_id = item_group.item_group_id', 'inner');

        // Entity filter
        if (isset($filters['e']) && $filters['e'] != 0) {
            $queryBuilder->where('item_group.fk_entity_id', $filters['e']);
        }

        // Text search filter
        if (isset($filters['ts']) && $filters['ts'] != '') {
            $whereCondition = $this->getTextSearchFilter(esc($filters['ts']));
            $queryBuilder->where($whereCondition);
        }

        // Item condition filter
        if (isset($filters['c'])) {
            $queryBuilder->whereIn('item_condition_id', $filters['c']);
        }

        // Item group filter
        if (isset($filters['g'])) {
            $queryBuilder->whereIn('item_common.item_group_id', $filters['g']);
        }

        // Stocking place filter
        if (isset($filters['s'])) {
            $queryBuilder->whereIn('item.stocking_place_id', $filters['s']);
        }

        // Item tags filter
        if (isset($filters['t'])) {
            $queryBuilder->whereIn('item_tag_link.item_tag_id', $filters['t']);
        }

        // Select fields manually to prevent ambiguous data
        $queryBuilder->select('
            item.item_id,
            item_common.item_common_id,
            item_common.name,
            item_common.description,
            item_common.image,
            GROUP_CONCAT(item_tag_link.item_tag_id),
            item.inventory_prefix,
            item.serial_number,
            item.stocking_place_id,
            item.item_condition_id,
        ');

        $orderByField = isset($filters['o']) ? $this->getOrderByField($filters['o']) : config('\Stock\Config\StockConfig')->default_order_by_field;
        $orderBy = !isset($filters['ad']) ? 'ASC' : ($filters['ad'] === '0' ? 'ASC': 'DESC');

        $queryBuilder->orderBy($orderByField, $orderBy);
        $queryBuilder->groupBy('item.item_id');

        // Count and get paginated items
        $itemsPerPage = config('\Stock\Config\StockConfig')->items_per_page;
        $totalItemsCount = $queryBuilder->countAllResults(false);
        $queryBuilder->limit($itemsPerPage, ($page - 1) * $itemsPerPage);
        $items = $queryBuilder->get()->getResultArray();
        
        foreach ($items as &$item) {
            $item['stocking_place'] = $this->getStockingPlace($item);
            $item['inventory_number'] = $this->getInventoryNumber($item);
            $item['condition'] = $this->getItemCondition($item);
            $item['current_loan'] = $this->getCurrentLoan($item);
            $item['image'] = $this->item_common_model->getImage($item);
            $item['image_path'] = $this->item_common_model->getImagePath($item);
        }

        unset($item);

        return array(
            'items' => $items,
            'items_count' => $totalItemsCount
        );
    }

    /**
     * Get text search condition from the provided string
     *
     * @param string $textSearch
     * @return string
     */
    private function getTextSearchFilter(string $textSearch): string {
        $parts = explode('.', $textSearch);
        $lastPart = end($parts);
        $whereConditions = [
            "item_common.description LIKE '%{$textSearch}%'",
            "item_common.name LIKE '%{$textSearch}%'",
            "item.serial_number LIKE '%{$textSearch}%'",
        ];

        if (is_numeric($lastPart)) {
            $inventoryNumber = implode('.', array_slice($parts, 0, -1));

            if ($inventoryNumber !== '') {
                $whereConditions[] = "item.item_id = {$lastPart} AND item.inventory_prefix LIKE '%{$inventoryNumber}%'";
            } else {
                $whereConditions[] = "item.item_id = {$lastPart}";
            }
        } else {
            $whereConditions[] = "item.inventory_prefix LIKE '%{$textSearch}%'";
        }

        // Combine conditions with OR
        return '(' . implode(' OR ', $whereConditions) . ')';
    }

    /**
     * Get order by field from the provided filter value
     *
     * @param string $filter
     * @return string
     */
    private function getOrderByField(string $filter): string {
        switch ($filter) {
            case '1':
                return 'item.stocking_place_id';
            case '2':
                return 'item.buying_date';
            case '3':
                return 'item.inventory_prefix';
            default:
                return config('\Stock\Config\StockConfig')->default_order_by_field;
        }
    }


    public function getInventoryNumber($item)
    {
        $inventory_number = "";

        if (!is_null($item)) {
            $inventory_id = $this->getInventoryID($item);
            $inventory_number = $item['inventory_prefix'] . "." . $inventory_id;
        }

        return $inventory_number;
    }

    public function getInventoryID($item)
    {
        $inventory_id = "";

        if (!is_null($item)) {
            $inventory_id = $item['item_id'];

            // Add leading zeros to inventory_id
            for ($i = strlen($inventory_id); $i < config('\Stock\Config\StockConfig')->inventory_number_chars; $i++) {
                $inventory_id = "0" . $inventory_id;
            }
        }

        return $inventory_id;
    }

    public function getStockingPlace($item)
    {

        if ($this->stocking_place_model == null) {
            $this->stocking_place_model = new Stocking_place_model();
        }
        $stockingPlace = $this->stocking_place_model->asArray()->withDeleted()->where(["stocking_place_id" => $item['stocking_place_id']])->first();


        return $stockingPlace;
    }

    public function getSupplier($item)
    {
        if ($this->supplier_model == null) {
            $this->supplier_model = new Supplier_model();
        }

        return $this->supplier_model->asArray()->where(["supplier_id" => $item['supplier_id']])->first();
    }


    protected function getCreator($item)
    {
        if ($this->user_model == null) {
            $this->user_model = new User_model();
        }

        return $this->user_model->asArray()->where(['id' => $item['created_by_user_id']])->first();
    }

    protected function getModifier($item)
    {
        if ($this->user_model == null) {
            $this->user_model = new User_model();
        }

        return $this->user_model->asArray()->where(['id' => $item['modified_by_user_id']])->first();
    }

    protected function getChecker($item)
    {
        if ($this->user_model == null) {
            $this->user_model = new User_model();
        }

        return $this->user_model->asArray()->where(['id' => $item['checked_by_user_id']])->first();
    }
}
