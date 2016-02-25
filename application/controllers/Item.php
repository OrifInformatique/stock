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
	
		$output['item'] = $this->item_model->with_all()
                                           ->get($id);
		$output['message'] = $message;
	
		$this->display_view('item/detail', $output);
	}
	
	/* *** Show by filter *** */
	
	public function filter()
	{
		// Get filters of URI
		$arg1 = $this->uri->segment(3);
		$arg2 = intval($this->uri->segment(4));
		
		$output['filters'] = $this->item_model->construct_item_filters();
		$output['item_link'] = $this->item_model->get_all_item_link_array();
		
		// Switch to filter request		
		if($arg1=='stocking_place')
		{
			$output['array_item'] = $this->item_model->get_item_filtered('stocking_place_id', $arg2);
		}
		
		if($arg1=='supplier')
		{
			$output['array_item'] = $this->item_model->get_item_filtered('supplier_id', $arg2);
		}
		
		if($arg1=='item_tag')
		{
			$output['array_item'] = $this->item_model->get_item_filtered_by_tag($arg2);
		}
		
		if($arg1=='created_by')
		{
			$output['array_item'] = $this->item_model->get_item_filtered('created_by_user_id', $arg2);
		}
		
		$this->item_model->build_item_inventory_nb($output['array_item'], $output['item_link']);
	
		$output['message'] = count($output['array_item']).' objet(s) trouvé(s) : ';
		

		$this->_view_stock_header($output);
		$this->load->view('item/view', $output);
		$this->load->view('item/footer');

	}
	
	/* *** Display by matching terms *** */
	
	public function search()
	{
	
		// Get term
		$term = $this->security->xss_clean($this->input->post('term'));
	
		$output['filters'] = $this->item_model->construct_item_filters();
		$output['item_link'] = $this->item_model->get_all_item_link_array();
	
		// If text is specified
		if(strlen($term)>0)
		{
			$output['array_item'] = $this->item_model->get_item_search($term);

			$this->item_model->build_item_inventory_nb($output['array_item'], $output['item_link']);
		}
		else
		{
			$this->view_all();
			return;
		}
	
		$output['message'] = count($output['array_item']).' objet(s) trouvé(s) : ';
	
		$this->_view_stock_header($output);
		$this->load->view('item/view', $output);
		$this->load->view('item/footer');
	
	}

	/* *** Base image upload request *** */
	
	public function upload($item_id)
	{	
		if(!$this->check_permission()) show_error("Authentification requise");
		
		$this->_view_stock_header($output);
		$this->load->view('item/upload_form', array('error' => ' ', 'item_id' => $item_id));
		$this->load->view('item/footer');
	}
	
	/* *** Uploads image *** */
	
	function do_upload($item_id)
	{
		if(!$this->check_permission()) show_error("Authentification requise");
		
		/* !!!!!!!!!!!!!!!!!!!!!!!!!! DEFINE HERE UPLOAD PATH !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
		$config['upload_path'] = './uploads/images/';
		$this->upload_path = './uploads/images/';
	
		$config['allowed_types'] = 'gif|jpg|png';
		// Max 10 Megabytes
		$config['max_size']	= '10000';
		$config['max_width']  = '4096';
		$config['max_height']  = '4096';
	
		$this->load->library('upload');
		$this->upload->initialize($config);
	
		// Try upload
		if ( ! $this->upload->do_upload())
		{
			$output = array('error' => $this->upload->display_errors());
			$output['item_id'] = $item_id;
			
			$this->_view_stock_header($output);
			$this->load->view('item/upload_form', $output);
			$this->load->view('item/footer');
				
		}
		else
		{
			$upload_data = $this->upload->data();

			// sets in database the image filename
			$this->item_model->set_image($item_id, $upload_data['file_name']);
			$this->view($item_id);
		}
	}
	
	/* *** Remove linked tags *** */
	
	public function remove_tag($item_id, $tag_id)
	{
		if(!$this->check_permission()) show_error("Authentification requise");
		
		$this->item_model->delete_tag($tag_id);
		$this->view($item_id);
	}
	
	/* *** Add linked tags *** */
	
	public function add_tag($item_id, $tag_id)
	{
		if(!$this->check_permission()) show_error("Authentification requise");
		
		$this->item_model->create_tag($item_id, $tag_id);
		$this->view($item_id);
	}
	
	/* *** Update item from text inputs *** */
	
	public function update($item_id)
	{
		if(!$this->check_permission()) show_error("Authentification requise");
		
		$output['item_link'] = $this->item_model->get_all_item_link_array();
		$output['array_item'] = $this->item_model->get_item($item_id);
	
		$this->item_model->build_item_inventory_nb($output['array_item'], $output['item_link']);
		
		$this->item_model->build_item_tags($output['array_item']);
		
		// Sets the item array to "$item" for easier reading
		$item = &$output['array_item'][0];
		
		$item['name'] = $this->security->xss_clean($this->input->post('name'));
		$item['stocking_place_id'] = $this->security->xss_clean($this->input->post('stocking_place'));
		$item['description'] = $this->security->xss_clean($this->input->post('description'));
		$item['supplier_id'] = $this->security->xss_clean($this->input->post('supplier'));
		$item['serial_number'] = $this->security->xss_clean($this->input->post('serial_number'));
		$item['remarks'] = $this->security->xss_clean($this->input->post('remarks'));
		$item['buying_price'] = $this->security->xss_clean($this->input->post('buying_price'));
		$item['buying_date'] = $this->security->xss_clean($this->input->post('buying_date'));
		$item['warranty_duration'] = $this->security->xss_clean($this->input->post('warranty_duration'));
		$item['file_number'] = $this->security->xss_clean($this->input->post('file_number'));
		$item['created_by_user_id'] = $this->security->xss_clean($this->input->post('created_by_user_id'));
		$item['created_date'] = $this->security->xss_clean($this->input->post('created_date'));
		$item['modified_by_user_id'] = $this->security->xss_clean($this->input->post('modified_by_user_id'));
		$item['modified_date'] = $this->security->xss_clean($this->input->post('modified_date'));
		$item['control_by_user_id'] = $this->security->xss_clean($this->input->post('control_by_user_id'));
		$item['control_date'] = $this->security->xss_clean($this->input->post('control_date'));
		$item['item_state_id'] = $this->security->xss_clean($this->input->post('item_state_id'));
	
		$error_message = '';
		
		// Check input fields for the MySQL database
		$this->item_model->validate_post($item, $error_message);
		
		// Insert by default today's date
		if($item['modified_date'] == NULL)
			$item['modified_date'] = date('Y-m-d');
		
		if(empty($error_message))
		{
			if($this->item_model->update_item($item_id, $item))
			{
				$this->view($item_id);
			}
			else
			{
				show_error('Impossible d\'entrer les valeurs dans la base de données');
			}
		}
		else 
		{
			$output['error_message'] = $error_message;
			
			$this->_view_stock_header($output);
			$this->load->view('item/view_single', $output);
			$this->load->view('item/footer');
		}
	}
	
	/* *** Prepare new item *** */
	
	public function new_item()
	{
		if(!$this->check_permission()) show_error("Authentification requise");
	
		$output['item_link'] = $this->item_model->get_all_item_link_array();
		
		// Generate blank array for a new item
		$output['array_item'][0] = $this->item_model->create_blank_item();
		
		$output['array_item'][0]['created_date'] = date('Y-m-d');
		
		$this->_view_stock_header($output);
		$this->load->view('item/create', $output);
		$this->load->view('item/footer');
		
	}
	
	/* *** Check and insert item *** */
	
	public function create()
	{
		if(!$this->check_permission()) show_error("Authentification requise");
		
		$output['item_link'] = $this->item_model->get_all_item_link_array();
		
		$output['array_item'][0] = $this->item_model->create_blank_item();
		
		$item = &$output['array_item'][0];
				
		$item['name'] = $this->security->xss_clean($this->input->post('name'));
		$item['stocking_place_id'] = $this->security->xss_clean($this->input->post('stocking_place'));
		$item['description'] = $this->security->xss_clean($this->input->post('description'));
		$item['supplier_id'] = $this->security->xss_clean($this->input->post('supplier'));
		$item['serial_number'] = $this->security->xss_clean($this->input->post('serial_number'));
		$item['remarks'] = $this->security->xss_clean($this->input->post('remarks'));
		$item['buying_price'] = $this->security->xss_clean($this->input->post('buying_price'));
		$item['buying_date'] = $this->security->xss_clean($this->input->post('buying_date'));
		$item['warranty_duration'] = $this->security->xss_clean($this->input->post('warranty_duration'));
		$item['file_number'] = $this->security->xss_clean($this->input->post('file_number'));
		$item['created_by_user_id'] = $this->security->xss_clean($this->input->post('created_by_user_id'));
		$item['created_date'] = $this->security->xss_clean($this->input->post('created_date'));
		$item['modified_by_user_id'] = $this->security->xss_clean($this->input->post('modified_by_user_id'));
		$item['modified_date'] = $this->security->xss_clean($this->input->post('modified_date'));
		$item['control_by_user_id'] = $this->security->xss_clean($this->input->post('control_by_user_id'));
		$item['control_date'] = $this->security->xss_clean($this->input->post('control_date'));
		$item['item_state_id'] = $this->security->xss_clean($this->input->post('item_state_id'));
		
		$error_message = '';
		
		$this->item_model->validate_post($item, $error_message);
		
		if(empty($error_message))
		{
			$new_item_id = $this->item_model->create_item($item);
			
			if($new_item_id)
			{
				$this->view($new_item_id);
			}
			else
			{
				show_error('Impossible d\'entrer les valeurs dans la base de données');
			}
		}
		else
		{
			$output['error_message'] = $error_message;
				
			$this->_view_stock_header($output);
			$this->load->view('item/create', $output);
			$this->load->view('item/footer');
		}
	}
	
	/* *** Prepare to remove item *** */
	
	public function remove($item_id)
	{
		if(!$this->check_permission()) show_error("Authentification requise");
		
		$output['item_id'] = $item_id;
				
		$this->_view_stock_header($output);
		$this->load->view('item/delete_confirm', $output);
		$this->load->view('item/footer');
		
	}
	
	/* *** Remove item *** */
	
	public function remove_confirmed($item_id)
	{
		if(!$this->check_permission()) show_error("Authentification requise");
	
		$this->item_model->delete_item($item_id);
		$this->view_all();
	}
	
}