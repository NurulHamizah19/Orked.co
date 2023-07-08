<?php 
require_once 'Database/database.php';
require_once 'Controller/ProductController.php';

use Controller\ProductController;

$productId = $_GET['id'];

$product = ProductController::getProductById($productId);
if ($product) {
    header('Content-Type: application/json');
    echo json_encode($product);
} else {
    header('HTTP/1.1 404 Not Found');
    echo 'Product not found';
}