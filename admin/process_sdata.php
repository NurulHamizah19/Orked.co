<?php
include_once 'connectdb.php';
session_start();
/*
* Write your logic to manage the data
* like storing data in database
*/
 $data = [];
// POST Data
$cname = $_POST['cname'];
$caddress = $_POST['caddress'];
$city = $_POST['city'];
$cpostcode = $_POST['cpostcode'];
$state = $_POST['state'];
$country = $_POST['country'];
$cphone = $_POST['cphone'];
$cemail = $_POST['cemail'];
 
$insert = $pdo->prepare("INSERT INTO tbl_supplier(name,address,postcode,city,state,country,phone,email) values(:name,:address,:postcode,:city,:state,:country,:phone,:email)");
        
$insert->bindParam(':name',$cname);
$insert->bindParam(':address',$caddress);
$insert->bindParam(':postcode',$cpostcode);
$insert->bindParam(':city',$city);
$insert->bindParam(':state',$state);
$insert->bindParam(':country',$country);
$insert->bindParam(':phone',$cphone);
$insert->bindParam(':email',$cemail);
$insert->execute();

exit;
 
?>