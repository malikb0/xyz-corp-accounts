<?php 
class Profits_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
    
        function db_insert($post_array) {	
                
            
            
		$this->db->trans_begin();
		

		// update related account balance
                
		$this->db->query("update tb_accounts set account_balance = account_balance - ".$post_array['amount']." where account_id = '".$post_array['account_id']."' ");
    	
		$st = $this->db->affected_rows(); //1
		
		$insert = $this->db->insert($this->table_name,$post_array);
		
	
		// roll back mechanism 
		if ($this->db->trans_status() === FALSE or !($st == 1) or $insert === false )
		{
				$this->db->trans_rollback();	
				return false;
		}
		else
		{
				$this->db->trans_commit();
				return $this->db->insert_id();		
		}
		

		
    	return false;
    } // end insert function 
    
    
    function db_update($post_array, $primary_key_value) {
		
		
    	$primary_key_field = $this->get_primary_key();
		if($primary_key_field === false)
    		return false;
		
		$this->db->trans_begin();
                
		// get old expense entry 
		$query = $this->db->query("select * from tb_profits where profit_id = " . $primary_key_value ."");
		$old_profit = $query->row();
		
		
		// undo old account balance update
		$this->db->query("update tb_accounts set account_balance = account_balance + ". $old_profit->amount ." where account_id = ". $old_profit->account_id ." ");
		$st = $this->db->affected_rows(); //1
                //
		///////////////////////////////////////////////////////////////////////////////////////////////////////
                
                
                
                //update transaction entry 
                $obj = $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));
		$st = $st + $this->db->affected_rows(); //2 
		
		 
		// update related account balance
                
		$this->db->query("update tb_accounts set account_balance = account_balance - ".$post_array['amount']." where account_id = '".$post_array['account_id']."' ");
    	
		$st = $st + $this->db->affected_rows(); //3
		
		
		if ($this->db->trans_status() === FALSE or !($st == 3)  )
		{
				$this->db->trans_rollback();
				return false;
		}
		else
		{
				$this->db->trans_commit();
				return true;
		}
		
    }
    
    
    
    function db_delete($primary_key_value){
            
    	$primary_key_field = $this->get_primary_key();

    	if($primary_key_field === false)
    		return false;
		
		$this->db->trans_begin();
		// get old expense entry 
		$query = $this->db->query("select * from tb_profits where profit_id = " . $primary_key_value ."");
		$old_profit = $query->row();
		
		
		// undo old account balance update
		$this->db->query("update tb_accounts set account_balance = account_balance + ". $old_profit->amount ." where account_id = ". $old_profit->account_id ." ");
		$st = $this->db->affected_rows(); //1
		
                
                //delete expense entry 
                $this->db->limit(1);
                $this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
		
		$st = $st + $this->db->affected_rows(); //2
		
    	if ($this->db->trans_status() === FALSE or !($st == 2)  )
		{
				$this->db->trans_rollback();
				return false;
		}
		else
		{
				$this->db->trans_commit();
                              //  @unlink('assets/uploads/files/fatora/'.$old_profit->fatora_url);
				return true;
		}
    }
    
    
}// end model class