<?php
include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "") {
  header('location:index.php');
}
date_default_timezone_set('Asia/Kuala_Lumpur');
if ($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent") {
  include_once 'headeruser.php';
} else {
  include_once 'header.php';
}
include_once 'phpqrcode/qrlib.php';
$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);
$text = "" . $row->barcode;

?>

<?php
if (isset($_POST['btnrestock'])) {
  $id = $_POST['id'];
  $restock = $_POST['txtrestock'];
  $lastupdate = date('d-m-Y H:i');
  $update = $pdo->prepare("UPDATE tbl_product SET pstock = pstock + '$restock', last_update = '$lastupdate', stockup = stockup + '$restock' WHERE pid='$id'");
  if ($update->execute()) {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Stock successfully updated",
                      icon: "success",
                      button: "Ok",
                    });
                });

                </script>';
  } else {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Failed to update stock",
                      icon: "error",
                      button: "Ok",
                    });
                });

                </script>';
  }
  echo '<script>
        window.setTimeout(function(){
        window.location.href = "product-list.php";
        }, 2000);
    </script>';
}
?>

<?php
if (isset($_POST['btnwithdraw'])) {
  $id = $_POST['id'];
  $withdraw = $_POST['txtwithdraw'];
  $lastupdate = date('d-m-Y H:i');
  $update = $pdo->prepare("UPDATE tbl_product SET pstock = pstock - '$withdraw', last_wupdate = '$lastupdate', stockout = stockout + '$withdraw' WHERE pid='$id'");
  if ($update->execute()) {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Stock successfully updated",
                      icon: "success",
                      button: "Ok",
                    });
                });

                </script>';
  } else {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Failed to update stock",
                      icon: "error",
                      button: "Ok",
                    });
                });

                </script>';
  }
  echo '<script>
        window.setTimeout(function(){
        window.location.href = "product-list.php";
        }, 2000);
    </script>';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View Product
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">

    <!--------------------------
        | Your Page Content Here |
        -------------------------->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"><a href="product-list.php" class="btn btn-primary" role="button">Back To Product List</a></h3>
      </div>

      <div class="box-body">
        <?php
        $id = $_GET['id'];
        $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
        $select->execute();

        while ($row = $select->fetch(PDO::FETCH_OBJ)) {
          echo '
                    <div class="col-md-6">
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Product</b></p></center>
                      <li class="list-group-item">ID <span class="badge">' . $row->pid . '</span></li>
                      <li class="list-group-item">Product Name <span class="label label-primary pull-right">' . $row->pname . '</span></li>
                      <li class="list-group-item">Category <span class="label label-warning pull-right">' . $row->pcategory . '</span></li>';
          if ($_SESSION['role'] == "Admin") {
            echo '<li class="list-group-item">Sale Price <span class="label label-success pull-right">' . $row->saleprice . '</span></li>
                        <li class="list-group-item">Purchase Price <span class="label label-warning pull-right">' . $row->purchaseprice . '</span></li>
                        <li class="list-group-item"><b>Product Profit </b><span class="label label-success pull-right">' . ($row->saleprice - $row->purchaseprice) . '</span></li>
                        <li class="list-group-item">Current Stock <span class="label label-danger pull-right">' . $row->pstock . '</span></li>
                        ';
          }

          echo '
                      <li class="list-group-item">Unit Sold <span class="label label-danger pull-right">' . $row->sold . '</span></li>
                      <li class="list-group-item">Barcode <span class="label label-info pull-right">' . $row->barcode . '</span></li>
                      <li class="list-group-item">Last Restock Date<span class="badge">' . $row->last_update . '</span></li>
                      <li class="list-group-item">Last Withdraw Date<span class="badge">' . $row->last_wupdate . '</span></li>
                      <li class="list-group-item">Total Restock<span class="badge">' . $row->stockup . '</span></li>
                      <li class="list-group-item">Total Stock Withdraw<span class="badge">' . $row->stockout . '</span></li>
                      <li class="list-group-item"><b>Description: -</b> <span>' . $row->pdescription . '</span></li>
                      
                    </ul>';
        } ?>
        <?php
        $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_OBJ);




        ?>
      </div>
      <div class="col-md-6">
        <center>
          <p class="list-group-item list-group-item-success"><b>Product Image</b></p>
        </center>

        <?php
        if ($row->pimage != null) {
          echo '<center><img src="productimages/' . $row->pimage . '" class="img-responsive"></center>';
        } else {
          echo '<center><img src="noimage.png" height="300px" width="300px" class="img-responsive"></center>';
        }
        ?>
      </div>
      <?php if($row->barcode): ?>
      <div class="col-md-6">
        <center>
          <p class="list-group-item list-group-item-success"><b>Product QR / Barcode</b></p>
        </center>
        <center><img src="barcode.php?f=png&s=ean-128&d=<?php echo $row->barcode; ?>" class="img-responsive">
        </center>
        <br>
      </div>
      <?php endif; ?>
      <div class="col-md-6">
        <center>
          <p class="list-group-item list-group-item-success"><b>Stock</b></p>
        </center>
        <br>
        <center><a href="stock-view.php?id=<?php echo $id; ?>" class="btn btn-info" name="btnrestock">Manage Stock </a></center>
        <br>
        <br>
      </div>





    </div>

</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once 'footer.php'
?>