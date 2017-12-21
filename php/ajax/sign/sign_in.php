<?php

$DIR = $_SERVER['DOCUMENT_ROOT'];
require_once $DIR . '/php/config.php';

if (!empty($_GET['email']) && !empty($_GET['password'])) {
    try {
        $auth->login($_GET['email'], $_GET['password']);
        // user is logged in
        echo json_encode(['error' => 0, 'text' => 'user is logged in']);


    } catch (\Delight\Auth\InvalidEmailException $e) {
        // wrong email address
        echo json_encode(['error' => 1, 'text' => ' Wrong email address']);
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        // wrong password
        echo json_encode(['error' => 2, 'text' => ' Wrong password']);
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
        // email not verified
        echo json_encode(['error' => 3, 'text' => 'Email not verified']);
    } catch (\Delight\Auth\TooManyRequestsException $e) {
        // too many requests
        echo json_encode(['error' => 4, 'text' => 'Too many requests']);
    }
}