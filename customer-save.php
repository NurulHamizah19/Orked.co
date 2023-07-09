<?php

require_once 'Database/database.php';
require_once 'Controller/CheckoutController.php';

use Controller\CheckoutController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerData = $_POST['customerData'];
    $cartItems = $_POST['cartItems'];

    var_dump($customerData);
    var_dump($cartItems);

    $result = CheckoutController::saveCustomerData($customerData, $cartItems);

    if ($result) {
        echo $result;
        echo 'success';
    } else {
        echo $result;
        echo 'error';
    }
}