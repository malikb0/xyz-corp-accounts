<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Upload_invoices extends CI_Controller {

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
		$this->load_orders();
		
	}
	
		public function load_orders(){
		
		if(!isset($this->session->userdata['logged_in']))
		{		$this->load->view('login_form');
                }else {
                    
		$crud = new grocery_CRUD();
		
		//$crud->set_model('Transactions_crudModel');
		$crud->set_model('Orders_crudModel');
		//$crud->set_theme('datatables');
                $crud->set_theme('bootstrap');
                // $crud->set_theme('flexigrid');
		$crud->set_table('tb_orders');
                $crud->set_subject('Invoices Upload');
                
		$crud->set_relation('client_id','tb_accounts','account_name',array( "account_type"  => "customer"));
                
                
                
		$crud->required_fields('order_name','client_id','order_start_date');
                $crud->fields('order_name','qr_inv','client_id','order_start_date','invoice_url', 'invoice_submission','invoicing_term');
                
                $crud->display_as('client_id','ClientName')
                        ->display_as('order_start_date','Invoice_Date');
                
                
                
                
                
                
                
                
                $crud->field_type('order_type','dropdown',
				array( "callout"  => "callout","contract"  => "contract"));
                
                $crud->field_type('order_complete', 'true_false',array('No','Yes'));
                
                $crud->change_field_type('order_name', 'disabled');
                
                
                
                $crud->display_as('invoice_url','Submitted Invoice');
                
                $crud->set_field_upload('invoice_url','assets/uploads/files/invoices');
		
                //$crud->unset_clone();
                //$crud->unset_add();
                
                $state = $crud->getState();
                $state_info = $crud->getStateInfo();
                
                
                
                $crud->callback_before_update(array($this,'unset_extras'));
               
                // $crud->callback_before_update(array($this,'unset_ordertype'));
                 
                $crud->callback_column('order_start_date',array($this,'_date'));
               
                
		$crud->unset_add()->unset_delete();
                
                
                //$crud->unset_jquery();
                
                
                
                $output = $crud->render();
		$this->load->view('output_page', $output);
		
                }
                
                }// end load orders function 
        
        function unset_extras($post_array, $primary_key) {
            unset($post_array['client_id']
                    ,$post_array['order_name']
                    ,$post_array['order_type']
                    ,$post_array['order_complete']
                    ,$post_array['order_start_date']
                    );
            
            
            
            return $post_array;
        }
        
        function unset_ordertype($post_array, $primary_key) {
            unset($post_array['order_type']);
            return $post_array;
        }
        function _date($value, $row)
            {
            return "<span style='visibility:hidden;display:none;'>".date('Y-m-d', strtotime($value))."</span>".date('d/m/Y', strtotime($value));
            }
}

?>