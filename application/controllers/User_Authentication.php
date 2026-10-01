<?php
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
//session_start(); //we need to start session in order to access it through CI

Class User_Authentication extends CI_Controller {

	public function __construct() {
	parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		$this->load->helper('url');
                
                $this->load->library('user_agent');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		$this->load->database(); // load database

		// Load database model
		$this->load->model('login_database');
		
		$this->load->library('grocery_CRUD');
	}

	// Show login page
	public function index() {
		$this->load->view('login_form');
	}
	
	private function _example_output($output = null)
	{
		$this->load->view('admin.php',$output);
	}
	
	
	private function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}
        
        private function valueToRiyal($value, $row){
            return $value. ' &#65020 ';
        }
	
	
	// Show registration page
	private function user_registration_show() {
		//$this->load->view('registration_form');
	}

	// Validate and store registration data in database
	private function new_user_registration() {

		// Check validation for user input in SignUp form
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
		$this->form_validation->set_rules('email_value', 'Email', 'trim|required|min_length[5]|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[12]');
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('registration_form');
			
		} else {
			
			$data = array(
					'sf_name' => $this->input->post('username'),
					'sf_email' => $this->input->post('email_value'),
					'sf_password' => md5($this->input->post('password'))
				);
			$result = $this->login_database->registration_insert($data);
			
			if ($result == TRUE) {
				
				$data['message_display'] = 'Registration Successfully !';
				$this->load->view('login_form', $data);
				
			} else {
				
				$data['message_display'] = 'Username already exist!';
				$this->load->view('registration_form', $data);
			}
		}
	}

	// Check for user login process
	public function user_login_process() {
                sleep(20);
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[25]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[25]');

		if ($this->form_validation->run() == FALSE) {
			
			//if(isset($this->session->userdata['logged_in'])){
                        if(
                           isset($this->session->userdata['logged_in']) and
                           $this->session->userdata['logged_in']['login'] == 'YES'
                            ){
			//$this->session->userdata['logged_in']['login']	
				
				$this->load_admin_page();
			}else{
				
				$this->load->view('login_form');
			}
			
		} else {
			
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			
			$result = $this->login_database->login($data);
			
			if ($result == TRUE) {

				$username = $this->input->post('username');
				$result = $this->login_database->read_user_information($username);
				
				if ($result != false) {
					
					$session_data = array(
						'username' => $result[0]->sf_name,
						'email' => $result[0]->sf_email,
                                                'role' => $result[0]->role,
                                                'dbgroup' => $result[0]->db_user,
                                                'acntid' => $result[0]->acnt_id,
                                                'login' => 'YES'
                                               );
					// Add user data in session
                                        
                                        
                                      
                                       
                                        
					$this->session->set_userdata('logged_in', $session_data);
					// Prevent session fixation: issue a fresh session id on login.
					$this->session->sess_regenerate(TRUE);
                                       
                                        
                                        
                                        
                                        
					$this->load_admin_page();
				}
				
			} else {
				
			$data = array(
					'error_message' => 'Invalid Username or Password'
				);
			$this->load->view('login_form', $data);
			
			}
		}
	
	}

	// Logout from admin page
	public function logout() {
		

		
			
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		$data['logout_message'] = 'Successfully Logout';
		
		$this->load->view('login_form', $data);
	}

	
	
	
	

	private function load_admin_page(){
		
		$this->db->select_sum('account_balance','Total_Debit')
                            ->from('tb_accounts')
                            ->where("account_balance > 0");
                $query = $this->db->get();
                if ($query->num_rows() > 0 )
                    {
                        $output['total_debit'] = $query->row();
                    }
                    
                $this->db->select_sum('account_balance','Total_Credit')
                            ->from('tb_accounts')
                            ->where("account_balance < 0");
                $query = $this->db->get();
                if ($query->num_rows() > 0 )
                    {
                        $output['total_credit'] = $query->row();
                    }
                    
                $this->db->select_sum('account_balance','Total_CashInHand')
                            ->from('tb_accounts')
                            ->where('account_type = "cash_inhand"');
                $query = $this->db->get();
                if ($query->num_rows() > 0 )
                    {
                        $output['total_cashinhand'] = $query->row();
                    }    
                        
                $this->db->select_sum('account_balance','Pending_Expenses')
                            ->from('tb_accounts')
                            ->where('(account_type = "expense"  or account_id in (select account_id from tb_vehicles)) and account_balance < 0');
                $query = $this->db->get();
                if ($query->num_rows() > 0 )
                    {
                        $output['pending_expenses'] = $query->row();
                    }      
                    
                $this->db->select_sum('account_balance','Pending_Vendors')
                            ->from('tb_accounts')
                            ->where('account_type = "vendor" and account_balance < 0');
                $query = $this->db->get();
                if ($query->num_rows() > 0 )
                    {
                        $output['pending_vendors'] = $query->row();
                    }  
                    
			                    
                $query = $this->db->query("
                    SELECT 
                        order_name,invoice_submission,invoicing_term , 
                        DATE_FORMAT( date_add(invoice_submission, INTERVAL invoicing_term day), '%d/%b/%Y') as due_date 
                    FROM `tb_orders` 
                    WHERE 
                        date_add(invoice_submission, INTERVAL invoicing_term day) <= date_add(CURRENT_DATE, INTERVAL 5 day) 
                        and order_complete != 1 ORDER BY date_add(invoice_submission, INTERVAL invoicing_term day) ASC
                        " ); 
                
                if ($query->num_rows() > 0 )
                    {
                        foreach ($query->result() as $row)
                                    {
                                    $output['invoices'][" ".$row->order_name] = $row->due_date;
                                   
                                            
                                    }
                    } 
                    
                    
                    $query = $this->db->query("
                    SELECT account_name , iqama_expire,license_expire,aramco_id_expire,passport_expire 
                        FROM 
                            tb_employees as emp 
                        join tb_accounts as ac on ac.account_id = emp.account_id

                        WHERE 
                        (    iqama_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            license_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            aramco_id_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            passport_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                            )
                        and emp_status = 'working' " ); 
                
                if ($query->num_rows() > 0 )
                    {
                        foreach ($query->result() as $row)
                                    {
                                    $output['emp_docs_expires'][" ".$row->account_name] = "Expired or going to Expire";
                                   
                                            
                                    }
                      
                    } 
                    
                    
                    
                    $query = $this->db->query("
                    SELECT 
                            account_name,insurance_expire,tafweez_expire,fahas_expire,istamara_expire,sticker_expire,mzn_card_expire 
                        FROM 
                            tb_vehicles as vh 
                        join tb_accounts as ac on ac.account_id = vh.account_id

                        WHERE 
                            insurance_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            tafweez_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            fahas_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            istamara_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            sticker_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)
                        or 
                            mzn_card_expire <= date_add(CURRENT_DATE, INTERVAL 30 day)" ); 
                
                if ($query->num_rows() > 0 )
                    {
                        foreach ($query->result() as $row)
                                    {
                                    $output['vhcl_docs_expires'][" ".$row->account_name] = "Expired or going to Expire";
                                   
                                            
                                    }
                      
                    } 
                    
                    
                    
		$this->load->view('admin_page',$output);
		
	}
        
      
}

?>