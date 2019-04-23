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
                    <li role="presentation" class="active"><a href="admintopics.php">Topic Management</a></li>
                    <li role="presentation"><a href="adminposts.php">Post Management</a></li>
                </ul>
            </div>
            
            <div class="col-sm-9">
            <?php
                // Get user info
                $sql = "SELECT
                            *
                        FROM
                            Topic";
                $result = mysql_query($sql);
                $row = mysql_fetch_assoc($result);

                if(!$result) {
                    echo "Unable to find topics.";
                } else {
                    if(mysql_num_rows($result) == 0) {
                        echo 'No topics availalbe.';
                    } else {

                        ?>                             
                                                                        
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                Topic Id
                                            </th>
                                            <th>
                                                Subject
                                            </th>
                                            <th>
                                                Date posted
                                            </th>
                                            <th>
                                                Author
                                            </th>
                                            <th>
                                                Category
                                            </th>
                                            <th>
                                                Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                        <?php
                                //display all user information
                                while($row = mysql_fetch_assoc($result)) {
                                    echo '<tr>';
                                        echo '<td>';
                                            echo '<p><a href="topic.php?Id='. $row['Topic_Id'] .'">' . $row['Topic_Id'] . '</a></p>';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<p>' . $row['Topic_Subject'] . '</p>';
                                        echo '</td>';  
                                        echo '<td >';
                                            echo '<p>' . $row['Topic_Date'] . '</p>';
                                        echo '</td>';
                                        echo '<td >';
                                            echo '<p><a href="user.php?Id='. $row['Topic_Author'] .'">' . $row['Topic_Author'] . '</a></p>';
                                        echo '</td>'; 
                                        echo '<td >';
                                            echo '<p><a href="category.php?Id='. $row['Topic_Category'] .'">' . $row['Topic_Category'] . '</a></p>';
                                        echo '</td>';
                                        echo '<td >';
                                            echo '<a href="deletetopic.php?Id=' . $row['Topic_Id'] . '">Delete</a>';
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