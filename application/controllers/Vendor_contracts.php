<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Vendor_contracts extends CI_Controller {

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
		$this->load_contracts();
		
	}

	
		public function load_contracts(){
		
		if(!isset($this->session->userdata['logged_in']))
		{		$this->load->view('login_form');
                }else{
                
                
               // $this->config->load('grocery_crud');
                
                
		
                
		$crud = new grocery_CRUD();
		
		
		
		//$crud->set_theme('datatables');
                //$crud->set_theme('flexigrid');
                $crud->set_theme('bootstrap');
		$crud->set_table('tb_vendor_contracts');
                $crud->set_subject('Contract');
                
		$crud->set_relation('vendor_id','tb_accounts','account_name',array( "account_type"  => "vendor"));
		$crud->required_fields('contract_name','vendor_id','contract_start_date','contract_complete','contract_description');
                $crud->display_as('vendor_id','Vendor Name')
                        ->display_as('contract_start_date','Contract Date');
                
                
                
		
                
                
                $crud->callback_before_update(array($this,'unset_vendor'));
                //$crud->unset_clone();
                
                //$crud->unset_jquery();
                
                $crud->columns(
                        'contract_id',
                        'contract_name',
                        'vendor_id',
                        'contract_start_date',
                        'contract_complete',
                        'contract_description'
                        
                        );
                
                $output = $crud->render();
		$this->load->view('output_page', $output);
                }
		
	}// end load orders function 
        
        function unset_vendor($post_array, $primary_key) {
            unset($post_array['vendor_id']);
            return $post_array;
        }
        function _date($value, $row)
            {
            return "<span style='visibility:hidden;display:none;'>".date('Y-m-d', strtotime($value))."</span>".date('d/m/Y', strtotime($value));
            }
        

        
}

?>