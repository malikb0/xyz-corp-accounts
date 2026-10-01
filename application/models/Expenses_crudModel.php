<?php 
class Expenses_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
    
        function db_insert($post_array) {	
                
            
            
		$this->db->trans_begin();
		

		// update related account balance
                
		$this->db->query(""
                        . "update tb_accounts set account_balance = account_balance - "
                        .$post_array['amount']. "-" . $post_array['vat_amount']. 
                        " where account_id = '".$post_array['account_id']."' ");
    	
		$st = $this->db->affected_rows(); //1
		
                 // update vendor vat
                  $vvat = $post_array['vat_amount'];
                             if($vvat <> 0) {
                                $st = $st + $this->update_vat($vvat);
                            } else {
                                
                                $st = $st + 1; // 2
                            }
                
                
		$insert = $this->db->insert($this->table_name,$post_array);
		
	
		// roll back mechanism 
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
    } // end insert function 
    
    
    function db_update($post_array, $primary_key_value) {
		
		
    	$primary_key_field = $this->get_primary_key();
		if($primary_key_field === false)
    		return false;
		
		$this->db->trans_begin();
                
		// get old expense entry 
		$query = $this->db->query("select * from tb_expenses where exp_id = " . $primary_key_value ."");
		$old_expense = $query->row();
		
		
		// undo old account balance update
		$this->db->query(""
                        . "update tb_accounts set account_balance = account_balance + "
                        . $old_expense->amount . " + " . $old_expense->vat_amount
                        ." where account_id = ". $old_expense->account_id ." ");
		$st = $this->db->affected_rows(); //1
                
                // update vendor vat
                  $vvat = $old_expense->vat_amount;
                             if($vvat <> 0) {
                                $st = $st + $this->update_vat(-$vvat); // 2
                            } else {
                                
                                $st = $st + 1; // 2
                            }
                
                
                
                //
		///////////////////////////////////////////////////////////////////////////////////////////////////////
                
                
                
                //update transaction entry 
                $obj = $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));
		$st = $st + $this->db->affected_rows(); //3 
		
		 
		// update related account balance
                
		$this->db->query(""
                        . "update tb_accounts set account_balance = account_balance - "
                        .$post_array['amount'] . "-" . $post_array['vat_amount']
                        ." where account_id = '".$post_array['account_id']."' ");
    	
		$st = $st + $this->db->affected_rows(); //4
                
                // update vendor vat
                  $vvat = $post_array['vat_amount'];
                             if($vvat <> 0) {
                                $st = $st + $this->update_vat($vvat); // 5
                            } else {
                                
                                $st = $st + 1; // 5
                            }
		
		
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
		// get old expense entry 
		$query = $this->db->query("select * from tb_expenses where exp_id = " . $primary_key_value ."");
		$old_expense = $query->row();
		
		
		// undo old account balance update
		$this->db->query(""
                        . "update tb_accounts set account_balance = account_balance + "
                        . $old_expense->amount . " + " . $old_expense->vat_amount 
                        ." where account_id = ". $old_expense->account_id ." ");
		$st = $this->db->affected_rows(); //1
		
                
                // update vendor vat
                  $vvat = $old_expense->vat_amount;
                             if($vvat <> 0) {
                                $st = $st + $this->update_vat(-$vvat); // 2
                            } else {
                                
                                $st = $st + 1; // 2
                            }
                
                
                //delete expense entry 
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
                                @unlink('assets/uploads/files/fatora/'.$old_expense->fatora_url);
				return true;
		}
    } // end of delete function 
    
    
      private function  update_vat($vat_amount) {
        
        
            $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            . $vat_amount .""
                            . " where account_id = 375");
                        $st = $this->db->affected_rows();
                        return $st;
        
        
            }// end of update Vat function 
    
    
}// end model class