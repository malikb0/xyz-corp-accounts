<?php
if ( ! defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
if (isset($this->session->userdata['logged_in'])) {

    header("location: " . base_url('index.php/User_Authentication/user_login_process'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Form</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>admin_resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>admin_resources/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>admin_resources/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>admin_resources/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?php
                        if (isset($logout_message)) {
                           echo "<div >";
                                echo "<h1 class='text-success'>" . $logout_message . "</h1>" ;
                           echo "</div>";
                       }
                    ?>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        
                        <?php echo form_open('User_Authentication/user_login_process'); 
                                    echo "<div class='text-danger'>";
                                    //echo "<h1>We are Doing Some Maintenance and Update Work</h1>";
                                    if (isset($error_message)) {
                                        echo $error_message; //commented out due to maintenance
                                        
                                   }
                                        echo validation_errors(); //commented out due to maintenance
                                    echo "</div>"; 
                         ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="User Name" name="username" id="name" type="text" autofocus >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value=" Login " name="submit"/><br />
                                <!-- Change this to a button or input when using this as a form -->
                                
                                
                            </fieldset>
                        <?php echo form_close(); ?>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>admin_resources/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>admin_resources/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>admin_resources/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>admin_resources/dist/js/sb-admin-2.js"></script>

</body>

</html>
