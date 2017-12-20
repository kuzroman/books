<?php

$requestMethod = $_SERVER['REQUEST_METHOD'];
$level = $_GET['level'];

$books = [];

$mysqli = new mysqli("localhost", "root", "", "books");
if ($mysqli->connect_errno) {
    echo "can not connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

if ($requestMethod == 'GET') {
    $res = $mysqli->query("SELECT `id`, `name`, `author` FROM `main` WHERE `level`='$level'"); // ORDER BY score * 1 DESC
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        array_push($books, $row); // $row['id'];
    }
    echo json_encode($books);
}

//elseif ($requestMethod == 'POST') {
//
//    $post_data = file_get_contents("php://input");
//    $post_data = json_decode($post_data, TRUE);
////    echo json_encode($post_data);
////    return;
//
//    $name = $post_data['name'];
//    $score = $post_data['score'];
//    $mysqli->query("INSERT INTO scores (`name`, `score`) VALUES ('$name', '$score')");
//    echo json_encode( array('id' => $mysqli->insert_id) );
//}