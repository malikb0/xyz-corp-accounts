<?php 
class Orders_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
		
		
		
    
	
	function db_delete($primary_key_value)
    {
		$primary_key_field = $this->get_primary_key();
		
		if($primary_key_field === false)
    		return false;
	
                
                $query = $this->db->query("select * from tb_orders where order_id = " . $primary_key_value ."");
		$old_entry = $query->row();
                
    	$this->db->limit(1);
    	$this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
    	if( $this->db->affected_rows() != 1){
    		return false;
        }	else {
                @unlink('assets/uploads/files/invoices/'.$old_entry->invoice_url);
    		return true;
        }    
  
    }
}
?>