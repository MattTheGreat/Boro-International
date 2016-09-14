<?php
// get post values
$firstName = $_POST["enFName"];
$lastName = $_POST["enLName"];
$email = $_POST["enEmailAddress"];
$phone = $_POST["enPhoneNumber"];
$address = $_POST["enAddress"];
$actName = $_POST["enAct"];
$song = $_POST["enSong"];
$inst = $_POST["enInstrument"];
$dance = $_POST["enDance"];
$actDesc = $_POST["enDescription"];
$indOrGroup = $_POST["enGroup"];
$numOfGroupMem = $_POST["grpNumber"];
$grpNumber = $_POST["grpNumber"];

$address = !empty($address) ? "'$address'" : "NULL";
$actName = !empty($actName) ? "'$actName'" : "NULL";
$perfType = "";
if(!empty($song))
{
$perfType = $song;
}
if(!empty($inst))
{
$perfType = $perfType . ", " . $inst;
}
if(!empty($dance))
{
$perfType = $perfType . ", " . $dance;
}
if(!($perfType === ""))
{
$perfType = "'".$perfType."'";

}
else{
$perfType = "NULL";
}

$actDesc = !empty($actDesc) ? "'$actDesc'" : "NULL";
$indOrGroup = !empty($indOrGroup) ? "'$indOrGroup'" : "NULL";
$grpNumber = !empty($grpNumber) ? "'$grpNumber'" : "NULL";

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include("db_connect.php");

$connection = db_connect();
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


// Attempt insert query execution
$sql = "CALL addEnter('$firstName','$lastName','$email','$phone',$address,$actName,$perfType,$actDesc,$indOrGroup,$grpNumber)";

if(mysqli_query($connection, $sql)){
    header("Location: success.html");
} else{
    header("Location: error.html");
}

// Close connection
mysqli_close($connection);
?>
