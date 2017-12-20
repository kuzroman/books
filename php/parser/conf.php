<?php

include $_SERVER['DOCUMENT_ROOT'] . "/php/libs/simple_html_dom/simple_html_dom.php";


$mysqli = new mysqli("localhost", "root", "", "books");
if ($mysqli->connect_errno) {
    echo "can not connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

