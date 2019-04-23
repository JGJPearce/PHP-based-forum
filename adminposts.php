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
                    <li role="presentation"><a href="adminusers.php">Users</a></li>
                    <li role="presentation"><a href="admincategories.php">Category Management</a></li>
                    <li role="presentation"><a href="admintopics.php">Topic Management</a></li>
                    <li role="presentation" class="active"><a href="adminposts.php">Post Management</a></li>
                </ul>
            </div>
            
            <div class="col-sm-9">
            <?php
                // Get user info
                $sql = "SELECT
                            *
                        FROM
                            Post";
                $result = mysql_query($sql);
                $row = mysql_fetch_assoc($result);

                if(!$result) {
                    echo "Unable to find posts.";
                } else {
                    if(mysql_num_rows($result) == 0) {
                        echo 'No posts availalbe.';
                    } else {

                        ?>                             
                                                                        
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                Post Id
                                            </th>
                                            <th>
                                                Post Content
                                            </th>
                                            <th>
                                                Posted in
                                            </th>
                                            <th>
                                                Post Author
                                            </th>
                                            <th>
                                                Date Posted
                                            </th>
                                            <th>
                                                Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                        <?php
                        
                      /*  if(isset($_POST['delete'])){
                            $deleteQuery = "DELETE FROM Post WHERE Post_Id ='$_POST['hidden']'";
                            //mysql_query($deleteQuery);
                        }*/
                                //display all user information
                                while($row = mysql_fetch_assoc($result)) {
                                    echo '<form action=adminposts.php method=post>';
                                    echo '<tr>';
                                        echo '<td>';
                                            echo '<p>' . $row['Post_Id'] . '</p>';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<p>' . $row['Post_Content'] . '</p>';
                                        echo '</td>';    
                                        echo '<td >';
                                            echo '<p><a href="topic.php?Id='. $row['Post_Topic'] .'">' . $row['Post_Topic'] . '</a></p>';
                                        echo '</td>';  
                                        echo '<td >';
                                            echo '<p><a href="user.php?Id='. $row['Post_Author'] .'">' . $row['Post_Author'] . '</a></p>';
                                        echo '</td>';
                                        echo '<td >';
                                            echo '<p>' . $row['Post_Date'] . '</p>';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<a href="deletepost.php?Id=' . $row['Post_Id'] . '">Delete</a>';
                                        echo '</td>';
                                    echo '</tr>';
                                    echo '</form>';
                                        
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