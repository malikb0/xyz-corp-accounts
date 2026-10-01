<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Trips extends CI_Controller {

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
		$this->load_trips();
		
	}
	
		public function load_trips(){
		
		if(!isset($this->session->userdata['logged_in']))
                    { 
                        $this->load->view('login_form');
                    }else {
                        
                        $crud = new grocery_CRUD();

                        $crud->set_model('Trips_crudModel');

                        //$crud->set_theme('datatables');
                        //$crud->set_theme('flexigrid');
                        $crud->set_theme('bootstrap');
                        $crud->set_table('tb_callout_trips');
                        $crud->set_subject('Trip');
                       // $crud->where("date_format(start_time, '%Y%m') > 201712 or date_format(start_time, '%Y%m') < 201506 ");
                        $crud->set_relation('order_id','tb_orders','{order_id} , {order_name}', 'order_complete = "no"');
                        $crud->set_relation('vendor_id','tb_accounts','account_name',array('account_type' => 'vendor'));
                        $crud->set_relation('driver_id','tb_accounts','account_name', 'account_type = "employee" or account_type = "driver_os"');
                        $crud->set_relation('vehicle_id','tb_accounts','account_name',array('account_type' => 'vehicle'));
                        $crud->set_relation('arbdes_id','tb_arbdescription','eng_description');


                        $crud->required_fields('order_id','vendor_id',
                                'driver_id','start_time','place_from',
                                'place_to','vendor_type','trip_charges',
                                'delay_charges','vendor_charges','trip_description','customer_vat','vendor_vat_amount','arbdes_id');

                        $crud->field_type('vendor_type','dropdown',
                                        array( "callout"  => "callout","contract"  => "contract"));
                        
                        $crud->set_field_upload('trip_docs','assets/uploads/files/trip-docs');

                        $crud->display_as('order_id','ID, Invoice Name')        
                               ->display_as('vendor_id','Vendor Name')
                               ->display_as('customer_vat','Customer Vat %')
                               ->display_as('driver_id','Driver Name')
                               ->display_as('start_time','Start Date')
                                ->display_as('end_time','End Date')
                                ->display_as('vehicle_id','Vehicle')
                                ->display_as('trip_description','Description')
                                ->display_as('arbdes_id', 'Arabic_Description');
                        //$crud->columns('order_id','place_from','place_to');
                       // $crud->unset_jquery();
                        
                        //$crud->unset_columns('waiting_charges');
                       $crud->columns(array('trip_id','order_id','vendor_id','vendor_type',
                                                'driver_id','vehicle_id','place_from','place_to',
                                                'start_time','end_time','trip_charges','delay_charges','customer_vat',
                                                'vendor_charges','vendor_vat_amount','traveling_distance_kms','trip_description','arbdes_id',
                                                 'waiting_description'));
                      // $crud->unset_clone();
                        
                        
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