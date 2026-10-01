<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Salary_slip extends CI_Controller {

	public function __construct() {
	parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		$this->load->helper('url');
                
                $this->load->helper('date');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

	if(isset($this->session->userdata['logged_in'])){
		
                   $this->load->database($this->session->userdata['logged_in']['dbgroup']); // load database
               }

		// Load database
		$this->load->model('login_database');
		
		$this->load->library('grocery_CRUD');
	}
		public function index() {
                   
                 $this->load_salary();
                    
                    // $this->load->view('salary_view', $output);
                     
		
	}
	
		public function load_salary(){
                    
                   //check login status of user 
                 if (! isset($this->session->userdata['logged_in'])) {
                   
                     $this->load->view('login_form');
                   
                  }else{
                   

                   /* Set validation rule for name field in the form */
                     $this->form_validation->set_rules('account_id', 'Employee-Name', 'required');
                     //$this->form_validation->set_rules('employee_name', 'Employee-Name', 'required'); 
                     $this->form_validation->set_rules('salary_month', 'Month', 'required|numeric'); 
                     $this->form_validation->set_rules('salary_year', 'Year', 'required|numeric'); 
                     
                     $output['employees'] = $this->get_employees();
                     
                     if ($this->form_validation->run() == FALSE) { 
                      $output['msg'] = "empty employee name";   
                      
                      $this->load->view('salary_view', $output);
                     } 
                     else { 
                         
                         
                        
                      
                   
                   
                        $account_id = $this->input->post('account_id');
                        $salary_month = $this->input->post('salary_month');
                        $salary_year = $this->input->post('salary_year');
                        $this->db->select('account_id, account_name, account_balance')
                                     ->from('tb_accounts')
                                     ->where("account_id = '".$account_id."' and account_type = 'employee'");
                         
                                
                                $query = $this->db->get();
                                
                                //check employee exists
                                if ($query->num_rows() > 0 )
                                    {    
                                        // retrive order from result
                                        $employee = $query->row();
                                        $account_id = $employee->account_id;
                                        $output['employee_name'] = $employee->account_name;
                                        $output['account_balance'] = $employee->account_balance;
                                        
                                        //get employee info against account_id
                                            $this->db->select('*');
                                            $this->db->from('tb_employees');
                                            $this->db->where('account_id',$account_id);
                                            $query = $this->db->get();
                                           if ($query->num_rows() > 0 ) {
                                               $employee_info = $query->row();
                                               $output['joining_date'] = date_format(date_create($employee_info->joining_date), "d, M, Y");
                                           }
                                            
                                        
                                        //get salary against account_id
                                            $this->db->select('*');
                                            $this->db->from('tb_salaries');
                                            $this->db->where("month(_date) = ".$salary_month." and year(_date) = ".$salary_year . " and account_id = " .$account_id);
                                            $query = $this->db->get();
                                            
                                        if ($query->num_rows() > 0 )// check if salary exists
                                        {   
                                            
                                            $output['salary'] = $query->row();
                                            $output['msg'] = "SALARY SLIP FOR THE MONTH OF " . date('F', mktime(0, 0, 0, $salary_month, 10)) ." , ".$salary_year ;
                                            $this->load->view('salary_view', $output); 
                                        }else {
                                        $output['msg'] = " NO SALARY EXISTS FOR THE MONTH OF ". date('F', mktime(0, 0, 0, $salary_month, 10)) ." , ".$salary_year ; 
                                        $this->load->view('salary_view', $output); 
                                        }
                                        
                                        
                                        
                                        
                                    }   
                                    else {
                                       $output['msg'] = " NO EMPLOYEE FOUND " ; 
                                        $this->load->view('salary_view', $output);  
                                        
                                    }// end of employee name checking in db
                        
                        
                    
                        }// end of validation if
                   }  
                }//end load salary function 
                
                private function get_employees(){
                    $this->db->select('tb_salaries.account_id, account_name')
                                     ->from('tb_accounts')
                                     ->join('tb_salaries','tb_salaries.account_id = tb_accounts.account_id')
                                     ->where('account_type', 'employee')
                                     ->order_by('account_name','asc');
                    
                    $query = $this->db->get();
                    if ($query->num_rows() > 0 )// check if salary exists
                        {
                            foreach ($query->result() as $row)
                                    {
                                            $employees[$row->account_id] = $row->account_name;
                                     
                                    }    
                        
                         return $employees;
                        }
                    }
                
}//end class