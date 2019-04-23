<?php
session_start();
// include header, database connection and nav bar
require 'include/db.php';
require 'include/header.html';
require 'include/nav.php';
?>

<!-- MAIN BODY OF CONTENT -->

<?php
echo '<h3>Register</h3> <br/>';
 
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
        <label for='inputPassword3' class='col-sm-2 form-control-label'>Confirm Password</label>
        <div class='col-sm-5'>
          <input type='password' name='User_Password_Check' class='form-control' id='inputPassword3' placeholder='Password'>
        </div>
      </div>
      <div class='form-group row'>
        <label for='inputEmail3' class='col-sm-2 form-control-label'>Email</label>
        <div class='col-sm-5'>
          <input type='email' name='User_Email' class='form-control' id='inputEmail3' placeholder='Email'>
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

    $errors = array(); 
     
    if(isset($_POST['User_Name']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['User_Name']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['User_Name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }
     
     
    if(isset($_POST['User_Password']))
    {
        if($_POST['User_Password'] != $_POST['User_Password_Check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }
     
    if(!empty($errors))
    {
        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
        echo '<ul>';
        foreach($errors as $key => $value) 
        {
            echo '<li>' . $value . '</li>'; 
        }
        echo '</ul>';
    }
    else
    {

        $sql = "INSERT INTO
                    User(User_Name, User_Password, User_Email ,User_Date, User_PermLvl)
                VALUES('" . mysql_real_escape_string($_POST['User_Name']) . "',
                       '" . sha1($_POST['User_Password']) . "',
                       '" . mysql_real_escape_string($_POST['User_Email']) . "',
                        NOW(),
                        0)";
                         
        $result = mysql_query($sql);
        if(!$result)
        {
         
            echo 'Something went wrong while registering. Please try again later.';
            //echo mysql_error(); 
        }
        else
        {
            echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
        }
    }
}


?>
<!-- Include footer -->
<?php
require_once 'include/footer.html';
?>