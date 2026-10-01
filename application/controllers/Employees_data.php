<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Employees_data extends CI_Controller {

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
		$this->load_Employees();
		
	}
	
		public function load_Employees(){
		
		if (! isset($this->session->userdata['logged_in'])) {                   $this->load->view('login_form');
                   
                   }else {
		$crud = new grocery_CRUD();
		
		$crud->set_model('empdata_crudModel');
		
		//$crud->set_theme('datatables');
                //$crud->set_theme('flexigrid');
                $crud->set_theme('bootstrap');
		$crud->set_table('tb_employees');
		$crud->set_subject('Employee_Data');

                
		$crud->set_relation('account_id','tb_accounts','account_name',' account_type = "employee" ');
               
               
                //$crud->unset_clone();
                
                $crud->unique_fields(array('account_id'));
                        
		$crud->set_field_upload('emp_pic_url','assets/uploads/files/emp-pic')
                        ->set_field_upload('iqama_url','assets/uploads/files/iqama')
                        ->set_field_upload('license_url','assets/uploads/files/license')
                        ->set_field_upload('aramco_id_url','assets/uploads/files/aramco-id')
                        ->set_field_upload('passport_url','assets/uploads/files/passport')
                        ->set_field_upload('other_file','assets/uploads/files/other-employee-files');
                


		                
                $crud->display_as('account_id','Account Name')
                        ->display_as('emp_pic_url','Employee Picture')
                        ->display_as('iqama_url','Iqama Image')
                        ->display_as('license_url','License Image')
                        
                        ->display_as('aramco_id_url','Aramco ID Image')
                        ->display_as('passport_url','Passport Image')
                        ->display_as('other_file','Other Image');
                
                
                $crud->required_fields('account_id');
                $crud->callback_before_update(array($this,'unset_accountname'));
                
                
                
                //$crud->unset_jquery();
                $output = $crud->render();
		
                $this->load->view('output_page', $output);
                
                }
		
	}
        function unset_accountname($post_array, $primary_key) {
            unset($post_array['account_id']);
            unset($post_array['emp_group']);
            return $post_array;
        }
        function _date($value, $row)
            {
            return "<span style='visibility:hidden;display:none;'>".date('Y-m-d', strtotime($value))."</span>".date('d/m/Y', strtotime($value));
            }
}

?>