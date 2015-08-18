<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ********************************************************************************************
 * Item_model : Model to interact with the stock database
 *
 *
 *
 *********************************************************************************************/

// Deactivate sql error feedback :
// In application/config/database.php set
// $db['default']['db_debug'] = FALSE;


class Item_model extends CI_Model {
		
    public function __construct()
    {
        $this->load->database();

    }
    
    /* *** Gets all linked item tables in an array *** */
    /* *** Use -1 array value for null dropdown option *** */
    
    public function get_all_item_link_array()
    {
    	$query = $this->db->get('stocking_place');
    	
    	$tables['stocking_place'][] = array ( 'stocking_place_id' => -1, 'name'  => 'Aucun');
    	
        if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$tables['stocking_place'][$row['stocking_place_id']] = $row;
    		}
    	}    	

    	$query = $this->db->get('supplier');
    	
    	$tables['supplier'][] = array ( 'supplier_id' => -1, 'name'  => 'Aucun');
    	
        if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$tables['supplier'][$row['supplier_id']] = $row;
    		}
    	}    	
    	
    	$query = $this->db->get('item_state');
    	
    	$tables['item_state'][] = array ( 'item_state_id' => -1, 'name'  => 'Aucun');
    	    	
    	if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$tables['item_state'][$row['item_state_id']] = $row;
    		}
    	}    	
    	
    	$query = $this->db->get('user');
    	
    	$tables['user'][] = array ( 'user_id' => -1, 'initials'  => 'Aucun');
    	
        if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$tables['user'][$row['user_id']] = $row;
    		}
    	}
    	
    	$query = $this->db->get('item_tag');
    	
    	$tables['item_tag'][] = array ( 'value' =>-1, 'text'  => 'Etiquette');
    	 
    	if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$tables['item_tag'][$row['item_tag_id']] = $row;
    			$tables['item_tag'][$row['item_tag_id']]['value'] = $row['item_tag_id'];
    			$tables['item_tag'][$row['item_tag_id']]['text'] = $row['name'];
    			
    		}
    	}
    	
    	
    	return $tables;
    }
    
    /* *** Build the inventory name eg. "INFO-12345" *** */
    
    public function build_item_inventory_nb(&$array_item, $array_link)
    {
    	foreach($array_item as &$item){
    		
    		/* TODO : Changer article_nb par le champ adéquat !!! */
    		//var_dump($item);
    		if($item['stocking_place_id'] !== NULL)
    		{
	    		$item['article_nb'] = $array_link['stocking_place'][$item['stocking_place_id']]['short'];
	    		$item['article_nb'] .= '-';
	    		
	    		// sprintf("%'.09d\n", 123);
	    		$item['article_nb'] .= sprintf('%05d',$item['item_id']);
    		}
    		else 
    		{
    			$item['article_nb'] = '{Lieu non valable!}-'.sprintf('%05d',$item['item_id']);;
    		}
    	}
    }
    
    /* *** Builds item's tags *** */
    
    public function build_item_tags(&$array_item)
    {
    	foreach($array_item as &$item){
	    	$query = $this->db->get_where('item_tag_link',  array('item_id' => $item['item_id']));
	    	$array_tag = $query->result_array();
	    	
	    	foreach($array_tag as $tag)
	    	{
	    		$item['tags'][$tag['item_tag_id']] = $tag;
	    	}
    	}
    }
    
    /* *** Gets item(s) *** */
    	
    public function get_item($id = 0)
    {

    	if ($id === 0)
    	{
    		$query = $this->db->get('item');
    	}
    	else
    	{
    		$query = $this->db->get_where('item',  array('item_id' => $id));
    	}
    	
    	return $query->result_array();
    	
    }
    
    /* *** Gets items by filter *** */
    
    public function get_item_filtered($column, $id)
    {
    		$query = $this->db->get_where('item',  array($column => $id));
    		return $query->result_array();
    	 
    }
    
    /* *** Gets items by search term *** */
    
    public function get_item_search($term)
    {
    	$this->db->like('name', $term);
    	$this->db->or_like('remarks', $term);
    	$this->db->or_like('description', $term);
    	$this->db->or_like('buying_price', $term);
    	$this->db->or_like('file_number', $term);
    	$this->db->or_like('serial_number', $term);

    	$query = $this->db->get('item');
    	
    	return $query->result_array();
    
    }
    
    /*
     * Requête pour tous les tags
     *
     * SELECT item.item_id, item.name, item_tag_link.item_id AS 'item_tag_link.item_id', item_tag_link.item_tag_id
     FROM item, item_tag_link
     WHERE  item.item_id = item_tag_link.item_id
     AND item_tag_link.item_tag_id = 1
     *
     *
     */
    
    /* *** Gets item by tag filter *** */
    
    public function get_item_filtered_by_tag($id)
    {

    	$sql = 'SELECT item.*, item_tag_link.item_id AS \'item_tag_link.item_id\', item_tag_link.item_tag_id
    	FROM item, item_tag_link
    	WHERE  item.item_id = item_tag_link.item_id
    	AND item_tag_link.item_tag_id = '.$id;
    	
	   	$query = $this->db->query($sql);
   	
    	return $query->result_array();
    }
    
    /* *** Build an array of item filters *** */
    
    public function construct_item_filters()
    {
    	
    	$query = $this->db->get('stocking_place');
    	
    	$filters['stocking_place'][] = array ( 'value' =>-1, 'text'  => 'Lieu de stockage');
    	
    	if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$filters['stocking_place'][$row['stocking_place_id']] =
    														array ( 'value' => $row['stocking_place_id'],
    																 'text'  =>	$row['name']);
    		}
    	}
    	
    	$filters['supplier'][] = array ( 'value' =>-1, 'text'  => 'Fournisseur');
    	
    	$query = $this->db->get('supplier');
    	
    	if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$filters['supplier'][$row['supplier_id']] =
											    			array ( 'value' => $row['supplier_id'],
											    					'text'  =>	$row['name']);
    		}
    	}

    	$filters['item_tag'][] = array ( 'value' =>-1, 'text'  => 'Type');
    	
    	$query = $this->db->get('item_tag');
    	 
    	if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$filters['item_tag'][$row['item_tag_id']] =
											    			array ( 'value' => $row['item_tag_id'],
											    					'text'  =>	$row['name']);
    		}
    	}
    	 
    	$filters['created_by'][] = array ( 'value' =>-1, 'text'  => 'Personne');
    	 
    	$query = $this->db->get('user');
    	
    	if($query->result_array())
    	{
    		foreach($query->result_array() as $row){
    			$filters['created_by'][$row['user_id']] =
											    			array ( 'value' => $row['user_id'],
											    					'text'  =>	$row['initials']);
    		}
    	}
    	
    	return $filters;
    	
  
    }
  
    /* *** Updates item's image in database *** */
    
    public function set_image($id, $image_file_name)
    {
    	
    	$update_array = array(
    			'image' => $image_file_name
    	);
    	
    	$this->db->where('item_id', $id);
    	$this->db->update('item', $update_array);
    	
    		
    }
    
    /* *** Delete tag from database *** */
    
    public function delete_tag($id)
    {
    	$this->db->where('item_tag_link_id', $id);
		$this->db->delete('item_tag_link');  
    
    }
    
    /* *** Create tag in database *** */
    
    public function create_tag($id, $tag_id)
    {
    	
    	$query = $this->db->get_where('item_tag_link',  array('item_id' => $id, 'item_tag_id' => $tag_id));
    	
    	if($query->num_rows() > 0) 
    		return false;
    	
	    $array_create = array(
	    		'item_id' => $id,
	    		'item_tag_id' => $tag_id
	    );
	    
	    $this->db->insert('item_tag_link', $array_create);
    }
    
    /* *** Check date format *** */
    
    function _validateDate($date)
    {
    	$d = DateTime::createFromFormat('Y-m-d', $date);
    	return $d && $d->format('Y-m-d') == $date;
    }
    
    /* *** Check inputs from a "HTML Form" for the item table *** */
    
    public function validate_post(&$item, &$error_message)
    {
    	
    	if($item['created_by_user_id'] < 1)
    	{
    		$error_message .= ('<br>"Crée par" est obligatoire');
    	}
    	
    	if($item['modified_by_user_id'] < 1)
    	{
    		$item['modified_by_user_id'] = NULL;
    	}
    	
    	if($item['control_by_user_id'] < 1)
    	{
    		$item['control_by_user_id'] = NULL;
    	}
    	
    	if($item['stocking_place_id'] < 1)
    	{
    		$item['stocking_place_id'] = NULL;
    	}
    	
    	if($item['item_state_id'] < 1)
    	{
    		$item['item_state_id'] = NULL;
    	}
    	
    	if($item['supplier_id'] < 1)
    	{
    		$item['supplier_id'] = NULL;
    	}
    	
    	if(empty($item['buying_date']))
    		$item['buying_date'] = NULL;
    	
    	if($item['buying_date'] != NULL)
	    	if(!$this->_validateDate($item['buying_date']))
	    	{
	    		$error_message .= ('<br>La date d\'achat est incorrecte');

	    	}
    	
    	if(empty($item['created_date']))
    		$item['created_date'] = NULL;
    		
    	
    	if($item['created_date'] != NULL)
    		if(!$this->_validateDate($item['created_date']))
    		{
    			$error_message .= ('<br>La date de création est incorrecte');

    		}

    	if(empty($item['modified_date']))
    		$item['modified_date'] = NULL;

    	if($item['modified_date'] != NULL)
    		if(!$this->_validateDate($item['modified_date']))
    		{
    			$error_message .= ('<br>La date de modification est incorrecte');

    		}
    	
    	if(empty($item['control_date']))
    		$item['control_date'] = NULL;

    	if($item['control_date'] != NULL)
    		if(!$this->_validateDate($item['modified_date']))
    		{
    			$error_message .= ('<br>La date de contrôle est incorrecte');

    		}
    	
    	return;
    }
    
    /* *** Update an item *** */
    
    public function update_item($id, &$item)
    {
    	
    	$update_array = array(
								'name'					=> $item['name'],
								'stocking_place_id' 	=> $item['stocking_place_id'],
				    			'description' 			=> $item['description'],
				    			'supplier_id' 			=> $item['supplier_id'],
				    			'serial_number' 		=> $item['serial_number'],
				    			'remarks' 				=> $item['remarks'],
				    			'buying_price' 			=> $item['buying_price'],
				    			'buying_date' 			=> $item['buying_date'],
				    			'warranty_duration' 	=> $item['warranty_duration'],
				    			'file_number' 			=> $item['file_number'],
				    			'created_by_user_id' 	=> $item['created_by_user_id'],
				    			'created_date' 			=> $item['created_date'],
				    			'modified_by_user_id' 	=> $item['modified_by_user_id'],
				    			'modified_date' 		=> $item['modified_date'],
				    			'control_by_user_id' 	=> $item['control_by_user_id'],
				    			'control_date' 			=> $item['control_date'],
				    			'item_state_id' 		=> $item['item_state_id']
				    			);
    	

 		$this->db->where('item_id', $id);

    	$this->db->set($update_array);
    	return $this->db->update('item');	
    }
    
    /* *** Create an item *** */
    
    public function create_item(&$item)
    {
    	 
    	$update_array = array(
    			'name'					=> $item['name'],
    			'stocking_place_id' 	=> $item['stocking_place_id'],
    			'description' 			=> $item['description'],
    			'supplier_id' 			=> $item['supplier_id'],
    			'serial_number' 		=> $item['serial_number'],
    			'remarks' 				=> $item['remarks'],
    			'buying_price' 			=> $item['buying_price'],
    			'buying_date' 			=> $item['buying_date'],
    			'warranty_duration' 	=> $item['warranty_duration'],
    			'file_number' 			=> $item['file_number'],
    			'created_by_user_id' 	=> $item['created_by_user_id'],
    			'created_date' 			=> $item['created_date'],
    			'modified_by_user_id' 	=> $item['modified_by_user_id'],
    			'modified_date' 		=> $item['modified_date'],
    			'control_by_user_id' 	=> $item['control_by_user_id'],
    			'control_date' 			=> $item['control_date'],
    			'item_state_id' 		=> $item['item_state_id']
    	);
    	
  	
    	$this->db->set($update_array);
    	
    	if($this->db->insert('item'))
	    	return $this->db->insert_id();
    	else
    		return 0;
    }
    
    /* *** Generate a blank item array *** */
    
    public function create_blank_item()
    {
    	$blank_array = array(
    			'name'					=> NULL,
    			'stocking_place_id' 	=> NULL,
    			'description' 			=> NULL,
    			'supplier_id' 			=> NULL,
    			'serial_number' 		=> NULL,
    			'remarks' 				=> NULL,
    			'buying_price' 			=> NULL,
    			'buying_date' 			=> NULL,
    			'warranty_duration' 	=> NULL,
    			'file_number' 			=> NULL,
    			'created_by_user_id' 	=> NULL,
    			'created_date' 			=> NULL,
    			'modified_by_user_id' 	=> NULL,
    			'modified_date' 		=> NULL,
    			'control_by_user_id' 	=> NULL,
    			'control_date' 			=> NULL,
    			'item_state_id' 		=> NULL
    	);
    	
    	return $blank_array;
    }

    /* *** Delete an item from database *** */
   
    public function delete_item($id)
    {
    	$this->db->where('item_id', $id);
    	$this->db->delete('item');
    
    }
    
    
}