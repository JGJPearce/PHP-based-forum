    <div id="container">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">Simple Bulletin Board</a>
            </div>
              
            <?php

            $getUserName = "SELECT 
                User_Id,
                User_Name,
                User_PermLvl
            FROM
                User
            WHERE 
                User_Id = '".$_SESSION['User_Id']."'";
            $userResult = mysql_query($getUserName);
            $row = mysql_fetch_assoc($userResult);
            $ulevel = $row['User_PermLvl'];
            ?>
              
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                <li><a href='userlists.php'>Users</a></li>
                <?php
                if ($ulevel == 1){
                    echo "<li><a href='adminpanel.php'>ADMIN PANEL</a></li>";
                }    
                ?>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <?php
                if(!$_SESSION['signed_in']) {  
                    echo "<li><a href='signin.php'>Sign In</a></li>";
                    echo "<li><a href='signup.php'>Register</a></li>";
                } else {
                    echo '<li><a href="user.php?Id=' . $row['User_Id'] . '">' . $row['User_Name'] . '</a><li>';
                    echo '<li><a href="signout.php">Sign Out</a></li>';
                }
                ?>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
        
        
        
