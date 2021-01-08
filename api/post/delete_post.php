<?php
//rest api

// Header
// Allow anybody to have access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

$post->id=$data->id;

// UPDATE post
if($post->delete_post())
{
    echo json_encode(array(
        'message'=>'post Success DELETED'
    ));
}
else
{
    echo json_encode(array(
        'error'=>'post failed to DELETE'
    ));
}