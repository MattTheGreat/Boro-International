<?php
// get post values
$nationRepresented = $_POST["veNation"];
$firstName = $_POST["veVendorFName"];
$lastName = $_POST["veVendorLName"];
$email = $_POST["veEmailAddress"];
$phone = $_POST["vePhoneNumber"];
$address = $_POST["veAddress"];
$vendorTypeME = $_POST["rbVendorType"];
$merchSubType  = $_POST["rbMerchType"];
// vendor product
$veArt = $_POST["veArt"];
$veJewelry = $_POST["veJewelry"];
$veClothing = $_POST["veClothing"];
$tbOther = $_POST["tbOther"];
$foodDesc = $_POST["veFoodDiscription"];
$exhibitDesc = $_POST["veExhibitInfo"];

$nationRepresented = !empty($nationRepresented) ? "'$nationRepresented'" : "NULL";
$address = !empty($address) ? "'$address'" : "NULL";
$vendorTypeME = !empty($vendorTypeME) ? "'$vendorTypeME'" : "NULL";
$merchSubType = !empty($merchSubType) ? "'$merchSubType'" : "NULL";
$foodDesc = !empty($foodDesc) ? "'$foodDesc'" : "NULL";
$exhibitDesc = !empty($exhibitDesc) ? "'$exhibitDesc'" : "NULL";

$vendorProd = "";
if(!empty($veArt))
{
$vendorProd = $veArt;
}
if(!empty($veJewelry))
{
$vendorProd = $vendorProd . ", " . $veJewelry;
}
if(!empty($veClothing))
{
$vendorProd = $vendorProd . ", " . $veClothing;
}
if(!empty($tbOther))
{
$vendorProd = $vendorProd . ", " . $tbOther;
}
if(!($vendorProd === ""))
{
$vendorProd = "'".$vendorProd."'";

}
else{
$vendorProd = "NULL";
}
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include("db_connect.php");

$connection = db_connect();
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Attempt insert query execution
$sql = "CALL addVendor($nationRepresented,'$firstName','$lastName','$email','$phone',$address,$vendorTypeME,$merchSubType, $vendorProd,$foodDesc,$exhibitDesc)";

if(mysqli_query($connection, $sql)){
    header("Location: success.html");
} else{
    header("Location: error.html");
}

// Close connection
mysqli_close($connection);
?>
