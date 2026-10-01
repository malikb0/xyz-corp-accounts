<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Get_report extends CI_Controller {

	public function __construct() {
	parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		$this->load->helper('url');

		// Load form validation library
		$this->load->library('form_validation');
                
                // laod table library 
                $this->load->library('table');
                
                
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
		$this->load_Report();
		
	}
	
		public function load_Report($report_type = null,$duration = null){
		
			
			
                        //check login status of user 
                   if (! isset($this->session->userdata['logged_in'])) {
                       
                       
                       $this->load->view('login_form');
                   
                   }else {
                   
                   
                     
                   
                                
                   
                   /* Set validation rule for name field in the form */
                     $this->form_validation->set_rules('account_id', 'Name', 'required|numeric');
                     
                     //$this->form_validation->set_rules('report_month', 'Month', 'required|numeric'); 
                     //$this->form_validation->set_rules('report_year', 'Year', 'required|numeric'); 
                     
                     $this->form_validation->set_rules('from_date', "date_from", 'required');
                     $this->form_validation->set_rules('to_date', "date_to", 'required');
                     
                     
                     $output['report_type'] = $report_type;
                     
                     
                     // get form accounts according to report type
                     $output['accounts'] = $this->get_accounts($report_type);
                     //$output['report_form'] = $this->get_report_form($report_type);
                     $output['report_form'] = $this->get_duration_form($report_type);
                     
                     $date_from = DateTime::createFromFormat('d/m/Y', '14/06/1996');
                     $date_from = date_create_from_format('d/m/Y', ''.$this->input->post('from_date'));
                     $date_to = DateTime::createFromFormat('d/m/Y', '14/06/1996');
                     $date_to = date_create_from_format('d/m/Y', ''.$this->input->post('to_date'));
                     
                    
                     
                     if ($this->form_validation->run() == FALSE || $date_from == false || $date_to == false) { 
                      $output['msg'] = "empty  name";   
                      
                      switch ($report_type) {
                                        case "accounts_payable":
                                            $this->total_dc_report($output,"account_balance < 0 ","Payable");
                                            break;
                                        case "accounts_receiveable":
                                            $this->total_dc_report($output,"account_balance > 0 ","Receiveable");
                                            break;
                                        default:
                                            $this->load->view('report_view',$output);
                                    } 
                     
                     } 
                     else { 
			
                               if (!isset($report_type)) {
                                   $output['msg'] = "No Report Type"; 
                                   $this->load->view('report_view',$output);
                               }
                            switch ($report_type) {
                                        case "vendor_trips":
                                            $this->vendor_trips_report($output,$date_from,$date_to);
                                            break;
                                        case "vendor_trips_during":
                                            break;
                                        case "vendor_trips_invoices_during":
                                            break;
                                        case "vendor_equipments":
                                            $this->vendor_equipments_report($output,$date_from,$date_to);
                                            break;
                                        case "accounts_payable":
                                            $this->total_dc_report($output,"account_balance < 0 ","Payable");
                                            break;
                                        case "accounts_receiveable":
                                            $this->total_dc_report($output,"account_balance > 0 ","Receiveable");
                                            break;
                                        case "invoices_of_duration":
                                            $this->get_invoices($output,$date_from,$date_to);
                                            break;
                                        case "vendor_contracts":
                                            $this->vendor_contracts($output,$date_from,$date_to);
                                            break;
                                           
                                        case "expenses_sheet_of_duration":
                                            $this->show_expenses_sheet($output, $date_from, $date_to);
                                            break;
                                        case "general_expenses":
                                            $this->general_expenses_report($output,$date_from,$date_to,"expense","General");
                                            break;
                                        case "office_expenses":
                                            $this->general_expenses_report($output,$date_from,$date_to,"office_expense", "Office");
                                            break;
                                        case "vehicle_expenses":
                                            $this->vehicle_expenses_report($output,$date_from,$date_to);
                                            break;
                                        case "monthly_transactions":
                                            $this->transactions_report($output,$date_from,$date_to);
                                            break;
                                        case "income_statement";
                                            $this->show_income_statement($output, $date_from, $date_to);
                                            break;
                                        default:
                                            $this->vendor_trips_report($output,$date_from,$date_to);
                                    }  
                         
                       
                        // 
                     }
                     
                   }
                     
	}// end of function load report 
        
        
     
        ////////////////////////////////////////////////////////////////////////
        
        ///////////////////////////////////////////////////////////////////////
         //                Forms For Reports
         ///////////////////////////////////////////////////////////////////////
        
        private function get_report_form($report_type){
           $url = base_url('index.php/Get_report/load_report/'.$report_type); 
           $accounts = $this->get_accounts($report_type);
           
           $years = range(2014, date("Y"));
             foreach ($years as $year) {
                    $year_list[$year] = $year;
                }
           
           $form = form_open($url)
                   
                   .form_label("Name",'account_id'). "<br>"
                   .form_dropdown('account_id', isset($accounts) ? $accounts : ''). "<br>". "<br>"
                   .form_label("Month :",'report_month'). "<br>"

                   .form_dropdown('report_month',array(
                                                '01' => 'January',
                                                '02' => 'February',
                                                '03' => 'March',
                                                '04' => 'April',
                                                '05' => 'May',
                                                '06' => 'June',
                                                '07' => 'July',
                                                '08' => 'August',
                                                '09' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December'),date("m")
                                                  ) . "<br>". "<br>"
                   . form_label("Year :",'report_year'). "<br>"
                   . form_dropdown('report_year', $year_list , date("Y")). "<br>". "<br>"             
                   . form_submit('submit','Get Report','class="btn btn-block btn-success"')
                   . form_close();
                                 return $form;
            
        }
        
        private function get_duration_form($report_type){
            $url = base_url('index.php/Get_report/load_report/'.$report_type); 
           $accounts = $this->get_accounts($report_type);
           
           $years = range(2014, date("Y"));
             foreach ($years as $year) {
                    $year_list[$year] = $year;
                }
                                        
           $form = 
                   form_open($url,'id = "report_form"')
                   .form_label("Name",'account_id'). "<br>"
                   .form_dropdown('account_id', isset($accounts) ? $accounts : ''). "<br>". "<br>"
                   ."<p>".form_label("Date From",'from_date'). "<br>" 
                   . form_input('from_date','', 'class = "dpDate" id = "date_from" name = "date_from"') ."</p><br>"
                   .form_label("Date To",'to_date'). "<br><p>" 
                   . form_input('to_date','','class = "dpDate" id = "date_to" name = "date_to" ') ."</p><br>". "<br>"             
                   . form_submit('submit','Get Report','class="btn btn-block btn-success"')
                   . form_close();
                                 return $form;
        }
        
        ////////////////////////////////////////////////////////////////////////
        
        ///////////////////////////////////////////////////////////////////////
         //                Report Form Parameters
         ///////////////////////////////////////////////////////////////////////
         
         
         
         private function get_accounts($report_type){
                    if (!isset($report_type)) 
                        return null;
                    
                    switch ($report_type) {
                        
                                case "vendor_trips":
                                    $account_type = "vendor";
                                    $accounts[0] = "All";
                                    $where = "account_type = ' ' )";
                                    break;
                                case "vendor_equipments":
                                    $account_type = "vendor";
                                    $accounts[0] = "All";
                                    $where = "account_type = ' ' )";
                                    
                                    break;
                                case "vendor_contracts":
                                    $account_type = "vendor";
                                    $where = "account_type = ' ' )";
                                    break;
                               // case "vehicle_expenses" ;
                                //    $account_type = "vehicle";
                                 //   $where = " account_type = ' ' ) and account_id in(select account_id from tb_vehicles) ";
                                 //   break;
                                case "monthly_transactions":
                                    $account_type = " ";
                                    $where = '1 = 1 )';
                                    break;
                                    
                                default:
                                    return NULL;
                            }
                            
                    
                    $this->db->select('account_id, account_name')
                                     ->from('tb_accounts')
                                     ->where(" ( account_type = '". $account_type ."' " )
                                     ->or_where($where)
                                     ->order_by('account_name','asc');
                    
                    $query = $this->db->get();
                    if ($query->num_rows() > 0 )// check if salary exists
                        {
                            
                            foreach ($query->result() as $row)
                                    {
                                            $accounts[$row->account_id] = $row->account_name;
                                            
                                    }    
                        
                         return $accounts;
                        }
                    }// end of get accounts function 
                    
                    
         
         ///////////////////////////////////////////////////////////////////////
        
        ///////////////////////////////////////////////////////////////////////
         //                Vendor Trips Report for given month 
         ///////////////////////////////////////////////////////////////////////
        
        
                    
         private function vendor_trips_report($output,$date_from,$date_to){
             
                        $account_id = $this->input->post('account_id');
                       
                        if($account_id == 0){
                            $case_all = TRUE;
                            
                        }else{
                            
                            $case_all = FALSE;
                        }
                        
                        $from_date = $date_from->format('Y-m-d');
                        $to_date = $date_to->format('Y-m-d');
                        
                        $this->db->select('account_id, account_name, account_balance')
                                     ->from('tb_accounts')
                                     ->where("account_id = '".$account_id."' ");
                         
                                
                                $query = $this->db->get();
                                
                                //check vendor exists
                                if ($query->num_rows() > 0 || $case_all === TRUE)
                                    {    
                                        // retrive order from result
                                        if(!($case_all === TRUE)){
                                        $account = $query->row();
                                        $account_id = $account->account_id;
                                        $output['report_heading'] = "Statement of Mr.".$account->account_name . ", For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
                                        $output['account_name'] = $account->account_name;
                                        $output['account_balance'] = $account->account_balance;
                                        $inwhere = "(vendor_id = ".$account_id ." and vendor_type = 'callout')";
                                        }else {
                                            $output['report_heading'] = "Statement of All Trips (with vendor charges)<br> For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
                                            $inwhere = "1 = 1";
                                            
                                        }
                                        
                                        
                                        $query = $this->db->query("Select trip_id as TripID, DATE_FORMAT(start_time, '%d/%b/%Y') as Date,account_name as 'Driver Name', place_from  as 'From' , place_to as 'To',vendor_charges as 'Amount SAR' "
                                                . "FROM tb_callout_trips "
                                                . "left join tb_accounts on driver_id = account_id "
                                                . "where  ". $inwhere ." and  (start_time  BETWEEN '". $from_date . "'  AND '". $to_date ." 23:59:59')"
                                                . "order by start_time asc" );
                                        
                                        $template = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        
                                        $output['table'] = $this->table->generate($query);
                                       
                                        
                                        
                                        $this->db->select_sum('vendor_charges','Total_Amount')
                                                    ->from('tb_callout_trips')
                                                    ->where($inwhere)
                                                    ->where("(start_time  BETWEEN '". $from_date . "'  AND '". $to_date ." 23:59:59')");
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $output['total_amount'] = $query->row()->Total_Amount;
                                            }  
                                        
                                        
                                        $this->load->view('report_view',$output);  
                                        
                                        
                                        
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Account Not Found";
             
                                      $this->load->view('report_view',$output);  
                                    }
             
         } // end of  vendor trips report function 
        
         
         ///////////////////////////////////////////////////////////////////////
         
         
         
         
         ///////////////////////////////////////////////////////////////////////
         //                Vendor Equipments Report for given month 
         ///////////////////////////////////////////////////////////////////////
         
         private function vendor_equipments_report($output,$date_from,$date_to){
             
             $account_id = $this->input->post('account_id');
                        //$report_month = $this->input->post('report_month');
                       // $report_year = $this->input->post('report_year');
             
                       if($account_id == 0){
                            $case_all = TRUE;
                            
                        }else{
                            
                            $case_all = FALSE;
                        }
                        
                        $from_date = $date_from->format('Y-m-d');
                        $to_date = $date_to->format('Y-m-d');
                        
                        $this->db->select('account_id, account_name, account_balance')
                                     ->from('tb_accounts')
                                     ->where("account_id = '".$account_id."' ");
                         
                                
                                $query = $this->db->get();
                                
                                //check employee exists
                                if ($query->num_rows() > 0 || $case_all === TRUE)
                                    {  
                                    
                                        if(!($case_all === TRUE)){
                                        // retrive order from result
                                        $account = $query->row();
                                        $account_id = $account->account_id;
                                        $output['report_heading'] = "Statement of Mr.".$account->account_name . ", For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
                                        $output['account_name'] = $account->account_name;
                                        $output['account_balance'] = $account->account_balance;
                                        $inwhere = "vendor_id = ".$account_id;
                                        }
                                        else 
                                        {
                                            $output['report_heading'] = "Statement of All Equipments, For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
                                            $inwhere = "1 = 1";
                                        }
                                        
                                        
                                        $query = $this->db->query("SELECT DATE_FORMAT(rental_date, '%d/%b/%Y') as Date ,equipment_name as 'Equipment Name',quantity as Quantity,usage_hours as 'Usage Hours',vendor_charges as 'Amount SAR' "
                                                . "FROM tb_rental_equipments "
                                                . "where  ". $inwhere ." and  (rental_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')"
                                                . "order by rental_date asc" );
                                        
                                        $template = array(
                                                    'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        
                                        $this->db->select_sum('vendor_charges','Total_Amount')
                                                    ->from('tb_rental_equipments')
                                                    ->where($inwhere)
                                                    ->where("(rental_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')")
                                                    ->order_by('','');
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $output['total_amount'] = $query->row()->Total_Amount;
                                            }  
                                        
                                        
                                        $this->load->view('report_view',$output);  
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Account Not Found";
             
                                      $this->load->view('report_view',$output);  
                                    }
             
         }// end of vendor equipments report 
         
         ///////////////////////////////////////////////////////////////////////
         
         
        
   
        
        
         
         
     
        
         
         
         ///////////////////////////////////////////////////////////////////////
         //                General Expenses Report for given month 
         ///////////////////////////////////////////////////////////////////////
                    
         private function general_expenses_report($output,$date_from,$date_to,$category,$type){
             
                //$report_month = $this->input->post('report_month');
                //$report_year = $this->input->post('report_year');
                $from_date = $date_from->format('Y-m-d');
                $to_date = $date_to->format('Y-m-d');
                
                $heading =  $type . " Expenses Report For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
                $where = "(exp_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')";
                $output['report_heading'] = $heading ;
               $expenses =  $this->get_general_expenses($output, $where,$category," ");
               $this->load->view('report_view',$expenses); 
            }
        

         private function get_general_expenses($output,$where,$category,$caption){
                                     $output['total_amount'] = 0;
             $this->db->select('DATE_FORMAT(exp_date, "%d/%b/%Y") as "Date",account_name as "Expense", description as Description, amount as Amount')
                                     ->from('tb_expenses as xp')
                                     ->join('tb_accounts as ac','ac.account_id = xp.account_id')
                                     ->where("account_type = '". $category ."' and ".$where)
                                     ->order_by('exp_date','asc');
                         
                                
                                $query = $this->db->get();
                                
                              
                                if ($query->num_rows() > 0 )
                                    {  
                                    
                                     
                                        
                                        
                                        $template = array(
                                                    'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        $this->table->set_caption($caption);
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        
                                      foreach ($query->result() as $row){  
                                        $output['total_amount'] += $row->Amount;
                                      }
                                        
                                        
                                        //$this->load->view('report_view',$output);
                                            return $output;
                                    }
                                    else 
                                    {
                                        
                                     
                                      $output['report_heading'] = "Nothing Found";
                                      return $output;
                                      //$this->load->view('report_view',$output);  
                                    }
         }// end of get general expenses
         
         ///////////////////////////////////////////////////////////////////////
         
         
         
         ///////////////////////////////////////////////////////////////////////
         //                Vehicle Expenses Report for given month 
         ///////////////////////////////////////////////////////////////////////
         
         private function vehicle_expenses_report($output,$date_from,$date_to){
                
                
             
                //$report_month = $this->input->post('report_month');
                //$report_year = $this->input->post('report_year');
             
                $from_date = $date_from->format('Y-m-d');
                $to_date = $date_to->format('Y-m-d');
                
                
                
                $heading = "Vehicle Expenses Report For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
               
                $output['report_heading'] = $heading ;
                $where = "(exp_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')";
                
                $this->db->select('vh.account_id as "vehicle_id",account_name')
                                     ->from('tb_vehicles as vh')
                                     ->join('tb_accounts as ac','ac.account_id = vh.account_id','left')
                                     ->join('tb_expenses as xp','xp.account_id = vh.account_id','left')
                                     ->where(" ".$where)
                                     ->group_by("account_name");
                         
                                
                                $query = $this->db->get();
                                
                                //check employee exists
            if ($query->num_rows() > 0 )
                { 
                        $i = 0;
                        foreach ($query->result() as $row){
                            
                            $where1 = "xp.account_id = ". $row->vehicle_id . " and  ".$where ;
                            $expense = $this->get_vehicle_expenses($where1, $row->account_name);

                            $output['tables']['table'.$i][''.$expense['total_amount']] = $expense['table'];
                            $i++;
                            
                        } // end of for each contract 
                          $i = 0;
                        $this->db->select_sum('amount','Total_Amount')
                                                    ->from('tb_expenses as xp')
                                                    ->join('tb_vehicles as vc','vc.account_id = xp.account_id')
                                                    ->where(" ".$where);
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $output['total_amount'] = abs($query->row()->Total_Amount);
                                            }    
                       $this->load->view('report_view',$output);
                       //$output['table'] = $expense['table'];
                      // $output['total_amount'] = $expense['total_amount'];
               
               
                }
               
               else
                   
               {
                    $output['report_heading'] = "Nothing Found";
                    $this->load->view('report_view',$output);
               }
               
                
            }
            
         
         private function get_vehicle_expenses($where,$vehicle){
             
             
             $this->db->select('DATE_FORMAT(exp_date, "%d/%b/%Y") as "Date", description as Description, amount as Amount')
                                     ->from('tb_expenses as xp')
                                     ->join('tb_accounts as ac','ac.account_id = xp.account_id')
                                     ->where(" ".$where)
                                     ->order_by('exp_date','asc');
                         
                                
                                $query = $this->db->get();
                                
                              
                                if ($query->num_rows() > 0 )
                                    {  
                                    
                                     
                                        
                                        
                                        $template = array(
                                                    'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">'
                                                    
                                            );

                                            $this->table->set_template($template);
                                            
                                            $this->table->set_caption(strtoupper($vehicle));
                                        
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        $output['total_amount'] = 0;
                                      foreach ($query->result() as $row){  
                                        $output['total_amount'] += $row->Amount;
                                      }
                                        
                                        
                                        return $output; 
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Nothing Found";
             
                                      //$this->load->view('report_view',$output);
                                      return null;
                                    }
             
         }
         
         ///////////////////////////////////////////////////////////////////////
         
         
 
            
         
      
         
         ///////////////////////////////////////////////////////////////////////
         
         
         ///////////////////////////////////////////////////////////////////////
         //                invoices Report for given duration 
         ///////////////////////////////////////////////////////////////////////
         
         private function get_invoices($output,$date_from,$date_to){
             
             
           $invoices =  $this->get_invoice_for($output,$date_from,$date_to);
           $this->load->view('report_view',$invoices); 
                                    
             
         }
         
         private function get_invoice_for($output,$date_from,$date_to){
             
             $from_date = $date_from->format('Y-m-d');
             $to_date = $date_to->format('Y-m-d');
             
            $output['report_heading'] = "<b> Invoicing Report For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
             $where = "order_start_date  BETWEEN '". $from_date . "' AND '". $to_date ."'" ;
             
             
             
             $this->db->select('DATE_FORMAT(order_start_date, "%d/%b/%Y") as "Date",'
                                    .' order_name as "Invoice Number", '
                                    .'po_number as "PO Number",'
                                    .'ac.account_name as "Company",'
                                    .'(IFNULL(callout_amount,0) + '
                                    . 'IFNULL(rental_amount,0) + '
                                    . 'IFNULL(sum(amount), 0)) as "Amount SAR"')
                     
                                     ->from('tb_orders as odr')
                                     ->join('tb_accounts as ac','ac.account_id = odr.client_id')
                                     ->join('(
                                                select 
                                                        drived_trips.order_id as callout_id, 
                                                        (IFNULL(trip_total,0) + IFNULL(rental_total,0)) as callout_amount 
                                                from
                                                        (
                                                            select 
                                                                    order_id , 
                                                                    sum(trip_charges + delay_charges) as trip_total 
                                                            from tb_callout_trips
                                                            GROUP by order_id
                                                        ) 
                                                as drived_trips
                                                left OUTER join (
                                                                    select 
                                                                            order_id, 
                                                                            sum(rental_charges) as rental_total 
                                                                    from 
                                                                            tb_rental_equipments 

                                                                    GROUP by order_id
                                                                 ) 
                                                as drived_rental 
                                                on drived_rental.order_id = drived_trips.order_id
                                                GROUP by drived_trips.order_id
                                                ) 
                                                 as callout','callout.callout_id = odr.order_id','left')
                     
                                     ->join('(
                                                select 
                                                        rntls1.order_id rental_id, 
                                                        sum(rental_charges) as rental_amount 
                                                from 
                                                        tb_rental_equipments 
                                                as rntls1 
                                                where rntls1.order_id not in(
                                                                                select 
                                                                                        order_id 
                                                                                from tb_callout_trips
                                                                            ) 
                                                GROUP by rntls1.order_id 
                                            ) as callout_rental'
                                             ,'callout_rental.rental_id = odr.order_id','left')
                     
                                     ->join('tb_contract_items as ctr','ctr.order_id = odr.order_id','left')
                                     ->where($where)
                                     ->group_by('odr.order_id')
                                     ->order_by('order_start_date','asc')
                                     ->order_by('order_name','asc');
                         
                                
                                $query = $this->db->get();
                                
                              
                                if ($query->num_rows() > 0 )
                                    {  
                                    
                                     
                                        
                                        
                                        $template = array(
                                                    'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        $output['total_amount'] = 0;
                                      foreach ($query->result() as $row){  
                                        $output['total_amount'] += $row->{'Amount SAR'};
                                      }
                                        
//                                        $output['total_amount'] = 0;
//                                        foreach ($query->result_array() as $row)
//                                                {
//                                                        
//                                                        $output['total_amount'] += $row['Amount SAR'];
//                                                }
                                        
                                        return $output ;
                                         
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Nothing Found";
                                      return $output;
                                      
                                    }
         }




         ///////////////////////////////////////////////////////////////////////
         
         
         ///////////////////////////////////////////////////////////////////////
         //                Expenses Sheet for given duration 
         ///////////////////////////////////////////////////////////////////////
         
         private function show_expenses_sheet($output,$date_from,$date_to){
             $expenses_sheet = $this->get_expenses_sheet($output, $date_from, $date_to);
             $this->load->view('report_view',$expenses_sheet);
         }
         
         private function get_expenses_sheet($output,$date_from,$date_to){
             
              //$report_month = $this->input->post('report_month');
                //$report_year = $this->input->post('report_year');
             
                $from_date = $date_from->format('Y-m-d');
                $to_date = $date_to->format('Y-m-d');
                
                $expense['abc'] = "abc"; // defined because passing it just as empty parameter in function calling                
                $heading = "Expenses Report For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
               
                $output['report_heading'] = $heading ;
                $where = "(exp_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')";
                
                
          // vehicle expenses calculation       
                
                $this->db->select('vh.account_id as "vehicle_id",account_name')
                                     ->from('tb_vehicles as vh')
                                     ->join('tb_accounts as ac','ac.account_id = vh.account_id','left')
                                     ->join('tb_expenses as xp','xp.account_id = vh.account_id','left')
                                     ->where(" ".$where)
                                     ->group_by("account_name");
                         
                                
                                $query = $this->db->get();
                                
                                //check vehicle expense exist or not 
            if ($query->num_rows() > 0 ) // vehicle Expense block
                { 
                        $i = 0;
                        foreach ($query->result() as $row){ 
                            
                            $where1 = "xp.account_id = ". $row->vehicle_id . " and  ".$where ;
                            $expense = $this->get_vehicle_expenses($where1, $row->account_name);

                            $output['tables']['table'.$i][''.$expense['total_amount']] = $expense['table'];
                          $i++;
                            
                        } // end of for each contract 
                
                        $this->db->select_sum('amount','Total_Amount')
                                                    ->from('tb_expenses as xp')
                                                    ->join('tb_vehicles as vc','vc.account_id = xp.account_id')
                                                    ->where(" ".$where);
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $vehicle_expense_total = abs($query->row()->Total_Amount);
                                            }
                                            else 
                                            {
                                                $vehicle_expense_total = 0;
                                            }
                                          
                       
                       //$output['table'] = $expense['table'];
                      // $output['total_amount'] = $expense['total_amount'];
               
               
                }else 
                {
                   $vehicle_expense_total = 0; 
                }
               
                
                
    //                  office expenses calculations...
                
               $where = "(exp_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')";
               
               
               $abc = ["report_heading" => "January"]; // just  passed incase as empty parameter 
                            

               $expenses =  $this->get_general_expenses($abc, $where,"office_expense","OFFICE EXPENSES");
               
               if (array_key_exists("table",$expenses) && array_key_exists("total_amount",$expenses)  )
                      {
                           
                            $output['tables']['table'][''.$expenses['total_amount']] = $expenses['table']; 
                            $office_expenses_total = $expenses['total_amount'];
                          }
                          else {
                              $office_expenses_total = 0;
                          }
                 
    //                    general expenses calculations...                      
                          
                $expenses =  $this->get_general_expenses($abc, $where,"expense","GENERAL EXPENSES");
               
               if (array_key_exists("table",$expenses) && array_key_exists("total_amount",$expenses)  )
                      {
                           
                            $output['tables']['table'][''.$expenses['total_amount']] = $expenses['table']; 
                            $general_expenses_total = $expenses['total_amount'];
                          }
                          else {
                              $general_expenses_total = 0;
                          }   
                          
    //                    Callout vendor trips calculations 
                          
                $where = "(start_time  BETWEEN '". $from_date . "'  AND '". $to_date ." 23:59:59')";
                $this->db->select_sum('vendor_charges','Total_Amount')
                                                    ->from('tb_callout_trips')
                                                    
                                                    ->where("vendor_type = 'callout' and ".$where);
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $callout_vendor_trips_total = abs($query->row()->Total_Amount);
                                            }
                                            else 
                                            {
                                                $callout_vendor_trips_total = 0;
                                            }
                                            
  //                             callout rental equipment expenses calculations
                                            
                                            
                 $where = "(rental_date  BETWEEN '". $from_date . "'  AND '". $to_date ." 23:59:59')";
                 $this->db->select_sum('vendor_charges','Total_Amount')
                                                    ->from('tb_rental_equipments')
                                                    
                                                    ->where("vendor_type = 'callout' and ".$where);
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $callout_vendor_equipments_total = abs($query->row()->Total_Amount);
                                            }
                                            else 
                                            {
                                                $callout_vendor_equipments_total = 0;
                                            }
                                            
     //                 contract vendor items calculation mean outsource contract expenses
                                            
                $where = "(item_date  BETWEEN '". $from_date . "'  AND '". $to_date ." 23:59:59')";
                 $this->db->select_sum('amount','Total_Amount')
                                                    ->from('tb_vendor_items')
                                                    
                                                    ->where(" ".$where);
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $vendor_items_total = abs($query->row()->Total_Amount);
                                            }
                                            else 
                                            {
                                                $vendor_items_total = 0;
                                            }
                                            
    //                Salary Expense Calculation
                                            
                $where = ""
                        . "month(_date) >= " . $date_from->format('m') . " AND "
                        . "month(_date) <= " . $date_to->format('m') . " AND    "
                        . "year(_date) >= " . $date_from->format('Y') . " AND   "
                        . "year(_date) <= " . $date_to->format('Y');
                 $this->db->select_sum('net_salary','Total_Amount')
                                                    ->from('tb_salaries1')
                                                    
                                                    ->where(" ".$where);
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $payroll_total = abs($query->row()->Total_Amount);
                                            }
                                            else 
                                            {
                                                $payroll_total = 0;
                                            }
                                            
                
                                            
                                            
                                            
                $this->table->set_caption("OPERATIONAL EXPENSES DURING " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y'));
                $this->table->set_heading(array('EXPENSE CATEGORY', 'AMOUNT'));

                $this->table->add_row(array( 'CALLOUT VENDOR VEHICLES', $callout_vendor_trips_total));
                $this->table->add_row(array( 'CALLOUT VENDOR EQUIPMENTS', $callout_vendor_equipments_total));
                $this->table->add_row(array( 'VENDOR CONTRACTS', $vendor_items_total));
                $this->table->add_row(array( 'PAYROLL', $payroll_total));
                //$this->table->add_row(array('Red', 'Large'));
                //$this->table->add_row(array('Green', 'Medium'));

                $expenses['table'] =  $this->table->generate();
                $expenses['total_amount'] = $callout_vendor_trips_total + $callout_vendor_equipments_total + $vendor_items_total + $payroll_total;
                $output['tables']['table'][''.$expenses['total_amount']] = $expenses['table'];
                
                
                $output['total_amount'] = ($vehicle_expense_total) + 
                        ($office_expenses_total) + ($general_expenses_total) + 
                        ($callout_vendor_trips_total) + ($callout_vendor_equipments_total) + ($vendor_items_total) + ($payroll_total);  
              
                
                return $output;
             
         }
         
         ///////////////////////////////////////////////////////////////////////
         
         
         ///////////////////////////////////////////////////////////////////////
         //                vendor contract report for given duration 
         ///////////////////////////////////////////////////////////////////////
         
         private function vendor_contracts($output,$date_from,$date_to){
             
                $report_account = $this->input->post('account_id');
                $from_date = $date_from->format('Y-m-d');
                $to_date = $date_to->format('Y-m-d');
                
                
                $this->db->select('account_id, account_name, account_balance')
                                     ->from('tb_accounts')
                                     ->where("account_id = '".$report_account."' ");
                         
                                
                                $query = $this->db->get();
                                
                                //check employee exists
                                if ($query->num_rows() > 0 )
                                    {    
                                        // retrive order from result
                                        $account = $query->row();
                                        
                                        $output['report_heading'] = "<b> Contract Report of  ".strtoupper($account->account_name)."</b><br><br> For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
                                        $output['account_balance'] = $account->account_balance;
                                       $where = "(vendor_id = ".$report_account." ) and  (contract_start_date  BETWEEN '". $from_date . "' AND '". $to_date ."')" ;
                                        $this->db->select('contract_start_date,vc.contract_id')
                                                ->from('tb_vendor_contracts as vc')
                                                ->join('tb_vendor_items as vi','vi.contract_id = vc.contract_id','right')
                                                ->where($where)
                                                ->group_by('vc.contract_id')
                                                ->order_by('contract_start_date');
                                        
                                        
                                        $query = $this->db->get();
                                
                              
                                        if ($query->num_rows() > 0 )
                                            {  
                                                $i = 0;
                                                foreach ($query->result() as $row){
                                                    
                                                    $where = "(vc.contract_id = ". $row->contract_id ." ) " ;
                                                    $contract = $this->get_vendor_contracts($where);
                                                    
                                                    $output['tables']['table'.$i][''.$contract['total_amount']] = $contract['table'];
                                                    $i++;
                                                    } // end of for each contract 
                                                    $i = 0;
                                       $where = "(vendor_id = ".$report_account." ) and  (contract_start_date  BETWEEN '". $from_date . "' AND '". $to_date ."')" ;           
                                      
                                       $this->db->select('sum(amount + item_vat_amount) as Total_Amount')
                                                ->from('tb_vendor_contracts as vc')
                                                ->join('tb_vendor_items as vi','vi.contract_id = vc.contract_id','right')
                                                ->where($where);
                                                
                                                $query = $this->db->get();
                                                
                                                  if ($query->num_rows() > 0 )
                                                    {
                                                        $output['total_amount'] = abs($query->row()->Total_Amount);
                                                    } 
                                                
                                                  $this->load->view('report_view',$output);  
                                                

                                            }else 
                                            {
                                                 $output['report_heading'] = "Nothing Found";
             
                                                 $this->load->view('report_view',$output);  
                                            }

                                        
                                    }else
                                    {
                                      $output['report_heading'] = "Account Not Found";
             
                                      $this->load->view('report_view',$output);  
                                    } 
             
             
         }
         
         private function  get_vendor_contracts($where){
             
             $this->db->select('DATE_FORMAT(contract_start_date, "%b/%Y") as "Date",'
                                . 'drivers as Drivers, '
                                . 'quantity as Quantity , '
                                . 'description as Description, '
                                . 'amount as Amount, '
                                . 'item_vat_amount as VAT')
                                     ->from('tb_vendor_contracts as vc')
                                     ->join('tb_vendor_items as vi','vi.contract_id = vc.contract_id')
                                     
                                     ->where($where)
                                     ->order_by('contract_start_date','asc');
                         
                                
                                $query = $this->db->get();
                                
                              
                                if ($query->num_rows() > 0 )
                                    {  
                                    
                                     
                                        
                                        
                                        $template = array(
                                                    'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        $output['total_amount'] = 0;
                                      foreach ($query->result() as $row){  
                                        $output['total_amount'] += $row->Amount + $row->VAT;
                                      }
                                        
                                        
                                        return $output; 
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Nothing Found";
                                      
                                     // $this->load->view('report_view',$output);  
                                    }
             
         }


         ///////////////////////////////////////////////////////////////////////
         
         ///////////////////////////////////////////////////////////////////////
         //                vendor contract report for given duration 
         ///////////////////////////////////////////////////////////////////////
         
         private function show_income_statement($output,$date_from,$date_to){
             $income_statement = $this->get_income_statement($output,$date_from,$date_to);
              $income_statement['report_heading'] = "<b> Income Statement For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
             $this->load->view('report_view',$income_statement);
         }
         
         private function get_income_statement($output,$date_from,$date_to){
             
             $invoices_sheet = $this->get_invoice_for($output, $date_from, $date_to);
             if(isset($invoices_sheet['total_amount'])){
             $invoices_total = $invoices_sheet['total_amount'];
             }else 
             {
                 $invoices_total = 0;
             }
             
             $expenses_sheet = $this->get_expenses_sheet($output, $date_from, $date_to);
             
             $expenses_total = $expenses_sheet['total_amount'];
             
             unset($output['tables']);
             
             $net_income = $invoices_total - $expenses_total;
             if($net_income > 0 ) 
             {
                 //$status = " PROFIT";
                 $first = array( 'data' => '<b>NET INCOME</b>' ,'style' => 'background-color:#ecec6f;border:2px solid black');
                 $second = array('data' => '' , 'style'=>'background-color:#ecec6f;border:2px solid black');
                 $third = array('data' => $net_income.' PROFIT', 'style' => 'background-color:#5ec15e;border:2px solid black');
                 
             }else {
                 //$status = " LOSS";
                 $first = array('data' => '<b>LOSS</b>' , 'style' => 'background-color:#e88c8c;border:2px solid black');
                 $second = array('data' => '' , 'style'=>'background-color:#e88c8c;border:2px solid black');
                 $third = array('data' => $net_income , 'style' => 'background-color:#e88c8c;border:2px solid black');
                 
             }
                $this->table->set_caption("");
                $this->table->set_heading(array('Description','SAR','SAR'));
                $template = array(
                     'table_open' => '<table class="central-table income-table" border="0">'
                    );
                $this->table->set_template($template);
                $this->table->add_row(array(array('data' => '<b> INCOME: </b>' , 'style'=>'background-color:lightgray;width:33em;text-align:left'),
                                    array('data' => '' , 'style'=>'background-color:lightgray;width:7em'),
                                    array('data' => '' , 'style'=>'background-color:lightgray;width:7em')));
                $this->table->add_row('','','');
                $this->table->add_row(array( 
                                        array('data' => '<br>Invoices Revenue<br><br>', 'style'=>'padding-left:6em'),
                                        '', $invoices_total));
            
                $this->table->add_row(array(array('data' => '<b> EXPENSES: </b>' , 'style'=>'background-color:lightgray;width:auto;text-align:left'),
                                        array('data' => '' , 'style'=>'background-color:lightgray;width:7em'),
                                         array('data' => '' , 'style'=>'background-color:lightgray;width:7em')));
                
                $this->table->add_row('<br>','<br>','<br>');
                if (isset($expenses_sheet)){
                            foreach($expenses_sheet['tables'] as $table){
                                    foreach($table as $total => $table){

                                        $dom = new DOMDocument();
                                        @$dom->loadHTML($table);
                                        $captions = $dom->getElementsByTagName('caption');
                                        foreach ($captions as $caption){
                                       $this->table->add_row(array( 
                                               array('data' => $caption->nodeValue , 'style'=>'text-align:left;padding-left:4em;'),
                                               array('data' => $total , 'style'=>'text-align:center')
                                               ,''));
                                        }

                                    }
                            }
                        }
                $this->table->add_row('<br>','<br>','<br>');
//                $this->table->add_row(array( 
//                    array('data' => '<b>TOTAL EXPENSES</b>', 'style'=>'padding-left:6em'),
//                    '', $expenses_total));
                
                $this->table->add_row('<br>','<br>','<br>');
                
                
                $this->table->add_row('',
                        array('data' => $expenses_total, 'style'=>'text-align:center;border:2px solid black'),
                        array('data' => $invoices_total, 'style'=>'text-align:center;border:2px solid black'));
                $this->table->add_row($first,$second,$third);
                

                $output['table'] =  $this->table->generate();
                $output['profit_loss'] = $net_income;
                
             
             
             
             return $output;
             
         }
         
         
         ///////////////////////////////////////////////////////////////////////
         
         
         
}// end of class       


?>