<?php
//session start
session_start();
?>
<html>
    <head> 
    <title> CS UTEP ALUMNI</title>
        <style>

            #nav {
                line-height:30px;
                background-color:#003366;
				color:#ffffff;
				text-align:center;
                height:100%;
                width:15%;
                float:left;
                padding:1%;	      
            }
			#nav a {
				text-decoration: none;
				text-transform: uppercase;
				color:#ffffff;
			}
			#userinfo {
                width:80%;
                float:right;
				text-align:right;
				padding-top: 1%;
				padding-right: 2%;
			}
            #section {
                width:80%;
                float:left;
                padding:1%;	 	 
            }
			#footer {
                background-color:#FF9900;
                height:10%;
                width:100%;
                float:left;
				text-align:center;
                padding:5px;
			}

        </style>
    </head>
    <body>

        <div id="header">
            <img src="pic1.jpg" alt="CS ALumni" style="width:100%;height:20%;">   
        </div>

        <div id="nav">
            <a href="index.php">Home</a><br>
			<a href="list.php">Graduates</a><br>

            <?php
            if (!isset($_SESSION['login_user'])) {
            	echo' <a href="login.php">Login</a><br>';
				echo' <a href="register.php">Register</a><br>';
			}
            else
            {
        		echo '<a href="profile.php">Profile</a><br>';
				echo '<a href="bulletin.php">Bulletin</a><br>';
		   	}  
            ?>    
        </div>
		
		<?php
		if (isset($_SESSION['login_user'])) {
			$fullName = $_SESSION['user_fullname'];
			echo '
				<div id="userinfo">
					Hi, <b>' . $fullName .'</b> | <a href="logout.php">Log Out</a><br>
				</div>
				';
		}
		?>
		
        <div id="section">
			<!-- START OF CONTENT -->
<?php
 		require_once 'db_connection.php';
 		if(isset($_POST['submit']) && $_COOKIE["PHPSESSID"]== $_POST['BId'])
                {
 			$conn = new mysqli($hn, $un, $pw, $db);
 			if ($conn->connect_error)
 				die($conn->connect_error);
 			$date = date("Y-m-d h:i:s ");
 			$title;
 			$description;
			$content;
 			if(isset($_POST['title'])){
 				$title = $_POST['title'];
 				unset($_POST['title']);
 			}
 			if(isset($_POST['description'])){
 				$description = $_POST['description'];
 				unset($_POST['description']);
 			}
			if(isset($_POST['content'])){
 				$content = $_POST['content'];
 				unset($_POST['content']);
 			}
 			$title = $conn->real_escape_string($title);
 			$description = $conn->real_escape_string($description);
 			$content = $conn->real_escape_string($content);
			$conn->query("INSERT INTO `bulletin` (title, description, time_posted,content) VALUES ('$title','$description','$date','$content')");
 			$conn->close();
 			unset($_POST['submit']);
 		}

		
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error)
			die($conn->connect_error);

		
		$query = "SELECT * FROM bulletin ORDER BY time_posted DESC";
		$result = $conn->query($query);
		if (!$result)
			die($conn->error);
		
		$rows = $result->num_rows;
		$title;
		$description;
		$postID;
		$content;
		echo '<h1> Bulletin </h1>';
		echo '<table border=1 width=80%>';
		echo '<tr>';
		echo '<th>PostID</th><th>Title</th><th>Description</th><th>Date</th><th>Content</th>';
		echo '</tr>';
		for($j = 0; $j < $rows; $j++){
			$row = $result->fetch_assoc();
			$title = $row['title'];
			$postID = $row['postID'];
			$content = $row['content'];
			$description = $row['description'];
			$date = $row['time_posted'];
			echo '<tr>';
			echo '<td>'.$postID.'</td>';
			echo '<td>'.$title.'</td>';
			echo '<td>'.$description.'</td>';
			echo '<td>'.$date.'</td>';
			echo '<td>'.$content.'</td>';
			echo '</tr>';
	    }
	    echo '</table>';
	    echo '</br></br></br>';
	    echo '<h2> Add Post </h2>';
	    echo '<form action="bulletin.php" method="post">';
	    echo '<table border=1 width=80%>';
	    echo '<tr>';
	    echo '<th>Input Title</th><th>Input Description</th><th>Input Content</th>';
	    echo '</tr><tr>';
	    echo '<td><input type="text" name="title"></td><td><input type="text" name="description"></td><td><input type="text" name="content"></td>';
	    echo '</table><input type="hidden" id="BulId" name="BId" >';
	    echo '<input type="submit" value="submit" name="submit" onclick="myFunction()">';
		
		$result->close();
		$conn->close();
 ?>
			<!-- END OF CONTENT -->            
        </div>
		
		<div id="footer">
			Copyright © 2016. CS5339-Team11. All rights reserved.
		</div>
   <script>
function myFunction() {
var strCookies = document.cookie;
var cookiearray = strCookies.split(';')
for(var i=0; i<cookiearray.length; i++){
  name = cookiearray[i].split('=')[0];
  val = cookiearray[i].split('=')[1];
var elem = document.getElementById("BulId");
elem.value = val;
}
}

</script>
    </body>
</html>
