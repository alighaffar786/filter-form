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
function getData($column, $where_clause = ""){
    $sql = "Select distinct(`$column`) as option_value from kms_courses_dev";
    if(!empty($where_clause)) {
        $sql.= " where ".$where_clause;
    }


    $result = connection()->query($sql);
    $data = [];
    while($row = $result->fetch_assoc()) {
        if(!empty($row['option_value'])){
            $data[$row['option_value']] = $row['option_value'];
        }
    }
    $result->close();
    return $data;
}

function getAjaxData($request, $fields){
    unset($fields["id"]);
    $where  = "";
    foreach($request as $column => $values){
        unset($fields[$column]);
        $where.= " $column IN (".implode($values, "'").") ";
    }
    $other_columns = array_keys($fields);
    
}

function toSnakeCase($inputString) {
    // Replace spaces and special characters with underscores
    $snakeCaseString = preg_replace('/[^A-Za-z0-9]+/', '_', $inputString);
    // Convert to lowercase
    $snakeCaseString = strtolower($snakeCaseString);
    // Remove leading and trailing underscores
    $snakeCaseString = trim($snakeCaseString, '_');
    return $snakeCaseString;
}

function get_options($options) {

    ob_start();
    include_once('_options.php');
    return ob_get_clean();
  }

