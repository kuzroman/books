<?php

$requestMethod = $_SERVER['REQUEST_METHOD'];

$limit = empty($_GET['limit']) ? 2 : $_GET['limit']; // для главной. Сделать пагинацию! или выводить больше
$author = empty($_GET['author']) ? '' : html_entity_decode($_GET['author']);// для авторов

//echo $author;

$books = [];

$mysqli = new mysqli("localhost", "root", "", "books");
if ($mysqli->connect_errno) {
    echo "can not connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

if ($requestMethod == 'GET') {
    // сократить кол-во полей!

    if ($author) { // если есть id ищем авторов
        $res = $mysqli->query("SELECT * FROM `main` WHERE author = '$author' ORDER BY `id` ASC");
    } else {
        $res = $mysqli->query("SELECT * FROM `main` ORDER BY `id` ASC LIMIT $limit"); //  WHERE id = 96 // DESC
    }

    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        array_push($books, $row); // $row['id'];
    }
    echo json_encode($books);
}
