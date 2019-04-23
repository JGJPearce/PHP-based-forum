<?php
session_start();
session_destroy();
echo "<a href='index.php'>If you are not automatically redirected click here</a>";
header('Location: index.php');
?>