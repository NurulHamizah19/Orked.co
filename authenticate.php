<?php

require_once 'Database/database.php';
require_once 'Controller/UserController.php';

use Controller\UserController;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'checkUserExists') {
    $email = $_POST['email'];

    if (UserController::isUserExists($email)) {
        echo 'exists';
    } else {
        echo 'not exists';
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateAccount') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $userId = $_SESSION['userId'];

    $result = UserController::updateUser($userId, $name, $email, $password);

    if ($result["success"]) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'not exists';
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'userLogin') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $userId = $_SESSION['userId'];

    $result = UserController::loginUser($email, $password);

    if ($result["success"]) {
        header('Location: dashboard.php');
        exit();
    } else {
        header('Location: sign-in.php?login=failed');
        exit();
    }
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['authType'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isRego = $_POST['authType'];

    if ($isRego) {
        $result = UserController::createUser($firstName, $lastName, $email, $password);
        if ($result["success"]) {
            $_SESSION['email'] = $email;
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['userId'] = $result["userId"];
            header('Location: dashboard.php');
            exit();
        } else {
            echo $result["error"];
        }
    }

    echo $result;
}
