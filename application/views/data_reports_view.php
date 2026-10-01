<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
$username = ($this->session->userdata['logged_in']['username']);
$email = ($this->session->userdata['logged_in']['email']);
} else {
header("location: " . base_url());
}
include_once 'ntow.php';
?>
	<head>
		<title>Reports</title>
		
                <?php
                        require_once 'admin-head.php';
                ?>

		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
                <link href='<?php echo base_url(); ?>assets/jquery_ui/jquery-ui.css' rel='stylesheet' type="text/css">
               
                <link href='<?php echo base_url(); ?>assets/jquery_ui/theme.css' rel='stylesheet' type="text/css">
                
                <?php
                      require_once 'admin-js.php';
                ?>
                
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery_ui/jquery-ui.js"></script>
                
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/print_jq/printThis.js"></script>
        
                
                <script type="text/javascript">
                    
                    function printDiv(){
                              
                               
                               
                                $("#slip_print").printThis({
                                                            debug: false,               
                                                            importCSS: true,            
                                                            importStyle: true,         
                                                            printContainer: true,      
                                                            pageTitle: "",              
                                                            removeInline: false,       
                                                            printDelay: 333,            
                                                            header: null,               
                                                            formValues: true            
                                                        });
                            }
                            
                        
                          
                          
                   $( function() {
                                            var dateFormat = "dd/mm/yy",
                                                    from = $( "#date_from" )
                                                            .datepicker({
                                                                    defaultDate: "-1m",
                                                                    changeMonth: true,
                                                                    changeYear: true,
                                                                    numberOfMonths: 3,
                                                                   <?php 
                                                                       if(isset($picker_format)){
                                                                       echo $picker_format;
                                                                       }
                                                                       else{ 
                                                                       echo 'dateFormat:"dd/mm/yy"';
                                                                       }
                                                                       ?>
                                                            })
                                                            .on( "change", function() {
                                                                    to.datepicker( "option", "minDate", getDate( this ) );
                                                            }),
                                                    to = $( "#date_to" ).datepicker({
                                                            
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            numberOfMonths: 3,
                                                            <?php 
                                                                       if(isset($picker_format)){
                                                                       echo $picker_format;
                                                                       }
                                                                       else{ 
                                                                       echo 'dateFormat:"dd/mm/yy"';
                                                                       }
                                                                       ?>
                                                    })
                                                    .on( "change", function() {
                                                            from.datepicker( "option", "maxDate", getDate( this ) );
                                                    });

                                            function getDate( element ) {
                                                    var date;
                                                    try {
                                                            date = $.datepicker.parseDate( dateFormat, element.value );
                                                    } catch( error ) {
                                                            date = null;
                                                    }

                                                    return date;
                                            }
                                } );
                          
                          
                          
                            
                          
                </script>

                <style>
                    @media print  
                        {
                            .results,.inwords,.tr{
                                page-break-inside: avoid;
                            }
                        }
                    
                        
                        #page-wrapper{
                             background-color: lightgray;
                        }
                    input[type="text"]{
                        
                        width: 20em;
                    }
                    .table-bordered{
                        border:2px solid black;
                    }
                    .central-table{
                        width: 100%;
                    }
                    .central-table tr td:first-child,.central-table tr td:last-child {
                            width: 8em;
                            
                        }
                        .central-table tr td:not(:last-child){
                            text-align: left;
                            padding-left: 1em;
                        }
                    .income-table td, th{
                            border-left:2px solid black;
                            border-right:2px solid black;
                        }
                        .income-table th{
                            border-top:2px solid black;
                        }
                    #report_form{
                        background-color: #abb7cf;
                        padding-top: 2em;
                        
                        
                    }
                    select{
                        color:blue;
                        width: 100%;
                    }
                    
                    #slip_print{
                        width: 21cm;
                        min-height: 29.7cm; 
                        margin:0; 
                        padding:1.5cm;
                        
                        
                        
                    }
                    #company_name{
                        width:auto;
                        display: inline;
                        margin-right:0;
                        margin-left: 5cm;
                    }
                   
                    
                    body th {
                        background-color: gray !important;
                        color: white!important;
                        padding: .1cm;
                        text-align: center;
                        font-size: 12px;
                    }
                    
                    span {
                        color:black;
                        
                    }
                    
                    td{
                        font-size: 10px;
                        padding: .06cm;
                        text-align: center;
                    }
                   
                    #co_logo{
                        display: inline;
                        width: 3cm;
                        height: 1cm;
                        margin-top: .75cm;
                    }
                    #company_details{
                        width:100%;
                    }
                    
                    #co_name_heading{
                        /*background-color: #bccbde !important;*/
                        color: black !important;
                        padding: .3cm;
                        border-bottom:.2em solid #cc0000;
                        border-top:.2em solid #cc0000;
                        /*border-radius: 25px;*/
                        margin-bottom: .85em;
                    }
                    table caption{
                        color: #9E00CF;
                        background: #7cafbb;
                        padding-left: 2em;
                    }
                    .headings{
                        
                        color: black !important;
                        padding: .5em;
                        border: 0.2em solid black;
                    }
                    
                    td.amount{
                        text-align: right;
                        padding-right: 2em;
                    }
                    hr{
                       
                       border-top: 4px solid brown;
                    }
                    
                    
                </style>
        </head>
        <body>
            
            <div id="wrapper">
                
                    <?php
                        require_once 'admin-nav.php';
                    ?>
                    <div id="page-wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header">Reports</h1>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                       
                        
                        <div class="row">
                            
                            
                           
                            
                            <div class="col-lg-3" id="report_form">
                                
                                <div>
                                    <div style="color:red;"><?php echo validation_errors(); ?></div>
                                    <?php 
                                    
                                    if (isset($report_form)){
                                        echo $report_form;
                                       
                                    }
                                    ?>
                                    
                                      <input type='button' class="btn btn-block btn-primary" value='Print' onclick='printDiv();'>
                                      <br>
                                </div>
                        
                            </div>
                            
<!--                        </div>
                        <div class="row">-->
                
<div class="col-lg-1"></div>                     
<div class="col-lg-8" style="padding: 1em;"> 
                                
                                <div id = "slip_print">



                                        <div id="company_details">

                                            <div id="company_name">
                                                
                                                <table  class="table">
                                                            <tr>
                                                                <td>
                                                                    <!--<img id="co_logo" src="<?php //echo base_url(); ?>imgs/logo.jpg" alt="Company Logo"  />-->
                                                                </td>
                                                                <td>
                                                                    <!--<h3 id="co_name_heading">XYZ CORP</h3>-->
                                                                </td>
                                                                

                                                            </tr>
                                                            
                                                            
                                                           
                                                            <tr>
                                                                <td colspan="2">
                                                                     <h5 class="headings"><?php echo isset($report_heading) ? $report_heading :  "ABC Report" ; ?> </h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                   <span style='float:right;'>
                                                                   
                                                                   <?php 
                                                                   if (isset($account_balance))
                                                                   {
                                                                       //echo "Account Balance on date : ";
                                                                       //echo date("d, F, Y") . " SAR is "; 
                                                                   
                                                                       
                                                                       if($account_balance > 0 ) {
                                                                       // echo abs($account_balance) . "/- <b>Dr</b>"; 
                                                                        }else {
                                                                       // echo abs($account_balance) . "/- <b>Cr</b>" ;   
                                                                        }
                                                                       
                                                                   }
                                                                   
                                                                     ?>
                                                                   </span>
                                                                </td>
                                                            </tr>
                                                </table>
                                                
                                            </div>
                                            <div>
                                                    <?php
                                                    if (isset($table)){
                                                        echo $table;
                                                 
                                                        echo "<br>";
                                                        if (isset($total_amount)){
                                                                echo "<div class = 'inwords'><br><hr>";
                                                                echo "<span style = 'float:right;'> Total Amount SAR is = " .$total_amount."/-</span>";
                                                                echo "IN WORDS = " . strtoupper(NumbersToWords::convert($total_amount)) . " SAR ONLY";
                                                                echo "</div>";
                                                                    
                                                        }
                                                                
                                                        }
                                                    ?>
                                                
                                                     <?php
                                                    if (isset($tables)){
                                                        foreach($tables as $table){
                                                                foreach($table as $total => $table){
                                                                    echo "<div class = 'results'>";
                                                                   echo $table; 
                                                                   echo "<br>";
                                                                    echo "<span style = 'float:right;'> Total SAR is = " .$total."/-</span>";
                                                                   // echo "IN WORDS = " . strtoupper(NumbersToWords::convert($total)) . " SAR ONLY";
                                                                    echo "<br>";
                                                                     echo "<br>";
                                                                      echo "<br>";
                                                                    echo "</div>";
                                                                }
                                                        }
                                                        echo "<br>";
                                                         
                                                          
                                                        if (isset($total_amount)){
                                                                echo "<div class = 'inwords'><br><hr>";
                                                                echo "<span style = 'float:right;'> Net Total SAR is = " .$total_amount."/-</span>";
                                                                echo "IN WORDS = " . strtoupper(NumbersToWords::convert($total_amount)) . " SAR ONLY";
                                                                echo "</div>";
                                                                
                                                        }
                                                    }
                                                    
                                                    if(isset($profit_loss)){
                                                        if($profit_loss > 0){$status = " NET PROFIT ";}else{$status = " LOSS ";} 
                                                        echo "<div class = 'inwords'><br><hr>";
                                                        echo "<span style = 'float:right;'> ". $status ." SAR is = " .$profit_loss."/-</span>";
                                                        echo $status . " IN WORDS = " . strtoupper(NumbersToWords::convert(abs($profit_loss))) . " SAR ONLY";
                                                        echo "</div>";
                                                    }
                                                    ?>
                                                
                                            </div>
                                        </div>

                                        


                                       
                                </div>

                
                
                            </div>   
                        </div> 
                    </div>
            </div>   
        </body>
        
</html>