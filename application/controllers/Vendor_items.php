<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Vendor_items extends CI_Controller {

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
		$this->load_items();
		
	}

        public function load_items(){
             if(!isset($this->session->userdata['logged_in']))
             {		$this->load->view('login_form');
             }else{
            
                
		$crud = new grocery_CRUD();
		
		$crud->set_model('vendoritems_crudModel');
		
		//$crud->set_theme('datatables');
                $crud->set_theme('bootstrap');
                //$crud->set_theme('flexigrid');
		$crud->set_table('tb_vendor_items');
                $crud->set_subject('Item');
                
		$crud->set_relation('contract_id','tb_vendor_contracts','contract_name',array( "contract_complete"  => "no"));
		$crud->required_fields('contract_name','item_date','drivers','quantity','description','amount','item_vat_amount');
                $crud->display_as('contract_name','Contract Name');
                //$crud->unset_clone();
                
                //$crud->unset_jquery();
                
                $crud->columns(
                        'item_id',
                        'contract_id',
                        'item_date',
                        'drivers',
                        'quantity',
                        'description',
                        'amount',
                        'item_vat_amount'
                        );
                
                $output = $crud->render();
                $this->load->view("output_page.php",$output);
             }
        }
        function _date($value, $row)
            {
            return "<span style='visibility:hidden;display:none;'>".date('Y-m-d', strtotime($value))."</span>".date('d/m/Y', strtotime($value));
            }

        
}

?>