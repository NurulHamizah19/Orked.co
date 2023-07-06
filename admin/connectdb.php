<?php

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbName = $_ENV['DB_NAME'];
$dbPass = $_ENV['DB_PASS'];

date_default_timezone_set('Asia/Kuala_Lumpur');

try{
$pdo = new 
PDO('mysql:host='.$dbHost.';dbname='.$dbName.'',$dbUser,$dbPass);
// echo 'Connection established';
} catch(PDOException $f){
    echo $f->getmessage();
}
?>


