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
                    <li role="presentation"><a href="adminposts.php">Post Management</a></li>
                </ul>
            </div>
        </div>
<?php  
    }   
}


require_once 'include/footer.html';
?>
