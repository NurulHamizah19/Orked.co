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
$agentid = $_POST['agentid'];
$caddress = $_POST['caddress'];
$city = $_POST['city'];
$cpostcode = $_POST['cpostcode'];
$state = $_POST['state'];
$cphone = $_POST['cphone'];
$cemail = $_POST['cemail'];
$cicnum = $_POST['cicnum'];
 
$insert = $pdo->prepare("INSERT INTO tbl_client(agentid,name,address,postcode,city,state,phone,email,icnum) values(:agentid,:name,:address,:postcode,:city,:state,:phone,:email,:icnum)");
        
$insert->bindParam(':agentid',$agentid);
$insert->bindParam(':name',$cname);
$insert->bindParam(':address',$caddress);
$insert->bindParam(':postcode',$cpostcode);
$insert->bindParam(':city',$city);
$insert->bindParam(':state',$state);
$insert->bindParam(':phone',$cphone);
$insert->bindParam(':email',$cemail);
$insert->bindParam(':icnum',$cicnum);

if($insert->execute()){
    echo 'inserted';
} else {
    echo 'failed';
}


exit;
 
?>