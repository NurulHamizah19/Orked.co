<?php 

include_once 'connectdb.php';
include_once 'config.php';

$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_product WHERE barcode=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);

    //FOR TBL_INVOICE
    $customer_name = 'n/a';
    $order_date = date('Y-m-d');
    $subtotal = $row['saleprice'] * $_GET['qty'];
    $tax = ($row['saleprice'] * $tax_rate) * $_GET['qty'];
    $discount = (($row['saleprice'] + ($row['saleprice'] * $tax_rate)) * ($_GET['dis'] / 100)) * $_GET['qty'];
    $total = $row['saleprice'];
    $paid = (($row['saleprice'] + ($row['saleprice'] * $tax_rate)) - ($row['saleprice'] + ($row['saleprice'] * $tax_rate)) * ($_GET['dis'] / 100)) * $_GET['qty'];
    $due = 0;
    $payment_type = "Cash";
    $profit = $row['profit'] * $_GET['qty'];
    $stock = $row['pstock'];
    $qty = $_GET['qty'];
    $pid = $row['pid']; 
    $productname = $row['pname'];

    $insert = $pdo->prepare("INSERT INTO tbl_invoice(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type,profit) values(:cust,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype,:profit)");

    $insert->bindParam(':cust',$customer_name);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':stotal',$subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':total',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':ptype',$payment_type);
    $insert->bindParam(':profit',$profit);
    $insert->execute();

    //FOR TBL_INVOICE_DETAILS
    
        $invoice_id = $pdo->lastInsertId();
echo "Please take note of this invoice ID upon adding new item: ".$invoice_id;
if($invoice_id != null){
        $rem_qty = $stock - $qty;
        $update = $pdo->prepare("UPDATE tbl_product SET pstock='$rem_qty' WHERE barcode='".$id."'");
        $update->execute();
        
        $insert = $pdo->prepare("INSERT INTO tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date,profit) values(:invid,:pid,:pname,:qty,:price,:orderdate,:profit)");
    
        $insert->bindParam(':invid',$invoice_id);
        $insert->bindParam(':pid',$pid);
        $insert->bindParam(':pname',$productname);
        $insert->bindParam(':qty',$qty);
        $insert->bindParam(':price',$total);
        $insert->bindParam(':orderdate',$order_date);
        $insert->bindParam(':profit',$profit);
        $insert->execute();

}
    
?>

    