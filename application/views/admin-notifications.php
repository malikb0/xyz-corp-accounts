<div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <i class="fa fa-bell fa-fw"></i> Invoices Status
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <div class=" list-group-item alert alert-info">
                                                 Invoice No
                                    <span class="pull-right text-muted medium ">Due Date 
                                                </span>
                                            </div>
                                <?php
                                if(isset($invoices)){
                                    foreach ($invoices as $invoice=>$due_date) {
                                        
                                    
                                        echo '<div class=" list-group-item alert alert-danger">
                                                <i class="fa fa-warning fa-fw"></i> <span  alert alert-danger>'. $invoice .'</span>'.
                                    '<span class="pull-right text-muted small "><em class="alert-danger"> '. $due_date .'  </em>
                                                </span>
                                            </div>';
                                
                                            }
                                }else {
                                    echo "No Invoices Due";
                                }
                                ?>
                            </div>
                            <!-- /.list-group -->
                            <!--<a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                 
                    <!-- /.panel .chat-panel -->
</div>
<div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <i class="fa fa-bell fa-fw"></i> Employees Documents Expire Notification
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <div class=" list-group-item alert alert-info">
                                                 Employee Name
                                    <span class="pull-right text-muted medium ">Documents Expires 
                                                </span>
                                            </div>
                                <?php
                                if(isset($emp_docs_expires)){
                                    foreach ($emp_docs_expires as $emp_doc_expires=>$expire_dates) {
                                        
                                    
                                        echo '<div class=" list-group-item alert alert-danger">
                                                <i class="fa fa-warning fa-fw"></i> <span  alert alert-danger>'. $emp_doc_expires .'</span>'.
                                    '<span class="pull-right text-muted small "><em class="alert-danger"> '. $expire_dates .'  </em>
                                                </span>
                                            </div>';
                                
                                            }
                                }else {
                                    echo "No Document";
                                }
                                ?>
                            </div>
                            <!-- /.list-group -->
                            <!--<a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                 
                    <!-- /.panel .chat-panel -->
</div>

<div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <i class="fa fa-bell fa-fw"></i> Vehicles Documents Expire Notification
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <div class=" list-group-item alert alert-info">
                                                 Vehicle 
                                    <span class="pull-right text-muted medium ">Documents Expires 
                                                </span>
                                            </div>
                                <?php
                                if(isset($vhcl_docs_expires)){
                                    foreach ($vhcl_docs_expires as $vh_doc_expires=>$expire_dates) {
                                        
                                    
                                        echo '<div class=" list-group-item alert alert-danger">
                                                <i class="fa fa-warning fa-fw"></i> <span  alert alert-danger>'. $vh_doc_expires .'</span>'.
                                    '<span class="pull-right text-muted small "><em class="alert-danger"> '. $expire_dates .'  </em>
                                                </span>
                                            </div>';
                                
                                            }
                                }else {
                                    echo "No Vehicle";
                                }
                                ?>
                            </div>
                            <!-- /.list-group -->
                            <!--<a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                 
                    <!-- /.panel .chat-panel -->
</div>