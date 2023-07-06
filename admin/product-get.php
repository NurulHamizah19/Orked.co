<?php

include_once 'connectdb.php';
// Number of records fetch
$numberofrecords = 10;

if (!isset($_POST['searchTerm'])) {
    // Fetch records
    $stmt = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pname LIMIT :limit");
    $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
    $stmt->execute();
    $productList = $stmt->fetchAll();
} else {
    $search = $_POST['searchTerm']; // Search text
    // Fetch records
    $stmt = $pdo->prepare("SELECT * FROM tbl_product WHERE pname like :name ORDER BY name LIMIT :limit");
    $stmt->bindValue(':name', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
    $stmt->execute();
    $productList = $stmt->fetchAll();
}

$response = array();

// Read Data
foreach ($productList as $product) {
    $response[] = array(
        "id" => $product['pid'],
        "text" => $product['pname']
    );
}

echo json_encode($response);
exit();
