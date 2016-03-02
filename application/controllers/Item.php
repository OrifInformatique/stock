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
			$this->load->library('form_validation');
			$this->load->helper('stock_helper');
			$this->load->model('login_model');
	}

	
	/**
    * Display items list
    */
	public function index()
    {
        $output['title'] = $this->lang->line('page_item_list');
        $output['items'] = $this->item_model->with('created_by_user')
                                            ->get_all();

        $this->display_view('item/list', $output);
    }
	
	
	/**
    * Display details of one single item
    *
    * @param $id : the item to display
    */
	public function view($id = NULL, $message = '')
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
		$output['message'] = $message;
	
		$this->display_view('item/detail', $output);
	}
}