<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Order_items extends CI_Controller {

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
			{	$this->load->view('login_form');
                        }else {
			$crud = new grocery_CRUD();
			$crud->set_model('orderItems_crudModel');
			//$crud->set_theme('datatables');
                        $crud->set_theme('bootstrap');
                        //$crud->set_theme('flexigrid');
			$crud->set_table('tb_contract_items');
			$crud->set_relation('order_id','tb_orders','order_name','order_type = "contract" and order_complete = "no"');
			//$crud->display_as('officeCode','Office City');
			$crud->set_subject('Contract_Item');

			$crud->required_fields('order_id', 'description', 'amount' , 'customer_vat');
			$crud->display_as('customer_vat' ,'Customer Vat %')
                                ->display_as('item','PO Item');
                        
                        //$crud->unset_clone();
                        
                        
			//$crud->unset_jquery();
                        
                        $crud->columns(
                                'item_id',
                                'item',
                                'order_id', 
                                'description',
                                'unit',
                                'qty',
                                'amount' , 
                                'customer_vat'
                                
                                );
                        
                        $output = $crud->render();
                        
			//$this->_example_output($output);
			$this->load->view('output_page', $output);
                        }
                        
                        }
                        
            function _date($value, $row)
            {
                return "<span style='visibility:hidden;display:none;'>".date('Y-m-d', strtotime($value))."</span>".date('d/m/Y', strtotime($value));
            }
}

?>