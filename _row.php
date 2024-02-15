<div class="row">
<?php
    foreach($row as $column => $meta){
        $column_name = ucwords(strtolower(str_replace('_', ' ', $column)));
        $column_id = toSnakeCase($column);
        include("_field.php");
    }
?>
</div>