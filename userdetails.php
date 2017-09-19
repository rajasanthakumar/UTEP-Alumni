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
			$username = $_GET['username'];
			
			require_once 'db_connection.php';
			$conn = new mysqli($hn, $un, $pw, $db);
			if ($conn->connect_error)
				die($conn->connect_error);
			
			$query = "SELECT * FROM users WHERE username = '$username';";
			$query .= "SELECT * FROM profiles WHERE username = '$username';";
			$query .= "SELECT * FROM Privacy WHERE username = '$username';";
			
			$profile_lname;
			$profile_fname;
			$profile_major;
			$profile_level;
			$profile_degree;
			
			$profile_image;
			$profile_address;
			$profile_phone;
			$profile_email;
			$profile_shortbio;
			
			
			$privacy_image;
			$privacy_address;
			$privacy_phone;
			$privacy_email;
			$privacy_shortbio;
			
			$i = 0;
			
			if (mysqli_multi_query($conn, $query)) {
				do {
					// store first result set
					if ($result = mysqli_store_result($conn)) {
						while ($row = mysqli_fetch_row($result)) {
							
							if($i == 0){
								$profile_lname = $row[2];
								$profile_fname = $row[1];
								$profile_major = $row[3];
								$profile_level = $row[4];
								$profile_degree = $row[5];
							}
							
							else if($i == 1){
								$profile_image = $row[10];
								$profile_address = $row[6];
								$profile_phone = $row[7];
								$profile_email = $row[8];
								$profile_shortbio = $row[9];
							}
							
							else if($i == 2){
								$privacy_image = $row[4];
								$privacy_address = $row[1];
								$privacy_phone = $row[5];
								$privacy_email = $row[2];
								$privacy_shortbio = $row[3];
							}
						}
						mysqli_free_result($result);
					}
					if (mysqli_more_results($conn)) {
						$i ++;
					}
				} while (mysqli_next_result($conn));
			}
			
			$isgraduate = false;
			$hisusername;
			if(isset($_SESSION['login_user'])){
				$isgraduate = true;
				$hisusername = $_SESSION['login_user'];
			}
			
			if(strcmp($privacy_image,"public") === 0){
				echo "<img src='profileimages/$profile_image' height='100' width='100'><br/>";
			} else if(strcmp($privacy_image,"graduates") === 0 && $isgraduate){
				echo "<img src='profileimages/$profile_image' height='100' width='100'><br/>";
			} 			
			echo 'First Name: ' . $profile_fname . '</br>';
			echo 'Last Name: ' . $profile_lname . '</br>';
			echo 'Major: ' . $profile_major . '</br>';
			echo 'Level: ' . $profile_level . '</br>';
			echo 'Degree: ' . $profile_degree . '</br>';
			
			if(strcmp($privacy_address,"public") === 0){
				echo 'Address: ' . $profile_address . '</br>';
			} else if(strcmp($privacy_address,"graduates") === 0 && $isgraduate){
				echo 'Address: ' . $profile_address . '</br>';
			} 
			
			if(strcmp($privacy_phone,"public") === 0){
				echo 'Phone: ' . $profile_phone . '</br>';
			} else if(strcmp($privacy_phone,"graduates") === 0 && $isgraduate){
				echo 'Phone: ' . $profile_phone . '</br>';
			} 
			
			if(strcmp($privacy_email,"public") === 0){
				echo 'Email: ' . $profile_email . '</br>';
			} else if(strcmp($privacy_email,"graduates") === 0 && $isgraduate){
				echo 'Email: ' . $profile_email . '</br>';
			} 
			
			if(strcmp($privacy_shortbio,"public") === 0){
				echo 'Short Bio: ' . $profile_shortbio . '</br>';
			} else if(strcmp($privacy_shortbio,"graduates") === 0 && $isgraduate){
				echo 'Short Bio: ' . $profile_shortbio . '</br>';
			} 
			
			$conn->close(); // Closing Connection
			?>	
			<!-- END OF CONTENT -->            
        </div>
		
		<div id="footer">
			Copyright © 2016. CS5339-Team11. All rights reserved.
		</div>
    </body>
</html>
