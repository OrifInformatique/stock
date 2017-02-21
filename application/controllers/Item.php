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
        $this->load->model('item_tag_model');

        $output['title'] = $this->lang->line('page_item_list');
        $output['items'] = $this->item_model->with('created_by_user')
                                            ->get_all();
        $output['item_tags'] = $this->item_tag_model->with('created_by_user')
                                            ->get_all();

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
    // Test input
    $this->load->library('form_validation');

    $this->form_validation->set_rules("name", "Nom de l'item", 'required',
    array('required' => "L'item doit avoir un nom"));

    // Get the ID that the new item will receive if it is created now
    $data['item_id'] = $this->item_model->get_future_id();

    if ($this->form_validation->run() === TRUE) {
      $itemArray = array();

      // IMAGE UPLOADING
      $config['upload_path']          = './uploads/images/';
      $config['allowed_types']        = 'gif|jpg|png';
      $config['max_size']             = 100;
      $config['max_width']            = 550;
      $config['max_height']           = 550;

      $this->load->library('upload', $config);

      // Name: [id_item]_[00number]
      if ($this->upload->do_upload('photo'))
      {
              $itemArray['image'] = $this->upload->data('file_name');
      } else {
        die($this->upload->display_errors());
      }

      $linkArray = array();

      $this->load->model('item_tag_link_model');

      foreach($_POST as $key => $value) {
        if (substr($key, 0, 3) == "tag") {
          // Stock link to be created when the item will exist
          $linkArray[] = $value;
        } else {
          $itemArray[$key] = $value;
        }
      }

      $this->item_model->insert($itemArray);

      foreach ($linkArray as $tag) {
        $this->item_tag_link_model->insert(array("item_tag_id" => $tag, "item_id" => ($data['item_id'])));
      }

      header("Location: " . base_url() . "item/view/" . $data['item_id']);
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

  		$this->display_view('item/form', $data);
    }
  }

  /**
  * Create loan for one given item
  *
  * @param $id : the item concerned
  */
  public function create_loan($id = NULL)
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

      $data['item'] = $item;
      $data['loans'] = $loans;

      // Test input
      $this->load->library('form_validation');

      $this->form_validation->set_rules("date", "Date du prêt", 'required',
      array('required' => "La date du prêt doit être fournie"));

      if ($this->form_validation->run() === TRUE) {
        $loanArray = $_POST;
        $loanArray["item_id"] = $id;

        // For now, loans are from and for Orif
        $loanArray["loan_to_user_id"] = $loanArray["loan_by_user_id"] = 1;

        $this->loan_model->insert($loanArray);

        header("Location: " . base_url() . "item/loans/" . $id);
        exit();
      } else {
        $this->display_view('item/loan_form', $data);
      }
  }

  /**
  * Modify some loan
  *
  * @param $id : the loan
  */
  public function modify_loan($id = NULL)
  {
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
    $this->load->model('item_tag_link_model');

    // If there is no submit,
    if (empty($_POST))
    {
      // get the data from the item with this id,
      $data = get_object_vars($this->item_model->get($id));

      // including its tags
      $data['tag_links'] = $this->item_tag_link_model->get_many_by("item_id", $id);

      // Load the tags
      $this->load->model('item_tag_model');
      $data['item_tags'] = $this->item_tag_model->get_all();

      // Load the options
      $this->load->model('stocking_place_model');
      $data['stocking_places'] = $this->stocking_place_model->get_all();
      $this->load->model('supplier_model');
      $data['suppliers'] = $this->supplier_model->get_all();
      $this->load->model('item_group_model');
      $data['item_groups'] = $this->item_group_model->get_all();
    } else {
      // Test input
      $this->load->library('form_validation');

      $this->form_validation->set_rules("name", "Nom de l'item", 'required',
      array('required' => "L'item doit avoir un nom"));

      if ($this->form_validation->run() === TRUE) {
        //Declarations
        $itemArray = array();

        // IMAGE UPLOADING
        $config['upload_path']          = "./uploads/images/";
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 550;
        $config['max_height']           = 550;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('photo'))
        {
          $itemArray['image'] = $this->upload->data('file_name');
        }

        // Delete ALL the tags for this object
        $this->item_tag_link_model->delete_by(array('item_id' => $id));

        foreach($_POST as $key => $value) {
          // If it is a tag, since their keys are tag1, tag2, …
          if (substr($key, 0, 3) == "tag") {
            // put it in the array for tags.
            $this->item_tag_link_model->insert(array("item_tag_id" => $value, "item_id" => $id));
          // Otherwise,
          } else {
            // put it in th array for item properties.
            $itemArray[$key] = $value;
          }
        }

        // Execute the changes in the item table
        $this->item_model->update($id, $itemArray);

        redirect("/item/view/" . $id);
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
    $this->display_view('item/form', $data);
	}

	public function delete($id, $command = NULL)
	{
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
	}

	public function delete_loan($id, $command = NULL)
	{
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
	}
}
