<?php
// get post values
//include("checkLogged.php")
//echo $_POST["adminUserNameHd"];
$userID = $_POST["adminUserNameHd"];
$firstName = $_POST["adminFN"];
$lastName = $_POST["adminLN"];
$password = $_POST["password"];

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include("db_connect.php");

$connection = db_connect();
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// Attempt insert query execution
$sql = "UPDATE `admin_login` SET firstName = '".$firstName."' , lastName = '".$lastName . "' WHERE username = '" . $userID . "' AND password = '".$password."'";
//echo $sql;

if(mysqli_query($connection, $sql)){
	if(mysqli_affected_rows($connection) >0)
	{
   header("Location: userManagement.php?ret=edit_succ");
	}
	else{
   header("Location: userManagement.php?ret=edit_fail");		
	}
} else{
   echo mysqli_error($connection);
}

// Close connection
mysqli_close($connection);
?>
