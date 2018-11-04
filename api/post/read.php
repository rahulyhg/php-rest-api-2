<?php
// Available to everybody
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$db = new Database();
$db = $db->connect();

$post = new Post($db);
$result = $post->read();
$num_rows = $result->rowCount();

if($num_rows > 0) {
    $posts_arr = [];
    $posts_arr['rows'] = $num_rows;
    $posts_arr['data'] = [];

    foreach($result as $row) {
        extract($row);
        
        $post_item = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        ];
        
        array_push($posts_arr['data'], $post_item);
    }
    echo json_encode($posts_arr);
} else {
    echo json_encode(
        ['message' => "No Posts Found"]
    );
}

echo "1";