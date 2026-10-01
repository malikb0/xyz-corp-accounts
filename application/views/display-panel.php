<div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-book fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                            <?php
                                                    if(isset($total_debit) && is_object($total_debit) ){
                                                        echo abs($total_debit->Total_Debit);
                                                    }
                                                ?>
                                        </div>
                                        <div>Account Debits</div>
                                    </div>
                                </div>
                            </div>
                            
                               
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-book fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                            <?php
                                                    if(isset($total_credit) && is_object($total_credit)){
                                                        echo abs($total_credit->Total_Credit);
                                                    }
                                                ?>
                                        </div>
                                        <div>Account Credits</div>
                                    </div>
                                </div>
                            </div>
                       
                             
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-hand-stop-o fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div style="font-size:15px">
                                            <?php
                                                    if(isset($total_cashinhand) && is_object($total_cashinhand)){
                                                        echo abs($total_cashinhand->Total_CashInHand);
                                                    }
                                                ?>
                                        </div>
                                        <div>Cash In Hand</div>
                                    </div>
                                </div>
                            </div>
                       
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-gears fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div style="font-size:15px">
                                            <?php
                                                    if(isset($pending_expenses) && is_object($pending_expenses)){
                                                        echo abs($pending_expenses->Pending_Expenses);
                                                    }
                                                ?>
                                        </div>
                                        <div>Pending Expenses</div>
                                    </div>
                                </div>
                            </div>
                      
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-gear fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div style="font-size:15px">
                                            <?php
                                                    if(isset($pending_vendors) && is_object($pending_vendors)){
                                                        echo abs($pending_vendors->Pending_Vendors);
                                                    }
                                                ?>
                                        </div>
                                        <div>Pending Vendors</div>
                                    </div>
                                </div>
                            </div>
         
                        </div>
                    </div>
                </div>