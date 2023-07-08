<?php

require_once 'Database/database.php';
require_once 'Controller/ReviewController.php';

use Controller\ReviewController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $result = ReviewController::saveReview($name, $email, $rating, $comment);

    if ($result) {
        // Data saved successfully
        echo $result;
        return true;
    } else {
        // Error occurred while saving data
        echo $result;
        return false;
    }
}