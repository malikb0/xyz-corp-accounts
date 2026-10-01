<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Vat_invoice extends CI_Controller {

	public function __construct() {
	parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		$this->load->helper('url');
                
                $this->load->helper('date');

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
		
                    $this->load_invoice();
		
	}
	
		public function load_invoice(){
                   //check login status of user 
                   if(!isset($this->session->userdata['logged_in']))
                   {		$this->load->view('login_form');
                 
                   }else {
                   /* Set validation rule for name field in the form */
                     $this->form_validation->set_rules('order_id', 'Order-Name', 'required');
                   
                   $output['orders'] = $this->get_orders();
                   
                   
                   //check order number is null or not 
                   if ($this->form_validation->run() == FALSE) { 

                        $output['msg'] = "empty order number";
                        $this->load->view('vat_invoice_view', $output);
                        
                    }
                    else 
                    {
                                
                        // select order from database for given order number
                        $order_id = $this->input->post('order_id');
                        //$output['msg'] = $order_number;  
                        $this->db->select('*')
                             ->from('tb_orders')
                             ->where('order_id',$order_id);

                        $query = $this->db->get();
                                
                        //if found an order process against it or show empty result
                        if ($query->num_rows() > 0 )
                            {    
                                // retrive order from result
                                $order = $query->row();
                                $order->order_start_date = date_format(date_create($order->order_start_date), "d, M, Y");

                                $output['order']= $order;

                                // get client account detail against order number
                                $this->db->select('account_name ,'
                                        . 'arabic_name, address1 , '
                                        . 'address2,address3,address4, '
                                        . 'arabic_address,'
                                        . 'vat_reg_no');
                                $this->db->from('tb_accounts');
                                $this->db->where('account_id',$order->client_id);
                                $query = $this->db->get();


                                //retrive client account info from result
                                $account = $query->row();
                                $output['client']= $account;

                                if($order->order_type == "callout"){

                                    //get trips against order_id
                                    $this->db->select(
                                            "date_format(start_time,'%b-%d, %Y') as _date,"
                                            . "trip_description,"
                                            . "place_from,"
                                            . "place_to,"
                                            . "trip_charges,"
                                            . "delay_charges,"
                                            . "waiting_description,"
                                            . "customer_vat"
                                            );
                                    $this->db->from('tb_callout_trips');
                                    $this->db->where('order_id',$order->order_id);
                                    $this->db->order_by('start_time asc,trip_id asc');
                                    $query = $this->db->get();
                                    $output['trips'] = $query->result(); 

                                    //get equipments against order_id

                                    $this->db->select(''
                                            . 'date_format(rental_date,"%b-%d, %Y") as _date,'
                                            . 'description,'
                                            . 'rental_charges,'
                                            . 'customer_vat');
                                    $this->db->from('tb_rental_equipments');
                                    $this->db->where('order_id',$order->order_id);
                                    $this->db->order_by('rental_date','asc');
                                    $query = $this->db->get();
                                    $output['equipments'] = $query->result(); 

                                }
                                else 
                                { // order type not callout
                                    //get items against order_id
                                    $this->db->select('*');
                                    $this->db->from('tb_contract_items');
                                    $this->db->where('order_id',$order->order_id);
                                    $query = $this->db->get();
                                    $output['items'] = $query->result();
                                }
                        }
                        else{ // no order found case
                                       
                                $output['trips'] = null;
                                $output['equipments'] = null;
                                $output['items'] = null;
                            }
                            //$this->_example_output($output);
                            $this->load->view('vat_invoice_view', $output);
                            
                    }// end if order number null or not
                   }
                    
                }// end function load invoice
                
                private function get_orders(){
                    $this->db->select('order_id, order_name')
                                     ->from('tb_orders')
                                     ->where('order_complete', "no")
                                     ->where('year(order_start_date) >= ', 2018)
                                     ->order_by('order_name','asc');
                    
                    $query = $this->db->get();
                    if ($query->num_rows() > 0 )// check if salary exists
                        {
                            foreach ($query->result() as $row)
                                    {
                                            $orders[$row->order_id] = $row->order_name;
                                     
                                    }    
                        
                         return $orders;
                        }
                    }
}

?>