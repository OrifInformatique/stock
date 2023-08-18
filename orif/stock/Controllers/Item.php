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

class Item extends BaseController {

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

    /**
     * Display items list, with filtering
     *
     * @param integer $page
     * @return void
     */
    public function index($page = 1) {
        // Load list of elements to display as filters
        $output['item_tags'] = $this->item_tag_model->dropdown('name');

        $output['item_conditions'] = $this->item_condition_model->dropdown('name');

        $output['sort_order'] = array(lang('MY_application.sort_order_name'),
                                        lang('MY_application.sort_order_stocking_place_id'),
                                        lang('MY_application.sort_order_date'),
                                        lang('MY_application.sort_order_inventory_number'));
        $output['sort_asc_desc'] = array(lang('MY_application.sort_order_asc'),
                                            lang('MY_application.sort_order_des'));

        // Prepare search filters values to send to the view
        if (!isset($output["ts"])) $output["ts"] = '';
        if (!isset($output["c"])) $output["c"] = '';
        if (!isset($output["g"])) $output["g"] = '';
        if (!isset($output["s"])) $output["s"] = '';
        if (!isset($output["t"])) $output["t"] = '';
        if (!isset($output["o"])) $output["o"] = '';
        if (!isset($output["ad"])) $output["ad"] = '';
        if (!isset($output["e"])) $output["e"] = '';

        $output['entities'] = $this->dropdown($this->entity_model->findAll(), 'entity_id');
        $output['has_entities'] = true;

        if (isset($_SESSION['user_id'])) {
            $userDefaultEntity = $this->user_entity_model->where('fk_user_id', $_SESSION['user_id'])->where('default', true)->first();
            $defaultEntity = isset($userDefaultEntity) ? $this->entity_model->find($userDefaultEntity['fk_entity_id']) : null;
            $output['has_entities'] = $this->config->access_lvl_admin > $_SESSION['user_access'] ? count($this->user_entity_model->where('fk_user_id', $_SESSION['user_id'])->findAll()) > 0 : true;
        }

        $output['default_entity'] = isset($defaultEntity['entity_id']) ? $defaultEntity['entity_id'] : ($this->entity_model->first()['entity_id'] ?? null);

        $filters = $_GET;

        $filters['e'] = $this->getEFilter($filters);

        $where = isset($filters['e']) && $filters['e'] !== 0 ? "fk_entity_id = {$filters['e']}" : "fk_entity_id IS NULL";

        $output['item_groups'] = $this->dropdown($this->item_group_model->select(["item_group_id", "name"])->where($where)->findAll(), 'item_group_id');

        $output['stocking_places'] = $this->dropdown($this->stocking_place_model->select(["stocking_place_id", "name"])->where($where)->findAll(), 'stocking_place_id');

        $output['entities_has_items'] = $this->has_items(false);

        // Send the data to the View
        return $this->display_view('Stock\Views\item\list', $output);
    }

    private function load_list($page = 1)
    {
        // Store URL to make possible to come back later (from item detail for example)
        $_SESSION['items_list_url'] = base_url('item/index/'.$page);
        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
            $_SESSION['items_list_url'] .= '?'.$_SERVER['QUERY_STRING'];
        }

        // Get user's search filters and add default values
        $filters = $_GET;
        if (!isset($filters['c'])) {
            // No condition selected for filtering, default filtering for "functional" items
            $filters['c'] = array($this->config->functional_item_condition);
        }
        
        $filters['e'] = $this->getEFilter($filters);

        $item_groups = $this->dropdown($this->item_group_model->where('fk_entity_id', $filters['e'] != 0 ? $filters['e'] : null)->findAll(), 'item_group_id');
        $stocking_places = $this->dropdown($this->stocking_place_model->where('fk_entity_id', $filters['e'] != 0 ? $filters['e'] : null)->findAll(), 'stocking_place_id');

        $output['div_item_groups'] = form_label(lang('MY_application.field_group'),'item_groups-multiselect').form_dropdown('g[]', $item_groups, isset($_GET["g"]) ? $_GET["g"] : "", 'id="item_groups-multiselect" multiple="multiple"');
        $output['div_stocking_places'] = form_label(lang('MY_application.field_stocking_place'),'stocking_places-multiselect').form_dropdown('s[]', $stocking_places, isset($_GET["s"]) ? $_GET["s"] : "", 'id="stocking_places-multiselect" multiple="multiple"');

        // Sanitize $page parameter
        if (empty($page) || !is_numeric($page) || $page<1) {
            $page = 1;
        }

        $output['items'] = $this->item_model->get_filtered($filters);

        // Verify the existence of the sort order key in filters
        if(array_key_exists("o", $filters)){
            switch ($filters['o']) {
                case 1:
                $sortValue = "stocking_place_id";
                break;
                case 2:
                $sortValue = "buying_date";
                break;
                case 3:
                $sortValue = "inventory_number";
                break;
                //In case of problem, it automatically switches to name
                default:
                case 0:
                $sortValue = "name";
                break;
            }
        } else {
            // default sort by name
            $sortValue = "name";
        }

        // If not 1, order will be ascending
        if(array_key_exists("ad", $filters)){
            $asc = $filters['ad'] != 1;
        } else {
            // default sort order is asc
            $asc = true;
        }
        $output['items'] = sortBySubValue($output['items'], $sortValue, $asc);

        // Add page title
        $output['title'] = lang('My_application.page_item_list');

        // Pagination
        $items_count = count($output["items"]);
        //$output['pagination'] =  $this->load_pagination($items_count)->create_links();
        $output['pagination'] = $this->load_pagination($items_count, $page);

        $output['number_page'] = $page;
        if($output['number_page']>ceil($items_count/$this->config->items_per_page)) $output['number_page']=ceil($items_count/$this->config->items_per_page);

        // Keep only the slice of items corresponding to the current page
        $output["items"] = array_slice($output["items"], ($output['number_page']-1)*$this->config->items_per_page, $this->config->items_per_page);

        // Format dates
        array_walk($output["items"], function(&$item) {
            $loan = $item['current_loan'];
            if (!isset($loan['planned_return_date'])) {
                $loan['planned_return_date'] = lang('MY_application.text_none');
            } else {
                $loan['planned_return_date'] = databaseToShortDate($loan['planned_return_date']);
            }
            if (isset($loan['date'])) {
                $loan['date'] = databaseToShortDate($loan['date']);
            }

            $item['current_loan'] = $loan;
        });

        // Get the amount of late loans
        if (isset($filters['e']) && $filters['e'] !== 0) {
            $output['late_loans_count'] = $this->loan_model->get_late_loans_by_entity($filters['e']);
        } else {
            $output['late_loans_count'] = count($this->loan_model->get_late_loans());
        }

        if (isset($_SESSION['user_id'])) {
            $entities = $this->user_entity_model->where('fk_user_id', $_SESSION['user_id'])->findColumn('fk_entity_id');
            $output['user_entities'] = $entities;
        }

        return $output;
    }

    public function load_list_json($page = 1){
        return json_encode($this->load_list($page));
    }

    public function load_pagination($nbr_items, $page)
    {
        // Create the pagination
        $pager = \Config\Services::pager();

        return $pager->makeLinks($page, $this->config->items_per_page, $nbr_items);
    }

    /**
     * Add a new item
     *
     * @return void
     */
    public function create($entity_id, $item_common_id = null) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_entity($_SESSION['user_id'], $entity_id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) 
        {
            if (!is_null($item_common_id)) {
                $item_common = $this->item_common_model->find($item_common_id);

                if (is_null($item_common)) {
                    // Item common does not exist
                    return redirect()->to(base_url());
                } else {
                    $data['item_common'] = $item_common;
                }
            }

            // Get new item id and set picture_prefix
            $item_id = $this->item_model->getFutureId();
            $_SESSION['picture_prefix'] = str_pad($item_id, $this->config->inventory_number_chars, "0", STR_PAD_LEFT);

            // Define image path variables
            $temp_image_name = $_SESSION["picture_prefix"].$this->config->image_picture_suffix.$this->config->image_tmp_suffix.$this->config->image_extension;
            $new_image_name = $_SESSION["picture_prefix"].$this->config->image_picture_suffix.$this->config->image_extension;

            // Check if the user cancelled the form
            if (isset($_POST['submitCancel'])) {
                $tmp_image_file = isset(glob($this->config->images_upload_path.$temp_image_name)[0])?glob($this->config->images_upload_path.$temp_image_name)[0]:null;

                // Check if there is a temporary file, if yes then delete it
                if ($tmp_image_file != null || $tmp_image_file != false) {
                    unlink($tmp_image_file);
                }

                return redirect()->to(base_url());
            }

            $validation = $this->set_validation_rules();

            $data['upload_errors'] = "";

            $upload_failed = false;

            if (isset($_FILES['linked_file']) && $_FILES['linked_file']['name'] != '') {

                // LINKED FILE UPLOADING
                $upload_path = '../../public/uploads/files/';
                $allowed_types = [
                    'application/pdf', //pdf
                    'application/msword', //doc
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
                ];
                $max_size = 2 * 1024 * 1024; //2MB max

                $file = $this->request->getFile('linked_file');

                if (!is_null($file) && $file->isValid() && $file->getSize() <= $max_size && in_array($file->getMimeType(), $allowed_types)) {
                    $file->store($upload_path);
                    $itemArray['linked_file'] = $file->getName();
                } else {
                    $upload_failed = true;
                    $data['upload_errors'] = [];
                    // Manually shove in the errors, as the upload library is no longer a thing
                    if (is_null($file) || !$file->isValid()) $data['upload_errors'][] = lang('upload.upload_file_partial');
                    if (!is_null($file) && $file->getSize() > $max_size) $data['upload_errors'][] = lang('upload.upload_file_exceeds_form_limit');
                    if (!is_null($file) && !in_array($file->getMimeType(), $allowed_types)) $data['upload_errors'][] = lang('upload.upload_invalid_filetype');
                }
            }

            if (!is_null($this->request->getVar('btn_submit')) && !empty($_POST) && $validation->run($_POST) && $upload_failed != TRUE) {
                $linkArray = array();

                foreach ($_POST as $key => $value) {
                    if (substr($key, -4, null) == "tags") {
                        // Stock links to be created when the item will exist
                        $linkArray[] = $value;
                    } else {
                        if (substr($key, 0, 11) == 'item_common' && is_null($item_common_id)) {
                            $itemCommonArray[substr($key, 12, null)] = $value;
                        } else {
                            $itemArray[$key] = $value;
                        }
                    }
                }

                if (is_null($item_common_id)) {
                    // Turn Temporaty Image into a final one if there is one
                    if (file_exists($this->config->images_upload_path.$temp_image_name)) {
                        rename($this->config->images_upload_path.$temp_image_name, $this->config->images_upload_path.$new_image_name);
                        $itemCommonArray['image'] = $new_image_name;
                    }

                    $item_common_id = $this->item_common_model->insert($itemCommonArray);

                    if (count($this->item_common_model->errors()) == 0) {
                        foreach ($linkArray as $tag) {
                            $this->item_tag_link_model->insert(array("item_tag_id" => $tag, "item_common_id" => $item_common_id));
                        }

                        $itemArray['item_common_id'] = $item_common_id;
                        $itemArray["created_by_user_id"] = $_SESSION['user_id'];

                        $item_id = $this->item_model->insert($itemArray);

                        return redirect()->to(base_url("/item_common/view/" . $item_common_id));
                    } else {
                        $data['errors'] = $this->item_common_model->errors();
                    }
                } else {
                    $itemArray['item_common_id'] = $item_common_id;
                    $itemArray["created_by_user_id"] = $_SESSION['user_id'];

                    $item_id = $this->item_model->insert($itemArray);

                    return redirect()->to(base_url("/item_common/view/" . $item_common_id));
                }
            } else if (!is_null($this->request->getVar('btn_submit_photo'))) {
                // If the user want to display the image form, we first save fields
                // values in the session, then redirect him to the image form
                $_SESSION['POST'] = $_POST;

                return redirect()->to(base_url("picture/select_picture"));
            }
            // Load entities
            if (isset($_SESSION['user_access']) && isset($_SESSION['user_id']) && $_SESSION['user_access'] < config('\User\Config\UserConfig')->access_lvl_admin) {
                $entity_ids = $this->user_entity_model->where('fk_user_id', $_SESSION['user_id'])->findColumn('fk_entity_id');
                $data['entities_list'] = $this->entity_model->find($entity_ids);
            } else {
                $data['entities_list'] = $this->entity_model->findAll();
            }
            
            $data['entities'] = $this->dropdown($data['entities_list'], 'entity_id');

            $data['stocking_places'] = $this->dropdown($this->stocking_place_model->where('fk_entity_id', $entity_id)->findAll(), 'stocking_place_id');

            $data['suppliers'] = $this->dropdown($this->supplier_model->findAll(), 'supplier_id');

            // Load item groups
            $data['item_groups_list'] = $this->item_group_model->where('fk_entity_id', $entity_id)->findAll();
            $data['item_groups'] = $this->dropdown($data['item_groups_list'], 'item_group_id');

            $data['conditions'] = $this->dropdown($this->item_condition_model->findAll(), 'item_condition_id');

            // Load the tags
            $data['item_tags_list'] = $this->item_tag_model->findAll();
            $data['item_tags'] = $this->dropdown($data['item_tags_list'], 'item_tag_id');

            // Load entity id
            $data['selected_entity_id'] = $entity_id;

            $data['item_id'] = $this->item_model->getFutureId();

            if (!isset($data['errors'])) {
                $data['errors'] = $validation->getErrors();
            }

            // Remember fields in case 
            if (isset($_SESSION['POST'])) {
                foreach ($_SESSION['POST'] as $key => $value) {
                    $data[$key] = $value;
                }
                unset($_SESSION['POST']);
            }

            $this->display_view('Stock\Views\item\form', $data);
        } else {
            // Access is not allowed
            return redirect()->to(base_url());
        }
    }
    
    /**
     * Modifz a new item
     *
     * @return void
     */
    public function modify($item_id) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_entity($_SESSION['user_id'], $item_id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) 
        {
            $item = $this->item_model->find($item_id);
            $item_common = $this->item_common_model->find($item['item_common_id']);

            $_SESSION['picture_prefix'] = str_pad($item_id, $this->config->inventory_number_chars, "0", STR_PAD_LEFT);

            $validation = $this->set_validation_rules();

            $upload_failed = false;

            if (!is_null($this->request->getVar('btn_submit')) && !empty($_POST) && $validation->run($_POST) && $upload_failed != TRUE) {
                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 11) != 'item_common') {
                        $itemArray[$key] = $value;
                    }
                }

                $itemArray["modified_by_user_id"] = $_SESSION['user_id'];

                $this->item_model->update($item_id, $itemArray);

                return redirect()->to(base_url("/item_common/view/" . $item['item_common_id']));
            } else {
                $data['errors'] = $validation->getErrors();
            }

            // Load entities
            if (isset($_SESSION['user_access']) && isset($_SESSION['user_id']) && $_SESSION['user_access'] < config('\User\Config\UserConfig')->access_lvl_admin) {
                $entity_ids = $this->user_entity_model->where('fk_user_id', $_SESSION['user_id'])->findColumn('fk_entity_id');
                $data['entities_list'] = $this->entity_model->find($entity_ids);
            } else {
                $data['entities_list'] = $this->entity_model->findAll();
            }

            $entity_id = $this->stocking_place_model->find($item['stocking_place_id'])['fk_entity_id'];
            
            $data['entities'] = $this->dropdown($data['entities_list'], 'entity_id');

            $data['stocking_places'] = $this->dropdown($this->stocking_place_model->where('fk_entity_id', $entity_id)->findAll(), 'stocking_place_id');

            $data['suppliers'] = $this->dropdown($this->supplier_model->findAll(), 'supplier_id');

            // Load item groups
            $data['item_groups_list'] = $this->item_group_model->where('fk_entity_id', $entity_id)->findAll();
            $data['item_groups'] = $this->dropdown($data['item_groups_list'], 'item_group_id');

            $data['conditions'] = $this->dropdown($this->item_condition_model->findAll(), 'item_condition_id');

            // Load the tags
            $data['item_tags_list'] = $this->item_tag_model->findAll();
            $data['item_tags'] = $this->dropdown($data['item_tags_list'], 'item_tag_id');

            // Load entity id
            $data['selected_entity_id'] = $entity_id;

            $data['item_common'] = $item_common;
            $data['item'] = $item;
            $data['item_id'] = $item_id;

            $this->display_view('Stock\Views\item\form', $data);
        } else {
            // Access is not allowed
            return redirect()->to(base_url());
        }
    }

    /**
     * Delete an item
     * ACCESS RESTRICTED FOR ADMINISTRATORS ONLY
     *
     * @param integer $id
     * @return void
     */
    public function delete($id, $action = 0) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin)
        {
            $item = $this->item_model->find($id);
            $item_common = $this->item_common_model->find($item['item_common_id']);

            switch($action) {
                case 0: // Display confirmation
                    $output = array(
                        'item_common' => $item_common,
                        'inventory_number' => $this->item_model->getInventoryNumber($item),
                        'title' => lang('stock_lang.title_delete_item')
                    );
                    $this->display_view('Stock\Views\item\confirm_delete', $output);
                    break;
                case 1: // Delete item_common and related items
                    $this->inventory_control_model->where('item_id', $item['item_id'])->delete();
                    $this->loan_model->where('item_id', $item['item_id'])->delete();

                    $this->item_model->delete($item['item_id']);
                    return redirect()->to(base_url("item_common/view/{$item_common['item_common_id']}"));
                default: // Do nothing
                    return redirect()->to("/item_common/view/{$item_common['item_common_id']}");
            }
        } else {
            // Access not allowed
            return redirect()->to(base_url());
        }
    }

    /**
     * Create inventory control for one given item
     *
     * @param integer $id
     * @return void
     */
    public function create_inventory_control($id = NULL) {
        // Check if this is allowed
        if (!empty($id) &&
            isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) {

            $this->user_model = new User_model();

            $data['item'] = $this->item_model->find($id);
            $data['item']['inventory_number'] = $this->item_model->getInventoryNumber($data['item']);
            $data['controller'] = $this->user_model->find($_SESSION['user_id']);

            if (isset($_POST['date']) && $_POST['date'] != '') {
                $data['date'] = $_POST['date'];
            } else {
                $data['date'] = date($this->config->database_date_format);
            }

            if (isset($_POST['remarks'])) {
                $data['remarks'] = $_POST['remarks'];
            } else {
                $data['remarks'] = '';
            }

            if (isset($_POST['submit'])) {
                $inventory_control['item_id'] = $id;
                $inventory_control['controller_id'] = $_SESSION['user_id'];
                $inventory_control['date'] = $data['date'];
                $inventory_control['remarks'] = $data['remarks'];

                $this->inventory_control_model->insert($inventory_control);
                return redirect()->to("/item/view/".$id);
            } else {
                $this->display_view('Stock\Views\inventory_control\form', $data);
            }
        } else {
            // No item specified or access is not allowed, display items list
            return redirect()->to('/item');
        }
    }

    /**
     * Display inventory controls list for one given item
     *
     * @param integer $id
     * @return void
     */
    public function inventory_controls($id = NULL) {
        if (!empty($id) &&
            isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) {

            helper('MY_date');

            // Get item object with related inventory controls
            $output['item'] = $this->item_model->find($id);
            $output['item_common'] = $this->item_common_model->find($output['item']['item_common_id']);
            $output['inventory_controls'] = $this->inventory_control_model->where('item_id='.$id)->findAll();
            $output['item']['inventory_number'] = $this->item_model->getInventoryNumber($output['item']);
            array_walk($output['inventory_controls'], function(&$control) {
                $control['controller'] = $this->inventory_control_model->getUser($control['controller_id']);
            });

            $this->display_view('Stock\Views\inventory_control\list', $output);
        } else {

            // No item specified or access not allowed, display items list
            return redirect()->to(base_url());
        }
    }

    /**
     * Create loan for one given item
     *
     * @param integer $id
     * @return void
     */
    public function create_loan($id = NULL) {
        // Check if this is allowed
        if (!empty($id) &&
            isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) && 
            $this->user_entity_model->check_user_item_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) {

            // Get item object and related loans
            $item = $this->item_model->find($id);

            $data['item'] = $item;
            $data['item_id'] = $id;
            $data['new_loan'] = true;
            $users = (new User_model())->findAll();
            $data['users'] = array_map(function($user) {
                return [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                ];
            }, $users);

            // Test input
            if (!empty($_POST)) {
                $validation = \Config\Services::validation();
                $user_ids = implode(',', array_map(function($user) { return $user['id']; }, $users)) . ','; // Allows empty ids

                $validation->setRule("date", "Date du prêt", 'required', array('required' => "La date du prêt doit être fournie"));
                $validation->setRule("planned_return_date", lang('MY_application.field_loan_planned_return'), 'required', [
                    'required' => lang('MY_application.msg_err_no_planned_return_date'),
                ]);
                $validation->setRule("borrower_email", lang('MY_application.field_borrower_email'), 'required|valid_email', [
                    'required' => lang('MY_application.msg_err_no_loan_email'),
                    'valid_email' => lang('MY_application.msg_err_email'),
                ]);
                $validation->setRule("loan_to_user_id", lang('MY_application.field_loan_to_user'), "if_exist|in_list[{$user_ids}]", [
                    'in_list' => lang('MY_application.msg_err_invalid_loan_to'),
                ]);

                if ($validation->run($_POST) === TRUE) {
                    $loanArray = $_POST;

                    if ($loanArray["real_return_date"] == 0 || $loanArray["real_return_date"] == "0000-00-00" || $loanArray["real_return_date"] == "") {
                        $loanArray["real_return_date"] = NULL;
                    }
                    if ($loanArray["loan_to_user_id"] == 0 || $loanArray["loan_to_user_id"] == "") {
                        $loanArray["loan_to_user_id"] = NULL;
                    }

                    $loanArray["item_id"] = $id;

                    $loanArray["loan_by_user_id"] = $_SESSION['user_id'];

                    $this->loan_model->insert($loanArray);

                    return redirect()->to("/item/loans/".$id);
                } else {
                    $data['errors'] = $validation->getErrors();

                    // List of data inputs from the user
                    $inputs = ['date', 'planned_return_date', 'real_return_date', 'loan_to_user_id', 'borrower_email', 'item_localisation'];
                    foreach ($inputs as $input) {
                        if (isset($_POST[$input])) $data[$input] = $_POST[$input];
                    }
                }
            }
            $this->display_view('Stock\Views\loan\form', $data);
        } else {

            // No item specified or access is not allowed, redirect to items list
            return redirect()->to('/item');
        }
    }

    /**
     * Modify some loan
     *
     * @param integer $id
     * @return void
     */
    public function modify_loan($id = NULL) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_loan_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) {

            // get the data from the loan with this id (to fill the form or to get the concerned item)
            $loan = $this->loan_model->find($id);

            $data['date'] = $loan['date'];
            $data['planned_return_date'] = $loan['planned_return_date'];
            $data['real_return_date'] = $loan['real_return_date'];
            $data['item_localisation'] = $loan['item_localisation'];
            $data['item_id'] = $loan['item_id'];
            $data['loan_to_user_id'] = $loan['loan_to_user_id'];
            $data['borrower_email'] = $loan['borrower_email'];
            $data['new_loan'] = false;
            $users = (new User_model())->findAll();
            $data['users'] = array_map(function($user) {
                return [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                ];
            }, $users);

            if (!empty($_POST)) {
                // test input
                $validation = \Config\Services::validation();
                $user_ids = implode(',', array_map(function($user) { return $user['id']; }, $users)) . ','; // Allows empty ids

                $validation->setRule("date", "Date du prêt", 'required', array('required' => "La date du prêt doit être fournie"));
                $validation->setRule("planned_return_date", lang('MY_application.field_loan_planned_return'), 'required', [
                    'required' => lang('MY_application.msg_err_no_planned_return_date'),
                ]);
                $validation->setRule("borrower_email", lang('MY_application.field_borrower_email'), 'required|valid_email', [
                    'required' => lang('MY_application.msg_err_no_loan_email'),
                    'valid_email' => lang('MY_application.msg_err_email'),
                ]);
                $validation->setRule("loan_to_user_id", lang('MY_application.field_loan_to_user'), "if_exist|in_list[{$user_ids}]", [
                    'in_list' => lang('MY_application.msg_err_invalid_loan_to'),
                ]);

                if ($validation->run($_POST) === TRUE) {
                    //Declarations

                    $loanArray = $_POST;

                    if ($loanArray["real_return_date"] == 0 || $loanArray["real_return_date"] == "0000-00-00" || $loanArray["real_return_date"] == "") {
                        $loanArray["real_return_date"] = NULL;
                    }
                    if ($loanArray["loan_to_user_id"] == 0 || $loanArray["loan_to_user_id"] == "") {
                        $loanArray["loan_to_user_id"] = NULL;
                    }

                    // Execute the changes in the item table
                    $this->loan_model->update($id, $loanArray);

                    return redirect()->to("/item/loans/".$data["item_id"]);
                } else {
                    $data['errors'] = $validation->getErrors();

                    // List of data inputs from the user
                    $inputs = ['date', 'planned_return_date', 'real_return_date', 'loan_to_user_id', 'borrower_email', 'item_localisation'];
                    foreach ($inputs as $input) {
                        if (isset($_POST[$input])) $data[$input] = $_POST[$input];
                    }
                }
            }
            $this->display_view('Stock\Views\loan\form', $data);
        } else {
            // Access is not allowed
            return redirect()->to("/item");
        }
    }


    /**
     *  Display loans list for one given item
     *
     * @param integer $id
     * @return void
     */
    public function loans($id = NULL) {
        if (!empty($id) &&
            isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_item_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access']>=config('\User\Config\UserConfig')->access_lvl_registered) {

            // Get item object and related loans
            $item = $this->item_model->find($id);
            $item_common = $this->item_common_model->find($item['item_common_id']);
            $item['inventory_number'] = $this->item_model->getInventoryNumber($item);
            $loans = $this->loan_model->where('item_id', $item['item_id'])->findAll();
            array_walk($loans, function(&$loan) {
                $loan['loan_by_user'] = $this->loan_model->get_loaner($loan);
                $loan['date'] = databaseToShortDate($loan['date']);
                if (!is_null($loan['planned_return_date'])) {
                    $loan['planned_return_date'] = databaseToShortDate($loan['planned_return_date']);
                }
                if (!is_null($loan['real_return_date'])) {
                    $loan['real_return_date'] = databaseToShortDate($loan['real_return_date']);
                }
                if (!is_null($loan['loan_to_user_id'])) {
                    $loan['loan_to_user'] = $this->loan_model->get_borrower($loan);
                }
            });

            $output['item'] = $item;
            $output['item_common'] = $item_common;
            $output['loans'] = $loans;

            $this->display_view('Stock\Views\loan\list', $output);
        } else {

            // No item specified or access not allowed, display items list
            return redirect()->to('/item');
        }
    }

    /**
     * Delete a loan
     * ACCESS RESTRICTED FOR ADMINISTRATORS ONLY
     *
     * @param integer $id
     * @param [type] $command
     * @return void
     */
    public function delete_loan($id, $command = NULL) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) &&
            $_SESSION['logged_in'] == true &&
            isset($_SESSION['user_id']) &&
            $this->user_entity_model->check_user_loan_entity($_SESSION['user_id'], $id) &&
            $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin) {

            if (empty($command)) {
                $data['db'] = 'loan';
                $data['id'] = $id;

                $this->display_view('Stock\Views\item\confirm_delete', $data);
            } else {
                // get the data from the loan with this id (to fill the form or to get the concerned item)
                $data = $this->loan_model->find($id);

                $this->loan_model->delete($id);

                return redirect()->to("/item/loans/" . $data["item_id"]);
            }
        } else {
            // Access is not allowed
            return redirect()->to('/item');
        }
    }

    /**
     * Displays the list for all active loans
     *
     * @return void
     */
    public function list_loans() {
        $output['entities'] = $this->entity_model->dropdown('name');
        $this->display_view('Stock\Views\item\loans_list', $output);
    }

    /**
     * Loads the list of loands
     *
     * @param integer $page
     * @return array
     */
    public function load_list_loans($page = 1) {
        helper('MY_date');

        // Store URL to make possible to come back later (from item detail for example)
        $_SESSION['items_list_url'] = base_url('item/index/'.$page);
        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
            $_SESSION['items_list_url'] .= '?'.$_SERVER['QUERY_STRING'];
        }

        // Add page title
        $title = lang('My_application.page_item_list');
        $late_loans_count = 0;

        // Get user's search filters and add default values
        $filters = $_GET;

        // Sanitize $page parameter
        if (empty($page) || !is_numeric($page) || $page<1) {
            $page = 1;
        }

        // Get Loans and corresponding items
        if (isset($filters['e'])) {
            $loans = $this->db->table('entity')
                              ->where('entity_id', $filters['e'])
                              ->where('real_return_date', null)
                              ->join('stocking_place', 'stocking_place.fk_entity_id = entity.entity_id', 'inner')
                              ->join('item', 'item.stocking_place_id = stocking_place.stocking_place_id', 'inner')
                              ->join('loan', 'loan.item_id = item.item_id', 'inner')
                              ->select(['loan.loan_id', 'loan.date', 'loan.item_localisation', 'loan.remarks', 'loan.planned_return_date', 'loan.real_return_date', 'loan.item_id', 'loan.loan_by_user_id', 'loan.loan_to_user_id', 'loan.borrower_email'])
                              ->get()->getResultArray();

            $late_loans_count = $this->loan_model->get_late_loans_by_entity($filters['e']);
        } else {
            $loans = $this->loan_model->where('real_return_date', NULL)->findAll();
            $late_loans_count = count($this->loan_model->get_late_loans());
        }

        if (count($loans) > 0) {
            foreach($loans as $loan) {
                $item = $this->loan_model->get_item($loan);
                $item['stocking_place'] = $this->item_model->getStockingPlace($item);
                $item['inventory_number'] = $this->item_model->getInventoryNumber($item);
                $item['condition'] = $this->item_model->getItemCondition($item);
                $item['current_loan'] = $this->item_model->getCurrentLoan($item);
                $item['image'] = $this->item_common_model->getImage($item);
                $item['image_path'] = $this->item_common_model->getImagePath($item);
                $item['name'] = $this->item_common_model->getName($item);
                $items[] = $item;
            }
    
            // Sort items, separate late loans and others, then sort by name
            usort($items, function($a, $b) {
                $late_a = $a['current_loan']['is_late'];
                $late_b = $b['current_loan']['is_late'];
                if ($late_a != $late_b) {
                    return $late_b <=> $late_a;
                } else {
                    return strtolower($a['name']) <=> strtolower($b['name']);
                }
            });
    
            // Pagination
            $items_count = count($items);
            $pagination = $this->load_pagination($items_count, $page);
    
            $number_page = $page;
            if($number_page > ceil($items_count/$this->config->items_per_page)) $number_page = ceil($items_count/$this->config->items_per_page);
    
            // Keep only the slice of items corresponding to the current page
            $items = array_slice($items, ($number_page-1)*$this->config->items_per_page, $this->config->items_per_page);
    
            // Format dates
            array_walk($items, function(&$item) {
                $loan = $item['current_loan'];
                if (!isset($loan['planned_return_date']) || is_null($loan['planned_return_date'])) {
                    $loan['planned_return_date'] = lang('MY_application.text_none');
                } else {
                    $loan['planned_return_date'] = databaseToShortDate($loan['planned_return_date']);
                }
                $loan['date'] = databaseToShortDate($loan['date']);
    
                $item['current_loan'] = $loan;
            });
    
            return [
                'items' => $items,
                'title' => $title,
                'pagination' => $pagination,
                'number_page' => $number_page,
                'late_loans_count' => $late_loans_count,
            ];
        } else {
            return [
                'items' => null,
                'title' => $title,
                'pagination' => null,
                'number_page' => 0,
                'late_loans_count' => 0,
            ];
        }
    }

    /**
     * Displays the JSON version of the result of `load_list_loans`
     *
     * @param integer $page
     * @return void
     */
    public function load_list_loans_json($page = 1) {
        return json_encode($this->load_list_loans($page));
    }

    /**
     * Set validation rules for create and update form
     *
     *
     * @param integer $id
     * @return mixed
     */
    private function set_validation_rules() {
        $validation = \Config\Services::validation();

        $validation->setRule("inventory_prefix", lang('MY_application.field_inventory_number'), 'required');
        $validation->setRule("stocking_place_id", lang('MY_application.field_stocking_place'), 'required');

        return $validation;
    }

    /**
     * @param  mixed $entityId
     * @return void
     */
    public function has_items($isJSON = true, $entityId = null) {
        // Get result by item_group
        $builder = $this->db->table('entity');
        $entity = !is_null($entityId) ? $builder->where('entity_id', $entityId) : $builder;
        $join_item_group = $entity->join('item_group', 'item_group.fk_entity_id = entity.entity_id', 'inner');
        $join_stocking_place = $join_item_group->join('stocking_place', 'stocking_place.fk_entity_id = entity.entity_id', 'inner');
        $join_item = $join_stocking_place->join('item', 'item.stocking_place_id = stocking_place.stocking_place_id', 'inner')
                                         ->join('item_common', 'item_common.item_group_id = item_group.item_group_id');
        
        // Count all results
        $nb_items = $join_item->countAllResults();
        $result = $nb_items > 0;

        if ($isJSON) {
            // Makes sure the debug toolbar is not sent with the JSON
            $this->response->setContentType('Content-Type: application/json');
            return json_encode([
                'has_items' => $result
            ]);
        } else {
            return $result;
        }
    }

    /**
     * Get e filter or set the default one 
     *
     * @param  array $filters = $_GET variable
     * @return int
     */
    private function getEFilter($filters): int {        
        if (isset($filters['e'])) {
            return $filters['e'];
        }
        
        if (isset($_SESSION['user_id'])) {
            $entityId = $this->user_entity_model->where('fk_user_id', $_SESSION['user_id'])->where('default', true)->first()['fk_entity_id'] ?? 0;
        } else {
            $entityId = 0;
        }
        
        if ($entityId !== 0) {
            return $entityId;
        }
        
        return $this->entity_model->first()['entity_id'] ?? 0;        
    }
    
    /**
     * Display a form to register the return of a loan
     * 
     * @param $id : The id of the concerned loan
     */
    public function return_loan($id) {
        $loan = $this->loan_model->find($id);

        if (!is_null($loan)) {
            $item = $this->item_model->find($loan['item_id']);
            $item_common = $this->item_common_model->find($item['item_common_id']);
            $item['inventory_item_nb'] = $this->item_model->getInventoryNumber($item);
            $user_model = new User_model();
            $loaner = $user_model->withDeleted()->find($loan['loan_by_user_id']);
    
            $item['inventory_number'] = $this->item_model->getInventoryNumber($item);
            $data['title'] = lang('MY_application.page_return_loan');
            $data['loan'] = $loan;
            $data['item'] = $item;
            $data['item_common'] = $item_common;
            $data['loaner'] = $loaner;
    
            return $this->display_view('Stock\Views\loan\return', $data);
        } else {
            return redirect()->to($_SESSION['_ci_previous_url']);
        }
    }

    /**
     * Save new return date
     * 
     * @param $id : The id of the concerned loan
     */
    public function save_loan_return_date($id) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_registered) {

            $data = [
                'real_return_date' => $this->request->getVar('real_return_date'),
            ];

            //save updated loan data
            $this->loan_model->update($id, $data);
        }

        return redirect()->to(base_url());
    }
}
