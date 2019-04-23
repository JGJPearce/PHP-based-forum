<?php
session_start();
// include header, database connection and nav bar
require_once 'include/db.php';
require_once 'include/header.html';
require_once 'include/nav.php';

// Get user info
$sql = "SELECT
            *
        FROM
            User";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($userResult);

if(!$result) {
    echo "Unable to find users.";
} else {
    if(mysql_num_rows($result) == 0) {
        echo 'No users availalbe.';
    } else {

        ?><div class="row">
            <div class="col-md-4">
        <?php
                //display all user information
                while($row = mysql_fetch_assoc($result)) {
                    echo '<h2><a href="user.php?Id='. $row['User_Id'] .'">' . $row['User_Name'] . '</a></h2>';
                    echo '<p>Email: ' . $row['User_Email'] . '</p>';
                    echo '<p>Date joined: ' . $row['User_Date'] . '</p>';
                    echo '<p>Account Level: ' . $row['User_PermLvl'] . '</p>';
                }
            ?></div><?php           
    } 
}


require_once 'include/footer.html';
?>
