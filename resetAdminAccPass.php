<?php
session_start();

//added session variable so only authorized users can access page

#error_reporting(17);
include("checkLogged.php");
$userID = $_POST["adminUserNameHd"];
$oldPassword = $_POST["oldPassword"];
$password = $_POST["pass"];

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include("db_connect.php");

$connection = db_connect();
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// Attempt insert query execution
$sql = "UPDATE `admin_login` SET password = '".$password."'  WHERE `username` = '" . $userID . "' AND `password` = '".$oldPassword."'";
//echo $sql;

if(mysqli_query($connection, $sql)){
	if(mysqli_affected_rows($connection) >0)
	{
  header("Location: userManagement.php?ret=reset_succ");
	}
	else{
  header("Location: userManagement.php?ret=reset_fail");		
	}
} else{
   echo mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
?>
