<?php 
  include_once("function.php");
  include_once("config.php");

  if(!empty($_POST['request'])){
    $response_data = get_ajax($_POST['request'],$mapping);
    if(empty($_POST['request']['all_option'])){
      echo json_encode($response_data);
      die;
    }else{
      $getdata = get_all_option($mapping);
      echo json_encode($getdata);
      die;
    }
  }

  function get_ajax($request, $columns){
    $data = [];
    if(!empty($request["column"])){
      unset($columns[$request["column"]]);
    }
    $request_data = !empty($request['data']) ? $request : [];
    foreach($columns as $column) {
        $selected = !empty($request['data']) ? $request['data'][$column] : "";
        $data[toSnakeCase($column)] = [
                'html' => get_options(getData($column, $request_data)), 
                'selected' =>  $selected
        ];
    }
    
    // echo json_encode($data);
    // die;
    return $data;
  }
  function get_all_option($mapping){
    foreach($mapping as $column) {
      $data[toSnakeCase($column)] = [
        'html' => get_options(getData($column, [])), 
      ];
    }
    return $data;
  }

?>