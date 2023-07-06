<?php
include_once 'connectdb.php';

$detail = $pdo->prepare("SELECT * FROM config WHERE id=1");
$detail->execute();
$cnf = $detail->fetch(PDO::FETCH_OBJ);

session_start();
/*
* Write your logic to manage the data
* like storing data in database
*/
$data = [];
// POST Data

$productname = $_POST['txtproductname'];
$category = $_POST['txtselect_option'];  // $_POST['']; 
$purchaseprice =  $_POST['txtpprice'];
$saleprice =  $_POST['txtsprice'];
$stock = $_POST['txtstock'];
$system_barcode = $cnf->prefix . '-' . $genid;
if (isset($_POST['txtbarcode'])) {
    $barcode = $_POST['txtbarcode'];
} else {
    $barcode = $system_barcode;
}

$profit = $_POST['txtsprice'] - $_POST['txtpprice'];

$insert = $pdo->prepare("INSERT INTO tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,profit,barcode) values(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:profit,:barcode)");

$insert->bindParam(':pname', $productname);
$insert->bindParam(':pcategory', $category);
$insert->bindParam(':purchaseprice', $purchaseprice);
$insert->bindParam(':saleprice', $saleprice);
$insert->bindParam(':pstock', $stock);
$insert->bindParam(':profit', $profit);
$insert->bindParam(':barcode', $barcode);
$insert->execute();

exit;
