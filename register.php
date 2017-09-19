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
		
		if (!isset($_SESSION['login_user'])) {
		//Display 
		echo '<form action="register.php" method="post">';
		echo '<table>';
		echo '<tr>';
		echo '<th colspan="2">Profile</th><th>Privacy</th>';
		echo '</tr>';
		echo '<tr>';
		echo "<td><img src='profileimages/' height='100' width='100' alt='profile-pic'></td>";
		echo '<td><input type="file" name="fileToUpload" id="fileToUpload"></td>';
		
		//Image privacy
		echo '<td><input type="radio" name="imageRadio" value="public">Public</input><input type="radio" name="imageRadio" value="graduates">Graduates</input><input type="radio" name="imageRadio" value="none">No one</input></td>';

		echo '</tr>';
		echo '<tr>';
		echo '<td>User Name:</td> <td><input type="text" name="unameText" value=""></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Password:</td> <td><input type="password" name="pwd" value=""></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Confirm Password:</td> <td><input type="password" name="pwd1" value=""></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>First Name:</td> <td><input type="text" name="fnameText" value=""></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Last Name:</td> <td><input type="text" name="lnameText" value=""></td> <td>Public</td>';
	    echo '</tr>';
		echo '<tr>';      
		echo '<td>Major:</td> <td><input type="text" name="majorText" value=""></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Level:</td> <td><input type="text" name="levelText" value=""></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Degree:</td> <td><input type="text" name="degreeText" value=""></td> <td>Public</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Year of Study:</td> <td><input type="text" name="YearText" value=""></td> <td>Public</td>';
		echo '</tr>';
        echo '<tr>';
        
        echo '<td>Address:</td> <td><input type="text" name="addressText" value=""></td>';
        //Address privacy
		
		echo '<td><input type="radio" name="addressRadio" value="public">Public</input><input type="radio" name="addressRadio" value="graduates">Graduates</input><input type="radio" name="addressRadio" value="none">No one</input></td>';
		
		echo '</tr>';
		echo '<tr>';
		
		echo '<td>Phone:</td> <td><input type="text" name="phoneText" value=""></td>';
		//Phone privacy
		
			echo '<td><input type="radio" name="phoneRadio" value="public">Public</input><input type="radio" name="phoneRadio" value="graduates">Graduates</input><input type="radio" name="phoneRadio" value="none">No one</input></td>';
		
		
		echo '</tr>';
        echo '<tr>';
        
        echo '<td>Email:</td> <td><input type="text" name="emailText" value=""></td>';
        //Email privacy
		
		echo '<td><input type="radio" name="emailRadio" value="public">Public</input><input type="radio" name="emailRadio" value="graduates">Graduates</input><input type="radio" name="emailRadio" value="none">No one</input></td>';
				
		echo '</tr>';
		echo '<tr>';
		
		echo '<td>Short Bio:</td> <td><input type="text" name="shortbioText" value=""></td>';
		//Short Bio privacy
		
			echo '<td><input type="radio" name="shortbioRadio" value="public">Public</input><input type="radio" name="shortbioRadio" value="graduates">Graduates</input><input type="radio" name="shortbioRadio" value="none">No one</input></td>';
		
		echo '</tr>';
		echo '</table>';                                         
		echo '<INPUT type="submit" value="Register" name="register">';
		echo '</form>';
		}
		
 ?>
		
		
			<!-- END OF CONTENT -->            
        </div>
		
		<div id="footer">
			Copyright © 2016. CS5339-Team11. All rights reserved.
		</div>
    </body>
</html>
<?php
require_once 'db_connection.php';

// Fetching data from the form 
if (isset($_POST['register'])) {

    $username = $_POST['unameText'];
    $password = $_POST['pwd'];
    $confirmpassword = $_POST['pwd1'];
	$fname = $_POST['fnameText'];
 	$lname = $_POST['lnameText'];
 	$major = $_POST['majorText'];
 	$level = $_POST['levelText'];
 	$degree = $_POST['degreeText'];
 	$address = $_POST['addressText'];
 	$phone = $_POST['phoneText'];
 	$email = $_POST['emailText'];
 	$shortbio = $_POST['shortbioText'];
	$image=$_POST['fileToUpload'];
	$imageprivacy=$_POST['imageRadio'];
	$addressprivacy=$_POST['addressRadio'];
	$phoneprivacy=$_POST['phoneRadio'];
	$emailprivacy=$_POST['emailRadio'];
	$shortbioprivacy=$_POST['shortbioRadio'];
	$year=$_POST['YearText'];
    
//Displaying alerts when field is left empty

    if ($fname == '') {
        echo"<script>alert('Please enter the First Name')</script>";
        exit();
    }
	if ($lname == '') {
        echo"<script>alert('Please enter the Last Name')</script>";
        exit();
    }
	if ($major == '') {
        echo"<script>alert('Please enter the Major')</script>";
        exit();
    }
	if ($level == '') {
        echo"<script>alert('Please enter the level')</script>";
        exit();
    }
	if ($degree == '') {
        echo"<script>alert('Please enter the Degree')</script>";
        exit();
    }
	if ($address == '') {
        echo"<script>alert('Please enter the address')</script>";
        exit();
    }

	if ($phone == '') {
        echo"<script>alert('Please enter the phone Number')</script>";
        exit();
    }
	
	if ($email == '') {
        echo"<script>alert('Please enter the E-mail')</script>";
        exit();
    }
	if ($shortbio == '') {
        echo"<script>alert('Please enter the ShortBio')</script>";
        exit();
    }
    if ($username == '') {
        echo"<script>alert('Please enter the user name')</script>";
        exit();
    }

    if ($password == '') {
        echo"<script>alert('Please enter the password')</script>";
        exit();
    }
	 if ($year == '') {
        echo"<script>alert('Please enter the Year of Study')</script>";
        exit();
    }

    if ($confirmpassword == '') {
        echo"<script>alert('Please re-enter the password')</script>";
        exit();
    }
    if ($password != $confirmpassword) {
        echo"<script>alert('Passwords do not match.Please enter matching passwords.')</script>";
        exit();
    }
	
	$conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error)
        die($conn->connect_error);

	
    $username = mysql_entities_fix_string($conn, $_POST['unameText']);
	$password  = mysql_entities_fix_string($conn, $_POST['pwd']);
	$fname = mysql_entities_fix_string($conn, $_POST['fnameText']);
	$lname = mysql_entities_fix_string($conn, $_POST['lnameText']);
	$major = mysql_entities_fix_string($conn, $_POST['majorText']);
	$level= mysql_entities_fix_string($conn, $_POST['levelText']);
	$degree = mysql_entities_fix_string($conn, $_POST['degreeText']);
	$address = mysql_entities_fix_string($conn, $_POST['degreeText']);
	$phone= mysql_entities_fix_string($conn, $_POST['phoneText']);
	$email = mysql_entities_fix_string($conn, $_POST['emailText']);
	$shortbio = mysql_entities_fix_string($conn, $_POST['shortbioText']);
    $year = mysql_entities_fix_string($conn, $_POST['YearText']);

    $check_uname_query = "select * from users WHERE username='$username'";
    $result = $conn->query($check_uname_query);


    if (!$result)
        die($conn->error);
    $rows = $result->num_rows;

// Check if username already exists. 

    if ($rows > 0) {
        echo "<script>alert(' $username already exists in our database, Please try another one!')</script>";
        exit();
    }

// Salting Password
    $salt = 'JSSY9283#^$3';
	$pass = md5($username . $salt . $password);

// Inserting values into the database
    $insert_user = "insert into users (username,fname,lname,major,level,degree,address,phonenumber,email,shortbio,password,yoa) VALUE ('$username','$fname','$lname','$major','$level','$degree','$address','$phone','$email','$shortbio','$pass','$year')";
    $result1 = $conn->query($insert_user);
    if (!$result1)
        die("Database access failed: " . $conn->error);
	
	$insert_profile = "insert into profiles (username,fname,lname,major,level,degree,address,phonenumber,email,shortbio,image) VALUE ('$username','$fname','$lname','$major','$level','$degree','$address','$phone','$email','$shortbio','$image')";
    $result2 = $conn->query($insert_profile);
    if (!$result2)
        die("Database access failed: " . $conn->error);

	$insert_privacy = "insert into Privacy (username,address,phonenumber,email,shortbio,image) VALUE ('$username','$addressprivacy','$phoneprivacy','$emailprivacy','$shortbioprivacy','$imageprivacy')";
    $result3 = $conn->query($insert_privacy);
    if (!$result3)
        die("Database access failed: " . $conn->error);

	
    if ($result1 && $result2 && $result3) {
        echo "<script>alert(' REGISTERED SUCCESSFULLY!')</script>";
        echo"<script>window.open('index.php','_self')</script>";
    }

    $result->close();
    $conn->close();
}
function mysql_entities_fix_string($connection, $string)
  {
    return htmlentities(mysql_fix_string($connection, $string));
  }	

function mysql_fix_string($connection, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
  }

?>  