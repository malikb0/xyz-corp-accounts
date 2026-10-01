<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Profits extends CI_Controller {

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
		$this->load_profits();
		
	}
	
		public function load_profits(){
		
		if (! isset($this->session->userdata['logged_in']))                {
                    $this->load->view('login_form');
                }else {
                
		
		$crud = new grocery_CRUD();
		
		$crud->set_model('Profits_crudModel');
		
		$crud->set_theme('datatables');
               //$crud->set_theme('flexigrid');
		$crud->set_table('tb_profits');
                $crud->set_subject('Profits');
                
		$crud->set_relation('account_id','tb_accounts','account_name', 'account_type = "owner" ');
		$crud->required_fields('account_id','dist_date','description','amount');
                
                //$crud->set_field_upload('fatora_url','assets/uploads/files/fatora');
                
                $crud->display_as('account_id','Account_Name')
                       // ->display_as('fatora_url','Fatora Copy')
                        ->display_as('dist_date','Distribution_Date');
        
                
                //$crud->order_by('exp_date','desc');
		$crud->callback_column('dist_date',array($this,'_date'));
                
                
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