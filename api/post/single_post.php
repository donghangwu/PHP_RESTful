<?php
//rest api

// Header
// Allow anybody to have access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/post.php';

//Instantiate DB and connect to DB;

$database = new Database();
$pdo=$database->connect();

//Instantiate blog post object;
$post = new Post($pdo);

// GET ID
$post_id = '';
if(isset($_GET['id']))
{
    $post_id=$_GET['id'];
}
else{
    $post_id=null;
}

$post->id=$post_id;
// GET post
$result = $post->single_post();

//Get row count
$num=$result->rowCount();

//check if any post exist
if($num>0)
{
    //post array
    $post_arr=array();
    $post_arr['data']=array();
    //return associate array,=>dictionary
    $ans=$result->fetchAll(PDO::FETCH_ASSOC);
    array_push($post_arr['data'],$ans);
    echo (json_encode($post_arr));
}
else{

}