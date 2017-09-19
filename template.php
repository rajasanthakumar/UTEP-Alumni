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
				echo '<a href="social.php">Social</a><br>';
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
			
			<!-- END OF CONTENT -->            
        </div>
		
		<div id="footer">
			Copyright © 2015. CS5339-Team4. All rights reserved.
		</div>
    </body>
</html>
