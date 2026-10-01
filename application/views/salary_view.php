<html>
<?php
//if (isset($this->session->userdata['logged_in'])) {
//$username = ($this->session->userdata['logged_in']['username']);
//$email = ($this->session->userdata['logged_in']['email']);
//} else {
//header("location: " . base_url());
//}
include_once 'ntow.php';
?>
	<head>
		<title>Salary Slip</title>
		
                <?php
                        require_once 'admin-head.php';
                ?>

		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
                
                
                <?php
                      require_once 'admin-js.php';
                ?>
                
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
                    
                </script>

                <style>
                    
                    input[type="text"]{
                        margin:2em;
                        width: 20em;
                    }
                    .table-bordered{
                        border:2px solid black;
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
                        font-size: 14px;
                        padding: .06cm;
                        
                    }
                   
                    #co_logo{
                        display: inline;
                        width:5cm;
                        height: 2.5cm;
                    }
                    #company_details{
                        width:100%;
                    }
                    #report_form{
                        background-color: #abb7cf;
                        padding-top: 2em;
                        
                        
                    }
                    select{
                        color:blue;
                        width: 100%;
                    }
                    #salary_heading{
/*                        background-color: #bccbde !important;
                        color: black !important;
                        padding:.3cm;*/
                        color: black !important;
                        padding: .3cm;
                        border-bottom:.2em solid #cc0000;
                        border-top:.2em solid #cc0000;
                        /*border-radius: 25px;*/
                        margin-bottom: .85em;
                        text-align: center;
                    }
                    .headings{
                        
                        background-color: #3e5637 !important;
                        color: white !important;
                        padding: .5em;
                    }
                    #items{
                        width: 100%;
                    }
                    #items tr:last-child{
                        background-color: wheat;
                    }
                    #items tr:last-child td:nth-child(2){
                        color: green;
                    }
                    #items tr:last-child td:nth-child(4){
                        color: red;
                    }
                    #items td{
                        padding-left: 1em;
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
                                <h1 class="page-header">Salary Slip Printing</h1>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                        
                        <div class="row">
                
                            
                            <div class="col-lg-3" id="report_form">
                                
                                <div >
                                    <?php echo form_open('Salary_slip'); ?>
                                    <div style="color:red;">
                                        <?php echo validation_errors();?>
                                       
                                    </div> 
                                    
                                    
                                    
                                    
                                    
                                    <div class="form-group">
                                      <?php 
                                            echo form_label("Employee-Name",'account_id'). "<br>";
                                            echo form_dropdown('account_id', isset($employees) ? $employees : ''); 

                                      ?>
                                    </div>

                                    <div class="form-group">
                                      <?php 
                                            echo form_label("Month",'salary_month'). "<br>";

                                            echo form_dropdown('salary_month',array(
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
                                                  ); ?>

                                    </div>
                                    <div class="form-group">
                                      <?php
                                            echo form_label("Year",'salary_year'). "<br>";

                                            $years = range(2014, date("Y"));
                                                foreach ($years as $year) {
                                                    $year_list[$year] = $year;
                                                }

                                            echo form_dropdown('salary_year', $year_list , date("Y"));
                                        ?>
                                    </div>
                                      <?php echo form_submit('submit','submit','class="btn btn-block btn-success"'); ?>
                                      <?php echo form_close(); ?>
                                      <input type='button' class="btn btn-block btn-primary" value='Print' onclick='printDiv();'>
                                      <br>
                                </div>
                        
                            </div>
                            
<!--                        </div>
                        <div class="row">-->
                
                        <div class="col-lg-1">
                        </div>
                            <div class="col-lg-8" style="border:1px solid black;padding: 1em;"> 
                                
                                <div id = "slip_print">



                                        <div id="company_details">

                                            <div id="company_name">
                                                <h2 id="salary_heading">XYZ CORP</h2>
                                                <table  class="table">
                                                            <tr>
                                                                <td rowspan="5">
                                                                    <img id="co_logo" src="<?php echo base_url(); ?>imgs/logo.jpg" alt="Company Logo"  />
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td> AL KHAMIS TOWER, OFFICE NO-16, AL MANAR DISTRICT, DAMMAM, KINDOM OF SAUDI ARABIA</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phone: 0583822224</td>
                                                            </tr>
                                                            <tr>
                                                                <td>accounts@example.test</td>
                                                            </tr>


                                                </table>
                                            </div>

                                        </div>

                                        <h4 class="headings"><?php echo $msg;?> </h4>


                                        <?php 
                                      //  if(isset($salary_)){
                                        ?>
                                        <table id="employee_info" class="table">
                                            <tr>
                                                <td>
                                                    <h5> EMPLOYEE NAME & DESIGNATION : <?php 
                                                        if(isset($employee_name))
                                                            echo $employee_name;
                                                    //echo $msg  ?>
                                                    </h5>

                                                </td>

                                            </tr>
                                            <tr>
                                               <td>
                                                    DATE OF JOINING : 
                                                        <?php 
                                                        if(isset($joining_date)) {
                                                                echo $joining_date;
//                                                                echo "<span style='float:right;'>  ACCOUNT BALANCE SAR NOW IS = ";  
//                                                                        if($account_balance > 0 ) {
//                                                                        echo abs($account_balance) . "/- <b>Dr</b>"; 
//                                                                        }else {
//                                                                        echo abs($account_balance) . "/- <b>Cr</b>" ;   
//                                                                        }
//                                                                        echo " </span>";

                                                        }
                                                        ?>
                                                </td>

                                            </tr>
                                        </table>
                                        <table id="items" class="table-bordered" >
                                            <tr>
                                                <th colspan="2">ADDITION</th>
                                                <th colspan="2">DEDUCTIONS</th>

                                            </tr>
                                            <?php
                                            if(isset($salary)){
                                                echo ""
                                                        . "<tr><td>Base Salary  </td><td class ='amount'>$salary->base_salary </td><td>Violations Amount</td><td class ='amount'></td></tr>"
                                                        . "<tr><td> Allowance  </td><td class ='amount'>$salary->other_allowance </td><td>Absent Days Deduction</td><td class ='amount'></td></tr>"
                                                        . "<tr><td>Kilometers Driven Amount  </td><td class ='amount'> </td><td>Other Deductions</td><td class ='amount'></td></tr>"
                                                        . "<tr><td>Commission  </td><td class ='amount'></td><td>-</td><td class ='amount'>-</td></tr>"
                                                        . ""
                                                        . ""
                                                        . ""
                                                        . ""
                                                        . "<tr>"
                                                        . "<td>TOTAL ADDITION = </td><td class ='amount'> $salary->net_salary</td>"
                                                        . "<td>TOTAL DEDUCTION = </td><td class ='amount'></td>"
                                                        . "</tr>"
                                                        . "<tr>"
                                                        . "<td> $salary->all_comments  </td>"
                                                        . "</tr>"
                                                        ;


                                            }


                                            ?>









                                        </table>
                                        <div style="margin-top: .2cm; font-size: 14px; padding:.2cm;" >

                                                <?php
                                                if(isset($salary)){
                                                echo "<div class = 'inwords'><br>";
                                                echo "IN WORDS = " . strtoupper(NumbersToWords::convert($salary->net_salary)) . " SAR ONLY";
                                                echo "<span style= 'border-top:1px solid black; border-top: double; float:right;'> NET SALARY SAR = $salary->net_salary</span>";
                                                echo "<br><br><hr>"
                                                
                                                
                                                        . "<p>I have read and understood all the calculations made/calculated "
                                                        . "in this pay slip and I agree on this salary for this particular month. "
                                                        . "Moreover, I have also submitted all the bills to be reimbursed for "
                                                        . "this specific month.</p><br>"
                                                        . "Signature of Employee : ___________________________"
                                                        . "<br><br>"
                                                        . "<hr>"
                                                        . "<br>";
                                                       // . "<span class = 'pull-left'> Prepared  By:- <br><br> Name :    ____________________________ <br><br> Signature __________________________</span>  "
                                                       // . "<span class = 'pull-right'> Verified By:-  <br><br> Name :    ____________________________ <br><br> Signature __________________________</span>";
                                                echo "</div>";
                                                }
                                                ?>

                                        </div>
                                        <?php
                                        //}else
                                        {
                                            //echo $msg;
                                        }
                                        ?>
                                </div>

                
                
                            </div>   
                        </div> 
                    </div>
            </div>   
        </body>
        
</html>