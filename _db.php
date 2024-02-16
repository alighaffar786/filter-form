<?php 
function connection(){
    $_host = "localhost";
    $_username = "root";
    $_password = "admin";
    $_database = "kms_courses";
    $connection =  new mysqli($_host, $_username, $_password,$_database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    else{
        return $connection;
    }
}