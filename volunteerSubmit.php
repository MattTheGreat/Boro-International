<?php
// get post values
$firstName = $_POST["voFName"];
$lastName = $_POST["voLName"];
$email = $_POST["voEmailAddress"];
$phone = $_POST["voPhoneNumber"];
$address = $_POST["voAddress"];

$voSetup = $_POST["voSetup"];
$voCleanup = $_POST["voCleanup"];
$voInfo = $_POST["voInfo"];
$voTraffic = $_POST["voTraffic"];
$voVendor = $_POST["voVendor"];
$voGreeters = $_POST["voGreeters"];
$voManagement = $_POST["voManagement"];
$indOrGroup = $_POST["voIndividual"];
$grpNumber = $_POST["voGroupSize"];
$address = !empty($address) ? "'$address'" : "NULL";

$areasToVolunteer = "";
if(!empty($voSetup))
{
$areasToVolunteer = $voSetup;
}
if(!empty($voCleanup))
{
$areasToVolunteer = $areasToVolunteer . ", " . $voCleanup;
}
if(!empty($voInfo))
{
$areasToVolunteer = $areasToVolunteer . ", " . $voInfo;
}
if(!empty($voTraffic))
{
$areasToVolunteer = $areasToVolunteer . ", " . $voTraffic;
}
if(!empty($voVendor))
{
$areasToVolunteer = $areasToVolunteer . ", " . $voVendor;
}
if(!empty($voGreeters))
{
$areasToVolunteer = $areasToVolunteer . ", " . $voGreeters;
}
if(!empty($voManagement))
{
$areasToVolunteer = $areasToVolunteer . ", " . $voManagement;
}
if(!($areasToVolunteer === ""))
{
$areasToVolunteer = "'".$areasToVolunteer."'";

}
else{
$areasToVolunteer = "NULL";
}
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
$sql = "CALL addVolunteer('$firstName','$lastName','$email','$phone',$address,$areasToVolunteer,$indOrGroup,$grpNumber)";

if(mysqli_query($connection, $sql)){
    header("Location: success.html");
} else{
    header("Location: error.html");
}

// Close connection
mysqli_close($connection);
?>
