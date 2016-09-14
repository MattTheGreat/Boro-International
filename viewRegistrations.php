<?php


/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("mysql.cs.mtsu.edu", "c1185421", "c1185421", "c1185421");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt insert query execution
$sql = "select * from Vendor";

if($result=mysqli_query($link, $sql)){
	if(mysqli_num_rows($result)>0){
  echo "<table border='1'>
  <caption>Vendors</caption>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Email</th>
<th>phone</th>
<th>Address</th>
<th>Vendor Type</th>
<th>Merchant Type</th>
<th>Product Type</th>
<th>Food Description</th>
<th>Exhibition Description</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['firstName'] . "</td>";
echo "<td>" . $row['lastName'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['phone'] . "</td>";
echo "<td>" . $row['address'] . "</td>";
echo "<td>" . $row['vendorTypeME'] . "</td>";
echo "<td>" . $row['merchSubType'] . "</td>";
echo "<td>" . $row['vendorProd'] . "</td>";
echo "<td>" . $row['foodDesc'] . "</td>";
echo "<td>" . $row['exhibitDesc'] . "</td>";
echo "</tr>";
}
echo "</table>";
}
// if there are no records in the database, display an alert message
else
{
echo "No results to display!";
}
}
else
{
	 echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>