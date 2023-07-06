<?php
# create database connection
$userid = $_REQUEST['userid'];
$connect = mysqli_connect("localhost","root","","sferapos-dsr");
if(!empty($_POST["username"])) {
  $query = "SELECT * FROM tbl_client WHERE id='" . $userid . "'";
  $result = mysqli_query($connect,$query);
  $count = mysqli_num_rows($result);
  $get = mysqli_fetch_array($result);
  $point = $get['point'];
  // var_dump($get);
  if($count>0) {
    echo "<span style='color:green'> Membership point available: $point </span>";
  }else{
    // echo "<span style='color:green'> User available for Registration .</span>";
  }
}
?>