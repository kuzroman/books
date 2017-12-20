<?php

$DIR = $_SERVER['DOCUMENT_ROOT'];
require_once $DIR . '/php/config.php';

if (!empty($_GET['email']) && !empty($_GET['password'])) {
    try {
        $auth->login($_GET['email'], $_GET['password']);

        // user is logged in
    } catch (\Delight\Auth\InvalidEmailException $e) {
        // wrong email address
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        // wrong password
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
        // email not verified
    } catch (\Delight\Auth\TooManyRequestsException $e) {
        // too many requests
    }
}

//if (!empty($_GET['email']) && !empty($_GET['password']) && !empty($_GET['username'])) {
//    try {
//        $userId = $auth->register($_GET['email'], $_GET['password'], $_GET['username'], function ($selector, $token) {
//            // send `$selector` and `$token` to the user (e.g. via email)
//        });
//
//        // we have signed up a new user with the ID `$userId`
//        echo json_encode(['error' => 0, 'text' => 'You have successfully registered']);
//    } catch (\Delight\Auth\InvalidEmailException $e) {
//        // invalid email address
//        echo json_encode(['error' => 1, 'text' => 'Invalid email address']);
//    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
//        // user already exists
//        echo json_encode(['error' => 2, 'text' => 'User with this email already exists :(']);
//    } catch (\Delight\Auth\InvalidPasswordException $e) {
//        // invalid password
//        echo json_encode(['error' => 3, 'text' => 'Invalid password']);
//    } catch (\Delight\Auth\TooManyRequestsException $e) {
//        // too many requests
//        echo json_encode(['error' => 4, 'text' => 'Too many requests']);
//    }
//}