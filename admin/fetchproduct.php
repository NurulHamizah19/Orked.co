<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "sferapos-app");
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($connect, $_POST["query"]);
 $query = "
  SELECT * FROM tbl_product 
  WHERE pname LIKE '%".$search."%'
  OR barcode LIKE '%".$search."%' 
  OR pid LIKE '%".$search."%' 
 ";
}
else
{
 $query = "
  SELECT * FROM tbl_product ORDER BY pid
 ";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    <tr>
     <th>ID</th>
     <th>Product Name</th>
     <th>Barcode</th>
     <th>-</th>
    </tr>
 ';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
   <tr>
    <td>'.$row["pid"].'</td>
    <td>'.$row["pname"].'</td>
    <td>'.$row["barcode"].'</td>
    <td><button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></td>
   </tr>
  ';
 }
 echo $output;
}
else
{
 echo 'Data Not Found';
}

?>