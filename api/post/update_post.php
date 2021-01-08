<?php
//rest api

// Header
// Allow anybody to have access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,
Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-Width');

include_once '../../config/Database.php';
include_once '../../model/post.php';

//Instantiate DB and connect to DB;

$database = new Database();
$pdo=$database->connect();

//Instantiate blog post object;
$post = new Post($pdo);

// Get raw posted data
$data=json_decode(file_get_contents("php://input"));
$post->title=$data->title;
$post->body =$data->body ;
$post->author=$data->author;
$post->category_id=$data->category_id;
$post->id=$data->id;

// UPDATE post
if($post->update_post())
{
    echo json_encode(array(
        'message'=>'post Success updated'
    ));
}
else
{
    echo json_encode(array(
        'error'=>'post failed to updated'
    ));
}