<?php
include("db_connect.php");
$connection = db_connect();
// Check connection
if(!$connection){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if(isset($_POST['login'])){
  $username = $_POST['user'];
  $password = $_POST['pass'];
  $query ="SELECT * FROM admin_login WHERE username='$username' and password='$password'";
  $result = mysqli_query($connection,$query);
  if(mysqli_num_rows($result)==1){
    session_start();
	$row = mysqli_fetch_array($result);
    $_SESSION['authorized'] = 'true';
	$_SESSION['User_Id'] = $row['username'];
	$_SESSION['Name'] = $row['firstName'] . " ". $row['lastName'];
    header("location: admin.php");
  }
  else {
   ?>
        <script>alert('invalid user ID or password');</script>
        <?php
      }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login </title>
<meta name="description" content="">

<!-- core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/prettyPhoto.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/adminLogin.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="images/favicon.jpg" rel="shortcut icon">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <header id="header">
    <nav class="navbar navbar-inverse" role="banner">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="index.html"><i class="fa fa-flag"></i> 'Boro International</a> </div>
        <div class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="schedule.html">Schedule</a></li>
            <li class="dropdown"><a class="dropdown-toggle" href="involved.html">Get Involved<span class="caret"></span></a>
              <ul class="dropdown-content">
                <li><a href="vendor.html">Vendor</a></li>
                <li><a href="entertainer.html">Entertainer</a></li>
                <li><a href="volunteer.html">Volunteer</a></li>
              </ul>
            </li>
            <li><a href="sponsors.html">Sponsors</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
      </div>
      <!--/.container-->
    </nav>
    <!--/nav-->
</header>
  <div class="container">
    <div class="card card-container">
      <h2>Admin Login</h2>
    <form class="form-signin" method="POST">
      <input type="text" name="user" class="form-control" placeholder="Username" required autofocus>
      <input type="password" name="pass" class="form-control" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="login">Sign in</button>
    </form><!-- /form -->
    <a href="#" class="forgot-password">
      Forgot your password?
    </a>
  </div><!-- /card-container -->
</div><!-- /container -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/jquery.isotope.min.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/countdown.js"></script>
</body>
</html>
