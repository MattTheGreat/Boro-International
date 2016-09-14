<?php
// get post values
session_start();

//added session variable so only authorized users can access page

#error_reporting(17);
include("checkLogged.php");

$userID = $_POST["adminUserNameHd"];
$password = $_POST["pass"];

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include("db_connect.php");

$connection = db_connect();
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// check user id query execution


$sql = "DELETE FROM `admin_login` WHERE `username` ='".$userID."' and `password` = '".$password."'" ;
$result = mysqli_query($connection, $sql);
if($result && mysqli_affected_rows($connection) >0)
{
	  header("Location: userManagement.php");
}
else
{
	header("Location: userManagement.php?ret=errDel");
	
}

// Close connection
mysqli_close($connection);
?>
