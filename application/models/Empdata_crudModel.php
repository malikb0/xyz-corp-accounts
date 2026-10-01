<?php 
class Empdata_crudModel extends grocery_CRUD_Model  {
 
	function __construct()
    {
        parent::__construct();
    }
    
    function db_delete($primary_key_value){
          $primary_key_field = $this->get_primary_key();
		
                if($primary_key_field === false)
    		return false;
                
                $query = $this->db->query("select * from tb_employees where emp_id = " . $primary_key_value ."");
		$old_entry = $query->row();
                
                
                $this->db->trans_begin();
                 // delete salary entry for given key 
                $this->db->limit(1);
                $this->db->delete($this->table_name,array( $primary_key_field => $primary_key_value));
		
		$st = $this->db->affected_rows(); //1
                    
                 // roll back mechanism 
              if ($this->db->trans_status() === FALSE or !($st == 1)  )
		{
				$this->db->trans_rollback();
				return false;
		}
		else
		{
				$this->db->trans_commit();
                               
                                
                                    @unlink('assets/uploads/files/emp-pic/'.$old_entry->emp_pic_url);
                                
                                    @unlink('assets/uploads/files/iqama/'.$old_entry->iqama_url);
                                
                                    @unlink('assets/uploads/files/license/'.$old_entry->license_url);
                                
                                    @unlink('assets/uploads/files/aramco-id/'.$old_entry->aramco_id_url);
                                
                                    @unlink('assets/uploads/files/passport/'.$old_entry->passport_url);
                               
                                    @unlink('assets/uploads/files/other-employee-files/'.$old_entry->other_file);
                                
                                return true;
		}
    }
    
    
    
}// end of model class