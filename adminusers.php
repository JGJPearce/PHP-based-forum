<?php
session_start();
// include header, database connection and nav bar
require_once 'include/db.php';
require_once 'include/header.html';
require_once 'include/nav.php';

// make sure they are signed in
if($_SESSION['signed_in'] == false) {
    echo 'Sorry, you have to be <a href="signin.php">signed in</a>.';
} else {  
    // make sure their PermLvl is high enough
    if($_SESSION['User_PermLvl'] != 1) {
        echo 'You do not have permission to be here.';
    } else {
?>    
        <div class="row">
            <div class="col-sm-3">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation" class="active"><a href="adminusers.php">Users</a></li>
                    <li role="presentation"><a href="admincategories.php">Category Management</a></li>
                    <li role="presentation"><a href="admintopics.php">Topic Management</a></li>
                    <li role="presentation"><a href="adminposts.php">Post Management</a></li>
                </ul>
            </div>
            
            
            <div class="col-sm-9">
            <?php
                // Get user info
                $sql = "SELECT
                            *
                        FROM
                            User";
                $result = mysql_query($sql);
                $row = mysql_fetch_assoc($result);

                if(!$result) {
                    echo "Unable to find users.";
                } else {
                    if(mysql_num_rows($result) == 0) {
                        echo 'No users availalbe.';
                    } else {

                        ?>                             
                                                                        
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                User ID
                                            </th>
                                            <th>
                                                Username
                                            </th>
                                            <th>
                                                Date joined
                                            </th>
                                            <th>
                                                Permision Level
                                            </th>
                                            <th>
                                                Change PermLevel
                                            </th>
                                            <th>
                                                Delete User
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                        <?php
                                //display all user information
                                while($row = mysql_fetch_assoc($result)) {
                                    echo '<tr>';
                                        echo '<td>';
                                            echo '<p><a href="user.php?Id='. $row['User_Id'] .'">' . $row['User_Id'] . '</a></p>';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<p>' . $row['User_Name'] . '</p>';
                                        echo '</td>';    
                                        echo '<td >';
                                            echo '<p>' . $row['User_Date'] . '</p>';
                                        echo '</td>';  
                                        echo '<td>';
                                            echo '<p>' . $row['User_PermLvl'] . '</p>';
                                        echo '</td>';  
                                        echo '<td>';
                                            echo '<a href="decreaseperms.php?Id=' . $row['User_Id'] . '">Decrease</a> / <a href="increaseperms.php?Id=' . $row['User_Id'] . '">Increase</a>';
                                        echo '</td>';  
                                        echo '<td>';
                                            echo '<a href="deleteuser.php?Id=' . $row['User_Id'] . '">Delete</a>';
                                        echo '</td>'; 
                                    echo '</tr>';
                                      
                                }
                            ?>	</tbody>
                            </table><?php           
                    } 
                }

        
            ?>
            </div>
        </div>
<?php  
    }   
}


require_once 'include/footer.html';
?>
