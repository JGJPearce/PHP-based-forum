<?php
session_start();
require_once 'include/db.php';
 
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo 'Sorry, you have to be <a href="signin.php">signed in</a> to create a Category.';
}
else
{ 
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
}
?>