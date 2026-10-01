<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">ERP v 1.0</a>
            </div>
            <!-- /.navbar-header -->
            <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-top-links navbar-right">
                
                
                <li>
                    <a href="<?php echo base_url(); ?>">
                        <i class="fa fa-home fa-fw"></i>Home Page    
                    </a>
                    
                </li>

                
 
                <li>
                            <a href="<?php echo base_url(); ?>index.php/Vehicles_data">
                            <i class="fa fa-truck fa-fw"></i>    Vehicles Data
                            </a>
                </li>
                        
                <li>
                    <a href="<?php echo base_url(); ?>index.php/Accounts">
                        <i class="fa fa-table fa-fw"></i>Accounts 
                        
                    </a>
                   
                </li>
                
                <li>
                    <a href="<?php echo base_url(); ?>index.php/Transactions">
                        <i class="fa fa-edit fa-fw"></i>Transactions
                    </a>
                </li>
                                <?php
                echo 
                    '
                


                
                
                <li>
                    <a href="'. base_url() .'index.php/Expenses">
                        <i class="fa fa-tasks fa-fw"></i>Expenses
                    </a> 
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-clipboard fa-fw"></i>Reports
                        
                    </a>
                    <ul class="dropdown-menu">
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" '. base_url() .'index.php/Get_report/load_report/vendor_trips">Callout Vendor Trips Report</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" '. base_url() .'index.php/Get_report/load_report/vendor_equipments">Callout Vendor Equipments Report</a>
                        </li>
                       
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" '. base_url() .'index.php/Get_report/load_report/expenses_sheet_of_duration">All Expenses Report</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" '. base_url() .'index.php/Get_report/load_report/invoices_of_duration">Invoices Report</a>
                        </li>
                        <li class="divider"><hr></li>
                          <li>
                            <a href=" '. base_url() .'index.php/Get_report/load_report/vendor_contracts">Monthly Vendor Contract Report</a>
                        </li>
                       
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" '. base_url() .'index.php/Get_report/load_report/income_statement">Income Statement</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" '. base_url() .'index.php/Invoice">Invoice</a>
                        </li>
                        
                    </ul>
                </li>
                
                
                
               
                
                ';

                ?>
                
                <li>
                            <a href="<?php echo base_url(); ?>index.php/Employees_data">Employees Data</a>
                </li>
                

                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-sitemap fa-fw"></i>Business Entries
                        
                    </a>
                    <ul class="dropdown-menu">
                        <li class="divider"><hr></li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Orders">Orders</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" <?php echo base_url(); ?>index.php/Invoice">Invoice</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" <?php echo base_url(); ?>index.php/Vat_invoice">Vat Invoice</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" <?php echo base_url(); ?>index.php/Vat_invoice_1">Vat Invoice Arabic</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href=" <?php echo base_url(); ?>index.php/Upload_invoices">Upload Invoice</a>
                        </li>
                        
                        <li class="divider"><hr></li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Vendor_contracts">Vendor Contracts</a>
                        </li>
                        
                        <li class="divider"><hr></li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Data_reports/load_report/vendor_trips">Callout Vendor Trips Report</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Data_reports/load_report/vendor_equipments">Callout Vendor Equipments Report</a>
                        </li>
                        <li class="divider"><hr></li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/Data_reports/load_report/vendor_contracts">Monthly Vendors Report</a>
                        </li>
                    </ul>
                </li>
                
                 <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"  >
                                <i class="fa fa-tasks fa-fw"></i>Business Items
                            </a>
                            <ul class="dropdown-menu">
                                <li class="divider"><hr></li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Arabic_description">Arabic Description</a>
                                </li>
                                <li class="divider"><hr></li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Trips">Trips</a>
                                </li>
                                <li class="divider"><hr></li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Rental_equipments">Rental Equipments</a>
                                </li>
                                <li class="divider"><hr></li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Order_items">Client Items</a>
                                </li>
                                <li class="divider"><hr></li>
                                <li>
                                    <a href="<?php echo base_url(); ?>index.php/Vendor_items">Vendor Items</a>
                                </li>
                            </ul>
                        </li>
                

                
                 <!--/.dropdown--> 
               
                    <!--                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                     /.dropdown-tasks 
                </li>-->
                 <!--/.dropdown--> 
                    <!--                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                     /.dropdown-alerts 
                </li>-->
                <!-- /.dropdown -->
                
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> 
                                <?php echo $this->session->userdata['logged_in']['username'] ?> 
                            </a>
                        
                        
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('index.php/User_Authentication/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            

            </div> 
            
            <!-- /.navbar-static-side -->
        </nav>