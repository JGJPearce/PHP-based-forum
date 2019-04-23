<?php
session_start();
require_once 'include/db.php';
require_once 'include/header.html';
require_once 'include/nav.php';
 
//first select the category based on $_GET['cat_id']
$sql = "SELECT
            Category_Id,
            Category_Name,
            Category_Description,
            Category_Perm
        FROM
            Categories
        WHERE
            Category_Id ='". mysql_real_escape_string($_GET['Id'])."'";
 
$result = mysql_query($sql);
$perm = mysql_fetch_assoc($result);
if($perm['Category_Perm'] == 1 && $_SESSION['User_PermLvl'] < 1) {
    echo 'You do not have permission to be here.';
} else {  
    if(!$result) {
        echo 'The category could not be displayed, please try again later.' . mysql_error();
    } else {
        if(mysql_num_rows($result) == 0) {
            echo 'This category does not exist.';
        } else {
            //display category data
            while($row = mysql_fetch_assoc($result)) {
                echo '<h2>Topics in ' . $row['Category_Name'] .'</h2>';
            }

            //do a query for the topics
            $sql = "SELECT 
                        *
                    FROM
                        Topic
                    WHERE
                        Topic_Category ='". mysql_real_escape_string($_GET['Id'])."'
                    ORDER BY Topic_Date DESC";

            $result = mysql_query($sql);

            if(!$result) {
                echo 'The topics could not be displayed, please try again later.';
            } else {
                if(mysql_num_rows($result) == 0) {
                    echo 'There are no topics in this category yet. <a href="createtopic.php">Click here to create one</a>';
                } else {

                    //prepare the table
                    echo '<table border="1" width="100%">
                          <tr>
                            <th>Topic</th>
                            <th>Created at</th>
                          </tr>'; 

                    while($row = mysql_fetch_assoc($result)) {               
                        echo '<tr>';
                            echo '<td class="leftpart" width="80%">';
                                echo '<p><a href="topic.php?Id=' . $row['Topic_Id'] . '">' . $row['Topic_Subject'] . '</a><p>';
                            echo '</td>';
                            echo '<td class="rightpart" width="20%">';
                                echo date('d-m-Y', strtotime($row['Topic_Date']));
                            echo '</td>';
                        echo '</tr>';
                    }
                    echo "<br/><a href='createtopic.php' class='btn btn-default' role='button'>Create a new topic</a><br/><br/>";

                }
            }
        }
    }
}

 
include 'include/footer.php';
?>