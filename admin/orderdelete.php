<?php

include_once 'connectdb.php';
$id = $_POST['pidd'];

$select = $pdo->prepare("SELECT * FROM tbl_invoice_details WHERE invoice_id=$id");
$select->execute();
while ($row = $select->fetch(PDO::FETCH_OBJ)) {
    $pid = $row->product_id;
    $qty = $row->qty;
    $return = $pdo->prepare("UPDATE tbl_product SET pstock = pstock + '$qty' WHERE pid=$pid");
    $return->execute();
}

$get = $select->fetch(PDO::FETCH_OBJ);
$sql = "delete tbl_invoice , tbl_invoice_details FROM tbl_invoice INNER JOIN tbl_invoice_details ON tbl_invoice.invoice_id = tbl_invoice_details.invoice_id where tbl_invoice.invoice_id=$id";
$delete = $pdo->prepare($sql);
if ($delete->execute()) {
} else {
    echo 'Delete failed';
}

$sql2 = "DELETE tbl_invoice FROM tbl_invoice WHERE invoice_id=$id";
$inv = $pdo->prepare($sql2);
$inv->execute();

$trx_bank = $pdo->prepare("DELETE bank_ac FROM bank_ac WHERE oid = $id");
$trx_bank->execute();

$trx_cash = $pdo->prepare("DELETE cash_ac FROM cash_ac WHERE oid = $id");
$trx_cash->execute();
