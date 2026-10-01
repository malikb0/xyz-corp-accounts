<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Owner_transactions
 *
 * @author Muhammad Awais
 */

if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
class Owner_transactions extends CI_Controller {

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
		$this->load_transactions();
		
	}
	
		public function load_transactions(){
		
		if (! isset($this->session->userdata['logged_in'])) {
			$this->load->view('login_form');
                   
                   }else {
                
                   
		$crud = new grocery_CRUD();
		
		$crud->set_model('Transactions_crudModel');
		
		$crud->set_theme('datatables');
                //$crud->set_theme('flexigrid');
		$crud->set_table('tb_transactions');
		$crud->set_subject('Transaction');
		$crud->set_relation('account_from','tb_accounts','account_name',
                                    "account_type = 'owner' "
                                  . "or account_type = 'bank'"
                                  . "or account_type = 'cash_inhand'");
		$crud->set_relation('account_to','tb_accounts','account_name',
                                    "account_type = 'owner'"
                                  . "or account_type = 'bank'"
                                  . "or account_type = 'cash_inhand'");
		$crud->where("(account_from in (select account_id from tb_accounts where account_type in ('bank', 'cash_inhand') )"
                        . "and account_to in (select account_id from tb_accounts where account_type = 'owner'))"
                        . "or"
                        . "(account_from in (select account_id from tb_accounts where account_type = 'owner' )"
                        . "and account_to in (select account_id from tb_accounts where account_type in ('bank', 'cash_inhand')))");
		$crud->required_fields('cash_amount','account_to','account_from','transaction_date');
		$crud->display_as('reference_url','Transaction Reference');
        
                
                $crud->set_field_upload('reference_url','assets/uploads/files/transaction-references');
                $crud->callback_column('transaction_date',array($this,'_date'));
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
