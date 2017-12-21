<?php

$DIR = $_SERVER['DOCUMENT_ROOT'];
require_once $DIR . '/php/config.php';

$response = '';

try {
    $auth->confirmEmail($_GET['selector'], $_GET['token']);
    $response = "email address has been verified";
}
catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    $response = "invalid token";
}
catch (\Delight\Auth\TokenExpiredException $e) {
    $response = "token expired";
}
catch (\Delight\Auth\UserAlreadyExistsException $e) {
    $response = "email address already exists";
}
catch (\Delight\Auth\TooManyRequestsException $e) {
    $response = "too many requests";
}


echo $twig->render('sign/verification.twig', array('DIR' => $DIR, 'response' => $response));

