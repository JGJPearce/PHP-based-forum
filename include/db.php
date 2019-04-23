<?php

$servername = "localhost";
$username = "Jack";
$password = "123";
$dbSchema = 'ThirdYearProject';

// Create connection
mysql_connect($servername, $username, $password) or die(mysql_error());

mysql_select_db($dbSchema)
?> 
