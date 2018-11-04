<?php

// Available to everybody
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$db = new Database();
$db = $db->connect();

$post = new Post($db);

$post->id = $_GET['id'] ?? die("nope");
$post->read_single_post();


$post_arr = [
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name,
    'created_at' => $post->created_at
];

echo json_encode($post_arr);