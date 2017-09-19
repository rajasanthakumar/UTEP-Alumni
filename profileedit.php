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
			table, th, td {
				border: 1px solid black;
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
		$profile_username = $_SESSION['login_user'];
		
		if(isset($_SESSION['image_url']))
			$profile_image_url = $_SESSION['image_url'];
		if(isset($_SESSION['first_name']))
			$profile_first_name = $_SESSION['first_name'];
		if(isset($_SESSION['last_name']))
			$profile_last_name = $_SESSION['last_name'];
		if(isset($_SESSION['major']))
			$profile_major = $_SESSION['major'];
		if(isset($_SESSION['level']))
			$profile_level = $_SESSION['level'];
		if(isset($_SESSION['degree']))
			$profile_degree = $_SESSION['degree'];
		if(isset($_SESSION['address']))
			$profile_address = $_SESSION['address'];
		if(isset($_SESSION['phone']))
			$profile_phone = $_SESSION['phone'];
		if(isset($_SESSION['email']))
			$profile_email = $_SESSION['email'];
		if(isset($_SESSION['shortbio']))
			$profile_shortbio = $_SESSION['shortbio'];
		
		require_once 'db_connection.php';
		
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error)
			die($conn->connect_error);
		
		$query = "SELECT * FROM Privacy WHERE Privacy.username = '$profile_username'";
		
		$result = $conn->query($query);
		if(!$result)
			die($conn->error);
				
		$row = $result->fetch_assoc();
		$privacy_image = $row['image'];
		$privacy_address = $row['address'];
		$privacy_phone = $row['phonenumber'];
		$privacy_email = $row['email'];
		$privacy_shortbio = $row['shortbio'];
		
		$result->close();
		$conn->close();
		
		//Display profile
		echo $privacy_image;
		echo '<form action="profile.php" method="post">';
		echo '<table>';
		echo '<tr>';
		echo '<th>Your Profile</th><th>Edit Profile</th><th>Edit Privacy</th>';
		echo '</tr>';
		echo '<tr>';
		echo "<td><img src='profileimages/".$profile_image_url."' height='100' width='100'></td>";
		echo '<td><input type="file" name="fileToUpload" id="fileToUpload"></td>';
		
		//Image privacy
		if(strcmp($privacy_image, "public") === 0){
			echo '<td><input type="radio" name="imageRadio" value="public" checked="checked">Public</input><input type="radio" name="imageRadio" value="user">Graduates</input><input type="radio" name="imageRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_image, "graduates") === 0){
			echo '<td><input type="radio" name="imageRadio" value="public">Public</input><input type="radio" name="imageRadio" value="user" checked="checked">Graduates</input><input type="radio" name="imageRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_image, "noone") === 0){
			echo '<td><input type="radio" name="imageRadio" value="public">Public</input><input type="radio" name="imageRadio" value="user">Graduates</input><input type="radio" name="imageRadio" value="none" checked="checked">No one</input></td>';
		} else {
			echo '<td><input type="radio" name="imageRadio" value="public">Public</input><input type="radio" name="imageRadio" value="user">Graduates</input><input type="radio" name="imageRadio" value="none">No one</input></td>';
		}
		
		echo '</tr>';
		echo '<tr>';
		echo '<td>First Name: ' . $profile_first_name . '</td> <td><input type="text" name="fnameText" value="'.$profile_first_name.'"></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Last Name: ' . $profile_last_name . '</td> <td><input type="text" name="lnameText" value="'.$profile_last_name.'"></td> <td>Public</td>';
	    echo '</tr>';
		echo '<tr>';      
		echo '<td>Major: ' . $profile_major . '</td> <td><input type="text" name="majorText" value="'.$profile_major.'"></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Level: ' . $profile_level . '</td> <td><input type="text" name="levelText" value="'.$profile_level.'"></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Degree: ' . $profile_degree . '</td> <td><input type="text" name="degreeText" value="'.$profile_degree.'"></td> <td>Public</td>';
		echo '</tr>';
        echo '<tr>';
        
        echo '<td>Address: ' . $profile_address . '</td> <td><input type="text" name="addressText" value="'.$profile_address.'"></td>';
        //Address privacy
		if(strcmp($privacy_address, "public") === 0){
			echo '<td><input type="radio" name="addressRadio" value="public" checked="checked">Public</input><input type="radio" name="addressRadio" value="user">Graduates</input><input type="radio" name="addressRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_address, "graduates") === 0){
			echo '<td><input type="radio" name="addressRadio" value="public">Public</input><input type="radio" name="addressRadio" value="user" checked="checked">Graduates</input><input type="radio" name="addressRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_address, "noone") === 0){
			echo '<td><input type="radio" name="addressRadio" value="public">Public</input><input type="radio" name="addressRadio" value="user">Graduates</input>Friends</input><input type="radio" name="addressRadio" value="none" checked="checked">No one</input></td>';
		} else {
			echo '<td><input type="radio" name="addressRadio" value="public">Public</input><input type="radio" name="addressRadio" value="user">Graduates</input><input type="radio" name="addressRadio" value="none">No one</input></td>';
		}
		
		echo '</tr>';
		echo '<tr>';
		
		echo '<td>Phone: ' . $profile_phone . '</td> <td><input type="text" name="phoneText" value="'.$profile_phone.'"></td>';
		//Phone privacy
		if(strcmp($privacy_phone, "public") === 0){
			echo '<td><input type="radio" name="phoneRadio" value="public" checked="checked">Public</input><input type="radio" name="phoneRadio" value="user">Graduates</input><input type="radio" name="phoneRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_phone, "graduates") === 0){
			echo '<td><input type="radio" name="phoneRadio" value="public">Public</input><input type="radio" name="phoneRadio" value="user" checked="checked">Graduates</input></input><input type="radio" name="phoneRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_phone, "noone") === 0){
			echo '<td><input type="radio" name="phoneRadio" value="public">Public</input><input type="radio" name="phoneRadio" value="user">Graduates</input><input type="radio" name="phoneRadio" value="none" checked="checked">No one</input></td>';
		} else {
			echo '<td><input type="radio" name="phoneRadio" value="public">Public</input><input type="radio" name="phoneRadio" value="user">Graduates</input><input type="radio" name="phoneRadio" value="none">No one</input></td>';
		}
		
		echo '</tr>';
        echo '<tr>';
        
        echo '<td>Email: ' . $profile_email . '</td> <td><input type="text" name="emailText" value="'.$profile_email.'"></td>';
        //Email privacy
		if(strcmp($privacy_email, "public") === 0){
			echo '<td><input type="radio" name="emailRadio" value="public" checked="checked">Public</input><input type="radio" name="emailRadio" value="user">Graduates</input><input type="radio" name="emailRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_email, "graduates") === 0){
			echo '<td><input type="radio" name="emailRadio" value="public">Public</input><input type="radio" name="emailRadio" value="user" checked="checked">Graduates</input><input type="radio" name="emailRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_email, "noone") === 0){
			echo '<td><input type="radio" name="emailRadio" value="public">Public</input><input type="radio" name="emailRadio" value="user">Graduates</input><input type="radio" name="emailRadio" value="none" checked="checked">No one</input></td>';
		} else {
			echo '<td><input type="radio" name="emailRadio" value="public">Public</input><input type="radio" name="emailRadio" value="user">Graduates</input><input type="radio" name="emailRadio" value="none">No one</input></td>';
		}
		
		echo '</tr>';
		echo '<tr>';
		
		echo '<td>Short Bio: ' . $profile_shortbio . '</td> <td><input type="text" name="shortbioText" value="'.$profile_shortbio.'"></td>';
		//Short Bio privacy
		if(strcmp($privacy_shortbio, "public") === 0){
			echo '<td><input type="radio" name="shortbioRadio" value="public" checked="checked">Public</input><input type="radio" name="shortbioRadio" value="user">Graduates</input><input type="radio" name="shortbioRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_shortbio, "graduates") === 0){
			echo '<td><input type="radio" name="shortbioRadio" value="public">Public</input><input type="radio" name="shortbioRadio" value="user" checked="checked">Graduates</input><input type="radio" name="shortbioRadio" value="none">No one</input></td>';
		} else if (strcmp($privacy_shortbio, "noone") === 0){
			echo '<td><input type="radio" name="shortbioRadio" value="public">Public</input><input type="radio" name="shortbioRadio" value="user">Graduates</input><input type="radio" name="shortbioRadio" value="none" checked="checked">No one</input></td>';
		} else {
			echo '<td><input type="radio" name="shortbioRadio" value="public">Public</input><input type="radio" name="shortbioRadio" value="user">Graduates</input><input type="radio" name="shortbioRadio" value="none">No one</input></td>';
		}
		
		echo '</tr>';
		echo '</table>';                                         
		echo '</br></br><input type="hidden" id="SessId" name="SessdId" >';
		echo '<INPUT type="submit" value="Save" name="submit" onclick="myFunction()">';
		echo '</form>';

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
var elem = document.getElementById("SessId");
elem.value = val;
}
}

</script>
		
    </body>
</html>