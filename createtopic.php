<?php
session_start();
require_once 'include/db.php';
require_once 'include/header.html';
require_once 'include/nav.php';
 
echo '<h2>Create a topic</h2>';
if($_SESSION['signed_in'] == false) {
    //the user is not signed in
    echo 'Sorry, you have to be <a href="signin.php">signed in</a> to create a topic.';
} else { 
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST') {   
        $sql = "SELECT
                    Category_Id,
                    Category_Name,
                    Category_Description
                FROM
                    Categories";
         
        $result = mysql_query($sql);
         
        if(!$result) {

            echo 'Error while selecting from database. Please try again later.';
        } else {
            if(mysql_num_rows($result) == 0) {

                if($_SESSION['User_PermLvl'] == 1) {
                    echo 'You have not created categories yet.';
                } else {
                    echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                }
            } else {
         
                echo '<form method="post" action="">
                    Subject: <input type="text" name="Topic_Subject" />
                    Category:'; 
                 
                echo '<select name="Topic_Category">';
                    while($row = mysql_fetch_assoc($result)) {
                        echo '<option value="'.$row['Category_Id'].'">'.$row['Category_Name'].'</option>';
                    }
                echo '</select>'; 
                echo '<br/>';   
                echo 'Message: <textarea name="Post_Content" /></textarea>
                    <br/>
                    Permission level:   <select name="Topic_Perm">
                                            <option value="0">Normal</option>
                                            <option value="1">Admin ONLY</option>
                                        </select>
                    <input type="submit" value="Create topic" />
                 </form>';
            }
        }
    } else {
        $query  = "BEGIN WORK;";
        $result = mysql_query($query);
         
        if(!$result){
            echo 'An error occured while creating your topic. Please try again later.';
        }else {
            $sql = "INSERT INTO 
                        Topic(Topic_Subject,
                               Topic_Date,
                               Topic_Category,
                               Topic_Author,
                               Topic_Perm)
                   VALUES('".mysql_real_escape_string($_POST['Topic_Subject'])."', NOW(),'".mysql_real_escape_string($_POST['Topic_Category'])."','" . $_SESSION['User_Id'] . "','" .mysql_real_escape_string($_POST['Topic_Perm'])."')";
                      
            $result = mysql_query($sql);
            if(!$result) {
                echo 'An error occured while inserting your data. Please try again later.' . mysql_error();
                $sql = "ROLLBACK;";
                $result = mysql_query($sql);
            } else {
                $topicid = mysql_insert_id();
                 
                $sql = "INSERT INTO Post(Post_Content, Post_Date, Post_Topic, Post_Author) VALUES('" .mysql_real_escape_string($_POST['Post_Content']). "', NOW(), '" .$topicid. "','" .$_SESSION['User_Id']."')"; 
                
                $result = mysql_query($sql);
                 
                if(!$result) {
                    echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
                    $sql = "ROLLBACK;";
                    $result = mysql_query($sql);
                } else {
                    $sql = "COMMIT;";
                    $result = mysql_query($sql);
                     
                    echo 'You have successfully created <a href="topic.php?Id='. $topicid . '">your new topic</a>.';
                }
            }
        }
    }
}
 
include 'include/footer.php';
?>