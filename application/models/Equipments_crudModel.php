<?php 
class Equipments_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
    
    function db_insert($post_array) {	
	
		$this->db->trans_begin();
               
                
              //get related order of equipment
                $query = $this->db->query("select * from tb_orders where order_id = ".$post_array['order_id']);
                $order = $query->row();
                
                //update client account
                if($order->order_type == "callout"){
                    $cvat = 0.0;
                    $cvat = (($post_array['rental_charges'])/100)* $post_array['customer_vat'];
                    $cvat = round($cvat,2);
                    $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            .round($post_array['rental_charges'], 2) ." + ". $cvat 
                            . " where account_id = ".$order->client_id );

                    
                    $st = $this->db->affected_rows();
                    
                    if($cvat <> 0) {
                                $st = $st + $this->update_vat(-$cvat);
                            } else {
                                
                                $st = $st + 1; // 2
                            }
                    
                }
                else 
                {
                    $post_array['rental_charges'] = 0;
                    $post_array['customer_vat'] = 0;
                    $st = 2;
                }
                ///////////////////////////////////////////////////////////////
                
                //update vendor account
		// the below step is to skip month vendor trip charges entry
                
                if($post_array['vendor_type'] == "callout"){
                    
                    $this->db->query("update tb_accounts set account_balance = account_balance - "
                            .$post_array['vendor_charges'] . " - " . $post_array['vendor_vat_amount'] . " where account_id = '".$post_array['vendor_id']."' ");
                    
                    $st = $st + $this->db->affected_rows(); // 3
		
                    // vendor vat update 
                    $vvat = $post_array["vendor_vat_amount"];
                     if($vvat <> 0) {
                                $st = $st + $this->update_vat($vvat);
                            } else {
                                
                                $st = $st + 1; // 4
                            }
                    
                    
                } else {
                    $post_array['vendor_charges'] = 0;
                    $post_array['vendor_vat_amount'] = 0;
                    $st = $st + 2; // 4
                }
                ///////////////////////////////////////////////////////////////
		$insert = $this->db->insert($this->table_name,$post_array);
		if ($this->db->trans_status() === FALSE or !($st == 4) or $insert === false )
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
		
                
                //get old rental entry 
		$query = $this->db->query("select * from tb_rental_equipments where re_id = " 
                        . $primary_key_value ."");
		
		$old_rental = $query->row();
		
                
                //get related order of equipment
                $query = $this->db->query("select * from tb_orders where order_id = ".$old_rental->order_id);
                $old_order = $query->row();
                
                //undo old client charges
                if($old_order->order_type == "callout"){
                        $cvat = 0.0;
                        $cvat = (($old_rental->rental_charges)/100)* $old_rental->customer_vat;
                        $cvat = round($cvat,2);
                    $this->db->query("update tb_accounts set account_balance = account_balance - "
                            . $old_rental->rental_charges . " - " . $cvat
                            ."  where account_id = ". $old_order->client_id);

                    $st = $this->db->affected_rows(); //1
                    
                    
                     // update client vat
                    if($cvat <> 0) {
                                $st = $st + $this->update_vat($cvat);
                            } else {
                                
                                $st = $st + 1; //2
                            }
                    
                }else
                    {
                      $st = 2;
                    }
                /////////////////////////////////////////////////////////////////////////////////////
                
                
                //undo old vendor charges    
                if($old_rental->vendor_type == "callout"){ 
                    
                    $this->db->query("update tb_accounts set account_balance = account_balance + "
                            . $old_rental->vendor_charges . " + " . $old_rental->vendor_vat_amount 
                            ." where account_id = ". $old_rental->vendor_id ." ");
		
                    $st = $st + $this->db->affected_rows(); //3
                    
                    
                        // vendor vat update 
                    $vvat = $old_rental->vendor_vat_amount;
                     if($vvat <> 0) {
                                $st = $st + $this->update_vat(-$vvat); // 4
                            } else {
                                
                                $st = $st + 1; //4
                            }
                    
                }else
                     {
                   
                    $st = $st + 2; //2
                   
                }
		//////////////////////////////////////////////////////////////////////////////////////
		
                //get new order detail
                $query = $this->db->query("select * from tb_orders where order_id = ".$post_array['order_id']);
                $new_order = $query->row();
                
		// update client account new charges
		if($new_order->order_type == "callout"){
                    
                    $cvat = 0.0;
                    $cvat = (($post_array['rental_charges'])/100)* $post_array['customer_vat'];
                    $cvat = round($cvat,2);
                    $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            . round($post_array['rental_charges'], 2) ." + " . $cvat 
                            . " where account_id = ". $new_order->client_id );


                    $st = $st + $this->db->affected_rows(); //5
                    //
                    // update client vat
                    if($cvat <> 0) {
                                $st = $st + $this->update_vat(-$cvat);
                            } else {
                                
                                $st = $st + 1; //6
                            }
                    
                    
                }
                else {
                 
                    $post_array['rental_charges'] = 0;
                    $post_array['customer_vat'] = 0;
                    $st = $st + 2; // 6
                    
                }
                ///////////////////////////////////////////////////////////////////////////////////////
                
                
		// the below step is to skip month vendor trip charges entry
                //update vendor new charges
                if($post_array['vendor_type'] == "callout"){
                    
                    $this->db->query("update tb_accounts set account_balance = account_balance - "
                            .$post_array['vendor_charges']. "-" . $post_array['vendor_vat_amount']
                            ." where account_id = '"
                            .$post_array['vendor_id']."' ");
                    
                    $st = $st + $this->db->affected_rows(); //7
                    
                    // vendor vat update 
                            $vvat = $post_array['vendor_vat_amount'];
                             if($vvat <> 0) {
                                        $st = $st + $this->update_vat($vvat); // 8
                                    } else {

                                        $st = $st + 1; //8
                                    }
		
                } else {
                    $post_array['vendor_charges'] = 0;
                    $post_array['vendor_vat_amount'] = 0 ;
                    $st = $st + 2;    //8
                }
		///////////////////////////////////////////////////////////////////////////////////////
                
                
		// update rental entry 
                $obj = $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));

		$st = $st + $this->db->affected_rows(); // 9 
                
                
                
                
                // roll back mechanism
		if ($this->db->trans_status() === FALSE or !($st == 9)  )
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
		// get old rental entry 
		$query = $this->db->query("select * from tb_rental_equipments where re_id = " 
                        . $primary_key_value ."");
		
		$old_rental = $query->row();
		
                
                
                //get related order of equipment
                $query = $this->db->query("select * from tb_orders where order_id = ". $old_rental->order_id);
                $order = $query->row();
                
                // undo client account charges
                if($order->order_type == "callout"){
                        $cvat = 0.0;
                        $cvat = (($old_rental->rental_charges)/100)* $old_rental->customer_vat;
                        $cvat = round($cvat,2);
                        $this->db->query("update tb_accounts set account_balance = account_balance - "
                                . $old_rental->rental_charges . "-" . $cvat  
                                ."  where account_id = ". $order->client_id);

                        $st = $this->db->affected_rows(); //1
                        
                        // undo client vat 
                
                        if($cvat <> 0) {
                                    $st = $st + $this->update_vat($cvat);
                                } else {

                                    $st = $st + 1; //2
                                }
                        
                        
                }
                else
                {
                    $st = 2;
                }
                
                ////////////////////////////////////////////////////////////////////////////////////////////////
                
                // undo vendor charges
                
                if($old_rental->vendor_type == "callout"){ 
                    
                    $this->db->query("update tb_accounts set account_balance = account_balance + "
                            . $old_rental->vendor_charges . " + " . $old_rental->vendor_vat_amount . " where account_id = ". $old_rental->vendor_id ." ");
		
                    $st = $st + $this->db->affected_rows(); //3
                    
                     // vendor vat update 
                        $vvat = $old_rental->vendor_vat_amount;
                         if($vvat <> 0) {
                                    $st = $st + $this->update_vat(-$vvat); // 4
                                } else {

                                    $st = $st + 1; //4
                                }
                    
                }
                
                else
                {
                   
                    $st = $st + 2; //4
                   
                }
                /////////////////////////////////////////////////////////////////////////////////////////////////
		
                
                //delete rental entry 
                $this->db->limit(1);
                $this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
		
		$st = $st + $this->db->affected_rows(); //5
              
		// rollback mechanism
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
    } // end of delete function 
    
    
    private function  update_vat($vat_amount) {
        
        
            $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            . $vat_amount .""
                            . " where account_id = 375");
                        $st = $this->db->affected_rows();
                        return $st;
        
        
            }// end of update Vat function 


    
}// end of class
?>