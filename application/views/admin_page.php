<?php
if (isset($this->session->userdata['logged_in'])) {
    
    $username = ($this->session->userdata['logged_in']['username']);
    $email = ($this->session->userdata['logged_in']['email']);
    
} 
else 
    {
    
    header("location: " . base_url());
    
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            require_once 'admin-head.php';
        ?>
        
        
        <title>Admin Home</title>
        
         <?php 
              require_once 'admin-js.php';
          ?>
        
        
        
    </head>
<body>
    
       
    
        <div id="wrapper">

            <?php
                require_once 'admin-nav.php';
            ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <?php
                    require_once 'display-panel.php';
                ?>
                
                <div class="row">
                    
                        <?php
                                       require_once 'admin-notifications.php';
                        ?>
                    
                </div>
                
             
                
            </div>

        </div>
        
    
            
    
    
  <!-- /#wrapper -->

  
</body>

</html>

