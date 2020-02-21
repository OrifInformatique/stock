<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * A controller to display and manage items
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */
class Item extends MY_Controller {

    /* MY_Controller variables definition */
    protected $access_level = "*";

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('item_model');
        $this->load->model('loan_model');
        $this->load->helper('sort');
    }

    /**
     * Display items list, with filtering
     *
     * @param integer $page
     * @return void
     */
    public function index($page = 1) {
        // Load list of elements to display as filters
        $this->load->model('item_tag_model');
        $output['item_tags'] = $this->item_tag_model->dropdown('name');
        $this->load->model('item_condition_model');
        $output['item_conditions'] = $this->item_condition_model->dropdown('name');
        $this->load->model('item_group_model');
        $output['item_groups'] = $this->item_group_model->dropdown('name');
        $this->load->model('stocking_place_model');
        $output['stocking_places'] = $this->stocking_place_model->dropdown('name');
        $output['sort_order'] = array($this->lang->line('sort_order_name'),
                                        $this->lang->line('sort_order_stocking_place_id'),
                                        $this->lang->line('sort_order_date'),
                                        $this->lang->line('sort_order_inventory_number'));
        $output['sort_asc_desc'] = array($this->lang->line('sort_order_asc'),
                                            $this->lang->line('sort_order_des'));
        // Prepare search filters values to send to the view
        if (!isset($output["ts"])) $output["ts"] = '';
        if (!isset($output["c"])) $output["c"] = '';
        if (!isset($output["g"])) $output["g"] = '';
        if (!isset($output["s"])) $output["s"] = '';
        if (!isset($output["t"])) $output["t"] = '';
        if (!isset($output["o"])) $output["o"] = '';
        if (!isset($output["ad"])) $output["ad"] = '';
        // Send the data to the View
        $this->display_view('item/list', $output);
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
            $filters['c'] = array(FUNCTIONAL_ITEM_CONDITION_ID);
        }
        
        // Sanitize $page parameter
        if (empty($page) || !is_numeric($page) || $page<1) {
            $page = 1;
        }
        
        // Get item(s) through filtered search on the database
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
        $output['title'] = $this->lang->line('page_item_list');
        
        // Pagination
        $items_count = count($output["items"]);
        $output['pagination'] =  $this->load_pagination($items_count)->create_links();
        
        $output['number_page'] = $page;
        if($output['number_page']>ceil($items_count/ITEMS_PER_PAGE)) $output['number_page']=ceil($items_count/ITEMS_PER_PAGE);
        
        // Keep only the slice of items corresponding to the current page
        $output["items"] = array_slice($output["items"], ($output['number_page']-1)*ITEMS_PER_PAGE, ITEMS_PER_PAGE);
        
        return $output;
    }
    
    public function load_list_json($page = 1){
        echo json_encode($this->load_list($page));
    }

    public function load_pagination($nbr_items)
    {
        // Create the pagination
        $this->load->library('pagination');

        $config['base_url'] = base_url('/item/index/');
        $config['total_rows'] = $nbr_items;
        $config['per_page'] = ITEMS_PER_PAGE;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = FALSE;
        $config['prev_link'] = FALSE;

        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</li></a>';
        $config['num_links'] = 5;

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        return $this->pagination->initialize($config);
    }
    /**
     * Display details of one single item
     *
     * @param $id : the item to display
     * @return void
     */
    public function view($id = NULL) {

        if (is_null($id)) {
            // No item sellected, display items list
            redirect('/item');
        }

        // Get item object and related objects
        $item = $this->item_model->with('supplier')
                ->with('stocking_place')
                ->with('item_condition')
                ->with('item_group')
                ->get($id);

        if (!is_null($item)) {
            $output['item'] = $item;
            $this->display_view('item/detail', $output);
        } else {
            // $id is not valid, display an error message
            $this->display_view('errors/application/inexistent_item');
        }
    }

    /**
     * Add a new item
     *
     * @return void
     */
    public function create() {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {

            $this->set_validation_rules();

            $data['upload_errors'] = "";
            
            $upload_failed = false;
            
            // If the user want to display the image form, we first save fields
            // values in the session, then redirect him to the image form
            if(isset($_POST['photoSubmit'])){
                $this->session->set_userdata("POST", $_POST);
                
                redirect(base_url("picture/select_picture"));
            }
            
            if (isset($_FILES['linked_file']) && $_FILES['linked_file']['name'] != '') {

                // LINKED FILE UPLOADING
                $config['upload_path'] = './uploads/files/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['max_size'] = 2048;
                $config['max_width'] = 0;
                $config['max_height'] = 0;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('linked_file')) {
                    $itemArray['linked_file'] = $this->upload->data('file_name');
                } else {
                    $data['upload_errors'] = $this->upload->display_errors();
                    $upload_failed = TRUE;
                }
            }

            if ($this->form_validation->run() == TRUE && $upload_failed != TRUE) {
                // No error, save item

                $linkArray = array();

                $this->load->model('item_tag_link_model');

                foreach ($_POST as $key => $value) {
                    if (substr($key, 0, 3) == "tag") {
                        // Stock links to be created when the item will exist
                        $linkArray[] = $value;
                    } else {
                        $itemArray[$key] = $value;
                    }
                }

                $itemArray["created_by_user_id"] = $_SESSION['user_id'];
                
                $this->item_model->insert($itemArray);
                $item_id = $this->db->insert_id();

                foreach ($linkArray as $tag) {
                    $this->item_tag_link_model->insert(array("item_tag_id" => $tag, "item_id" => ($item_id)));
                }
                redirect("item/view/" . $item_id);
            } else {
                // Remember checked tags to display them checked again
                foreach ($_POST as $key => $value) {
                    // If it is a tag
                    if (substr($key, 0, 3) == "tag") {
                        // put it in the data array
                        $tag_link = new stdClass();
                        $tag_link->item_tag_id = substr($key, 3);
                        $data['tag_links'][] = (object) $tag_link;
                    }
                }

                // Load the comboboxes options
                $this->load->model('stocking_place_model');
                $data['stocking_places'] = $this->stocking_place_model->get_all();
                $this->load->model('supplier_model');
                $data['suppliers'] = $this->supplier_model->get_all();
                $this->load->model('item_group_model');
                $data['item_groups_name'] = $this->item_group_model->dropdown('name');

                // Load item groups
                $data['item_groups'] = $this->item_group_model->get_all();

                $this->load->model('item_condition_model');
                $data['condishes'] = $this->item_condition_model->get_all();

                // Load the tags
                $this->load->model('item_tag_model');
                $data['item_tags'] = $this->item_tag_model->get_all();

                $data['item_id'] = $this->item_model->get_future_id();

                // If the user gets back from another view, get the fields values
                // which have been saved in session variable.
                // Then reset this session variable.
                if(isset($_SESSION['POST'])){
                    foreach ($_SESSION['POST'] as $key => $value) {
                        // If it is a tag
                        if (substr($key, 0, 3) == "tag") {
                            // put it in the data array
                            $tag_link = new stdClass();
                            $tag_link->item_tag_id = substr($key, 3);
                            $data['tag_links'][] = (object) $tag_link;
                        }else{
                            $data[$key] = $value;
                        }
                    }
                    unset($_SESSION['POST']);
                }
                
                $this->display_view('item/form', $data);
            }
        } else {
            // Access is not allowed
            $this->ask_for_login();
        }
    }

    /**
     * Modify an existing item
     *
     * @param integer $id
     * @return void
     */
    public function modify($id) {
        // Check if access is allowed
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            $this->load->model('item_tag_link_model');

            // If there is no submit
            if (empty($_POST)) {
                // get the data from the item with this id,
                $data = get_object_vars($this->item_model->get($id));

                // including its tags
                $data['tag_links'] = $this->item_tag_link_model->get_many_by("item_id", $id);
            } else {
                $this->set_validation_rules($id);

                $data['upload_errors'] = "";
                
                $upload_failed = false;
                
                // If the user wants to display the image form, we first save fields
                // values in the session, then redirect him to the image form
                if(isset($_POST['photoSubmit'])){
                    $this->session->set_userdata("POST", $_POST);

                    redirect(base_url("picture/select_picture"));
                    exit();
                }
                
                if (isset($_FILES['linked_file']) && $_FILES['linked_file']['name'] != '') {

                    // LINKED FILE UPLOADING
                    $config['upload_path'] = './uploads/files/';
                    $config['allowed_types'] = 'pdf|doc|docx';
                    $config['max_size'] = 2048;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;

                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('linked_file')) {
                        $itemArray['linked_file'] = $this->upload->data('file_name');
                    } else {
                        $data['upload_errors'] = $this->upload->display_errors();
                        $upload_failed = TRUE;
                    }
                }

                if ($this->form_validation->run() == TRUE && $upload_failed != TRUE) {

                    // Delete ALL the tags for this object
                    $this->item_tag_link_model->delete_by(array('item_id' => $id));

                    foreach ($_POST as $key => $value) {
                        // If it is a tag, since their keys are tag1, tag2, …
                        if (substr($key, 0, 3) == "tag") {
                            // put it in the array for tags.
                            $this->item_tag_link_model->insert(array("item_tag_id" => $value, "item_id" => $id));
                        } else {
                            // put it in th array for item properties.
                            $itemArray[$key] = $value;
                        }
                    }
                    
                    // Execute the changes in the item table
                    $this->item_model->update($id, $itemArray);
                    
                    redirect("/item/view/" . $id);
                } else {
                    // Remember checked tags to display them checked again
                    foreach ($_POST as $key => $value) {
                        // If it is a tag, since their keys are tag1, tag2, …
                        if (substr($key, 0, 3) == "tag") {
                            // put it in the data array
                            $tag_link = new stdClass();
                            $tag_link->item_tag_id = substr($key, 3);
                            $data['tag_links'][] = (object) $tag_link;
                        }
                    }
                }
            }

            $data['modify'] = true;
            $data['item_id'] = $id;
            $_SESSION['picture_prefix'] = $data['inventory_id'];

            // Load the options
            $this->load->model('stocking_place_model');
            $data['stocking_places'] = $this->stocking_place_model->get_all();
            $this->load->model('supplier_model');
            $data['suppliers'] = $this->supplier_model->get_all();
            $this->load->model('item_group_model');
            $data['item_groups_name'] = $this->item_group_model->dropdown('name');
            $this->load->model('item_condition_model');
            $data['condishes'] = $this->item_condition_model->get_all();

            // Load item groups
            $data['item_groups'] = $this->item_group_model->get_all();

            // Load the tags
            $this->load->model('item_tag_model');
            $data['item_tags'] = $this->item_tag_model->get_all();

            // If the user gets back from another view, get the fields values
            // which have been saved in session variable.
            // Then reset this session variable.
            if(isset($_SESSION['POST']) && ($_SESSION['submit_image'] ?? FALSE)) {
                foreach ($_SESSION['POST'] as $key => $value) {
                    // If it is a tag
                    if (substr($key, 0, 3) == "tag") {
                        // put it in the data array
                        $tag_link = new stdClass();
                        $tag_link->item_tag_id = substr($key, 3);
                        $data['tag_links'][] = (object) $tag_link;
                    }else{
                        $data[$key] = $value;
                    }
                }
            }
            $_SESSION['submit_image'] = FALSE;
            unset($_SESSION['POST']);
            
            $this->display_view('item/form', $data);
        } else {
            // Update is not allowed
            $this->ask_for_login();
        }
    }

    /**
     * Delete an item
     * ACCESS RESTRICTED FOR ADMINISTRATORS ONLY
     *
     * @param integer $id
     * @param [type] $command
     * @return void
     */
    public function delete($id, $command = NULL) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN) {
            if (empty($command)) {
                $data['db'] = 'item';
                $data['id'] = $id;

                $this->display_view('item/confirm_delete', $data);
            } else {
                $this->load->model("item_model");
                $this->load->model("loan_model");
                $this->load->model("item_tag_link_model");

                $this->item_model->update($id, array("description" => "FAC"));

                $this->item_tag_link_model->delete_by(array('item_id' => $id));
                $this->loan_model->delete_by(array('item_id' => $id));
                $this->item_model->delete($id);

                redirect('/item');
            }
        } else {
            // Access is not allowed
            $this->ask_for_login();
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
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            if (empty($id)) {
                // No item specified, display items list
                redirect('/item');
            }

            $this->load->model('user_model');
            $this->load->model('inventory_control_model');

            $data['item'] = $this->item_model->get($id);
            $data['controller'] = $this->user_model->get($_SESSION['user_id']);

            if (isset($_POST['date']) && $_POST['date'] != '') {
                $data['date'] = $_POST['date'];
            } else {
                $data['date'] = date('Y-m-d');
            }

            if (isset($_POST['remarks'])) {
                $data['remarks'] = $_POST['remarks'];
            } else {
                $data['remarks'] = '';
            }

            if (isset($_POST['submit'])) {
                $inventory_control->item_id = $id;
                $inventory_control->controller_id = $_SESSION['user_id'];
                $inventory_control->date = $data['date'];
                $inventory_control->remarks = $data['remarks'];

                $this->inventory_control_model->insert($inventory_control);
                redirect("item/view/" . $id);
            } else {
                $this->display_view('inventory_control/form', $data);
            }
        } else {
            // Access is not allowed
            $this->ask_for_login();
        }
    }

    /**
     * Display inventory controls list for one given item
     *
     * @param integer $id
     * @return void
     */
    public function inventory_controls($id = NULL) {
        if (empty($id)) {
            // No item specified, display items list
            redirect('/item');
        }

        // Get item object with related inventory controls
        $output['item'] = $this->item_model->get($id);
        $output['inventory_controls'] = $this->inventory_control_model->with('controller')
                ->get_many_by('item_id=' . $id);

        $this->display_view('inventory_control/list', $output);
    }

    /**
     * Create loan for one given item
     *
     * @param integer $id
     * @return void
     */
    public function create_loan($id = NULL) {
        // Check if this is allowed
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            if (empty($id)) {
                // No item specified, display items list
                redirect('/item');
            }

            // Get item object and related loans
            $item = $this->item_model->get($id);
            $loans = $this->loan_model->with('loan_by_user')
                    ->with('loan_to_user')
                    ->get_many_by('item_id', $item->item_id);

            $data['item'] = $item;
            $data['loans'] = $loans;
            $data['item_id'] = $id;

            // Test input
            $this->load->library('form_validation');

            $this->form_validation->set_rules("date", "Date du prêt", 'required', array('required' => "La date du prêt doit être fournie"));

            if ($this->form_validation->run() === TRUE) {
                $loanArray = $_POST;

                if ($loanArray["planned_return_date"] == 0 || $loanArray["planned_return_date"] == "0000-00-00" || $loanArray["planned_return_date"] == "") {
                    $loanArray["planned_return_date"] = NULL;
                }

                if ($loanArray["real_return_date"] == 0 || $loanArray["real_return_date"] == "0000-00-00" || $loanArray["real_return_date"] == "") {
                    $loanArray["real_return_date"] = NULL;
                }

                $loanArray["item_id"] = $id;

                $loanArray["loan_to_user_id"] = null;
                $loanArray["loan_by_user_id"] = $this->session->user_id;

                $this->loan_model->insert($loanArray);

                header("Location: " . base_url() . "item/loans/" . $id);
                exit();
            } else {
                $this->display_view('loan/form', $data);
            }
        } else {
            // Access is not allowed
            $this->ask_for_login();
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
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            // get the data from the loan with this id (to fill the form or to get the concerned item)
            $data = get_object_vars($this->loan_model->get($id));

            if (!empty($_POST)) {
                // test input
                $this->load->library('form_validation');

                $this->form_validation->set_rules("date", "Date du prêt", 'required', array('required' => "La date du prêt doit être fournie"));

                if ($this->form_validation->run() === TRUE) {
                    //Declarations

                    $loanArray = $_POST;

                    if ($loanArray["planned_return_date"] == 0 || $loanArray["planned_return_date"] == "0000-00-00" || $loanArray["planned_return_date"] == "") {
                        $loanArray["planned_return_date"] = NULL;
                    }

                    if ($loanArray["real_return_date"] == 0 || $loanArray["real_return_date"] == "0000-00-00" || $loanArray["real_return_date"] == "") {
                        $loanArray["real_return_date"] = NULL;
                    }

                    // Execute the changes in the item table
                    $this->loan_model->update($id, $loanArray);

                    redirect("/item/loans/" . $data["item_id"]);
                    exit();
                } else {
                    // Load the options
                    $this->load->model('stocking_place_model');
                    $data['stocking_places'] = $this->stocking_place_model->get_all();
                    $this->load->model('supplier_model');
                    $data['suppliers'] = $this->supplier_model->get_all();
                    $this->load->model('item_group_model');
                    $data['item_groups'] = $this->item_group_model->get_all();

                    // Load the tags
                    $this->load->model('item_tag_model');

                    $data['item_tags'] = $this->item_tag_model->get_all();
                }
            }
            $this->display_view('loan/form', $data);
        } else {
            // Access is not allowed
            $this->ask_for_login();
        }
    }


    /**
     *  Display loans list for one given item
     *
     * @param integer $id
     * @return void
     */
    public function loans($id = NULL) {
        if (empty($id)) {
            // No item specified, display items list
            redirect('/item');
        }

        // Get item object and related loans
        $item = $this->item_model->get($id);
        $loans = $this->loan_model->with('loan_by_user')
                ->with('loan_to_user')
                ->get_many_by('item_id', $item->item_id);

        $output['item'] = $item;
        $output['loans'] = $loans;

        $this->display_view('loan/list', $output);
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
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN) {
            if (empty($command)) {
                $data['db'] = 'loan';
                $data['id'] = $id;

                $this->display_view('item/confirm_delete', $data);
            } else {
                $this->load->model("loan_model");

                // get the data from the loan with this id (to fill the form or to get the concerned item)
                $data = get_object_vars($this->loan_model->get($id));

                $this->loan_model->delete($id);

                redirect("/item/loans/" . $data["item_id"]);
            }
        } else {
            // Access is not allowed
            $this->ask_for_login();
        }
    }

    /**
     * Set validation rules for create and update form
     *
     *
     * @param integer $id
     * @return void
     */
    private function set_validation_rules($id = NULL) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules("name", $this->lang->line('field_item_name'), 'required');

        $this->form_validation->set_rules("inventory_prefix", lang('field_inventory_number'), 'required');
    }
    
}
