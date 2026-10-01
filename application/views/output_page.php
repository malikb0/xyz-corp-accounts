<html>
<?php
if (isset($this->session->userdata['logged_in'])) {
$username = ($this->session->userdata['logged_in']['username']);
$email = ($this->session->userdata['logged_in']['email']);
} else {
header("location: " . base_url());
}
?>
	<head>
		<title>display_page</title>
		

		<?php 
			//crud block
			foreach($css_files as $file): ?>
			<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
		<?php endforeach; ?>
		
                 <?php 
                    require_once 'admin-js.php';
                ?>       
                        
		<?php foreach($js_files as $file): ?>
			<script src="<?php echo $file; ?>"></script>
		<?php endforeach; ?>
                

		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
               
                <?php
                    require_once 'admin-head.php';
                ?>
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/style.css">
                <style>
                    body{
                        background-color:darkgray;
                        font-family:"Bookman Old Style","Helvetica Neue",Helvetica,Arial,sans-serif;
                    }
                    th{
                        font-size: 14px;
                    }
                    td{
                        font-size: 14px;
                    }
                    table tr td:nth-child(14),td:nth-child(15){
                            /*max-width:.5em;*/
                        }
                    .table-hover tbody tr:hover td, .table-hover tbody tr:hover th, .table-hover tbody tr:hover td.sorting_1{
                          background-color: lightgreen;
                        }
                        .tools{
                            width: 6em;
                        }   
                        #page-wrapper{
                            background-color: darkgray;
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
                                <h1 class="page-header">DATABASE</h1>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                        <?php
                            //require_once 'display-panel.php';
                        ?>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <?php 
                                    echo $output; 
                             
                                ?>
                            </div>
                        </div>
                        
                    </div>

                </div>
                

	</body>
</html>