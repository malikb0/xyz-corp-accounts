<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Vehicles_data extends CI_Controller {

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
		$this->load_vehicles();
		
	}
	
		public function load_vehicles(){
		
		if(!isset($this->session->userdata['logged_in']))
		{		$this->load->view('login_form');
                }else{
		$crud = new grocery_CRUD();
		
		$crud->set_model('vehicles_crudModel');
		
		//$crud->set_theme('datatables');
                //$crud->set_theme('flexigrid');
		$crud->set_theme('bootstrap');
                $crud->set_table('tb_vehicles');
		$crud->set_subject('Vehicle_Data');
	
                $crud->set_relation('account_id','tb_accounts','account_name',' account_type = "vehicle"  ');
		
                $crud->unique_fields(array('account_id'));
                
		$crud->set_field_upload('insurance_url','assets/uploads/files/insurance')
                        ->set_field_upload('fahas_url','assets/uploads/files/fahas')
                        ->set_field_upload('istamara_url','assets/uploads/files/istamara')
                        ->set_field_upload('sticker_url','assets/uploads/files/sticker')
                        ->set_field_upload('tafweez_url','assets/uploads/files/tafweez')
                        ->set_field_upload('mzn_card_url','assets/uploads/files/meezan-card')
                        ->set_field_upload('other_file','assets/uploads/files/other-vehicle-files');
                

		
                $crud->display_as('account_id','Vehicle Account Name')
                        ->display_as('mzn_card_expire','Meezan Card Expire')
                        ->display_as('insurance_url','Insurance Image')
                        
                        ->display_as('fahas_url','Fahas Image')
                        ->display_as('istamara_url','Istamara Image')
                        ->display_as('tafweez_url','Tafweez Image')
                        ->display_as('sticker_url','Sticker Image')
                        ->display_as('mzn_card_url','Meezan Card Image')
                        ->display_as('other_file','Other Image');
                
                $crud->required_fields('account_id');
                $crud->callback_before_update(array($this,'unset_accountname'));
                //$crud->unset_clone();
                        
                   
                //$crud->unset_jquery();
                $output = $crud->render();
		
		$this->load->view('output_page', $output);
                }
	}
        
        function unset_accountname($post_array, $primary_key) {
            unset($post_array['account_id']);
            return $post_array;
        }
        function _date($value, $row)
            {
            return "<span style='visibility:hidden;display:none;'>".date('Y-m-d', strtotime($value))."</span>".date('d/m/Y', strtotime($value));
            }
}

?>