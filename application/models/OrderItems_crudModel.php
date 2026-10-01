<?php 
class OrderItems_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
        function db_insert($post_array) {
       
                //get related order of item
                $query = $this->db->query("select * from tb_orders where order_id = ".$post_array['order_id']);
                $order = $query->row();
                
                
           $this->db->trans_begin();
		
                
                $cvat = 0.0;
                $cvat = (($post_array['amount'])/100)* $post_array['customer_vat'];
                $cvat = round($cvat,2);
		$this->db->query("update tb_accounts "
                            . "set account_balance = round(account_balance, 2) + "
                            . round($post_array['amount'], 2) . " + " . $cvat  
                            . " where account_id = ".$order->client_id );


                    $st = $this->db->affected_rows();// 1
                    
                     // update customer vat
                            if($cvat <> 0) {
                                $st = $st + $this->update_vat(-$cvat); // 1
                            } else {
                                
                                $st = $st + 1; // 2
                            }
                    
                
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
    }// end insert function 
    

        function db_update($post_array, $primary_key_value) {
		
		
		
                $primary_key_field = $this->get_primary_key();
        
		if($primary_key_field === false)
    		return false;
                
                
                $query = $this->db->query("select * from tb_contract_items where item_id = " 
                        . $primary_key_value ."");
		
		$old_item = $query->row();
		
                
                
                //get related order of item
                $query = $this->db->query("select * from tb_orders where order_id = ". $old_item->order_id);
                $old_order = $query->row();
                
                $this->db->trans_begin();
                // undo client account balance changes
                
                $cvat = 0.0;
                $cvat = (round($old_item->amount,2)/100)* $old_item->customer_vat;
                $cvat = round($cvat,2);
                $this->db->query("update tb_accounts set account_balance = round(account_balance, 2) - "
                                . round($old_item->amount,2) . " - " . $cvat   
                                ."  where account_id = ". $old_order->client_id);

                        $st = $this->db->affected_rows(); //1
                        
                        // update client vat
                            if($cvat <> 0) {
                                        $st = $st + $this->update_vat($cvat);
                                    } else {

                                        $st = $st + 1; //2
                                    }
                        
                        
                        
                ///////////////////////////////////////////////////////////////////////////////////////////////////        
                
                //get related new order of item
                $query = $this->db->query("select * from tb_orders where order_id = ".$post_array['order_id']);
                $new_order = $query->row();
                
                
                // update new customer account amount
                $cvat = 0.0;
                $cvat = ($post_array['amount']/100)* $post_array['customer_vat'];
                $cvat = round($cvat,2);
                $this->db->query("update tb_accounts "
                            . "set account_balance = round(account_balance, 2) + "
                            .round($post_array['amount'], 2). " + " . $cvat  
                            . " where account_id = ".$new_order->client_id );


                    $st = $st + $this->db->affected_rows(); //3
                    
                    
                    // update client vat
                            if($cvat <> 0) {
                                $st = $st + $this->update_vat(-$cvat);
                            } else {
                                
                                $st = $st + 1; //4
                            }
                    
                ///////////////////////////////////////////////////////////////////////////////////////
                
                
		// update item entry 
                $obj = $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));

		$st = $st + $this->db->affected_rows(); //5 
                
                
                
                
                // roll back mechanism
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
                
          }// end of update function 
    
    
        function db_delete($primary_key_value){
            
    	$primary_key_field = $this->get_primary_key();

                if($primary_key_field === false)
    		return false;
		
		
		// get old item entry 
		$query = $this->db->query("select * from tb_contract_items where item_id = " 
                        . $primary_key_value ."");
		
		$old_item = $query->row();
		
                
                
                //get related order of item
                $query = $this->db->query("select * from tb_orders where order_id = ". $old_item->order_id);
                $old_order = $query->row();
                
                $this->db->trans_begin();
                // undo client account balance changes
                
                $cvat = 0.0;
                $cvat = ((round($old_item->amount, 2))/100) * $old_item->customer_vat;
                $cvat = round($cvat,2);
                $this->db->query("update tb_accounts set account_balance = round(account_balance, 2) - "
                                . round($old_item->amount, 2) . "-" . $cvat 
                                ."  where account_id = ". $old_order->client_id);

                        $st = $this->db->affected_rows(); //1
                        
                        // update client vat
                            if($cvat <> 0) {
                                        $st = $st + $this->update_vat($cvat);
                                    } else {

                                        $st = $st + 1; //2
                                    }
                        
                        
                        
                 //delete item entry 
                $this->db->limit(1);
                $this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
		
		$st = $st + $this->db->affected_rows(); //3  // db can stop checking effective rows for delete
              
		// rollback mechanism
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
                
                
        }//end of delete function 
        
        
           private function  update_vat($vat_amount) {
        
        
            $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            . $vat_amount .""
                            . " where account_id = 375");
                        $st = $this->db->affected_rows();
                        return $st;
        
        
            } // end of update_vat function 
    
}// class end bracket