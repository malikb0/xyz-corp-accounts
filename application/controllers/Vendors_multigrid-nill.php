<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Vendors_multigrid extends CI_Controller {

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
		$this->multigrids();
		
	}
        
        public function _example_output($output = null){
		$this->load->view('output_page.php',$output);
	}
	

        
        function unset_vendor($post_array, $primary_key) {
            unset($post_array['vendor_id']);
            return $post_array;
        }
        
        function multigrids(){
                if(!isset($this->session->userdata['logged_in']))
             {		$this->load->view('login_form');
             }else{
		$this->config->load('grocery_crud');
                //$this->config->set_item('csrf_regenerate',FALSE);
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->vendor_contracts2();

		$output2 = $this->vendor_items();

		//$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files ;// + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files;// + $output3->css_files;
		$output = "<h1>Vendor Contracts</h1>".$output1->output ."<h1>Contract Items</h1>".$output2->output;//."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
             }
	} // end of multigrids function 
        
        public function vendor_contracts2(){
            if(!isset($this->session->userdata['logged_in']))
				$this->load->view('login_form');
		
            
              
		$crud = new grocery_CRUD();
		
		
		
		$crud->set_theme('datatables');
                //$crud->set_theme('flexigrid');
		$crud->set_table('tb_vendor_contracts');
                $crud->set_subject('Contract');
                
                $crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));
                
		$crud->set_relation('vendor_id','tb_accounts','account_name',array( "account_type"  => "vendor"));
		$crud->required_fields('contract_name','vendor_id','contract_start_date','contract_complete','contract_description');
                $crud->display_as('vendor_id','Vendor Name')
                        ->display_as('contract_start_date','Contract Date');
                
                
                
		
                
                
                $crud->callback_before_update(array($this,'unset_vendor'));
                
                
                
                //$crud->unset_jquery();
                $output = $crud->render();
                
                
                if($crud->getState() != 'list'){
                    
                    $this->_example_output($output);
                }
                else {
		return $output;
                }
            
        }
        
        public function vendor_items(){
            if(!isset($this->session->userdata['logged_in']))
				$this->load->view('login_form');
		
            
                
		$crud = new grocery_CRUD();
		
		$crud->set_model('vendoritems_crudModel');
		
		$crud->set_theme('datatables');
                //$crud->set_theme('flexigrid');
		$crud->set_table('tb_vendor_items');
                $crud->set_subject('Item');
                
		$crud->set_relation('contract_id','tb_vendor_contracts','contract_name',array( "contract_complete"  => "no"));
		$crud->required_fields('contract_name','item_date','drivers','quantity','description','item_amount','item_vat_amount');
                $crud->display_as('contract_name','Contract Name');
                
                
                
		
                
                
                
                
                $crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));
               // $crud->unset_clone();
                
                //$crud->unset_jquery();
                $output = $crud->render();
		
                if($crud->getState() != 'list'){
                    
                    $this->_example_output($output);
                }
                else {
		return $output;
                }
            
        }
        
}

?>