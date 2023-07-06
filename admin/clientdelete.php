<?php

include_once 'connectdb.php';
$id = $_POST['pidd'];

$sql="delete tbl_client FROM tbl_client where id=$id";
$delete = $pdo->prepare($sql);
if($delete->execute()){

} else {
    echo 'Delete failed';
}

?>