<?php 
// THIS WILL ADD MORE ITEM TO EXISTING ORDER ID
include_once 'connectdb.php';
include_once 'config.php';

$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_product WHERE barcode=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);

    //FOR TBL_INVOICE
    $subtotal = $row['saleprice'] * $_GET['qty'];
    $order_date = date('Y-m-d');
    $tax = ($row['saleprice'] * $tax_rate) * $_GET['qty'];
    $discount = (($row['saleprice'] + ($row['saleprice'] * $tax_rate)) * ($_GET['dis'] / 100)) * $_GET['qty'];
    $total = $row['saleprice'];
    $paid = (($row['saleprice'] + ($row['saleprice'] * $tax_rate)) - ($row['saleprice'] + ($row['saleprice'] * $tax_rate)) * ($_GET['dis'] / 100)) * $_GET['qty'];
    $due = 0;
    $profit = $row['profit'] * $_GET['qty'];
    $stock = $row['pstock'];
    $qty = $_GET['qty'];
    $pid = $row['pid'];  
    $productname = $row['pname'];
    $inv = $_GET['invid'];

    $insert = $pdo->prepare("UPDATE tbl_invoice SET subtotal=subtotal+".$subtotal.",tax=tax+ ".$tax.",discount=discount + ".$discount.",total=total + ".$total.",paid=paid + ".$paid.",due=due + ".$due.",profit=profit + ".$profit." WHERE invoice_id='".$inv."'");

    $insert->bindParam('subtotal',$subtotal);
    $insert->bindParam('tax',$tax);
    $insert->bindParam('disc',$discount);
    $insert->bindParam('total',$total);
    $insert->bindParam('paid',$paid);
    $insert->bindParam('due',$due);
    $insert->bindParam('profit',$profit);
    if($insert->execute()){
            echo '.';
        } else {
             echo 'failed';
        }
$invoice_id = $_GET['invid'];
    //FOR TBL_INVOICE_DETAILS
//if($invoice_id != null){
//        
//        $rem_qty = $stock - $qty;
//        $update = $pdo->prepare("UPDATE tbl_product SET pstock='$rem_qty' WHERE barcode='".$id."'");
//        $update->execute();
//        
//        $insert = $pdo->prepare("INSERT INTO tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date,profit) values(:invid,:pid,:pname,:qty,:price,:orderdate,:profit)");
//        
//        $insert->bindParam(':invid',$invoice_id);
//        $insert->bindParam(':pid',$pid);
//        $insert->bindParam(':pname',$productname);
//        $insert->bindParam(':qty',$qty);
//        $insert->bindParam(':price',$total);
//        $insert->bindParam(':orderdate',$order_date);
//        $insert->bindParam(':profit',$profitt);
//        $insert->execute();
//    }
    if($inv != null){
            $rem_qty = $stock - $qty;
            $update = $pdo->prepare("UPDATE tbl_product SET pstock='$rem_qty' WHERE barcode='".$id."'");
            if($update->execute()){
            echo '.';
        } else {
             echo 'failed';
        }
            
            $insert = $pdo->prepare("INSERT INTO tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date,profit) values(:invid,:pid,:pname,:qty,:price,:orderdate,:profit)");
            
        $insert->bindParam(':invid',$invoice_id);
        $insert->bindParam(':pid',$pid);
        $insert->bindParam(':pname',$productname);
        $insert->bindParam(':qty',$qty);
        $insert->bindParam(':price',$total);
        $insert->bindParam(':orderdate',$order_date);
        $insert->bindParam(':profit',$profit);
        if($insert->execute()){
            echo '.';
        } else {
             echo 'error';
        }
                
    }
?>
Item added!