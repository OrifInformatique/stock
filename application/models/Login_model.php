<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ********************************************************************************************
 * Login_model : Model to interact with the user tables
 *
 *
 *
 *********************************************************************************************/

class login_model extends CI_Model
{	
	function __construct()
	{
		//parent::__construct();
	}
	 
	/* *** Validate authentification inputs *** */
	
	function validate() {
		
		$username = $this->security->xss_clean($this->input->post('username'));
		$password = $this->security->xss_clean($this->input->post('password'));
		
		$this->db->where('initials', $username );
		//$this->db->where('user_state_id ', 2 );
		
		$query = $this->db->get('user')->result_array();
		
		var_dump($query);
		
		if ( is_array($query) && count($query) == 1 )
		{
			$hash = $query[0]['password_hash'];

			if(password_verify($password, $hash))
			{
				$this->set_session($query[0]);
				return true;
			}	
		}
			
		return false;
	}
	
	/* *** Get user details from database *** */
	
	function __build_user_details(&$tables)
	{
		$query = $this->db->get('user_state');
		
		if($query->result_array())
		{
			foreach($query->result_array() as $row){
				$tables['user_state'][$row['user_state_id']] = $row;
			}
		}
		
		$query = $this->db->get('user_type');
			
		if($query->result_array())
		{
			foreach($query->result_array() as $row){
				$tables['user_type'][$row['user_type_id']] = $row;
			}
		}
	
		
		return $tables;
		
	}
	
	/* *** Set PHP session *** */
	
	function set_session($user_details) {
		
		$this->__build_user_details($user_details);
		
		$this->session->set_userdata( array(
				'id'=> $user_details['user_id'],
				'initials'=> $user_details['initials'],
				'access_level'=> $user_details['user_type'][ $user_details['user_type_id'] ]['access_level'],
				'validated' => true
			)
		);
		
		
	}
	
	/* *** Disable session's values *** */
	
	function unset_session() {
		
		$array_items = array(
				'id',
				'initials',
				'access_level',
				'validated'
			);
		
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
	}
	
	/* *** Check valid session *** */
	
	function check_validated()
	{
		if($this->session->userdata('validated') !== NULL)
			return true;
		
		return false;
	}
	
	/* *** If session exists get its values *** */
	
	function get_session_userdata()
	{
		if($this->session->userdata('validated') !== NULL)
		{
			return $this->session->all_userdata();
		}
	}
	
	/* *** If session exists gets the access level *** */
	
	function get_access_level()
	{
		if($this->session->userdata('validated') !== NULL)
		{
			if($this->session->userdata('access_level') !== NULL)
			{
				return intval($this->session->userdata('access_level'));
			}
			else 
			{
				return 0;
			}
		}
		return 0;	
	}
	
	/* *** Generate default password hash *** */
	
	function generate_password_hash($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

}

?>