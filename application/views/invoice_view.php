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
		<title>Invoice</title>

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
                               var text = $("#rig_text").val(); 
                               $("#rig_text").css("display","none");
                                $("#rig_span").html(text);
                               
                                text = $("#po_text").val(); 
                               $("#po_text").css("display","none");
                                $("#po_span").html(text);
                                
                                 text = $("#ticket_text").val(); 
                               $("#ticket_text").css("display","none");
                                $("#ticket_span").html(text);
                               
                               
                                $("#report_page").printThis({
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
                    .table-bordered{
                        border:2px solid black;
                    }
                    #report_page{
                        width: 21cm;
                        min-height: 29.7cm; 
                        margin:0; 
                        padding:2.5cm;
                        
                        
                    }
                    #report_form{
                        background-color: #abb7cf;
                        padding-top: 2em;
                        
                        
                    }
                    select{
                        color:blue;
                        width: 100%;
                    }
                    #tb_order{
                        margin-right:0;
                        margin-left:auto; 
                        margin-bottom:0.5cm; 
                        width:7cm;
                        float:right;
                    }
                    #tb_client{
                        
                        margin-left:0;
                        margin-right:auto;
                        width:7cm;
                    }
                    #items_area{
                        width:100%;
                        height:11cm;
                    }
                    #tb_items{
                        height:8cm;
                    }
                    #tb_items th{
                        height:1cm;
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
                        padding: .05cm;
                    }
             
                    input[type="text"]{
                        margin:.2em;
                        width: 10em;
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
                                <h1 class="page-header">Invoice Printing</h1>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                        
                            
                       
                        
                        <div class="row">
                
                            
                            <div class="col-lg-3" id="report_form">

                                      <?php echo form_open('Invoice'); ?>
                                      <?php echo validation_errors(); ?>
                                        <div class="form-group">
                                            <label for="order_id" >Order Name : </label>
                                            <br>
                                      <?php 
                                            
                                            echo form_dropdown('order_id', isset($orders) ? $orders : '','class = "form-control"'); 
                                      ?>
                                        </div>
                                        <div class="form-group">
                                      <?php echo form_submit('submit','submit','class = "btn  btn-block btn-success"'); ?>
                                        </div>
                                      
                                      <?php echo form_close(); ?>
                                <input type='button'  class="btn btn-block btn-primary" value='Print' onclick='printDiv();'>
                                <br>
                            </div>
                            <div class="col-lg-1"></div>
<!--                        </div>
                         
                        
                        <div class="row">-->
                            <div class="col-lg-8" style="border:1px solid black;padding: 1em;">
                                <div id="report_page" >
                                   <h1 align="center" style="font-weight: bold;margin:1cm;text-align: center;">INVOICE</h1>
                                        <div>
                                       <?php if(isset($order)){ ?>


                                                <br>
                                                <table id="tb_order" class="table-bordered" >
                                                    <tr><th>DATE</th><td><?php echo $order->order_start_date;?></td></tr>
                                                    <tr><th>INOVICE#</th><td><?php echo $order->order_name;?></td></tr>
                                                    <tr><th>RIG NAME</th><td id="rig_name"><span id="rig_span" ></span><input id="rig_text"  style="border: none; padding:0;margin-top:3px;" type="text"></td></tr>
                                                    <tr><th>PO#</th><td id="po_no"><span id="po_span" ></span><input id="po_text" style="border: none; padding:0;margin-top:3px" type="text"></td></tr>
                                                    <tr><th>TICKET#</th><td id="ticket_no"><span id="ticket_span" ></span><input id="ticket_text" style="border: none; padding:0;margin-top:3px" type="text"></td></tr>

                                                </table>

                                        <?php }?>

                                        <?php if(isset($client)){ ?>

                                            <table class="table-bordered" id="tb_client" >
                                                <tr><th>BILL TO</th></tr>
                                                <tr><td><?php echo $client->account_name; ?></td></tr>
                                                <tr><td><?php echo $client->address1; ?></td></tr>
                                                <tr><td><?php echo $client->address2; ?></td></tr>
                                                <tr><td><?php echo $client->address3; ?></td></tr>
                                                <tr><td><?php echo $client->address4; ?></td></tr>

                                            </table>
                                        </div>
                                        <?php }?>




                <!--                        trips and equipments area -->
                                        <div id="items_area" >

                                            <table id="tb_items" class="table-bordered" style="margin-top: .5cm; width:100%;text-align: center;">

                                                <?php
                                                //echo $output;
                                                       echo "<th>ITEM</th>";
                                                       if(!isset($items)){
                                                       echo "<th>DATE</th>";
                                                       }
                                                       echo "<th>DESCRIPTION</th>";
                                                       if(!isset($items)){
                                                           echo "<th>FROM</th>";
                                                           echo "<th>TO</th>";
                                                       }
                                                       else 
                                                       {
                                                           echo "<th>QTY</th>";
                                                           echo "<th>UNIT</th>";
                                                       }

                                                       echo "<th>AMOUNT SAR</th>";

                                                       $comulative_charges = 0;
                                                       $count = 0;
                                                       //if trips available display them
                                                       if(isset($trips))
                                                           {

                                                                foreach($trips as $trip) {
                                                                    echo "<tr>";
                                                                        echo "<td>";
                                                                            echo $count = $count + 1 ;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $trip->_date ;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $trip->trip_description . "<br>" . $trip->waiting_description;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $trip->place_from;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $trip->place_to;
                                                                        echo "</td>";
                                                                        echo "<td>";

                                                                            echo $trip->trip_charges; 

                                                                            if(!$trip->delay_charges == 0)
                                                                                echo "<br>". $trip->delay_charges;

                                                                        echo "</td>";
                                                                        $comulative_charges = $comulative_charges + $trip->trip_charges + $trip->delay_charges;

                                                                    echo "</tr>";
                                                                }
                                                            }

                                                       //if equipments available display them
                                                        if(isset($equipments))
                                                           {
                                                            foreach($equipments as $equipment) 
                                                                {
                                                                    echo "<tr>";
                                                                        echo "<td>";
                                                                            echo $count = $count + 1 ;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $equipment->_date ;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $equipment->description ;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo "-";
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo "-";
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $equipment->rental_charges;
                                                                        echo "</td>";
                                                                        $comulative_charges = $comulative_charges + $equipment->rental_charges ;

                                                                    echo "</tr>";

                                                                }
                                                            }

                                                       //if items available display them
                                                        if(isset($items))
                                                           {
                                                            $comulative_charges = 0;
                                                            foreach($items as $item) 
                                                                {
                                                                    echo "<tr>";
                                                                        echo "<td>";
                                                                            echo $item->item ;
                                                                        echo "</td>";
                                                                        echo "<td style='text-align:left;'>";
                                                                            echo $item->description ;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $item->qty;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $item->unit;
                                                                        echo "</td>";
                                                                        echo "<td>";
                                                                            echo $item->amount;
                                                                        echo "</td>";
                                                                        $comulative_charges = $comulative_charges + $item->amount ;

                                                                    echo "</tr>";

                                                                }
                                                            }

                                                ?>
                                            </table>

                                            <div style="margin-top: .5cm;margin-left:1cm;">
                                               <?php
                                                    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                    echo strtoupper($f->format($comulative_charges)." ONLY");
                                                    //echo strtoupper(NumbersToWords::convert($comulative_charges)." ONLY");
                                                    echo "<span align = 'left' style = 'float:right;color:black; border-top:thin solid black;border-top:double;'> ";
                                                    echo "Total   ";
                                                    echo "SAR ";
                                                    echo $comulative_charges;
                                                    echo "</span>";
                                                ?> 
                                            </div>   

                                        </div>    

                                        <table class="table-bordered" id="tb_bank_details" style="margin: 1cm auto 0.5cm 0;">
                                            <tr><th style="padding:.2cm;">BANK DETAILS</th></tr>
                                            <tr><td style="padding:.2cm;">National Commercial Bank <br> 
                                                    XYZ Corp<br>
                                                    IBAN: SA09 1000 0032 0485 9500 0104<br>
                                                    A/C No.: 32 0485 9500 0104<br>
                                                    Swift Code: NCBKSAJEA
                                                </td>
                                            </tr>
                                        </table>

                                        <div id="bottom_note" style="text-align:center;font-size:11px;">
                                            For any query about this invoice, please contact <br>
                                            [Support, 0000000000, support@example.test]<br>
                                            <b>Thank You For Your Business!</b>
                                        </div>

                                    </div>
                            </div>
                        </div>
                        
                    </div>
            </div>   

	
	</body>
        
</html>