<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Rental_equipments extends CI_Controller {

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
		$this->load_rentals();
		
	}
	
		public function load_rentals(){
		
		if(!isset($this->session->userdata['logged_in']))
		{		$this->load->view('login_form');
                }else{
                
		$crud = new grocery_CRUD();
		
		$crud->set_model('equipments_crudModel');
		
		//$crud->set_theme('datatables');
                 //$crud->set_theme('flexigrid');
                $crud->set_theme('bootstrap');
		$crud->set_table('tb_rental_equipments');
		$crud->set_subject('Rent_Equipment');
                
		$crud->set_relation('order_id','tb_orders','order_name','order_complete = "no" ');
                $crud->set_relation('vendor_id','tb_accounts','account_name',array('account_type' => 'vendor'));
		//$crud->set_relation('arbdes_id','tb_arbdescription','eng_description');
		
		$crud->required_fields(
                        'equipment_name',
                        'order_id',
                        'vendor_id',
                        'vendor_type',
                        'rental_date',
                        'quantity',
                        'usage_hours',
                        'vendor_charges',
                        'rental_charges',
                        'description',
                        'customer_vat',
                        'vendor_vat_amount');
		
                $crud->display_as('client_id','Client Name')
                        ->display_as('order_id','Order Name')
                        ->display_as('vendor_id','Vendor Name')
                        ->display_as('rental_date','Acquiring Time')
                        ->display_as('rental_charges','Customer Charges')
                        ->display_as('customer_vat','Customer Vat %');
                
                $crud->field_type('vendor_type','dropdown',
				array( "callout"  => "callout","contract"  => "contract"));
               //$crud->unset_clone();
                
                $crud->columns(
                        're_id',
                        'equipment_name',
                        'order_id',
                        'vendor_id',
                        'vendor_type',
                        'rental_date',
                        'quantity',
                        'usage_hours',
                        'vendor_charges',
                        'vendor_vat_amount',
                        'description',
                        'rental_charges',
                        'customer_vat'
                       
                        );
                
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