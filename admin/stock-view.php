<?php
include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "") {
  header('location:index.php');
}
if ($_SESSION['role'] == "User") {
  include_once 'headeruser.php';
} else {
  include_once 'header.php';
}
include_once 'phpqrcode/qrlib.php';
$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

function get_pname($id, $pdo)
{
  $product = $pdo->prepare("SELECT pname FROM tbl_product WHERE pid=$id");
  $product->execute();
  $get = $product->fetch(PDO::FETCH_OBJ);
  $pname = $get->pname;
  return $pname;
}
function get_pstock($id, $pdo)
{
  $product = $pdo->prepare("SELECT pstock FROM tbl_product WHERE pid=$id");
  $product->execute();
  $get = $product->fetch(PDO::FETCH_OBJ);
  $pstock = $get->pstock;
  return $pstock;
}
?>

<?php
if (isset($_POST['btnrestock'])) {
  $id = $_POST['id'];
  $restock = $_POST['txtrestock'];
  $remark = $_POST['remark'];
  $lastupdate = date('d-m-Y H:i');
  $getstock = get_pstock($id, $pdo);
  $total_stock = $getstock + $restock;
  $update = $pdo->prepare("UPDATE tbl_product SET pstock = pstock + '$restock', last_update = '$lastupdate', stockup = stockup + '$restock' WHERE pid='$id'");
  if ($update->execute()) {
    $insert_log = $pdo->prepare("INSERT INTO stock_log(pid,restock,total_stock,remark) VALUES(:pid,:restock,:total_stock,:remark)");
    $insert_log->bindParam(":pid", $id);
    $insert_log->bindParam(":restock", $restock);
    $insert_log->bindParam(":remark", $remark);
    $insert_log->bindParam(":total_stock", $total_stock);
    $insert_log->execute();
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
}
?>

<?php
if (isset($_POST['btnwithdraw'])) {
  $id = $_POST['id'];
  $withdraw = $_POST['txtwithdraw'];
  $remark = $_POST['remark'];
  $lastupdate = date('d-m-Y H:i');
  $getstock = get_pstock($id, $pdo);
  $total_stock = $getstock - $withdraw;
  $update = $pdo->prepare("UPDATE tbl_product SET pstock = pstock - '$withdraw', last_wupdate = '$lastupdate', stockout = stockout + '$withdraw' WHERE pid='$id'");
  if ($update->execute()) {
    $insert_log = $pdo->prepare("INSERT INTO stock_log(pid,withdraw,total_stock,remark) VALUES(:pid,:withdraw,:total_stock,:remark)");
    $insert_log->bindParam(":pid", $id);
    $insert_log->bindParam(":withdraw", $withdraw);
    $insert_log->bindParam(":remark", $remark);
    $insert_log->bindParam(":total_stock", $total_stock);
    $insert_log->execute();
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
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Product Stock Log
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
        <h3 class="box-title"><a href="stock-list.php" class="btn btn-primary" role="button">Return To Stock List</a></h3>
        <h3 class="box-title"><a href="product-list.php" class="btn btn-info" role="button">Return To Product List</a></h3>
      </div>

      <div class="box-body">
        <?php
        $id = $_GET['id'];
        $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
        $select->execute();

        while ($row = $select->fetch(PDO::FETCH_OBJ)) {
          echo '
                    <div class="col-md-12">
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Product</b></p></center>
                      <li class="list-group-item">ID <span class="badge" style="font-size:13px;">' . $row->pid . '</span></li>
                      <li class="list-group-item">Product Name <span class="label label-primary pull-right" style="font-size:13px;">' . $row->pname . '</span></li>
                      <li class="list-group-item">Category <span class="label label-warning pull-right" style="font-size:13px;">' . $row->pcategory . '</span></li>
                      <li class="list-group-item">Current Stock <span class="label label-danger pull-right" style="font-size:13px;">' . $row->pstock . '</span></li>
                      <li class="list-group-item">Unit Sold <span class="label label-danger pull-right" style="font-size:13px;">' . $row->sold . '</span></li>
                      <li class="list-group-item">Last Restock Date<span class="badge" style="font-size:13px;">' . $row->last_update . '</span></li>
                      <li class="list-group-item">Last Withdraw Date<span class="badge" style="font-size:13px;">' . $row->last_wupdate . '</span></li>
                      <li class="list-group-item">Total Restock<span class="badge" style="font-size:13px;">' . $row->stockup . '</span></li>
                      <li class="list-group-item">Total Stock Withdraw<span class="badge" style="font-size:13px;">' . $row->stockout . '</span></li>
                      
                    </ul>
                    </div>';
        } ?>
        <?php
        $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_OBJ);




        ?>


        <?php
        if ($_SESSION['role'] == "Admin") {
          echo '
                  <div class="col-md-6">
                    <center><p class="list-group-item list-group-item-success"><b>Restock Product</b></p></center>
                    
                    <form method= "post">    
                    <li class="list-group-item">Amount to Restock <input type="number" step="any" name="txtrestock" class="form-control"/></li>
                    <li class="list-group-item">Remark <input type="text" name="remark" class="form-control"/></li>
                    <input type="hidden" name="id" value="' . $_GET['id'] . '">
                    <input type="hidden" name="lastupdate" value="' . date('Y-m-d H:i') . '">
                    
                    <br>
                    <center><button type="submit" class="btn btn-info" name="btnrestock">Restock Product</button></center>
                    <br>
                    </form>
                 </div>
                  
                  ';
        }

        ?>

        <?php
        if ($_SESSION['role'] == "Admin") {
          echo '
                  <div class="col-md-6">
                    <center><p class="list-group-item list-group-item-success"><b>Withdraw Stock</b></p></center>
                   
                    <form method="post">    
                    <li class="list-group-item">Amount to Withdraw <input type="number" step="any" name="txtwithdraw" class="form-control"/></li>
                    <li class="list-group-item">Remark <input type="text" name="remark" class="form-control"/></li>
                    <input type="hidden" name="id" value="' . $_GET['id'] . '">
                    <input type="hidden" name="lastupdate" value="' . date('Y-m-d H:i') . '">
                    <br>
                    <center><button type="submit" class="btn btn-danger" name="btnwithdraw">Withdraw Product</button></center>
                    <br>
                    </form>
                    </div>
                  ';
        }
        ?>
        <div class="col-md-12">
          <div style="overflow-x:auto;">
            <table id="producttable" class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Remark</th>
                  <th>Total Stock</th>
                  <th>Stock Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $select = $pdo->prepare("SELECT * FROM stock_log ORDER BY id asc");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                  if ($row->pid == $id) {
                    $when = strtotime($row->timestamp);
                    $dt = date('d/m/Y H:i:s', $when);
                    echo '
                                <tr>
                                <td>' . $row->id . '</td>
                                <td>' . get_pname($id, $pdo) . '</td>';

                    if ($row->restock != 0) {
                      echo '<td>Restock</td>';
                      echo '<td>' . $row->restock . '</td>';
                    }
                    if ($row->withdraw != 0) {
                      echo '<td>Withdraw</td>';
                      echo '<td>' . $row->withdraw . '</td>';
                    }
                    echo '
                                <td>' . $row->remark . '</td>
                                <td>' . $row->total_stock . '</td>
                                <td>' . $dt . '</td>';
                  }
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>

      </div>

    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    $('#producttable').DataTable({
      "order": [
        [0, "desc"]
      ],
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });
  });
</script>
<?php
include_once 'footer.php'
?>