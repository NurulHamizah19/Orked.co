<?php 
require_once 'Database/database.php';
require_once 'Controller/ProductController.php';

use Controller\ProductController;

$products = ProductController::getAllProducts();

var_dump($products);