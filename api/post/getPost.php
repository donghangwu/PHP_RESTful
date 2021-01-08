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

//Blog post query
$result = $post->getPosts();
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
    //while($row=$result->fetch(PDO::FETCH_ASSOC)){
        //extract($row);
        // echo json_encode($row);
        // exit();
        // $post_item = array(
        //     'id'=>$id,
        //     'title'=>$title,
        //     'body'=>html_entity_decode($body),
        //     'author'=>$author,
        //     'category_id'=>$category_id,
        //     'category_name'=>$category_name
        // );
        //array_push($post_arr['data'],$row);
    //}
    //push "data"
    echo json_encode($post_arr);

}
else{
    // NO posts
    echo json_encode(
        array('message'=>'NO post get')
    );
}