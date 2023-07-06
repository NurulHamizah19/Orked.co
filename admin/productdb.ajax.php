<?php
header('Content-type: Application/JSON');
include_once 'connectdb.php';
// header("Content-Type: application/json; charset=UTF-8");
// $obj = json_decode($_GET["x"], false);

// $conn = new mysqli("localhost", "root", "", "sferapos-app");
// $stmt = $conn->prepare("SELECT * FROM tbl_products LIMIT ?");
// $stmt->bind_param("s", $obj->limit);
// $stmt->execute();
// $result = $stmt->get_result();
// $outp = $result->fetch_all(MYSQLI_ASSOC);

$select = $pdo->prepare("SELECT * FROM tbl_product");
$select->execute();
$rows = $select->fetchAll();

// print_r($rows);
$jsonData = json_encode($rows, JSON_PRETTY_PRINT);
// echo json_encode($rows,JSON_PRETTY_PRINT);
echo  $jsonData ;
?>