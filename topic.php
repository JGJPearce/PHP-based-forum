<?php
session_start();
require_once 'include/db.php';
require_once 'include/header.html';
require_once 'include/nav.php';
 
// Get content from topic based on the id in url
$sql = "SELECT
            Topic_Id,
            Topic_Subject,
            Topic_Perm
        FROM
            Topic
        WHERE
            Topic_Id ='".mysql_real_escape_string($_GET['Id'])."'
        LIMIT 1";
 
$result = mysql_query($sql);
$perm = mysql_fetch_assoc($result);
if($perm['Topic_Perm'] == 1 && $_SESSION['User_PermLvl'] < 1) {
    echo 'You do not have permission to be here.';
} else { 
    if(!$result) {
        echo 'The Topic could not be displayed, please try again later.' . mysql_error();
    } else {
        if(mysql_num_rows($result) == 0) {
            echo 'Hmm, there does not seem to be a topic here.';
        } else {
            //display category data
            while($row = mysql_fetch_assoc($result)) {
                echo '<h2>Posts in ' . $row['Topic_Subject'] . '</h2>';
            }
            
            //do a query for the topics
            $sql = "SELECT
                        Post.Post_Topic,
                        Post.Post_Content,
                        Post.Post_Date,
                        Post.Post_Author, 
                        User.User_Id,
                        User.User_Name
                    FROM
                        Post
                    LEFT JOIN
                        User
                    ON
                        Post.Post_Author = User.User_Id
                    WHERE
                        Post.Post_Topic = '".mysql_real_escape_string($_GET['Id'])."'";

            $result = mysql_query($sql);

            if(!$result) {
                echo 'The Post could not be displayed, please try again later.';
            } else {
                if(mysql_num_rows($result) == 0) {
                    echo 'There are no Posts in this category yet.';
                } else {
                    //prepare the table

                    echo '<table border="1" width="100%">
                          <tr>
                            <th>Creator</th>
                            <th>Content</th>
                          </tr>'; 

                    while($row = mysql_fetch_assoc($result)) {                               
                        echo '<tr>';
                            echo '<td width="20%">';
                                echo '<p>' .$row['User_Name']. '</p> <br/> ';
                                echo date('d-m-Y', strtotime($row['Post_Date']));
                            echo '</td>';
                            echo '<td width="80%">';
                                echo '<p>' .$row['Post_Content']. '</p>';
                      /*  if($row['Post_Author'] == $_SESSION['User_Id']){
                            echo '<a href="editpost.php?Id=' . $row['Post_Id'] . '">Delete</a>';
                        }*/
                            echo '</td>';               
                        echo '</tr>';
                    }
                }

                $topicSQL = "SELECT
                                Topic_Id
                            FROM
                                Topic
                            WHERE
                                Topic_Id ='".mysql_real_escape_string($_GET['Id'])."'
                            LIMIT 1"; 
                $topicResult = mysql_query($topicSQL);

                $topicId = mysql_real_escape_string($_GET['Id']);

                if(!$_SESSION['signed_in']){
                    echo '<tr><td colspan=2>You must be <a href="signin.php">signed in</a> to reply. You can also <a href="signup.php">sign up</a> for an account.';
                } else {
                    //show reply box
                    echo '<tr><td colspan="2"><h2>Reply:</h2><br />
                        <form method="post" action="reply.php?Id='.$topicId.'">
                            <textarea name="reply-content"></textarea><br /><br />
                            <input type="submit" value="Submit reply" />
                        </form></td></tr>';
                }

                //finish the table
                echo '</table>';
            }
        }
    }
}
include 'include/footer.php';
?>