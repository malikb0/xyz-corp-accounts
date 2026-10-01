<?php 
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
Class Data_reports extends CI_Controller {

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
		
			
			
                        /////////////////////////////////////////////    check login status of user   /////////////// 
                    
                    
                   if (! isset($this->session->userdata['logged_in'])) {
                       
                       
                       $this->load->view('login_form');
                   
                   }else {
                   
                   
                     ////////////////////////////////////////////////////////////////////////////////////////////////
                   
                                
                   
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
                                          //  $this->total_dc_report($output,"account_balance < 0 ","Payable");
                                            break;
                                        case "accounts_receiveable":
                                          //  $this->total_dc_report($output,"account_balance > 0 ","Receiveable");
                                            break;
                                        default:
                                            $this->load->view('data_reports_view',$output);
                                    } 
                     
                     } 
                     else { 
			
                               if (!isset($report_type)) {
                                   $output['msg'] = "No Report Type"; 
                                   $this->load->view('data_reports_view',$output);
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
                                            //$this->total_dc_report($output,"account_balance < 0 ","Payable");
                                            break;
                                        case "accounts_receiveable":
                                            //$this->total_dc_report($output,"account_balance > 0 ","Receiveable");
                                            break;
                                        case "invoices_of_duration":
                                            //$this->get_invoices($output,$date_from,$date_to);
                                            break;
                                        case "vendor_contracts":
                                            $this->vendor_contracts($output,$date_from,$date_to);
                                            break;
                                           
                                        case "expenses_sheet_of_duration":
                                            //$this->show_expenses_sheet($output, $date_from, $date_to);
                                            break;
                                        case "general_expenses":
                                            //$this->general_expenses_report($output,$date_from,$date_to,"expense","General");
                                            break;
                                        case "office_expenses":
                                            //$this->general_expenses_report($output,$date_from,$date_to,"office_expense", "Office");
                                            break;
                                        case "vehicle_expenses":
                                            //$this->vehicle_expenses_report($output,$date_from,$date_to);
                                            break;
                                        case "monthly_transactions":
                                            //$this->transactions_report($output,$date_from,$date_to);
                                            break;
                                        case "income_statement";
                                            //$this->show_income_statement($output, $date_from, $date_to);
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
           $url = base_url('index.php/Data_reports/load_report/'.$report_type); 
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
            $url = base_url('index.php/Data_reports/load_report/'.$report_type); 
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
                                        
                                        
                                        $query = $this->db->query("Select DATE_FORMAT("
                                                                                        . "start_time, '%d/%b/%Y') as Date,"
                                                                                        . "account_name as 'Driver Name', "
                                                                                        . "place_from  as 'From' , "
                                                                                        . "place_to as 'To',"
                                                                                        . "vendor_charges as 'Amount_SAR', "
                                                                                        . "vendor_vat_amount as 'VAT' "
                                                . "FROM tb_callout_trips "
                                                . "left join tb_accounts on driver_id = account_id "
                                                . "where  ". $inwhere ." and  (start_time  BETWEEN '". $from_date . "'  AND '". $to_date ." 23:59:59')"
                                                . "order by start_time asc" );
                                        
                                        $template = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        
                                        $this->db->select_sum('(vendor_charges + vendor_vat_amount)','Total_Amount')
                                                    ->from('tb_callout_trips')
                                                    ->where($inwhere)
                                                    ->where("(start_time  BETWEEN '". $from_date . "'  AND '". $to_date ." 23:59:59')");
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $output['total_amount'] = $query->row()->Total_Amount;
                                            }  
                                        
                                        
                                        $this->load->view('data_reports_view',$output);  
                                        
                                        
                                        
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Account Not Found";
             
                                      $this->load->view('data_reports_view',$output);  
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
                                        
                                        
                                        $query = $this->db->query(""
                                                . "SELECT DATE_FORMAT("
                                                        . "rental_date, '%d/%b/%Y') as Date ,"
                                                        . "equipment_name as 'Equipment Name',"
                                                        . "quantity as Quantity,"
                                                        . "usage_hours as 'Usage Hours',"
                                                        . "vendor_charges as 'Amount SAR',"
                                                        . "vendor_vat_amount as 'VAT' "
                                                . "FROM tb_rental_equipments "
                                                . "where  ". $inwhere ." and  (rental_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')"
                                                . "order by rental_date asc" );
                                        
                                        $template = array(
                                                    'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        
                                        $this->db->select_sum('(vendor_charges + vendor_vat_amount)','Total_Amount')
                                                    ->from('tb_rental_equipments')
                                                    ->where($inwhere)
                                                    ->where("(rental_date  BETWEEN '". $from_date . "'  AND '". $to_date ."')")
                                                    ->order_by('','');
                                        $query = $this->db->get();
                                        if ($query->num_rows() > 0 )
                                            {
                                                $output['total_amount'] = $query->row()->Total_Amount;
                                            }  
                                        
                                        
                                        $this->load->view('data_reports_view',$output);  
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Account Not Found";
             
                                      $this->load->view('data_reports_view',$output);  
                                    }
             
         }// end of vendor equipments report 
         
         ///////////////////////////////////////////////////////////////////////
         
             
         ///////////////////////////////////////////////////////////////////////
         //                Transactions Report for given duration  
         ///////////////////////////////////////////////////////////////////////
         
         
         private function transactions_report($output,$date_from,$date_to){
                $report_account = $this->input->post('account_id');
                
                
                //$report_month = $this->input->post('report_month');
                //$report_year = $this->input->post('report_year');
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
                                        
                                        $output['report_heading'] = "<b> Transactions Report of ".strtoupper($account->account_name)."</b><br><br> For the duration of " . $date_from->format('d-F, Y') ." to ".$date_to->format('d-F, Y')  ;
                                        $output['account_balance'] = $account->account_balance;
                                       // $where = "ac.account_id = ".$report_account." or ac1.account_id = ".$report_account. " and  year(transaction_date) = ".$report_year." and month(transaction_date) = ".$report_month;
                                         $where = "(tr.account_to = ".$report_account. ") and  (transaction_date  BETWEEN '". $from_date . "' AND '". $to_date ."')" ;
                                         $where1 = "(tr.account_from = ".$report_account.") and  (transaction_date  BETWEEN '". $from_date . "' AND '". $to_date ."')" ;
                                        $this->get_monthly_transactions($output, $where,$where1,$date_to);
                                    }else
                                    {
                                      $output['report_heading'] = "Account Not Found";
             
                                      $this->load->view('data_reports_view',$output);  
                                    }
            }
         
         private function get_monthly_transactions($output,$where,$where1,$date_to){
             
//             $this->db->select('DATE_FORMAT(transaction_date, "%d/%b/%Y") as "Date",ac.account_name as "Debit From",ac1.account_name as "Credit To", description as Description, cash_amount as "Credit SAR","-" as "Debit SAR"')
//                                     ->from('tb_transactions as tr')
//                                     ->join('tb_accounts as ac','ac.account_id = tr.account_from')
//                                     ->join('tb_accounts as ac1','ac1.account_id = tr.account_to')
//                                     ->where($where)
//                                     ->order_by('transaction_date','asc');
                         
             
             $query = 'select transaction_date as "Date" , ac.account_name as Debit_From , acc.account_name as Credit_To ,description as Description, round(cash_amount, 2) as Credit , "-" as Debit from tb_transactions as tr 
                        join tb_accounts as ac on ac.account_id = tr.account_from
                        join tb_accounts as acc on acc.account_id = tr.account_to
                        where '.$where.'
                        
                        union all
                        select transaction_date as "Date" , ac.account_name as Debit_From , acc.account_name as Credit_To ,description as Description, "-" as Credit , round(cash_amount, 2) as Debit from tb_transactions as tr 
                        join tb_accounts as ac on ac.account_id = tr.account_from
                        join tb_accounts as acc on acc.account_id = tr.account_to
                        where '.$where1.'
                        
                        union all
                        Select "<b></b>" as "Date", "-" as Debit_From, "-" as Credit_To,"<b>Total</b>" as Description,
                        Concat("<b>",
                        (select sum(cash_amount) as Credit from tb_transactions as tr 
                        where '.$where.')
                            ,"</b>")
                            as Credit,
                        Concat("<b>",
                        (select sum(cash_amount) as Debit from tb_transactions as tr 
                        where '.$where1.')
                            ,"</b>")
                            as Debit
                            
                            ';
                        //order by "Date" asc';
                                
                        $query = $this->db->query($query);
                                
                              
                                if ($query->num_rows() > 0 )
                                    {  
                                    
                                     
                                        
                                        
                                        $template = array(
                                                    'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="central-table">');

                                            $this->table->set_template($template);
                                        
                                        
                                        
                                        
                                        $output['table'] = $this->table->generate($query);
                                        
                                        
                                        //$output['total_amount'] = 0;
                                      //foreach ($query->result() as $row){  
                                       // $output['total_amount'] += $row->Amount;
                                     // }
                                        
                                        
                                        $this->load->view('data_reports_view',$output);  
                                    }
                                    else 
                                    {
                                      $output['report_heading'] = "Nothing Found";
             
                                      $this->load->view('data_reports_view',$output);  
                                    }
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
                                                
                                                  $this->load->view('data_reports_view',$output);  
                                                

                                            }else 
                                            {
                                                 $output['report_heading'] = "Nothing Found";
             
                                                 $this->load->view('data_reports_view',$output);  
                                            }

                                        
                                    }else
                                    {
                                      $output['report_heading'] = "Account Not Found";
             
                                      $this->load->view('data_reports_view',$output);  
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
                                      
                                     // $this->load->view('data_reports_view',$output);  
                                    }
             
         }


         ///////////////////////////////////////////////////////////////////////
         

         
         
         ///////////////////////////////////////////////////////////////////////
         
         
         
}// end of class       


?>