<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ********************************************************************************************
 * Admin : Controller to edit user tables and stock tables 
 * 
 * It uses Grocery CRUD to display tables.
 * 
 *********************************************************************************************/


class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		// Loads the Grocery CRUD library
		$this->load->library('grocery_CRUD');
	}
	
	/* *** Main output with Grocery CRUD support *** */

	public function _view_output($output = null)
	{
		
		if($this->session->userdata('validated') !== NULL)
			$output->userdata = $this->session->all_userdata();
		
		$this->load->view('admin/crud_header.php',$output);
		$this->load->view('login_bar.php',$output);
		$this->load->view('admin/nav',$output);
		$this->load->view('admin/crud_view',$output);
		$this->load->view('admin/crud_footer',$output);
		
	}
	
	/* *** Test if authentified *** */

	private function __check_auth()
	{
		if($this->login_model->check_validated())
		{
			if($this->login_model->get_access_level()>=10)
			{
				return true;
			}
		}
			
		return false;
	}
	
	/* *** Base *** */
	
	public function index()
	{
		$this->load->model('login_model');
		
		// Get session data
		$output['userdata'] = $this->session->all_userdata();

		if($this->__check_auth())
		{
			$this->load->view('login_bar.php',$output);
			$this->load->view('admin/nav',$output);
			
		}
	}
	
	/* ********************************************* Tables Utilisateur **************************************************** */
	
	public function user()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
					// new object
					$crud = new grocery_CRUD();
		
					// sets table to use
					$crud->set_table('user');
					$crud->set_subject('Utilisateur');
				
					// callbacks for password editing
					$crud->callback_edit_field('password_hash', array($this,'__clean_field'));
	
					$crud->callback_before_insert(array($this, '__password_user_before_insert'));
					$crud->callback_before_update(array($this, '__password_user_before_update'));

					// links foreign keys
					$crud->set_relation('user_type_id','user_type','name');
					$crud->set_relation('user_state_id','user_state','name');
					$crud->set_relation('department_id','department','name');
			
					// renders the table in output					
					$output = $crud->render();
					
					// sets some text to determine which table is edited
					$output->current = 'Utilisateur';
					
					// display all
					$this->_view_output($output);
					
		
				}catch(Exception $e){
					show_error($e->getMessage().' --- '.$e->getTraceAsString());
				}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else 
			// if not authentified send back to login
			redirect('login');
	}
	
	/* *** Callbacks for password encryption *** */
	
	function __password_user_before_insert($post_array,$primary_key)
	{
		//$post_array['password_hash'] = password_hash($post_array['password_hash'], PASSWORD_DEFAULT);
	
		$this->db->insert('user', $post_array);
	
		return true;
	}
	
	function __clean_field($value,$primary_key)
	{
		$value = '';
		return '<input type="password" maxlength="24" value="'.$value.'" name="password_hash" style="width:250px">';
	}
	
	function __password_user_before_update($post_array,$primary_key)
	{
	
		$post_array['password_hash'] = password_hash($post_array['password_hash'], PASSWORD_DEFAULT);
		return $post_array;
	}
	
	/* ******************************************* */
	
	public function user_state()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('user_state');
				$crud->set_subject('Etat Utilisateur');
	
				// Force primary key display
				$crud->columns('user_state_id', 'name');
				
				// Force order
				$crud->order_by('user_state_id', 'asc');
					
				$output = $crud->render();
					
				$output->current = 'Etat Utilisateur';
				
				$output->current .= '<div style="color:red">';
				$output->current .= 'Ne pas modifier les ID actif et inactif<br>';
				$output->current .= '1 : Inactif<br>';
				$output->current .= '2 : Actif<br>';
				$output->current .= '</div>';
	
				$this->_view_output($output);
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function user_type()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('user_type');
				$crud->set_subject('Type Utilisateur');
	
					
				$output = $crud->render();
					
				$output->current = 'Type Utilisateur';
				
				$output->current .= '<div style="color:red">';
				$output->current .= 'Un niveau d\'accès 10 correspond aux administrateurs<br>';
				$output->current .= 'Un niveau d\'accès plus grand que 0 correspond à la lecture/écriture';
				$output->current .= '</div>';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function department()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('department');
				$crud->set_subject('Lieu');
	
					
				$output = $crud->render();
					
				$output->current = 'Lieu';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	/* ********************************************* Tables du stock **************************************************** */

	public function item()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('item');
				$crud->set_subject('Article');
				
				/* !!!!!!!!!!!!!!!!!!!!!!!!! If case of new item columns, modifiy here !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */ 
				
				$crud->columns('item_id', 'name', 'description', 'supplier_id', 'supplier_ref', 'buying_price', 'buying_date', 'warranty_duration',
							'file_number', 'remarks', 'image', 'created_by_user_id', 'created_date', 'modified_by_user_id', 'modified_date',
							'control_by_user_id', 'control_date', 'stocking_place_id', 'item_state_id');
				
				$crud->order_by('item_id', 'desc');
				
				$crud->set_relation('supplier_id','supplier','name');
				$crud->set_relation('created_by_user_id','user','initials');
				$crud->set_relation('modified_by_user_id','user','initials');
				$crud->set_relation('control_by_user_id','user','initials');
				$crud->set_relation('stocking_place_id','stocking_place','name');
				$crud->set_relation('item_state_id','item_state','name');
	
					
				$output = $crud->render();
					
				$output->current = 'Article';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function item_state()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('item_state');
				$crud->set_subject('Etat Article');
	
					
				$output = $crud->render();
					
				$output->current = 'Etat Article';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function item_tag()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('item_tag');
				$crud->set_subject('Tag Article');
	
					
				$output = $crud->render();
					
				$output->current = 'Tag Article';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function item_tag_link()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('item_tag_link');
				$crud->set_subject('Lien Tag Article');
	
				$crud->set_relation('item_id','item','name');
				$crud->set_relation('item_tag_id','item_tag','name');
					
				$output = $crud->render();
					
				$output->current = 'Lien Tag Article';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function stocking_place()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('stocking_place');
				$crud->set_subject('Emplacement stockage');
					
				$output = $crud->render();
					
				$output->current = 'Emplacement stockage';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function supplier()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('supplier');
				$crud->set_subject('Fournisseur');
	
					
				$output = $crud->render();
					
				$output->current = 'Fournisseur';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	public function loan()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('loan');
				$crud->set_subject('Prets');
	
				$crud->set_relation('item_id','item','name');
				$crud->set_relation('loan_by_user_id','user','initials');
				$crud->set_relation('loan_to_user_id','user','initials');
					
				$output = $crud->render();
					
				$output->current = 'Prets';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	// Standard prototype for new tables
	
	public function __proto()
	{
		$this->load->model('login_model');
		if($this->__check_auth())
		{
			if($this->login_model->get_access_level() >= 10)
				try{
				$crud = new grocery_CRUD();
	
				$crud->set_table('user');
				$crud->set_subject('Utilisateur');
	
					
				$output = $crud->render();
					
				$output->current = 'User';
	
				$this->_view_output($output);
					
	
			}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
			}
			else
			{
				show_error('L\'utilisateur n\'a pas les privilèges nécessaires.');
				die();
			}
		}
		else
			redirect('login');
	}
	
	
}
