<?php 
    ini_set('memory_limit', '256M'); // Adjust the memory limit as needed
    ini_set('error_reporting', 'E_All');
    ini_set('display_errors', 'On');
    include_once("function.php");
    include_once("config.php");

    $response_data = getAjaxData($_POST["request"], $mapping);
    print_r(json_encode($response_data));
    // echo json_last_error_msg();
    die;
?>
