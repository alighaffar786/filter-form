<?php
require_once("_db.php");
function getData($column, $request){
    $sql = "Select distinct(`$column`) as option_value from kms_courses_dev";

    $where = [];
    if(!empty($request['data'])){
        foreach($request['data'] as $key => $values){
            if($column != $key){
               $in =  "'" . implode("','", $values) . "'";
               $where[] =  "`$key` IN ($in)";
            }
       }
       $where_clause = implode(" and ", $where);
    }

    $where_clause = implode(" and ", $where);

    if(!empty($where_clause)) {
        $sql.= " where ".$where_clause;
    }
    wh_log($sql);
    
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
    $option_value = "";
    foreach ($options as $option){
        $option_value .= "<option name='$option' value='$option'>$option</option>";
    }
    return $option_value;
  }

  function wh_log($log_msg)
  {
      $log_filename = "log";
      if (!file_exists($log_filename)) 
      {
          // create directory/folder uploads.
          mkdir($log_filename, 0777, true);
      }
      $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
      // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
      file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
  } 