<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Accounts extends CI_Controller {

	public function __construct() {
	parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		$this->load->helper('url');

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
		$this->accounts_();
		
	}
	
		public function accounts_(){
		
			if(!isset($this->session->userdata['logged_in']) ){
				$this->load->view('login_form');
                        }
                        
                        else {
                            
                        
		  
                            
			$crud = new grocery_CRUD();
			$crud->set_model('accounts_crudModel');
			//$crud->set_theme('datatables');
                        //$crud->set_theme('flexigrid');
                        $crud->set_theme('bootstrap');
			$crud->set_table('tb_accounts');
			//$crud->set_relation('officeCode','offices','city');
			//$crud->display_as('officeCode','Office City');
			$crud->set_subject('Account');
                        $crud->display_as('account_id','ACC ID')
                                ->display_as('address1', 'First Address Line');
			$crud->required_fields('account_name', 'account_type');
			$crud->field_type('account_type','dropdown',
				array( "cash_inhand" => "cash_inhand", 
                                    "customer" => "customer", 
                                    "vendor" => "vendor" ,
                                    "driver_os" => "driver_os", 
                                    "employee" => "employee",
                                    "vehicle" => "vehicle",
                                    "sattah" => "sattah",
                                    "bank" => "bank" , 
                                    "asset" => "asset", 
                                    "expense" => "expense", 
                                    "office_expense" => "office_expense",
                                    "owner"  => "owner",
                                    "tax" => "tax",
                                    "zakat" => "zakat"));
			
                        $crud->unset_edit_fields('account_balance','account_type');
                        $crud->unset_add_fields('account_balance');
                        
                        
                        
                        
                        //$crud->unset_clone();
			//$crud->unset_jquery();
                        $crud->columns(array(
                            'account_id',
                            'account_name',
                            'account_type',
                            'address1',
                            'arabic_address',
                            'arabic_name',
                            'vat_reg_no',
                            'account_balance',
                        ));
                        
                        $output = $crud->render();
                        $output->output = "<h1>Accounts</h1>".$output->output;
			//$this->_example_output($output);
			$this->load->view('output_page', $output);
                        
	
                        }
        }
}

?>