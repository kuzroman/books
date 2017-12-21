<?php

$DIR = $_SERVER['DOCUMENT_ROOT'];
require_once $DIR . '/php/config.php';

echo $twig->render('sign/sign_in.twig', array('DIR' => $DIR));

