<?php 
class Trips_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
    
    function db_insert($post_array) {	
	
		$this->db->trans_begin();
                $st = 0;
                //get related order of trip
                $query = $this->db->query("select * from tb_orders where order_id = ".$post_array['order_id']);
                $order = $query->row();
                
                
                // update client account block 
                if($order->order_type == "callout"){
                    
                    $cvat = 0.0;
                    $cvat = (($post_array['trip_charges']  +  $post_array['delay_charges'])/100) * $post_array['customer_vat'];
                    $cvat = round($cvat,2);
                    $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            .$post_array['trip_charges'] ." + ".$post_array['delay_charges']." + ". $cvat.""
                            . " where account_id = ".$order->client_id);
                        $st = $this->db->affected_rows();
                        // update customer vat
                            if($cvat <> 0) {
                                $st = $st + $this->update_vat(-$cvat); // 1
                            } else {
                                
                                $st = $st + 1; // 2
                            }
                            
                          
                        
                    }
                    else 
                    {
                        $post_array['trip_charges'] = 0;
                        $post_array['delay_charges'] = 0;
                        $post_array['customer_vat'] = 0;
                        $st = 2;
                    }       
		/////////////////////////////////////////////////////////////////////////////////
                
                
		// the below step is to skip month vendor trip charges entry
                
                if($post_array['vendor_type'] == "callout"){
                    
                    $this->db->query("update tb_accounts set account_balance = account_balance - "
                            .$post_array['vendor_charges']. " - " . $post_array["vendor_vat_amount"] . " where account_id = '".$post_array['vendor_id']."' ");
                    
                    $st = $st + $this->db->affected_rows(); // 3
                   
                    // vendor vat update 
                    $vvat = $post_array["vendor_vat_amount"];
                     if($vvat <> 0) {
                                $st = $st + $this->update_vat($vvat); // 4
                            } else {
                                
                                $st = $st + 1; // 4
                            }
		
                } else {
                    $post_array['vendor_charges'] = 0;
                    $post_array['vendor_vat_amount'] = 0;
                    $st = $st + 2; // 4
                }
                /////////////////////////////////////////////////////////////////////////////////////
                
                //enter the trip into db
                
		$insert = $this->db->insert($this->table_name,$post_array);
		
                
                //rollback block 
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
		
                // get old entry 
		$query = $this->db->query("select * from tb_callout_trips where trip_id = " 
                        . $primary_key_value ."");
		
		$old_trip = $query->row();
                
                
                // get old order to get old client id 
                
                $query = $this->db->query("select * from tb_orders where order_id = " 
                        . $old_trip->order_id);
                
                $old_order = $query->row();
                
		///////////////////////////////////////////////////////////////////////////
                
                //undo changes to client account 
                if($old_order->order_type == "callout"){
                   $cvat = 0.0;
                $cvat = (($old_trip->trip_charges  +  $old_trip->delay_charges)/100) * $old_trip->customer_vat;  
                $cvat = round($cvat,2);
                    $this->db->query("update tb_accounts set account_balance = account_balance - "
                            . $old_trip->trip_charges ." - ". $old_trip->delay_charges . " - " . $cvat
                            ."  where account_id =  "
                            . $old_order->client_id );

                    $st = $this->db->affected_rows(); //1
                    
                    
                    // update client vat
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
		/////////////////////////////////////////////////////////////////////////////////////
                
                //undo chnages to vendor account
                if($old_trip->vendor_type == "callout"){ 
                    
                    $this->db->query("update tb_accounts set account_balance = account_balance + "
                            . $old_trip->vendor_charges ." + ". $old_trip->vendor_vat_amount ." where account_id = ". $old_trip->vendor_id ." ");
		
                    $st = $st + $this->db->affected_rows(); //3
                    
                    
                        // vendor vat update 
                    $vvat = $old_trip->vendor_vat_amount;
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
		////////////////////////////////////////////////////////////////////////////////////////
		
		// update client block 
                //get new order and new client id
                $query = $this->db->query("select * from tb_orders where order_id = " 
                        . $post_array['order_id']);
                
                $new_order = $query->row();
                $cvat = 0.0;
                $cvat = (($post_array['trip_charges']  +  $post_array['delay_charges'])/100) * $post_array['customer_vat'];
                $cvat = round($cvat,2);
		if($new_order->order_type == "callout"){
                    $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            .$post_array['trip_charges'] ." + ". $post_array['delay_charges']." + ". $cvat
                            . " where account_id = "
                            . $new_order->client_id );

                    $st = $st + $this->db->affected_rows(); //5
                    
                    // update client vat
                            if($cvat <> 0) {
                                $st = $st + $this->update_vat(-$cvat);
                            } else {
                                
                                $st = $st + 1; //6
                            }
                    
                    
                }
                else
                {
                    $post_array['trip_charges'] = 0;
                    $post_array['delay_charges'] = 0;
                    $post_array['customer_vat'] = 0;
                    $st = $st + 2;//6
                }
                ////////////////////////////////////////////////////////////////////////////////////////
                
                // update vendor block 
		// the below step is to skip month vendor trip charges entry
                
                if($post_array['vendor_type'] == "callout"){
                   
                    $this->db->query("update tb_accounts set account_balance = account_balance - "
                            .$post_array['vendor_charges'] . "-". $post_array['vendor_vat_amount'] ." where account_id = '"
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
                    $post_array['vendor_vat_amount'] = 0;
                    $st = $st + 2;    //8
                }
		////////////////////////////////////////////////////////////////
                
                
		// update trip block 
                
                $obj = $this->db->update($this->table_name,$post_array, array( $primary_key_field => $primary_key_value));
		
		$st = $st + $this->db->affected_rows(); //9 
                
                //////////////////////////////////////////////////////////////
                
                
                //rollback block 
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
		// get trip
		$query = $this->db->query("select * from tb_callout_trips where trip_id = " 
                        . $primary_key_value ."");
		
		$trip = $query->row();
                
                ///////////////////////////////////////////////////////////////////////////
                
                
                //get order
                
                $query = $this->db->query("select * from tb_orders where order_id = " 
                        . $trip->order_id ."");
                $order = $query->row();
                
                
                ///////////////////////////////////////////////////////////////////////////
                
                if ($order->order_type == "callout") {
                
                //update client account
                $cvat = 0.0;
                $cvat = (($trip->trip_charges  +  $trip->delay_charges)/100) * $trip->customer_vat;  
                $cvat = round($cvat,2);
		$this->db->query("update tb_accounts set account_balance = account_balance - "
                        . $trip->trip_charges ." - ". $trip->delay_charges ." - ". $cvat 
                        ."  where account_id =  "
                        . $order->client_id .  "");
		
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
                
                ///////////////////////////////////////////////////////////
                
                
                // update vendor block 
                if($trip->vendor_type == "callout"){ 
                    
                    $this->db->query("update tb_accounts set account_balance = account_balance + "
                            . $trip->vendor_charges . " + " . $trip->vendor_vat_amount .   " where account_id = ". $trip->vendor_id ." ");
		
                    $st = $st + $this->db->affected_rows(); //3
                    
                    
                    
                        // vendor vat update 
                    $vvat = $trip->vendor_vat_amount;
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
               
                ///////////////////////////////////////////////////////////
                
                
                
                
                
		// delete trip block 
                $this->db->limit(1);
                $this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
		
		$st = $st + $this->db->affected_rows(); //5
              
		////////////////////////////////////////////////////////////
                
                 // rollback block 
                
                if ($this->db->trans_status() === FALSE or !($st == 5)  )
		{
				$this->db->trans_rollback();
				return false;
		}
		else
		{
				$this->db->trans_commit();
                                @unlink('assets/uploads/files/trip-docs/'.$trip->trip_docs);
				return true;
		}
                
    }
    
    private function  update_vat($vat_amount) {
        
        
            $this->db->query("update tb_accounts "
                            . "set account_balance = account_balance + "
                            . $vat_amount .""
                            . " where account_id = 375");
                        $st = $this->db->affected_rows();
                        return $st;
        
        
            } // end of update_vat function 


    
}
?>