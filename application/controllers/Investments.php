<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Investments extends CI_Controller {

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
		$this->load_transactions();
		
	}
	
		public function load_transactions(){
		
		if (! isset($this->session->userdata['logged_in'])) {
			$this->load->view('login_form');
                   
                   }else {
                   
		$crud = new grocery_CRUD();
		
		$crud->set_model('Investments_crudModel');
		
		//$crud->set_theme('datatables');
                $crud->set_theme('flexigrid');
		$crud->set_table('tb_investments');
		$crud->set_subject('Investment');
		$crud->set_relation('owner_account','tb_accounts','account_name',"account_type = 'owner'");
		$crud->set_relation('cash_account','tb_accounts','account_name',"account_type = 'cash_inhand' or account_type = 'bank' ");
		
		$crud->required_fields('owner_account','cash_account','amount','investment_date','description');
		$crud->display_as('reference_url','Investment Reference');
        
                
                $crud->set_field_upload('reference_url','assets/uploads/files/investment-references');
                
                //$crud->unset_jquery();
                $output = $crud->render();
		
		$this->load->view('output_page', $output);
                   }
		
	}
}

?>