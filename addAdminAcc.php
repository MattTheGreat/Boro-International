<?php
session_start();

//added session variable so only authorized users can access page

#error_reporting(17);
include("checkLogged.php");
$userID = $_POST["nuserId"];
$firstName = $_POST["nfirstName"];
$lastName = $_POST["nlastName"];
$password = $_POST["npass"];

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include("db_connect.php");

$connection = db_connect();
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// check user id query execution
$sql = "SELECT username from `admin_login` WHERE `username` = '" . $userID . "'";
//echo $sql;

if($result=mysqli_query($connection, $sql)){
	if(mysqli_num_rows($result) >0)
	{
  header("Location: userManagement.php?ret=user_same");
	}
	else{
		$sql = "INSERT INTO `admin_login`(`username`, `firstName`, `lastName`, `password`) values('".$userID."','".$firstName."','".$lastName."','".$password."')";
		//echo $sql;
		if($result=mysqli_query($connection, $sql)&& mysqli_affected_rows($connection) >0)
	{
  header("Location: userManagement.php?ret=user_succ");
	}
	
 	
	}
} else{
   echo mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
?>
