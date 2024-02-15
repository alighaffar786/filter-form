<?php 
  include_once("function.php");
  include_once("config.php");

  if($_POST['request']){
    echo json_encode(get_ajax($_POST['request'],$mapping));
  }

  function get_ajax($request, $columns){
    $data = [];
    unset($columns[$request["column"]]);
    $where = [];
    foreach($request['data'] as $column => $values){
        $in =  "'" . implode("','", $values) . "'";
        $where[] =  "`$column` IN ($in)";
    }

    $where_clause = implode(" and ", $where);
    foreach($columns as $column) {
        $data[toSnakeCase($column)] = [
                'html' => get_options(getData($column, $where_clause)), 
                'selected' => $request[$column]
            ];
    }
    echo json_encode($data);
    die;
  }

?>