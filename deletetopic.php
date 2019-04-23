<?php
session_start();
require_once 'include/db.php';
 
$Id=$_GET['Id'];

// Delete data in mysql from row that has this id 
$sql="DELETE FROM Topic WHERE Topic_Id='$Id'";
$result=mysql_query($sql);

// if successfully deleted
if($result){
echo "Deleted Successfully";
echo "<BR>";
echo "<a href='index.php'>Back to main page</a>";
header('Location: admintopics.php');
}

else {
echo "ERROR";
}

// close connection 
mysql_close();
?>