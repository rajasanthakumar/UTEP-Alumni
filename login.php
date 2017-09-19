<?php
//session start
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
	//Database login details
	require_once 'db_connection.php';
	
	//connecting to database
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error)
	    die($conn->connect_error);
	
	// Read $username and $password
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// To protect MySQL injection using salting 
	$salt = 'JSSY9283#^$3';
	$pass = md5($username . $salt . $password);
	
	// SQL query to fetch information of registered users
	$query = "select * from users where password='$pass' AND username='$username'";
	$result = $conn->query($query);
	$rows = $result->num_rows;

	// Check if username and password exits
	if ($rows == 1) {
		$row = $result->fetch_assoc();
		$_SESSION['login_user'] = $row['username']; // Initializing Session
		$_SESSION['user_fullname'] = $row['fname'] . ' ' . $row['lname'];
		echo "<script>window.open('index.php','_self')</script>"; // Redirecting to home page
	} else {
		echo "<script>alert(' Invalid Username or password!')</script>";
		echo "<script>window.open('login.php','_self')</script>";
	}
	$result->close();
	$conn->close(); // Closing Connection
}
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
				echo '<a href="logout.php">Log Out</a><br>';
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
            
			<form action="login.php" method="post">
				<table>
					<tr><td><label>Username </label></td>
						<td><input id="name" name="username" placeholder="username" type="text"></td>
					</tr>
					<tr><td><label>Password </label></td>
						<td><input id="password" name="password" placeholder="**********" type="password"></td></tr>
					<tr><td colspan="3" align="center"><input name="submit" type="submit" value=" Login "></td></tr>
				</table>
			</form>
			<b>Not registered?</b> <br/> Click the Register tab';
			
			<!-- END OF CONTENT -->            
        </div>
		
		<div id="footer">
			Copyright © 2016. CS5339-Team11. All rights reserved.
		</div>
    </body>
</html>
