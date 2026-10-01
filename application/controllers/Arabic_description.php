<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Arabic_description extends CI_Controller {

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
		$this->arb_des();
		
	}
	
		public function arb_des(){
		
			if(!isset($this->session->userdata['logged_in'])){
				$this->load->view('login_form');
                        }
                        else {
			$crud = new grocery_CRUD();
			
			//$crud->set_theme('datatables');
                       $crud->set_theme('bootstrap');
			$crud->set_table('tb_arbdescription');
			
			$crud->set_subject('Arabic Descriptions');

			//$crud->unset_clone();
                        
                        
                       
                        
                        
                        
			//$crud->unset_jquery();
                        $output = $crud->render();
                        $output->output = "<h1>Arabic Descriptions</h1>".$output->output;
			//$this->_example_output($output);
			$this->load->view('output_page', $output);
	
                        }
        }
}

?>