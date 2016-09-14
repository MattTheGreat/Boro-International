<?php 
 
     global $_SESSION;
     if (!isset($_SESSION["authorized"]) || $_SESSION["authorized"]!= 'true' ) { 
          header("Location: adminLogin.php"); 
     }
 
?>