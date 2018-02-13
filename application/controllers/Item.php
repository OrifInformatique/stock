<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * A controller to display and manage items
 *
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
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
	}

	/**
    * Display items list
    */
	public function index()
  {
    $output['title'] = $this->lang->line('page_item_list');

    // Load list of elements to display as filters
    $this->load->model('item_tag_model');
    $output['item_tags'] = $this->item_tag_model->dropdown('name');
    $this->load->model('item_condition_model');
    $output['item_conditions'] = $this->item_condition_model->get_all();
    $this->load->model('item_group_model');
    $output['item_groups'] = $this->item_group_model->get_all();
    $this->load->model('stocking_place_model');
    $output['stocking_places'] = $this->stocking_place_model->get_all();

    // Store URL to make possible to come back later (from item detail for example)
    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
      $_SESSION['items_list_url'] = current_url().'?'.$_SERVER['QUERY_STRING'];
    } else {
      $_SESSION['items_list_url'] = current_url();
    }


    /*********************
    ** ITEM TAGS FILTER
    **********************/
    $where_itemTagsFilter = '';

    if (isset($_GET['t'])) {
      // Get a list of item_tag_link elements
      $this->load->model('item_tag_link_model');
      $item_tags_selection = $_GET['t'];

      $where_itemTagLinks = '';
      foreach ($item_tags_selection as $item_tag) {
        $where_itemTagLinks .= 'item_tag_id='.$item_tag.' OR ';
      }
      // Remove the last " OR "
      $where_itemTagLinks = substr($where_itemTagLinks, 0, -4);

      $item_tag_links = $this->item_tag_link_model->get_many_by($where_itemTagLinks);
      

      // Prepare WHERE close for all corresponding items
      $where_itemTagsFilter .= '(';
      foreach ($item_tag_links as $item_tag_link) {
        $where_itemTagsFilter .= 'item_id='.$item_tag_link->item_id.' OR ';
      }
      // Remove the last " OR "
      $where_itemTagsFilter = substr($where_itemTagsFilter, 0, -4);
      $where_itemTagsFilter .= ')';
      

      // Send back the tags selection to keep them selected
      $output['item_tags_selection'] = $item_tags_selection;

    } else {
      // No tags selected for filtering
      $output['item_tags_selection'] = '';
    }


/*********************
** TODO : ADD OTHER FILTERS
**********************/
/*
          $where2 = "";

          if (isset($where['c']))
          {
            if ($where2 != "")
            {
              $where2 .= " AND ";
            }

            $where2 .= "(" . $where['c'] . ")";
          }

          if (isset($where['g']))
          {
            if ($where2 != "")
            {
              $where2 .= " AND ";
            }

            $where2 .= "(" . $where['g'] . ")";
          }

          if (isset($where['s']))
          {
            if ($where2 != "")
            {
              $where2 .= " AND ";
            }

            $where2 .= "(" . $where['s'] . ")";
          }
*/

    /*********************
    ** GROUP ALL FILTERS AND GET ITEMS
    **********************/
	  $where_itemsFilters = $where_itemTagsFilter;

    $output["items"] = $this->item_model->with('stocking_place')
                                        ->with('item_condition')
                                        ->get_many_by($where_itemsFilters);

    $this->display_view('item/list', $output);
  }

	/**
    * Display details of one single item
    *
    * @param $id : the item to display
    */
	public function view($id = NULL)
	{
		if (empty($id))
		{
      // No item specified, display items list
			redirect('/item');
		}

        // Get item object and related objects
        $item = $this->item_model->with('supplier')
                                 ->with('stocking_place')
                                 ->with('item_condition')
                                 ->with('item_group')
                                 ->get($id);
		
    $output['item'] = $item;

		$this->display_view('item/detail', $output);
	}

  /**
   * Add a new item
   */
	public function create()
  {
    // Check if this is allowed
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {

      $this->set_validation_rules();

      $data['upload_errors'] = "";
      if (isset($_FILES['photo']) && $_FILES['photo']['name']!='') {
        // IMAGE UPLOADING
        $config['upload_path']          = './uploads/images/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2048;
        $config['max_width']            = 360;
        $config['max_height']           = 360;
        
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('photo'))
        {
          $itemArray['image'] = $this->upload->data('file_name');
        } else {
          $data['upload_errors'] = $this->upload->display_errors();
          $upload_failed = TRUE;
        }
      }
      if (isset($_FILES['linked_file']) && $_FILES['linked_file']['name']!='') {
        
        // LINKED FILE UPLOADING
        $config['upload_path']          = './uploads/files/';
        $config['allowed_types']        = 'pdf|doc|docx';
        $config['max_size']             = 2048;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('linked_file'))
        {
          $itemArray['linked_file'] = $this->upload->data('file_name');
        } else {
          $data['upload_errors'] = $this->upload->display_errors();
          $upload_failed = TRUE;
        }
      }
      
      if ($this->form_validation->run() == TRUE && $upload_failed!=TRUE) {
        // No error, save item

        $linkArray = array();

        $this->load->model('item_tag_link_model');

        foreach($_POST as $key => $value) {
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
        foreach($_POST as $key => $value) {
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
    		$data['item_groups'] = $this->item_group_model->dropdown('name');
        $this->load->model('item_condition_model');
        $data['condishes'] = $this->item_condition_model->get_all();
        
        // Load the tags
        $this->load->model('item_tag_model');
        $data['item_tags'] = $this->item_tag_model->get_all();

        $this->display_view('item/form', $data);
      }

    } else {
      // Access is not allowed
      redirect("auth/login");
    }
  }

  /**
  * Create loan for one given item
  *
  * @param $id : the item concerned
  */
  public function create_loan($id = NULL)
  {
    // Check if this is allowed
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      if (empty($id))
      {
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

      $this->form_validation->set_rules("date", "Date du prêt", 'required',
      array('required' => "La date du prêt doit être fournie"));

      if ($this->form_validation->run() === TRUE) {
        $loanArray = $_POST;

        if ($loanArray["planned_return_date"] == 0 || $loanArray["planned_return_date"] == "0000-00-00" || $loanArray["planned_return_date"] == "")
        {
          $loanArray["planned_return_date"] = NULL;
        }

        if ($loanArray["real_return_date"] == 0 || $loanArray["real_return_date"] == "0000-00-00" || $loanArray["real_return_date"] == "")
        {
          $loanArray["real_return_date"] = NULL;
        }

        $loanArray["item_id"] = $id;

        // For now, loans are from and for Orif
        $loanArray["loan_to_user_id"] = $loanArray["loan_by_user_id"] = 1;

        $this->loan_model->insert($loanArray);

        header("Location: " . base_url() . "item/loans/" . $id);
        exit();
      } else {
        $this->display_view('item/loan_form', $data);
      }
    // Creation is not allowed for the non-connected users, which are sent to the connection page
    } else {
      header("Location: " . base_url() . "auth/login");
      exit();
    }
  }

  /**
  * Modify some loan
  *
  * @param $id : the loan
  */
  public function modify_loan($id = NULL)
  {
    // Check if this is allowed
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      // get the data from the loan with this id (to fill the form or to get the concerned item)
      $data = get_object_vars($this->loan_model->get($id));

      if (!empty($_POST)) {
        // test input
        $this->load->library('form_validation');

        $this->form_validation->set_rules("date", "Date du prêt", 'required',
        array('required' => "La date du prêt doit être fournie"));

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
      $this->display_view('item/loan_form', $data);
    // Update is not allowed for the non-connected users, which are sent to the connection page
    } else {
      header("Location: " . base_url() . "auth/login");
      exit();
    }
  }

  /**
  * Display loans list for one given item
  *
  * @param $id : the item concerned
  */
  public function loans($id = NULL)
  {
    if (empty($id))
    {
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

    $this->display_view('item/loans', $output);
  }

	public function modify($id)
	{
    // Check if access is allowed
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      $this->load->model('item_tag_link_model');

      // If there is no submit
      if (empty($_POST))
      {
        // get the data from the item with this id,
        $data = get_object_vars($this->item_model->get($id));

        // including its tags
        $data['tag_links'] = $this->item_tag_link_model->get_many_by("item_id", $id);

      } else {
        $this->set_validation_rules($id);

        $data['upload_errors'] = "";
        if (isset($_FILES['photo']) && $_FILES['photo']['name']!='') {
          // IMAGE UPLOADING
          $config['upload_path']          = './uploads/images/';
          $config['allowed_types']        = 'gif|jpg|png';
          $config['max_size']             = 2048;
          $config['max_width']            = 360;
          $config['max_height']           = 360;
          
          $this->load->library('upload');
          $this->upload->initialize($config);
          
          if ($this->upload->do_upload('photo'))
          {
            $itemArray['image'] = $this->upload->data('file_name');
          } else {
            $data['upload_errors'] = $this->upload->display_errors();
            $upload_failed = TRUE;
          }
        }
        if (isset($_FILES['linked_file']) && $_FILES['linked_file']['name']!='') {
          
          // LINKED FILE UPLOADING
          $config['upload_path']          = './uploads/files/';
          $config['allowed_types']        = 'pdf|doc|docx';
          $config['max_size']             = 2048;
          $config['max_width']            = 0;
          $config['max_height']           = 0;
          
          $this->load->library('upload');
          $this->upload->initialize($config);
          
          if ($this->upload->do_upload('linked_file'))
          {
            $itemArray['linked_file'] = $this->upload->data('file_name');
          } else {
            $data['upload_errors'] = $this->upload->display_errors();
            $upload_failed = TRUE;
          }
        }
		
        if ($this->form_validation->run() == TRUE && $upload_failed!=TRUE) {

          // Delete ALL the tags for this object
          $this->item_tag_link_model->delete_by(array('item_id' => $id));

          foreach($_POST as $key => $value) {
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
          foreach($_POST as $key => $value) {
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

      // Load the options
      $this->load->model('stocking_place_model');
      $data['stocking_places'] = $this->stocking_place_model->get_all();
      $this->load->model('supplier_model');
      $data['suppliers'] = $this->supplier_model->get_all();
      $this->load->model('item_group_model');
      $data['item_groups'] = $this->item_group_model->dropdown('name');
      $this->load->model('item_condition_model');
      $data['condishes'] = $this->item_condition_model->get_all();

      // Load the tags
      $this->load->model('item_tag_model');
      $data['item_tags'] = $this->item_tag_model->get_all();

      $this->display_view('item/form', $data);
    
    } else {
      // Update is not allowed
      redirect("auth/login");
    }
	}

	public function delete($id, $command = NULL)
	{
    // Check if this is allowed
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      if (empty($command))
      {
        $data['db'] = 'item';
    		$data['id'] = $id;

    		$this->display_view('item/confirm_delete', $data);
      } else {
        $this->load->model("item_model");
        $this->load->model("loan_model");
        $this->load->model("item_tag_link_model");

        $this->item_model->update($id, array("description" => "FAC"));

        $this->item_tag_link_model->delete_by( array('item_id' => $id) );
        $this->loan_model->delete_by( array('item_id' => $id) );
        $this->item_model->delete($id);

        redirect('/item');
      }
    // Delete is not allowed for the non-connected users, which are sent to the connection page
    } else {
      header("Location: " . base_url() . "auth/login");
      exit();
    }
  }

	public function delete_loan($id, $command = NULL)
	{
    // Check if this is allowed
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
      if (empty($command))
      {
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
  // Delete is not allowed for the non-connected users, which are sent to the connection page
  } else {
    header("Location: " . base_url() . "auth/login");
    exit();
  }
	}
	
  /**
  * Set validation rules for create and update form
  **/
  private function set_validation_rules($id = NULL) {
    $this->load->library('form_validation');

    $this->form_validation->set_rules("name", $this->lang->line('field_item_name'), 'required');

    // If new item or if inventory_number has been changed, check if it's unique
    if (is_null($id) || $_POST['inventory_number'] != $this->item_model->get($id)->inventory_number) {
      $this->form_validation->set_rules("inventory_number", $this->lang->line('field_inventory_number'),
        'required|is_unique[item.inventory_number]',
        array('is_unique' => $this->lang->line('msg_err_inventory_used')));
    } else {
      $this->form_validation->set_rules("inventory_number", $this->lang->line('field_inventory_number'), 'required');
    }
  }
}