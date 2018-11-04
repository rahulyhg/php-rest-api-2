<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include '../../models/Category.php';

$ct = new Category();
$id = json_decode(file_get_contents('php://input'))->id;

if($ct->delete_category($id)) {
    echo json_encode([
        'message' => "OK deleted"
    ]);
} else {
    echo json_encode([
        'message' => "not OK deleted"
    ]);
}