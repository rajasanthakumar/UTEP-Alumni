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
        		echo '<a href="profile.php"> Profile</a><br>';
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
			 <h2>CS GRADUATE LIST</h2>
			
			<form method="post" action="list.php">
				<h3> Filter graduates: </h3>
				<label> Major: </label>
	            <select name='major'>
					<option value="any">-- All --</option>
					<option value="CS">CS</option>
					<option value="MIT">MIT</option>
					<option value="CSCI">CSCI</option>
					<option value="SWE">SWE</option>
					<option value="IT">IT</option>
				</select> &emsp;
				
				<label> Level: </label>
	            <select name='level'>
					<option value="any">-- All --</option>
					<option value="UG">Undergraduate</option>
					<option value="GR">Graduate</option>
					<option value="DR">Doctoral</option>
				</select> &emsp;
				
				<label> Year: </label>
	            <select name='year'>
					<option value="any">-- All --</option>
					<?php
					for ($i = 1995; $i <= 2014; $i++) {
						$yos = $i . '-' . substr($i+1, 2);
						echo "<option value='$yos'>$yos</option>";
					}
					?>
				</select> <br>
				
				<h3> Sort graduates: </h3>
				<label> Sort by: </label>
	            <select name='sort_column'>
					<option value="fname">First Name</option>
					<option value="lname">Last Name</option>
					<option value="major">Major</option>
					<option value="yoa">Year of Study</option>
					<option value="level">Level</option>
					<option value="degree">Degree</option>
				</select> &emsp;
				
				<label> Order: </label>
	            <select name='sort_order'>
					<option value="asc">Ascending (A-Z)</option>
					<option value="desc">Descending (Z-A)</option>
				</select><br><br>
	             
	            <input type="submit" name="sort" value="Search"><br>
	        </form>
			<br>
			
			<?php
			$condition = '1=1 ';
			if (isset($_POST['major']) && $_POST['major'] != 'any') $condition .= " AND major='". $_POST['major'] . "' ";
			if (isset($_POST['level']) && $_POST['level'] != 'any') $condition .= " AND level='" . $_POST['level'] . "' ";
			if (isset($_POST['year']) && $_POST['year'] != 'any') $condition .= " AND yoa='" . $_POST['year'] . "' ";
			
			$sort_column = isset($_POST['sort_column']) ? $_POST['sort_column'] : 'fname';
			$sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'asc';
  
			require_once 'db_connection.php';
			$conn = new mysqli($hn, $un, $pw, $db);
			if ($conn->connect_error)
				die($conn->connect_error);
			
			$query = "SELECT * FROM users WHERE $condition order by $sort_column $sort_order ";
			$result = $conn->query($query);
			if (!$result)
				die($conn->error);
			
			$rows = $result->num_rows;
			
			//Displaying the list of registered users in a table
			echo "
			<table border=1 width=80%>
			<tr>
			  	<th>First Name</th>
			  	<th>Last Name</th>
				<th>Major</th>  
				<th>Level</th>
			  	<th>Year of Study</th>	
			  	<th>Degree</th>
			</tr>";
			for ($j = 0; $j < $rows; ++$j) {
				$result->data_seek($j);
				$row = $result->fetch_assoc();
				echo '<tr><td>'. '<a href="userdetails.php?username=' . $row['username'] . '">' . $row['fname'] . '</a> </td>';
				$result->data_seek($j);
				echo '<td>' . $result->fetch_assoc()['lname'] . '</td>';
				$result->data_seek($j);
				echo '<td>' . $result->fetch_assoc()['major'] . '</td>';
				$result->data_seek($j);
				echo '<td>' . $result->fetch_assoc()['level'] . '</td>';
				$result->data_seek($j);
				echo '<td>' . $result->fetch_assoc()['yoa'] . '</td>';
				$result->data_seek($j);
				echo '<td>' . $result->fetch_assoc()['degree'] . '</td></tr>';
			}
			echo '
			</table>';
			$result->close();
			$conn->close();
			?>
			<!-- END OF CONTENT -->            
        </div>
		
		<div id="footer">
			Copyright © 2016. CS5339-Team11. All rights reserved.
		</div>
    </body>
</html>
