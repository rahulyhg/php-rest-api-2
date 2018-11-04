<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include '../../models/Category.php';

$ct = new Category();
$data = json_decode(file_get_contents('php://input'));

if($ct->update_category($data)) {
    echo json_encode([
        'message' => "OK updatedd"
    ]);
} else {
    echo json_encode([
        'message' => "not OK updated"
    ]);
}