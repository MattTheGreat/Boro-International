<?php
session_start();

//added session variable so only authorized users can access page

#error_reporting(17);
include("checkLogged.php");
include("db_connect.php");
// Attempt insert query execution
$connection = db_connect();

// Check connection
if(!$connection){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// accept vendor
if(isset($_GET["type"]) && $_GET["type"] =="accVend")
{
$sql = "UPDATE `Vendor` SET `Status` = 2, `lastProcessingDate` = CURRENT_TIMESTAMP, `processedBy`='".$_SESSION["user"]."'  WHERE `vendorId` =".$_GET['id'] ;

}
else if(isset($_GET["type"]) && $_GET["type"] =="rejVend")
{

$sql = "UPDATE `Vendor` SET `Status` = 3, `lastProcessingDate` = CURRENT_TIMESTAMP, `processedBy`='".$_SESSION["user"]."'  WHERE `vendorId` =".$_GET['id'] ;

}
else if(isset($_GET["type"]) && $_GET["type"] =="accEnt")
{

$sql = "UPDATE `entertainer` SET `Status` = 2, `lastProcessingDate` = CURRENT_TIMESTAMP, `processedBy`='".$_SESSION["user"]."'  WHERE `enterId` =".$_GET['id'] ;

}
else if(isset($_GET["type"]) && $_GET["type"] =="rejEnt")
{

$sql = "UPDATE `entertainer` SET `Status` = 3, `lastProcessingDate` = CURRENT_TIMESTAMP, `processedBy`='".$_SESSION["user"]."'  WHERE `enterId` =".$_GET['id'] ;

}
else if(isset($_GET["type"]) && $_GET["type"] =="accVol")
{

$sql = "UPDATE `Volunteer` SET `Status` = 2, `lastProcessingDate` = CURRENT_TIMESTAMP, `processedBy`='".$_SESSION["user"]."'  WHERE `volunteerId` =".$_GET['id'] ;

}
else if(isset($_GET["type"]) && $_GET["type"] =="rejVol")
{

$sql = "UPDATE `Volunteer` SET `Status` = 3, `lastProcessingDate` = CURRENT_TIMESTAMP, `processedBy`='".$_SESSION["user"]."'  WHERE `volunteerId` =".$_GET['id'] ;

}
if(isset($_GET["type"])){
if(!mysqli_query($connection, $sql))
{
	echo mysqli_error($connection);
}
}
$sql = "SELECT * FROM `Vendor` as v INNER JOIN `ApplicationStatus` as a ON v.Status = a.status_id ";
$vendors = mysqli_query($connection, $sql);
$sql = "SELECT * FROM `entertainer` as e INNER JOIN `ApplicationStatus` as a ON e.Status = a.status_id ";
$enters = mysqli_query($connection, $sql);
$sql = "SELECT * FROM `Volunteer` as vol INNER JOIN `ApplicationStatus` as a ON vol.Status = a.status_id ";
$volunteers = mysqli_query($connection, $sql);

$vendor_num = mysqli_num_rows($vendors);
$sql = "SELECT COUNT(vendorId) as num_food FROM `Vendor` where vendorTypeME = 'MERCHANDISER' AND merchSubType='Food' ";

$num_food_data = mysqli_query($connection, $sql);
$vendor_food_num = mysqli_fetch_assoc($num_food_data)['num_food'] ;

$sql = "SELECT COUNT(vendorId) as num_prod FROM `Vendor` where vendorTypeME = 'MERCHANDISER' AND merchSubType = 'Product' ";

$num_prod_data = mysqli_query($connection, $sql);
$vendor_prod_num = mysqli_fetch_assoc($num_prod_data)['num_prod'] ;

$sql = "SELECT COUNT(vendorId) as num_exh FROM `Vendor` where vendorTypeME = 'EXHIBITOR' ";

$num_exh_data = mysqli_query($connection, $sql);
$vendor_exh_num = mysqli_fetch_assoc($num_exh_data)['num_exh'] ;

$enters_num = mysqli_num_rows($enters);
$volunt_num = mysqli_num_rows($volunteers);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="description" content="Developed By M Abdur Rokib Promy">
        <meta name="keywords" content="Admin, Bootstrap 3, Template, Theme, Responsive">
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- google font -->
       <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
        <!-- Theme style -->

		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="images/favicon.jpg" rel="shortcut icon">
        <script src="js/jquery.min.js" type="text/javascript"></script>


        <!-- Director App -->
        <script src="js/Director/app.js" type="text/javascript"></script>
		 <script src="js/jquery.js" type="text/javascript"></script>
		 <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(
		function(){
		$(".vendorView").click(
		function(){
		var recordno = $(this).attr("data-record");
        var data = getDataFromTable(recordno);
        populateModalForm(data,recordno);
        $("#vendorMod").modal();
		}
		);

	function getDataFromTable(recordno)
{
    var data = {};

    $("#"+recordno +" [name]").each(function()
    {
        data["'"+$(this).attr("name")+"'"] = $(this).html();

    });

    return data;
}

function populateModalForm(data,rowid)
{
    //select all input elements having name attribute

	$("#exhVenddr").css("display","");
	$("#merchType").css("display","");
	$("#vendPrd").css("display","");
	$("#FdDesc").css("display","");
    $("#vendorMod [name]").each(function()
    {
		var attName = $(this).attr("name");
		if(attName == "vendorType" && data["'"+attName+"'"] =="MERCHANDISER")
		{
			$("#exhVenddr").css("display","none");
		}
		if(attName == "vendorType" && data["'"+attName+"'"] =="EXHIBITOR")
		{

			$("#merchType").css("display","none");
	$("#vendPrd").css("display","none");
	$("#FdDesc").css("display","none");
		}
		if(attName == "vendorId")
		{
 $(this).val(data["'"+$(this).attr("name")+"'"]);
		}
		else{
         $(this).html(data["'"+$(this).attr("name")+"'"]);
		}


    });

}

function populateModalEnterForm(data,rowid)
{
    $("#enterMod [name]").each(function()
    {
		var attName = $(this).attr("name");
		if(attName == "enterId")
		{
 $(this).val(data["'"+$(this).attr("name")+"'"]);
		}
else{
         $(this).html(data["'"+$(this).attr("name")+"'"]);
}
}

  );


}


function populateModalVolForm(data,rowid)
{
    $("#volMod [name]").each(function()
    {
		var attName = $(this).attr("name");
		if(attName == "volId")
		{
 $(this).val(data["'"+$(this).attr("name")+"'"]);
		}
else{
         $(this).html(data["'"+$(this).attr("name")+"'"]);
}
}

  );


}

$(".enterView").click(
		function(){
		var recordno = $(this).attr("data-record");
        var data = getDataFromTable(recordno);
        populateModalEnterForm(data,recordno);
        $("#enterMod").modal();
		}
		);


$(".volView").click(
		function(){
		var recordno = $(this).attr("data-record");
        var data = getDataFromTable(recordno);
        populateModalVolForm(data,recordno);
        $("#volMod").modal();
		}
		);

   $('#vendorAccept').click(function(){
        var id = $(this).attr('value');
		window.location="admin.php?type=accVend&id="+id;
		return true;
   });

	 $('#vendorReject').click(function(){
        var id = $(this).attr('value');
		window.location="admin.php?type=rejVend&id="+id;
		return true;
   });

	 $('#enterAccept').click(function(){
        var id = $(this).attr('value');
		window.location="admin.php?type=accEnt&id="+id;
		return true;
   });

	 $('#enterReject').click(function(){
        var id = $(this).attr('value');
		window.location="admin.php?type=rejEnt&id="+id;
		return true;
   });

	 $('#volAccept').click(function(){
        var id = $(this).attr('value');
		window.location="admin.php?type=accVol&id="+id;
		return true;
   });

	 $('#volReject').click(function(){
        var id = $(this).attr('value');
		window.location="admin.php?type=rejVol&id="+id;
		return true;
   });


		}
);



		</script>
		<style>
		.borderless td, .borderless tr{
			border:none !important;
		}
		</style>

    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">

            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
	<i class="fa fa-flag" style="color:#f39c12">

	</i>
			   Admin
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">

                        <div class="pull-left info">
                            <p>Hello, <?php echo $_SESSION["Name"]; ?></p>

                        </div>
                    </div>
                    <!-- search form -->

                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="admin.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="userManagement.php">
                                <i class="fa fa-gavel"></i> <span>Users</span>
                            </a>
                        </li>
						 <li>
                            <a href="logout.php">
                                <i class="fa fa-power-off"></i> <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
<div class="row" style="margin-bottom:5px;">


                        <div class="col-md-2">
                            <div class="sm-st clearfix">
                                <span class="sm-st-icon st-red"><i class="fa fa-cutlery"></i></span>
                                <div class="sm-st-info">
                                    <span><?php echo $vendor_food_num ?></span>
                                    Total Food Vendors
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sm-st clearfix">
                                <span class="sm-st-icon st-violet"><i class="fa fa-shopping-cart"></i></span>
                                <div class="sm-st-info">
                                    <span><?php echo $vendor_prod_num ?></span>
                                    Total Product Vendors
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sm-st clearfix">
                                <span class="sm-st-icon st-blue"><i class="fa fa-picture-o"></i></span>
                                <div class="sm-st-info">
                                    <span><?php echo $vendor_exh_num ?></span>
                                    Total Exhibitors
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="sm-st clearfix">
                                <span class="sm-st-icon st-green"><i class="fa fa-music"></i></span>
                                <div class="sm-st-info">
                                    <span><?php echo $enters_num; ?></span>
                                    Total Entertainers
                                </div>
                            </div>
                        </div>
						 <div class="col-md-4">
                            <div class="sm-st clearfix">
                                <span class="sm-st-icon st-green"><i class="fa fa-user"></i></span>
                                <div class="sm-st-info">
                                    <span><?php echo $volunt_num ?></span>
                                    Total Volunteers
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <header class="panel-heading">
                                  <strong>Vendors</strong>
                                </header>
                                <div class="panel-body table-responsive">
								<?php
								if($vendor_num >0){
  echo '<table class="table table-bordered table-hover">
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>E-mail</th>
<th>Phone</th>
<th>Vendor Type</th>
<th>Status</th>
</tr>';

while($row = mysqli_fetch_array($vendors))
{
echo "<tr id='vendor". $row['vendorId'] ."'>";
echo "<td><a href='#' class='vendorView' name='vendorFN' data-record='vendor". $row['vendorId'] ."'>" . $row['firstName'] . "</a></td>";
echo "<td name='vendorLN'>" . $row['lastName'] . "</td>";
echo "<td name='vendorEmail'>" . $row['email'] . "</td>";
echo "<td name='vendorPh'>" . $row['phone'] . "</td>";
echo "<td name='vendorType'>" . $row['vendorTypeME'] . "</td>";
echo "<td name='vendorAdd' style='display:none'>".$row['address']."</td>";
echo "<td name='merchSubType' style='display:none'>".$row['merchSubType']."</td>";
echo "<td name='vendorProd' style='display:none'>".$row['vendorProd']."</td>";
echo "<td name='foodDesc' style='display:none'>".$row['foodDesc']."</td>";
echo "<td name='exhibitDesc' style='display:none'>".$row['exhibitDesc']."</td>";
echo "<td name='registrationDate' style='display:none'>".$row['registrationDate']."</td>";
echo "<td name='nationRepresented' style='display:none'>".$row['nationRepresented']."</td>";
echo "<td name='vendorId' style='display:none'>".$row['vendorId']."</td>";
switch($row['Status'])
{
case 1: {
	echo "<td ><span class='label label-warning'>" . $row['status_desc'] . "</span></td>";
}
break;
case 2:{
	echo "<td><span class='label label-success'>" . $row['status_desc'] . "</span></td>";
}
break;
case 3:{
	echo "<td><span class='label label-danger'>" . $row['status_desc'] . "</span></td>";
}
break;

}
echo "</tr>";
}
echo "</table>";
}
else
{
	echo "<b>No Data Found</b>";

}
?>



                                   <!-- <div class="table-foot">
                                        <ul class="pagination pagination-sm no-margin pull-right">
                                        <li><a href="#">&laquo;</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">&raquo;</a></li>
                                    </ul>
                                    </div>-->

                                </div><!-- /.panel-body -->
                            </div><!-- /.panel -->
						</div><!-- /.col -->
						<!-- Trigger the modal with a button -->
<!-- Modal -->
<div id="vendorMod" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="logo modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Vendor Application</h4>
      </div>
      <div class="modal-body">
	  <table  class="table borderless" width="100%" align="center">
	  <tr>
	  <td>
        First Name :
		</td>
		<td name="vendorFN">
		</td>
		<td>
		Last Name :
</td>
<td name="vendorLN">
		</td>
      </tr>
	  <tr>
	  <td>Email : </td><td name="vendorEmail">
		</td>
		<td>
		 Phone :</td><td name="vendorPh">
		</td>
      </tr>
	  <tr>
	  <td>
       Address : </td><td name="vendorAdd">
		</td>
		<td>
		Nation Represented : </td><td name="nationRepresented">
		</td>
      </tr>
	  <tr>
	  <td>
        Vendor Type : </td><td name="vendorType">
		</td>
		<td id="merchType">Merchandiser Type :</td>
		<td name="merchSubType" id="merchType">
		</td>
      </tr>
	  <tr>
	  <td id="vendPrd">
        Vendor Product :</td>
		<td name="vendorProd" id="vendPrd">
		</td>
		<td id="FdDesc">
		 Food Description :</td><td name="foodDesc" id="FdDesc">
		</td>
      </tr>
	  <tr>
	  <td id="exhVenddr">
       Exhibition Description :</td>
	   <td name="exhibitDesc" id="exhVenddr">
		</td>
		<td>
		 Registration Date :</td>
		 <td name="registrationDate">
		</td>
      </tr>
	  <tr>
	  <td  colspan="4" align="center">
	  <button class="btn btn-success"  name="vendorId" id="vendorAccept"><i class="fa fa-check" aria-hidden="true"></i></button>&nbsp;&nbsp;
	  <button class="btn btn-danger"  name="vendorId" id="vendorReject"><i class="fa fa-times" aria-hidden="true"></i></button></td>
	  </tr>
	  </table>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

                    </div><!-- /.row -->

					<!-- Entertainer and Volunteer data-->
					 <div class="row">
                        <div class="col-md-6">
                            <div class="panel">
                                <header class="panel-heading">
                                  <strong>Entertainers</strong>
                                </header>
                                <div class="panel-body table-responsive">
								<?php
								if($enters_num > 0){
  echo '<table class="table table-bordered table-hover">
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>E-mail</th>
<th>Phone</th>
<th>Performance Type</th>
<th>Status</th>
</tr>';
while($row = mysqli_fetch_array($enters))
{
echo "<tr id='enter". $row['enterId'] ."'>";
echo "<td><a href='#' class='enterView' name='enterFN' data-record='enter". $row['enterId'] ."'>" . $row['firstName'] . "</a></td>";
echo "<td name='enterLN'>" . $row['lastName'] . "</td>";
echo "<td name='enterEmail'>" . $row['email'] . "</td>";
echo "<td name='enterPh'>" . $row['phone'] . "</td>";
echo "<td name='enterPerfType'>".$row['performanceType']."</td>";
echo "<td name='enterAdd' style='display:none'>".$row['address']."</td>";
echo "<td name='enterAct' style='display:none'>".$row['actName']."</td>";
echo "<td name='enterDesc' style='display:none'>".$row['actDesc']."</td>";
echo "<td name='enterIndOrGrp' style='display:none'>".$row['indOrGroup']."</td>";
echo "<td name='enterNumOfGrp' style='display:none'>".$row['numOfGroupMem']."</td>";
echo "<td name='enterRegistrationDate' style='display:none'>".$row['registrationDate']."</td>";
echo "<td name='enterId' style='display:none'>".$row['enterId']."</td>";
switch($row['Status'])
{
case 1: {
	echo "<td ><span class='label label-warning'>" . $row['status_desc'] . "</span></td>";
}
break;
case 2:{
	echo "<td><span class='label label-success'>" . $row['status_desc'] . "</span></td>";
}
break;
case 3:{
	echo "<td><span class='label label-danger'>" . $row['status_desc'] . "</span></td>";
}
break;

}
echo "</tr>";
}
echo "</table>";
}
else
{
	echo "<b>No Data Found</b>";

}
?>

                                   <!-- <div class="table-foot">
                                        <ul class="pagination pagination-sm no-margin pull-right">
                                        <li><a href="#">&laquo;</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">&raquo;</a></li>
                                    </ul>
                                    </div>-->

                                </div><!-- /.panel-body -->
                            </div><!-- /.panel -->
<div id="enterMod" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="logo modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Entertainer Application</h4>
      </div>
      <div class="modal-body">
	  <table  class="table borderless" width="100%" align="center">
	  <tr>
	  <td>
        First Name :
		</td>
		<td name="enterFN">
		</td>
		<td>
		Last Name :
</td>
<td name="enterLN">
		</td>
      </tr>
	  <tr>
	  <td>Email : </td><td name="enterEmail">
		</td>
		<td>
		 Phone :</td><td name="enterPh">
		</td>
      </tr>
	  <tr>
	  <td>
       Address : </td><td name="enterAdd">
		</td>
		<td>
		Performance Type : </td><td name="enterPerfType">
		</td>
      </tr>
	  <tr>
	  <td>
     Act Name : </td><td name="enterAct">
		</td>
		<td >Act Description :</td>
		<td name="enterDesc">
		</td>
      </tr>
	  <tr>
	  <td >
       Individual/Group :</td>
		<td name="enterIndOrGrp" >
		</td>
		<td>
		No. Group Members : </td><td name="enterNumOfGrp">
		</td>
      </tr>
	  <tr>
	  <td >
       Registration Date : </td>
	   <td name="enterRegistrationDate">
		</td>

      </tr>
	  <tr>
	  <td  colspan="4" align="center">
	  <button class="btn btn-success"  name="enterId" id="enterAccept"><i class="fa fa-check" aria-hidden="true"></i></button>&nbsp;&nbsp;
	  <button class="btn btn-danger"  name="enterId" id="enterReject"><i class="fa fa-times" aria-hidden="true"></i></button></td>
	  </tr>
	  </table>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


						</div><!-- /.col -->

						  <div class="col-md-6">
                            <div class="panel">
                                <header class="panel-heading">
                                  <strong>Volunteers</strong>
                                </header>
                               <div class="panel-body table-responsive">
								<?php
								if($volunt_num > 0){
  echo '<table class="table table-bordered table-hover">
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>E-mail</th>
<th>Phone</th>
<th>Status</th>
</tr>';

while($row = mysqli_fetch_array($volunteers))
{
echo "<tr id='vol". $row['volunteerId'] ."'>";
echo "<td><a href='#' class='volView' name='volFN' data-record='vol". $row['volunteerId'] ."'>" . $row['firstName'] . "</a></td>";
echo "<td name='volLN'>" . $row['lastName'] . "</td>";
echo "<td name='volEmail'>" . $row['email'] . "</td>";
echo "<td name='volPh'>" . $row['phone'] . "</td>";
echo "<td name='volAreas' style='display:none'>".$row['areasToVolunteer']."</td>";
echo "<td name='volAdd' style='display:none'>".$row['address']."</td>";
echo "<td name='volIndOrGrp' style='display:none'>".$row['indOrGroup']."</td>";
echo "<td name='volNumOfGrp' style='display:none'>".$row['numOfGroupMem']."</td>";
echo "<td name='volRegistrationDate' style='display:none'>".$row['registrationDate']."</td>";
echo "<td name='volId' style='display:none'>".$row['volunteerId']."</td>";
switch($row['Status'])
{
case 1: {
	echo "<td><span class='label label-warning'>" . $row['status_desc'] . "</span></td>";
}
break;
case 2:{
	echo "<td><span class='label label-success'>" . $row['status_desc'] . "</span></td>";
}
break;
case 3:{
	echo "<td><span class='label label-danger'>" . $row['status_desc'] . "</span></td>";
}
break;

}
echo "</tr>";
}
echo "</table>";
}
else
{
	echo "<b>No Data Found</b>";

}
?>
                                   <!-- <div class="table-foot">
                                        <ul class="pagination pagination-sm no-margin pull-right">
                                        <li><a href="#">&laquo;</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">&raquo;</a></li>
                                    </ul>
                                    </div>-->

                                </div><!-- /.panel-body -->
                            </div><!-- /.panel -->
<div id="volMod" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="logo modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Volunteer Application</h4>
      </div>
      <div class="modal-body">
	  <table  class="table borderless" width="100%" align="center">
	  <tr>
	  <td>
        First Name :
		</td>
		<td name="volFN">
		</td>
		<td>
		Last Name :
</td>
<td name="volLN">
		</td>
      </tr>
	  <tr>
	  <td>Email : </td><td name="volEmail">
		</td>
		<td>
		 Phone :</td><td name="volPh">
		</td>
      </tr>
	  <tr>
	  <td>
       Address : </td><td name="volAdd">
		</td>
		<td>
	Areas To Volunteer : </td><td name="volAreas">
		</td>
      </tr>
	  <tr>
	  <td >
       Individual/Group :</td>
		<td name="volIndOrGrp" >
		</td>
		<td>
		No. Group Members :</td><td name="volNumOfGrp">
		</td>
      </tr>
	  <tr>
	  <td >
       Registration Date :</td>
	   <td name="volRegistrationDate">
		</td>

      </tr>
	  <tr>
	  <td  colspan="4" align="center">
	  <button class="btn btn-success"  name="volId" id="volAccept"><i class="fa fa-check" aria-hidden="true"></i></button>&nbsp;&nbsp;
	  <button class="btn btn-danger"  name="volId" id="volReject"><i class="fa fa-times" aria-hidden="true"></i></button></td>
	  </tr>
	  </table>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

						</div><!-- /.col -->




                    </div><!-- /.row -->



                </section><!-- /.content -->



             <footer id="footer">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">Built by students from <a href="http://mtsu.edu/csc/">MTSU Computer Science.</a></div>
      <div class="col-sm-6">
        <ul id="menu-primary-navigation-2" class="menu">
          <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-38"><a href="index.html">Home</a></li>
          <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-38"><a href="about.html">About</a></li>
          <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-38"><a href="schedule.html">Schedule</a></li>
          <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-38"><a href="involved.html">Get Involved</a></li>
          <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-38"><a href="sponsors.html">Sponsors</a></li>
          <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-38"><a href="contact.html">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
</aside><!-- /.right-side -->

		   </div><!-- ./wrapper -->


    </body>
</html>
<?php
mysqli_close($connection);
?>
