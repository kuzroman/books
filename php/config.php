<?php
$DIR = $_SERVER['DOCUMENT_ROOT'];

require_once $DIR . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem($DIR . '/tmpl');
$twig = new Twig_Environment($loader, array(//    'cache' => $DIR . '/php/cache/twig', // нужен только на проде
));

// https://github.com/delight-im/PHP-Auth#creating-a-new-instance
$db = new \PDO('mysql:dbname=books;host=localhost;charset=utf8mb4', 'root', '');
$auth = new \Delight\Auth\Auth($db);
