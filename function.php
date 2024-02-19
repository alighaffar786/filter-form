<?php
require_once("_db.php");

function getAjaxData($request, $columns)
{
    // wh_log("\n-----------------------------------\n");
    $data = [];
    if (!empty($request["column"])) {
        unset($columns[$request["column"]]);
    }
    $request_data = !empty($request['data']) ? $request : [];
    foreach ($columns as $column) {
        // $selected = !empty($request['data'][$column]) ? $request['data'][$column] : [];
        $data[toSnakeCase($column)] = getData($column, $request_data);
    }
    return $data;
}

function getData($column, $request)
{
    $sql = "Select distinct(`$column`) as option_value from kms_courses_dev";

    $where = [];
    if (!empty($request['data'])) {
        foreach ($request['data'] as $key => $values) {
            if ($column != $key) {
                $in = "'" . implode("','", $values) . "'";
                $where[] = "`$key` IN ($in)";
            }
        }
    }

    if (!empty($where)) {
        $where_clause = implode(" and ", $where);
        $sql .= " where " . $where_clause;
    }

    $result = connection()->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['option_value'])) {
            $option = mb_convert_encoding($row['option_value'], 'UTF-8', 'UTF-8');
            $data[$option] = $option;
        }
    }
    $result->close();
    // wh_log($column."--".$sql);
    return $data;
}


function toSnakeCase($inputString)
{
    // Replace spaces and special characters with underscores
    $snakeCaseString = preg_replace('/[^A-Za-z0-9]+/', '_', $inputString);
    // Convert to lowercase
    $snakeCaseString = strtolower($snakeCaseString);
    // Remove leading and trailing underscores
    $snakeCaseString = trim($snakeCaseString, '_');
    return $snakeCaseString;
}

function wh_log($log_msg)
{
    $log_filename = "log";
    if (!file_exists($log_filename)) {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}
function get_columns(){
    $sql = "DESC kms_courses_dev";
    $result = connection()->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['Field']] = ucfirst(str_replace("_", " ",strtolower($row['Field'])));
    }
    return $data;
}
// print_r(get_columns());