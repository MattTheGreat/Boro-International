<?php

function db_connect() {

    // Define connection as a static variable, to avoid connecting more than once 
    $connection;
	$config = parse_ini_file('config.ini'); 
	$connection = mysqli_connect($config['server'], $config['username'],$config['password'],$config['dbname']);
    // If connection was not successful, handle the error
    if($connection === false) {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    return $connection;
}

?>