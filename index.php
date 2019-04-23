<?php
session_start();
// include header, database connection and nav bar
require_once 'include/db.php';
require_once 'include/header.html';
require_once 'include/nav.php';


$sql = "SELECT
			Categories.Category_Id,
			Categories.Category_Name,
			Categories.Category_Description,
            Categories.Category_Perm,
			COUNT(Topic.Topic_Id) AS Topic
		FROM
			Categories
		LEFT JOIN
			Topic
		ON
			Topic.Topic_Id = Categories.Category_Id
		GROUP BY
			Categories.Category_Name, Categories.Category_Description, Categories.Category_Id";

$result = mysql_query($sql);

if(!$result) {
	echo 'The categories could not be displayed, please try again later.';
} else {
	if(mysql_num_rows($result) == 0) {
		echo 'No categories defined yet.';
	} else {
		//prepare the table
		echo '<table border="1" width="100%">
			  <tr>
				<th width="70%">Category</th>
				<th width="30%">Last topic</th>
			  </tr>';	
			
		while($row = mysql_fetch_assoc($result))
		{				
			echo '<tr>';
				echo '<td class="leftpart" width="70%">';
					echo '<h3><a href="category.php?Id=' . $row['Category_Id'] . '">' . $row['Category_Name'] . '</a></h3>' . $row['Category_Description'];
				echo '</td>';
				echo '<td class="rightpart" width="30%">';
				
				//fetch last topic for each cat
					$topicsql = "SELECT
									Topic_Id,
									Topic_Subject,
									Topic_Date,
									Topic_Category
								FROM
									Topic
								WHERE
									Topic_Category = " . $row['Category_Id'] . "
								ORDER BY
									Topic_Date
								DESC
								LIMIT
									1";
								
					$topicsresult = mysql_query($topicsql);
				
					if(!$topicsresult)
					{
						echo 'Last topic could not be displayed.';
					}
					else
					{
						if(mysql_num_rows($topicsresult) == 0)
						{
							echo 'no topics';
						}
						else
						{
							while($topicrow = mysql_fetch_assoc($topicsresult))
							echo '<a href="topic.php?Id=' . $topicrow['Topic_Id'] . '">' . $topicrow['Topic_Subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['Topic_Date']));
						}
					}
				echo '</td>';
			echo '</tr>';
		}
	}
}

require_once 'include/footer.html';
?>
