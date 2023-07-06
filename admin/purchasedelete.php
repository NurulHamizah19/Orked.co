<?php

include_once 'connectdb.php';
$id = $_POST['pidd'];

$sql="delete tbl_order , tbl_order_details FROM tbl_order INNER JOIN tbl_order_details ON tbl_order.invoice_id = tbl_order_details.invoice_id where tbl_order.invoice_id=$id";
$delete = $pdo->prepare($sql);
if($delete->execute()){
    
} else {
    echo 'Delete failed';
}

?>