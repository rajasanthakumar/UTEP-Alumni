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

	function findUserFromDatabase($username,$result,$rows){
		
		for ($j = 0; $j < $rows; ++$j) {
			
			$result->data_seek($j);
			$check_for_username = $result->fetch_assoc()['username'];
			
			if(strcmp($check_for_username, $username) === 0){
				return $j;
			}
		}
		
		return -1;
		
	}
	
	function upload(){
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	
	if(isset($_POST['submit']) && $_COOKIE["PHPSESSID"]== $_POST['SessdId'])
            {
		//upload();
		
		$username = $_SESSION['login_user'];
		
		$privacy_image;
		if(isset($_POST['imageRadio'])){
			if($_POST['imageRadio'] == "public"){
				$privacy_image = "public";
			}
			else if($_POST['imageRadio'] == "user"){
				$privacy_image = "graduates";
			}
			else if($_POST['imageRadio'] == "none"){
				$privacy_image = "noone";
			}
			else{
				$privacy_image = "noone";
			}
		}else {
			$privacy_image = "noone";
		}
		
		$privacy_phone;
		if(isset($_POST['phoneRadio'])){
			if($_POST['phoneRadio'] == "public"){
				$privacy_phone = "public";
			}
			else if($_POST['phoneRadio'] == "user"){
				$privacy_phone = "graduates";
			}
			else if($_POST['phoneRadio'] == "none"){
				$privacy_phone = "noone";
			}
			else{
				$privacy_phone = "noone";
			}
		}else {
			$privacy_phone = "noone";
		}
		
		$privacy_address;
		if(isset($_POST['addressRadio'])){
			if($_POST['addressRadio'] == "public"){
				$privacy_address = "public";
			}
			else if($_POST['addressRadio'] == "user"){
				$privacy_address = "graduates";
			}
			else if($_POST['addressRadio'] == "none"){
				$privacy_address = "noone";
			}
			else{
				$privacy_address = "noone";
			}
		}else {
			$privacy_address = "noone";
		}
		
		$privacy_email;
		if(isset($_POST['emailRadio'])){
			if($_POST['emailRadio'] == "public"){
				$privacy_email = "public";
			}
			else if($_POST['emailRadio'] == "user"){
				$privacy_email = "graduates";
			}
			else if($_POST['emailRadio'] == "none"){
				$privacy_email = "noone";
			}
			else{
				$privacy_email = "noone";
			}
		}else {
			$privacy_email = "noone";
		}
		
		$privacy_shortbio;
		if(isset($_POST['shortbioRadio'])){
			if($_POST['shortbioRadio'] == "public"){
				$privacy_shortbio = "public";
			}
			else if($_POST['shortbioRadio'] == "user"){
				$privacy_shortbio = "graduates";
			}
			else if($_POST['shortbioRadio'] == "none"){
				$privacy_shortbio = "noone";
			}
			else{
				$privacy_shortbio = "noone";
			}
		}else {
			$privacy_shortbio = "noone";
		}
		
		$fname;
		if(isset($_POST['fnameText']))
			$fname = $_POST['fnameText'];
		else
			$fname = "";
			
		$lname;
		if(isset($_POST['lnameText']))
			$lname = $_POST['lnameText'];
		else
			$lname = "";
			
		$major;
		if(isset($_POST['majorText']))
			$major = $_POST['majorText'];
		else
			$major = "";
			
		$level;
		if(isset($_POST['levelText']))
			$level = $_POST['levelText'];
		else
			$level = "";
			
		$degree;
		if(isset($_POST['degreeText']))
			$degree = $_POST['degreeText'];
		else
			$degree = "";
			
		$address;
		if(isset($_POST['addressText']))
			$address = $_POST['addressText'];
		else
			$address = "";
			
		$phone;
		if(isset($_POST['phoneText']))
			$phone = $_POST['phoneText'];
		else
			$phone = "";
			
		$email;
		if(isset($_POST['emailText']))
			$email = $_POST['emailText'];
		else
			$email = "";
			
		$shortbio;
		if(isset($_POST['shortbioText']))
			$shortbio = $_POST['shortbioText'];
		else
			$shortbio = "";
		
		require_once 'db_connection.php';
		$conn = new mysqli($hn, $un, $pw, $db);
 		if ($conn->connect_error)
 			die($conn->connect_error);
 		
 		$fname = $conn->real_escape_string($fname);
 		$lname = $conn->real_escape_string($lname);
 		$major = $conn->real_escape_string($major);
 		$level = $conn->real_escape_string($level);
 		$degree = $conn->real_escape_string($degree);
 		$address = $conn->real_escape_string($address);
 		$phone = $conn->real_escape_string($phone);
 		$email = $conn->real_escape_string($email);
 		$shortbio = $conn->real_escape_string($shortbio);
 		
 		$query = "SELECT * FROM `profiles` WHERE username = '$username'";
 		$result = $conn->query($query);
 		if(!$result)
 			die($conn->error);
 		if(mysqli_num_rows($result) > 0){
 			mysqli_free_result($result);
 			//$result->close();
 			
 			$sql = "UPDATE `users` SET lname = '$lname',fname = '$fname',major = '$major',level = '$level',degree = '$degree' WHERE username = '$username';";
 			$sql .= "UPDATE `profiles` SET address = '$address',phonenumber = '$phone',email = '$email',shortbio = '$shortbio' WHERE username = '$username';";
 			$sql .= "UPDATE `Privacy` SET image = '$privacy_image',address = '$privacy_address',phonenumber = '$privacy_phone',email = '$privacy_email',shortbio = '$privacy_shortbio' WHERE username = '$username'";
 		} else {
 			mysqli_free_result($result);
 			$result->close();
 			
 			$sql = "UPDATE `users` SET lname = '$lname',fname = '$fname',major = '$major',level = '$level',degree = '$degree' WHERE username = '$username';";
 			$sql .= "INSERT INTO profiles (username,address,phonenumber,email,shortbio) VALUES ('$username','$address','$phone','$email','$shortbio');";
 			$sql .= "INSERT INTO Privacy (image,username,address,phonenumber,email,shortbio) VALUES ('$privacy_image','$username','$privacy_address','$privacy_phone','$privacy_email','$privacy_shortbio')";
 		}
 		if(mysqli_multi_query($conn, $sql)){                                                            
 		}
 		$conn->close();
	}

	if(isset($_SESSION['login_user']) || isset($_SESSION['profile'])){
		
		//Check who's profile to display
		
		if(isset($_SESSION['profile'])){
			
			$profile_username = $_SESSION['profile'];
			unset($_SESSION['profile']);
			$is_user_profile = false;
			
		} else {
			
			$profile_username = $_SESSION['login_user'];
			$is_user_profile = true;
			
		}
		
		$profile_image_url;
		$profile_first_name;
		$profile_last_name;
		$profile_major;
		$profile_level;
		$profile_degree;
		
		require_once 'db_connection.php';
		
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error)
			die($conn->connect_error);

		//Queries from profile table in Database
   
		
		//Queries from users table in Database
		
		$query = "SELECT * FROM users WHERE username = '$profile_username';";
		$query .= "SELECT * FROM profiles WHERE username = '$profile_username'";
		
		$i = 0;
			
		if (mysqli_multi_query($conn, $query)) {
			do {
				// store first result set
				if ($result = mysqli_store_result($conn)) {
					while ($row = mysqli_fetch_row($result)) {
						if($i == 0){
							$profile_first_name = $row[1];
							$profile_last_name = $row[2];
							$profile_major = $row[3];
							$profile_level = $row[4];
							$profile_degree = $row[5];
						}
						else if($i == 1){
							$profile_image_url = $row[10];
							$profile_address = $row[6];
							$profile_phonenumber = $row[7];
							$profile_email = $row[8];
							$profile_shortbio = $row[9];
						}
					}
					mysqli_free_result($result);
				}
				if (mysqli_more_results($conn)) {
					$i ++;
				}
			} while (mysqli_next_result($conn));
		}

		$_SESSION['first_name'] = $profile_first_name;
		$_SESSION['last_name'] = $profile_last_name;
		$_SESSION['major'] = $profile_major;
		$_SESSION['level'] = $profile_level;
		$_SESSION['degree'] = $profile_degree;
		$_SESSION['image_url'] = $profile_image_url;
		$_SESSION['address'] = $profile_address;
		$_SESSION['phone'] = $profile_phonenumber;
		$_SESSION['email'] = $profile_email;
		$_SESSION['shortbio'] = $profile_shortbio;
		
		//Display profile
		
                
		echo "<img src='profileimages/".$profile_image_url."' height='100' width='100'><br/>";
		echo 'First Name: ' . $profile_first_name . "<br/>";
		echo 'Last Name: ' . $profile_last_name . "<br/>";
		echo 'Major: ' . $profile_major . "<br/>";
		echo 'Level: ' . $profile_level . "<br/>";
		echo 'Degree: ' . $profile_degree . "<br/>";
		echo 'Address: ' . $profile_address . "<br/>";
		echo 'Phone Number: ' . $profile_phonenumber . "<br/>";
		echo 'Email: ' . $profile_email . "<br/>";
		echo 'Short Bio: ' . $profile_shortbio . "<br/>";
	
		if($is_user_profile){
			?>
				<br/><br/>
				</br><button onclick="window.location.href='profileedit.php'">Edit</button></html>
			<?php
		}
		
		//$result->close();
		$conn->close();
    } else {
    	echo 'There is no profile to display';
    }
 ?>
			<!-- END OF CONTENT -->            
        </div>
		
		<div id="footer">
			Copyright © 2016. CS5339-Team11. All rights reserved.
		</div>
    </body>
</html>


