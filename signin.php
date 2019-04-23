<?php
session_start();
require 'include/db.php';
require 'include/header.html';
require 'include/nav.php';
 
echo '<h3>Sign in</h3> <br/>';
 

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {

        echo"<form method='post' action=''>
              <div class='form-group row'>
                <label for='username' class='col-sm-2 form-control-label'>Username</label>
                <div class='col-sm-5'>
                  <input type='text' name='User_Name' class='form-control' id='inputEmail3' placeholder='Username'>
                </div>
              </div>
              <div class='form-group row'>
                <label for='inputPassword3' class='col-sm-2 form-control-label'>Password</label>
                <div class='col-sm-5'>
                  <input type='password' name='User_Password' class='form-control' id='inputPassword3' placeholder='Password'>
                </div>
              </div>
              <div class='form-group row'>
                <div class='col-sm-offset-2 col-sm-5'>
                  <button type='submit' class='btn btn-secondary'>Register</button>
                </div>
              </div>
            </form>";
    }
    else
    {

        $errors = array(); /* declare the array for later use */
         
        if(!isset($_POST['User_Name']))
        {
            $errors[] = 'The username field must not be empty.';
        }
         
        if(!isset($_POST['User_Password']))
        {
            $errors[] = 'The password field must not be empty.';
        }
         
        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
            $sql = "SELECT 
                        User_Id,
                        User_Name,
                        User_PermLvl
                    FROM
                        User
                    WHERE
                        User_Name = '" . mysql_real_escape_string($_POST['User_Name']) . "'
                    AND
                        User_Password = '" . sha1($_POST['User_Password']) . "'";
                         
            $result = mysql_query($sql);
            if(!$result)
            {
                echo 'Something went wrong while signing in. Please try again later.';
                //echo mysql_error(); 
            }
            else
            {

                if(mysql_num_rows($result) == 0)
                {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                }
                else
                {
                    $_SESSION['signed_in'] = true;

                    while($row = mysql_fetch_assoc($result))
                    {
                        $_SESSION['User_Id']    = $row['User_Id'];
                        $_SESSION['User_Name']  = $row['User_Name'];
                        $_SESSION['User_PermLvl'] = $row['User_PermLvl'];
                    }
                     
                    echo 'Welcome, ' . $_SESSION['User_Name'] . '. <a href="index.php">Proceed to the forum overview</a>.';
                }
            }
        }
    }
}
 
include 'footer.php';
?>