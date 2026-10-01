<?php 
class Transactions_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
    function db_insert($post_array) {	
	
		$this->db->trans_begin();
		
		$this->db->query("update tb_accounts set account_balance = account_balance - ".$post_array['cash_amount']." where account_id = '".$post_array['account_from']."' ");
		
		$st = $this->db->affected_rows();
		
		$this->db->query("update tb_accounts set account_balance = account_balance + ".$post_array['cash_amount']." where account_id = '".$post_array['account_to']."' ");
    	
		$st = $st + $this->db->affected_rows();
		
		$insert = $this->db->insert($this->table_name,$post_array);
		
	
		
		if ($this->db->trans_status() === FALSE or !($st == 2) or $insert === false )
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
    }

    function db_update($post_array, $primary_key_value) {
		
		
    	$primary_key_field = $this->get_primary_key();
		if($primary_key_field === false)
    		return false;
		
		$this->db->trans_begin();
                
		// get old transaction 
		$query = $this->db->query("select * from tb_transactions where transaction_id = " . $primary_key_value ."");
		$old_transaction  = $query->row();
		
                //undo effected accounts
		$this->db->query("update tb_accounts set account_balance = account_balance + ". $old_transaction->cash_amount ." where account_id = ".$old_transaction->account_from ." ");
		$st = $this->db->affected_rows(); //1
		
		$this->db->query("update tb_accounts set account_balance = account_balance - ". $old_transaction->cash_amount ." where account_id = ". $old_transaction->account_to ." ");
		$st = $st + $this->db->affected_rows(); //2
		///////////////////////////////////////////////////////////////////////////////////////////////////////
                
                
                
                //update transaction entry 
                $obj = $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));
		$st = $st + $this->db->affected_rows(); //3 
		
		 //update accounts with new transaction entry 
		$this->db->query("update tb_accounts set account_balance = account_balance - ".$post_array['cash_amount']." where account_id = ".$post_array['account_from']." ");
		$st = $st + $this->db->affected_rows(); //4
		
		$this->db->query("update tb_accounts set account_balance = account_balance + ".$post_array['cash_amount']." where account_id = ".$post_array['account_to']." ");
		$st = $st + $this->db->affected_rows(); // 5
		
		
		
		if ($this->db->trans_status() === FALSE or !($st == 5)  )
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
		
		$query = $this->db->query("select * from tb_transactions where transaction_id = " . $primary_key_value ."");
		$old_transaction = $query->row();
		
		$this->db->query("update tb_accounts set account_balance = account_balance + ". $old_transaction->cash_amount ." where account_id = ". $old_transaction->account_from ." ");
		$st = $this->db->affected_rows(); //1
		
		$this->db->query("update tb_accounts set account_balance = account_balance - ". $old_transaction->cash_amount ." where account_id = ". $old_transaction->account_to ." ");
		$st = $st + $this->db->affected_rows(); //2
		
    	$this->db->limit(1);
    	$this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
		
		$st = $st + $this->db->affected_rows(); //3
		
    	if ($this->db->trans_status() === FALSE or !($st == 3)  )
		{
				$this->db->trans_rollback();
				return false;
		}
		else
		{
				$this->db->trans_commit();
                                @unlink('assets/uploads/files/transaction-references/'.$old_transaction->reference_url);
				return true;
		}
    }
    
}
?>