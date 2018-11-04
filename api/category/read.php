<?php

header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');


include_once '../../models/Category.php';

$ct = new Category();
$result = $ct->read();
$num_rows = $result->rowCount();

if($num_rows > 0) {
    $ct_arr = [];
    $ct_arr['rows'] = $num_rows;
    $ct_arr['data'] = [];

    while($row = $result->fetch()) {
        extract($row);
        $item = [
            'id' => $id,
            'name' => $name,
            'created_at' => $created_at
        ];

        array_push($ct_arr['data'],$item);
    }

    echo json_encode($ct_arr);
} else {
    echo json_encode([
        'error' => "There are no categories"
    ]);
}
