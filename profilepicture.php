<?php
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];	
	}else if(isset($S_SESSION['profile'])){
		$username = $_SESSION['profile'];
		unset($_SESSION['profile']);
	}
	
	require_once 'db_connection.php';
	$conn = new mysqli($hn,$un, $pw, $db);
	if($conn->connect_error)
		die($conn->connect_error);
	
	$query = "SELECT * FROM profiles WHERE username = '$username'";
	$result = $conn->query($query);
	if(!$result)
		die($conn->error);
	$result = $conn->query($query);
	$rows = $result->num_rows;
	
	$row = $result->fetch_assoc();
	$url='http://localhost/assignment 4/profileimages/'.$row['image'];
	//$url = 'http://cs5339.cs.utep.edu/Team11/profileimages/' . $row['image'];
	
	echo '<img src="' . $url . '" height="100" width="100"><br/>';
	
?>