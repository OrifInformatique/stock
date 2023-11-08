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
     * @param array $filters The array of filters
     * @return An array of corresponding items
     */
    public function get_filtered($filters)
    {

        if (is_null($this->stocking_place_model)) {
            $this->stocking_place_model = new Stocking_place_model();
        }

        if (is_null($this->item_condition_model)) {
            $this->item_condition_model = new Item_condition_model();
        }

        // Initialize a global WHERE clause for filtering
        $where_itemsFilters = '';

        $join_item_common = '';

        /*********************
         ** TEXT SEARCH FILTER
         **********************/
        $where_textSearchFilter = '';

        if (isset($filters['ts']) && $filters['ts'] != '') {
            $text_search_content = $filters['ts'];

            // If the search text is an inventory number, separate the ID from the rest (ID is after the last '.')
            $inventory_exploded = explode('.', $text_search_content);
            $inventory_lastPart = end($inventory_exploded);

            if (is_numeric($inventory_lastPart)) {
                // The last part of the search text is probably the item ID
                $item_id = intval($inventory_lastPart);

                // The other part(s) compose the inventory_number
                $inventory_number = '';
                for ($i = 0; $i < (count($inventory_exploded) - 1); $i++) {
                    if ($i > 0) {
                        $inventory_number .= '.';
                    }
                    $inventory_number .= $inventory_exploded[$i];
                }
            } else {
                // The item ID is probably not in the search text.
                $inventory_number = $text_search_content;
            }

            // Prepare WHERE clause
            $where_textSearchFilter .= '(';
            $where_textSearchFilter .=
                "item_common.name LIKE '%" . $text_search_content . "%' "
                . "OR item_common.description LIKE '%" . $text_search_content . "%' "
                . "OR item.serial_number LIKE '%" . $text_search_content . "%' ";

            if (isset($item_id)) {
                if (isset($inventory_number) && $inventory_number != '') {
                    $where_textSearchFilter .= "OR (item_id = " . $item_id . " AND inventory_prefix LIKE '%" . $inventory_number . "%') ";
                } else {
                    $where_textSearchFilter .= "OR item_id = " . $item_id . " ";
                }
            } else {
                $where_textSearchFilter .= "OR inventory_prefix LIKE '%" . $text_search_content . "%' ";
            }
            $where_textSearchFilter .= ')';

            // Add this part of WHERE clause to the global WHERE clause
            if ($where_itemsFilters != '') {
                // Add new filter after existing filters
                $where_itemsFilters .= ' AND ';
            }
            $where_itemsFilters .= $where_textSearchFilter;
        }

        /*********************
         ** ITEM CONDITION FILTER
         ** Default filtering for "functional" items
         **********************/
        $where_itemConditionFilter = '';

        if (isset($filters['c'])) {
            $item_conditions_selection = $filters['c'];

            // Prepare WHERE clause
            $where_itemConditionFilter .= '(';
            foreach ($item_conditions_selection as $item_condition_id) {
                $where_itemConditionFilter .= 'item_condition_id=' . $item_condition_id . ' OR ';
            }
            // Remove the last " OR "
            $where_itemConditionFilter = substr($where_itemConditionFilter, 0, -4);
            $where_itemConditionFilter .= ')';

            // Add this part of WHERE clause to the global WHERE clause
            if ($where_itemsFilters != '') {
                // Add new filter after existing filters
                $where_itemsFilters .= ' AND ';
            }
            $where_itemsFilters .= $where_itemConditionFilter;
        }

        /*********************
         ** ITEM GROUP FILTER
         **********************/
        $where_itemGroupFilter = '';

        if (isset($filters['g'])) {
            $item_groups_selection = $filters['g'];

            // Prepare WHERE clause
            $where_itemGroupFilter .= '(';
            foreach ($item_groups_selection as $item_group_id) {
                $where_itemGroupFilter .= 'item_common.item_group_id=' . $item_group_id . ' OR ';
            }
            // Remove the last " OR "
            $where_itemGroupFilter = substr($where_itemGroupFilter, 0, -4);
            $where_itemGroupFilter .= ')';

            // Add this part of WHERE clause to the global WHERE clause
            if ($where_itemsFilters != '') {
                // Add new filter after existing filters
                $where_itemsFilters .= ' AND ';
            }
            $where_itemsFilters .= $where_itemGroupFilter;
        }

        /*********************
         ** STOCKING PLACE FILTER
         **********************/
        $where_stockingPlaceFilter = '';
        if (isset($filters['s'])) {
            $stocking_places_selection = $filters['s'];

            // Prepare WHERE clause
            $where_stockingPlaceFilter .= '(';
            foreach ($stocking_places_selection as $stocking_place_id) {
                $where_stockingPlaceFilter .= 'item.stocking_place_id=' . $stocking_place_id . ' OR ';
            }
            // Remove the last " OR "
            if ($where_stockingPlaceFilter != "(") {
                $where_stockingPlaceFilter = substr($where_stockingPlaceFilter, 0, -4);
                $where_stockingPlaceFilter .= ')';
            } else {
                $where_stockingPlaceFilter .= '';
            }

            // Add this part of WHERE clause to the global WHERE clause
            if ($where_itemsFilters != '') {
                // Add new filter after existing filters
                $where_itemsFilters .= ' AND ';
            }
            $where_itemsFilters .= $where_stockingPlaceFilter;
        }

        /*********************
         ** ITEM TAGS FILTER
         **********************/
        $where_itemTagsFilter = '';

        if (isset($filters['t'])) {
            // Get a list of item_tag_link elements
            $this->item_tag_link_model = new Item_tag_link_model();
            $item_tags_selection = $filters['t'];

            $where_itemTagLinks = '';
            foreach ($item_tags_selection as $item_tag) {
                $where_itemTagLinks .= 'item_tag_id=' . $item_tag . ' OR ';
            }
            // Remove the last " OR "
            $where_itemTagLinks = substr($where_itemTagLinks, 0, -4);

            $item_tag_links = $this->item_tag_link_model->where($where_itemTagLinks)->findAll();

            // Prepare WHERE clause for all corresponding items
            $where_itemTagsFilter .= '(';
            foreach ($item_tag_links as $item_tag_link) {
                $where_itemTagsFilter .= 'item.item_common_id=' . $item_tag_link['item_common_id'] . ' OR ';
            }
            // Remove the last " OR "
            if ($where_itemTagsFilter != "(") {
                $where_itemTagsFilter = substr($where_itemTagsFilter, 0, -4);
                $where_itemTagsFilter .= ')';
            } else {
                // No item_tag_link found : no item correspond to the filter.
                // We use "item_id=-1" filter to return no item.
                $where_itemTagsFilter = 'item.item_common_id=-1';
            }

            // Add this part of WHERE clause to the global WHERE clause
            if ($where_itemsFilters != '') {
                // Add new filter after existing filters
                $where_itemsFilters .= ' AND ';
            }
            $where_itemsFilters .= $where_itemTagsFilter;
        }

        if ($where_itemGroupFilter !== '') {
            $join_item_common = 'item_common.item_common_id = item.item_common_id';
        }

        /*********************
         ** ENTITY TAG FILTERS
         **********************/

        if (isset($filters['e']) && $filters['e'] !== 0) {
            $join_items = $this->db->table('entity')
                                   ->where('entity_id', $filters['e'])
                                   ->join('item_group', 'item_group.fk_entity_id = entity.entity_id', 'inner')
                                   ->join('stocking_place', 'stocking_place.fk_entity_id = entity.entity_id', 'inner')
                                   ->join('item_common', 'item_common.item_group_id = item_group.item_group_id', 'inner')
                                   ->join('item', 'item.stocking_place_id = stocking_place.stocking_place_id AND item.item_common_id = item_common.item_common_id', 'inner');
        }

        /*********************
         ** GET FILTERED ITEMS
         **********************/
        if (isset($filters['e']) && $filters['e'] !== 0) {
            $items = $join_items->where($where_itemsFilters)->get()->getResultArray();
        } else {
            $items = $this->asArray()->where($where_itemsFilters)->join('item_common', 'item_common.item_common_id = item.item_common_id')->find();
        }

        foreach ($items as &$item) {
            $item['stocking_place'] = $this->getStockingPlace($item);
            $item['inventory_number'] = $this->getInventoryNumber($item);
            $item['condition'] = $this->getItemCondition($item);
            $item['current_loan'] = $this->getCurrentLoan($item);
            $item['image'] = $this->item_common_model->getImage($item);
            $item['image_path'] = $this->item_common_model->getImagePath($item);
        }

        return $items;
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
        $stockingPlace = $this->stocking_place_model->asArray()->where(["stocking_place_id" => $item['stocking_place_id']])->first();


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
