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
                    <li role="presentation" class="active"><a href="admincategories.php">Category Management</a></li>
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
                            Categories";
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
                                                Category_ID
                                            </th>
                                            <th>
                                                Category Title
                                            </th>
                                            <th>
                                                Subject
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
                                            echo '<p><a href="category.php?Id='. $row['Category_Id'] .'">' . $row['Category_Id'] . '</a></p>';
                                        echo '</td>';
                                        echo '<td>';
                                            echo '<p>' . $row['Category_Name'] . '</p>';
                                        echo '</td>';    
                                        echo '<td >';
                                            echo '<p>' . $row['Category_Description'] . '</p>';
                                        echo '</td>';  
                                        echo '<td >';
                                            echo '<a href="deletecategory.php?Id=' . $row['Category_Id'] . '">Delete</a>';
                                        echo '</td>';                                     
                                    echo '</tr>';
                                        
                                }
                            ?>	</tbody>
                            </table><?php           
                    } 
                }
                
                // Create a new category
        
                echo '<h3>Create a new Category</h3>';
                if($_SERVER['REQUEST_METHOD'] != 'POST'){
                    //the form hasn't been posted yet, display it
                    echo '<form method="POST" action="">
                    Category name: <input type="text" name="Category_Name" /><br/>
                    Category description: <input type="text" name="Category_Description" /></textarea><br/>
                    Permission level: <select name="Category_Perm">
                                        <option value="0">Normal</option>
                                        <option value="1">Admin ONLY</option>
                                    </select>
                    <input type="submit" value="Add category" />
                    </form>';
                }else{
                    if($_SESSION['User_PermLvl'] != 1) {
                        echo 'You must wait for an admin to create some categories.<a href="index.php">Return to the home page</a>';
                    } else {
                        //the form has been posted, so save it
                        $name = mysql_real_escape_string($_POST['Category_Name']);
                        $desc = mysql_real_escape_string($_POST['Category_Description']);
                        $perm = mysql_real_escape_string($_POST['Category_Perm']);

                        $sql = "INSERT INTO Categories (Category_Name, Category_Description, Category_Perm) VALUES ('".$name."','".$desc."','".$perm."')"; 


                        $result = mysql_query($sql);
                        if(!$result)
                        {
                            //something went wrong, display the error
                            echo 'Error' . mysql_error();
                        }
                        else
                        {
                            echo 'New category successfully added.';
                        }  
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