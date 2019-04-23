<?php
session_start();
require_once 'include/db.php';
require_once 'include/header.html';
require_once 'include/nav.php';
 
if($_SERVER['REQUEST_METHOD'] != 'POST') {
    //someone is calling the file directly, which we don't want
    echo 'This file cannot be called directly.';
} else {
    //check for sign in status
    if(!$_SESSION['signed_in']) {
        echo 'You must be signed in to post a reply.';
    } else {
        //a real user posted a real reply
        $sql = "INSERT INTO 
                    Post(Post_Content,
                          Post_Date,
                          Post_Topic,
                          Post_Author) 
                VALUES ('".$_POST['reply-content']."',
                        NOW(),
                        '".mysql_real_escape_string($_GET['Id'])."',
                        '".$_SESSION['User_Id']."')";
                         
        $result = mysql_query($sql);
                         
        if(!$result) {
            echo 'Your reply has not been saved, please try again later.' . mysql_error();
        } else {
            echo 'Your reply has been saved, check out <a href="topic.php?Id=' . htmlentities($_GET['Id']) . '">the topic</a>.';
        }
    }
}
 
include 'footer.php';
?>