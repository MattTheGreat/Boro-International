<?php
session_start();

//added session variable so only authorized users can access page

#error_reporting(17);
include("checkLogged.php");
$msg = "";
$style = "";
//added session variable so only authorized users can access page
/*if(!$_SESSION['authorized']){
  header("location: adminLogin.php");
}*/
#error_reporting(17);
//include("checkLogged.php");


$ret = $_GET["ret"];

if($ret =="edit_fail")
{
$style= "alert alert-danger";
$msg = "Invalid Password";	
}
else if($ret =="reset_fail")
{
$style= "alert alert-danger";
$msg = "Invalid Old Password";	
}
else if($ret =="reset_succ")
{
	$style= "alert alert-success";
$msg = "Password updated";	
}
else if($ret =="user_same")
{
	$style= "alert alert-danger";
$msg = "User ID already exists";	
}
else if($ret =="user_succ")
{
	$style= "alert alert-success";
$msg = "Account Added";	
}
else if($ret =="edit_succ")
{
	$style= "alert alert-success";
$msg = "Edit successful";	
}
else if($ret =="errDel")
{
	$style= "alert alert-danger";
$msg = "Invalid Password";	
}
include("db_connect.php");
// Attempt insert query execution
$connection = db_connect();

// Check connection
if(!$connection){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


$sql = "SELECT * FROM `admin_login`";
$admins = mysqli_query($connection, $sql);
$admin_num = mysqli_num_rows($admins);


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
		
        <script src="js/jquery.min.js" type="text/javascript"></script>

        
        <!-- Director App -->
        <script src="js/Director/app.js" type="text/javascript"></script>
		 <script src="js/jquery.js" type="text/javascript"></script>
		 <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(
		function(){
		
		$("[name='editBt']").click(
		function(){
		var username = $(this).attr("data-record");
        var data = getDataFromTable(username);
        populateModalEditForm(data,username);
        $("#editUser").modal();
		}
		);
		
		$("[name='resetPassBt']").click(
		function(){
		
		var username = $(this).attr("data-record");
        var data = getDataFromTable(username);
        populateModalResetForm(data,username);
        $("#resetUser").modal();
		}
		);
		
		
		$("[name='deleteBt']").click(
		function(){
		
		var username = $(this).attr("data-record");
        var data = getDataFromTable(username);
        populateModalDelForm(data,username);
        $("#delUser").modal();
		}
		);
	function getDataFromTable(username)
{
    var data = {};

    $("#"+username +" [name]").each(function()
    {
        data["'"+$(this).attr("name")+"'"] = $(this).html();
			
    });

    return data;
}



function populateModalEditForm(data,rowid)
{
    //select all input elements having name attribute 
	

    $("#editUser [name]").each(function()
    {
		var attName = $(this).attr("name");
		
         $(this).val(data["'"+$(this).attr("name")+"'"]);
		 $(this).html(data["'"+$(this).attr("name")+"'"]);
		
    });

}

function populateModalResetForm(data,rowid)
{
    //select all input elements having name attribute 
	

    $("#resetUser [name]").each(function()
    {
		var attName = $(this).attr("name");
		
        $(this).val(data["'"+$(this).attr("name")+"'"]);
		 $(this).html(data["'"+$(this).attr("name")+"'"]);
		
    });

}


function populateModalDelForm(data,rowid)
{
    //select all input elements having name attribute 
	

    $("#delUser [name]").each(function()
    {
		var attName = $(this).attr("name");
		
        $(this).val(data["'"+$(this).attr("name")+"'"]);
		 $(this).html(data["'"+$(this).attr("name")+"'"]);
		
    });

}	

$("#addVal").click(function()
    {
		var pass = $("#npass").val();
		var confPass = $("#nconfPass").val();
		if(pass != confPass)
		{
			alert("Passwords Do not match");
			return false;
			
		}
		else
		{
			return true;
			
		}
		
    });

	
	
	$("#resetPassVal").click(function()
    {
		var pass = $("#pass").val();
		var confPass = $("#confirmPass").val();
		if(pass != confPass)
		{
			alert("Passwords Do not match");
			return false;
			
		}
		else
		{
			return true;
			
		}
		
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
	<div class='<?php echo $style; ?>' align="center">
	 <button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $msg; ?></div>
        <!-- header logo: style can be found in header.less -->
        <header class="header" >

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
                            <p>Hello, <?php  echo $_SESSION["Name"]; ?></p>

                        </div>
                    </div>
                    <!-- search form -->

                    <ul class="sidebar-menu">
                        <li>
                            <a href="admin.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li  class="active">
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


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <header class="panel-heading">
                                  <strong>Add New Admin Account</strong>
                                </header>
                                <div class="panel-body">
							 <form role="form" method="post" action="addAdminAcc.php">
                                      <div class="form-group">
                                          <label for="userId">*User ID</label>
                                          <input type="text" class="form-control" name="nuserId" placeholder="Enter User ID" required="">
                                      </div>
                                      <div class="form-group">
                                          <label for="firstName">*First Name</label>
                                          <input type="text" class="form-control" name="nfirstName" placeholder="First Name" required="">
                                      </div>
									   <div class="form-group">
                                          <label for="lastName">*Last Name</label>
                                          <input type="text" class="form-control" name="nlastName" placeholder="Last Name" required="">
                                      </div>
                                      <div class="form-group">
                                          <label for="pass">*Password</label>
                                          <input type="password" class="form-control" name="npass" id="npass" placeholder="Password" required="">
                                      </div>
									  <div class="form-group">
                                          <label for="confPass">*Confirm Password</label>
                                          <input type="password" class="form-control" name="nconfPass" id="nconfPass" placeholder="Confirm Password" required="">
                                      </div>
                                      
                                      <button type="submit" class="btn btn-primary" id="addVal">Submit</button>
                                  </form>

                                </div><!-- /.panel-body -->
                            </div><!-- /.panel -->
						</div><!-- /.col -->
						<!-- Trigger the modal with a button -->

                    </div><!-- /.row -->

 <div class="row">
						  <div class="col-md-12">
                            <div class="panel">
                                <header class="panel-heading">
                                  <strong>Existing Admin Accounts</strong>
                                </header>
                               <div class="panel-body table-responsive">
								<?php
								if($admin_num > 0){
  echo '<table class="table table-bordered table-hover">
<tr>
<th>User ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Settings</th>
</tr>';

while($row = mysqli_fetch_array($admins))
{
echo "<tr id='".$row['username'] ."'>";
echo "<td name='adminUserName'>".$row['username']."</td>";
echo "<td name='adminFN'>".$row['firstName']."</td>";
echo "<td name='adminLN'>" . $row['lastName'] . "</td>";
echo "<td name='adminUserNameHd' style='display:none'>".$row['username']."</td>";
echo "<td><button class='btn btn-info btn-xs' data-record='". $row['username'] ."' name='editBt'><i class='fa fa-pencil'></i></button>&nbsp;
<button class='btn btn-danger btn-xs' data-record='". $row['username'] ."' name='deleteBt'><i class='fa fa-times'></i></button>&nbsp;<button class='btn btn-warning btn-xs' data-record='". $row['username'] ."' name='resetPassBt' ><i class='fa fa-lock' ></i></button></td>";
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
<div id="editUser" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="logo modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Admin Account</h4>
      </div>
      <div class="modal-body">
	  <form role="form" method="post" action="editAdminAcc.php">
                                      <div class="form-group">
                                          <label for="userId">User ID</label>
                                          <label class="form-control" name="adminUserName"></label>
										  <input type="hidden" name="adminUserNameHd"></input>
                                      </div>
                                      <div class="form-group">
                                          <label for="firstName">*First Name</label>
                                          <input type="text" class="form-control" name="adminFN" required="">
                                      </div>
									   <div class="form-group">
                                          <label for="lastName">*Last Name</label>
                                          <input type="text" class="form-control" name="adminLN" required="">
                                      </div>
                                      <div class="form-group">
                                          <label for="pass">*Password</label>
                                          <input type="password" class="form-control" name="password" required="">
                                      </div>
									 
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                  </form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>										
		
<div id="resetUser" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="logo modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Account Password</h4>
      </div>
      <div class="modal-body">
	  <form role="form" method="post" action="resetAdminAccPass.php">
                                      <div class="form-group">
                                          <label for="userId">User ID</label>
                                        <label class="form-control" name="adminUserName"></label>
										<input type="hidden" name="adminUserNameHd"></input>
                                      </div>
									  <div class="form-group">
                                          <label for="oldPassword">*Old Password</label>
                                          <input type="password" class="form-control" name="oldPassword" required="">
                                      </div>
                                      <div class="form-group">
                                          <label for="pass">*New Password</label>
                                          <input type="password" class="form-control" id="pass" name="pass" required="">
                                      </div>
									  <div class="form-group">
                                          <label for="confirmPass">*Confirm New Password</label>
                                          <input type="password" class="form-control" id="confirmPass" name="confirmPass" required="">
                                      </div>
                                      
                                      <button type="submit" class="btn btn-primary" id="resetPassVal">Submit</button>
                                  </form>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>		


<div id="delUser" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="logo modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Account</h4>
      </div>
      <div class="modal-body">
	  <form role="form" method="post" action="deleteAdminAcc.php">
                                      <div class="form-group">
                                          <label for="userId">User ID</label>
                                        <label class="form-control" name="adminUserName"></label>
										<input type="hidden" name="adminUserNameHd"></input>
                                      </div>
									  <div class="form-group">
                                          <label for="oldPassword">Account Password</label>
                                          <input type="password" class="form-control" name="pass">
                                      </div>
                                      
                                      <button type="submit" class="btn btn-primary">Delete</button>
                                  </form>
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
