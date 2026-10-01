<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Expenses extends CI_Controller {

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
		$this->load_expenses();
		
	}
	
		public function load_expenses(){
		
		if (! isset($this->session->userdata['logged_in']))
                {
                    $this->load->view('login_form');
                }else {
                
		
		$crud = new grocery_CRUD();
		
		$crud->set_model('expenses_crudModel');
		
		//$crud->set_theme('datatables');
               $crud->set_theme('flexigrid');
                //$crud->set_theme('bootstrap');
		$crud->set_table('tb_expenses');
                        
		$crud->set_subject('Expense');
                
		$crud->set_relation('account_id','tb_accounts','account_name', 
                        'account_type = "expense" or '
                        . 'account_type = "office_expense" or '
                        . 'account_type = "sattah" or '
                        . 'account_type = "zakat" or '
                        . 'account_id in (select account_id from tb_vehicles)');
                
                
		$crud->required_fields('account_id','exp_date','description','amount', 'vat_amount');
                $crud->fields('account_id','exp_date','description','amount', 'vat_amount','fatora_url');
                $crud->set_field_upload('fatora_url','assets/uploads/files/fatora');
                
                $crud->display_as('account_id','Account_Name')
                        ->display_as('exp_id','Expense ID')
                        ->display_as('fatora_url','Fatora Copy')
                        ->display_as('exp_date','Date_of_Expense');
                $crud->unset_columns('fatora_url');
                
                //$crud->order_by('exp_date','desc');
		//$crud->callback_column('exp_date',array($this,'_date'));
                //$crud->unset_clone();
                
			                
                
                
                        
                        
                $crud->columns(array(
                    'exp_id',
                    'account_id',
                    'exp_date',
                    'amount',
                    'description',
                    'vat_amount',
                    
                    
                ));         
                //$crud->unset_jquery();
                $output = $crud->render();
                $this->load->view('output_page', $output);
                
                }
		
	}
        
        function _date($value, $row)
            {
            return "<span style='visibility:hidden;display:none;'>".date('Y-m-d', strtotime($value))."</span>".date('d/m/Y', strtotime($value));
            }
}

?>