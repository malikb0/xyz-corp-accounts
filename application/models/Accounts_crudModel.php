<?php 
class Accounts_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
		
		
		
    
	
	function db_delete($primary_key_value)
    {
		$primary_key_field = $this->get_primary_key();
		
		if($primary_key_field === false)
    		return false;
		
                $query = $this->db->query("select * from tb_accounts where account_id = " . $primary_key_value ."");
		$old_entry = $query->row();
                
                if($old_entry->account_type == 'asset' || 
                        $old_entry->account_type == 'cash_inhand' ||
                        $old_entry->account_type == 'bank' ||
                        $old_entry->account_type == 'owner' ||
                        $old_entry->account_type == 'tax' ||
                        $old_entry->account_type == 'zakat'){
                    return FALSE;
                        }
                
		$query = $this->db->query("select * from tb_transactions where account_from = " . $primary_key_value ."");
		
		if ($query->num_rows() > 0)
			return false;
		
		$query = $this->db->query("select * from tb_transactions where account_to = " . $primary_key_value ."");
		
		if ($query->num_rows() > 0)
			return false;
		

    	$this->db->limit(1);
    	$this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
    	if( $this->db->affected_rows() != 1){
    		return false;
        }	else {
    		return true;
        }    
  
    }
}
?>