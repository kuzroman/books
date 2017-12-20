<?php

//echo phpinfo();

// http://english-e-books.net/
include "php/config.php";

//$page = $_SERVER['REQUEST_URI']; // # - хеш нельзя получить с помощью php!

echo $twig->render('index.twig', array('DIR' => $DIR));




