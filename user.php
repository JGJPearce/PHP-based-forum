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
            User
        WHERE
            User_Id = '".mysql_real_escape_string($_GET['Id'])."'";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($userResult);

if(!$result) {
    echo "This User cant be displayed rightnow.";
} else {
    if(mysql_num_rows($result) == 0) {
        echo 'This User does not exist.';
    } else {

        ?><div class="row">
            <div class="col-md-4">
        <?php
                //display all user information
                while($row = mysql_fetch_assoc($result)) {
                    echo '<h2>Username: ' . $row['User_Name'] . '</h2>';
                    echo '<p>Email: ' . $row['User_Email'] . '</p>';
                    echo '<p>Date joined: ' . $row['User_Date'] . '</p>';
                    echo '<p>Account Level: ' . $row['User_PermLvl'] . '</p>';
                }
            ?></div><?php           
    } 
}

// get posts that the user has posted
$userPosts = "SELECT
                Post.Post_Topic,
                Post.Post_Content,
                Post.Post_Date,
                Post.Post_Author, 
                Topic.Topic_Id,
                Topic.Topic_Subject
            FROM
                Post
            LEFT JOIN
                Topic
            ON
                Post.Post_Topic = Topic.Topic_Id
            WHERE
                Post_Author = '".mysql_real_escape_string($_GET['Id'])."'";
$postResult = mysql_query($userPosts);
$postRow = mysql_fetch_assoc($postResult);

if(!$postResult) {
        echo "This Users posts cant be displayed rightnow." .mysql_error();
} else {
    if(mysql_num_rows($postResult) == 0) {
        echo 'This User does not have any posts.';
    } else {

        ?>        
            <div class="col-md-8">
        <?php  
                //display all posts
                while($postRow = mysql_fetch_assoc($postResult)) {
                    echo '<h2><a href="topic.php?Id='. $postRow['Topic_Id'] .'">' . $postRow['Topic_Subject'] . '</a></h2>';
                    echo '<p>Post content: ' . $postRow['Post_Content'] . '</p>';
                    echo date('d-m-Y', strtotime($row['Post_Date']));
                }
        ?></div>
                </div>
                <?php   
    } 
} 


require_once 'include/footer.html';
?>
