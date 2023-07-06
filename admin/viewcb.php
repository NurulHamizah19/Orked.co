<?php 
include_once'connectdb.php';
session_start();
if($_SESSION['useremail']==""){
    header('location:index.php');
}
$id = $_GET['id'];
include_once 'header.php';

if(isset($_POST['deletecb'])){
  $id = $_GET['id'];
$sql="DELETE tbl_cb FROM tbl_cb WHERE cb_id=$id";
$delete = $pdo->prepare($sql);
if($delete->execute()){
    echo '<script type="text/javascript">
    jQuery(function validation(){
        swal({
          title: "Success",
          text: "Transaction deleted",
          icon: "success",
          button: "Ok",
        });
    });
    window.setTimeout(function(){
      window.location= "cashbook.php";

  }, 1000);
    </script>';
} else {
    echo 'Delete failed';
}
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Viewing Transaction <?php echo '#'.$id; ?>
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
                <h3 class="box-title"><a href="cashbook.php" class="btn btn-success" role="button">Back To Cash Book</a></h3> <br>
                
            </div>
            
            <div class="box-body">
                <?php
                $id = $_GET['id'];
                $select = $pdo->prepare("SELECT *, DATE_FORMAT(cb_date, '%d/%m/%Y') AS cb_date FROM tbl_cb WHERE cb_id=$id");
                $select->execute();
                
                while($row = $select->fetch(PDO::FETCH_OBJ)){
                    echo '
                    <div class="col-md-6">
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Transaction Details</b></p></center>
                      <li class="list-group-item">ID <span class="badge">'.$row->cb_id.'</span></li>
                      <li class="list-group-item">Transaction Details <span class="label label-primary pull-right">'.$row->dc.'</span></li>
                      <li class="list-group-item">Date <span class="label label-warning pull-right">'.$row->cb_date.'</span></li>
                      <li class="list-group-item">Transaction Details <span class="label label-warning pull-right">'.$row->detail.'</span></li>';
					if($row->dc == "Debit"){
						echo '<li class="list-group-item">Amount<span class="label label-success pull-right">RM '.$row->d_amount.'</span></li>';
					} else {
						echo '<li class="list-group-item">Amount<span class="label label-success pull-right">RM '.$row->c_amount.'</span></li>';
					}
					if($row->dc == "Debit"){
						echo '
                      <li class="list-group-item">Payer Name<span class="label label-success pull-right">'.($row->name).'</span></li>';
					} else {
						echo '
                      <li class="list-group-item">Payee Name<span class="label label-success pull-right">'.($row->name).'</span></li>';
					}
                      echo '
                      <li class="list-group-item">Reference : &nbsp;&nbsp;&nbsp;&nbsp;'.$row->reference.'</li>
                      
                    </ul>
                    <form action="" method="POST">
                <button class="btn btn-danger" name="deletecb" role="button">Delete Transaction</button>
                </form>
                    </div>
                    <div class="col-md-6">
                    <center><p class="list-group-item list-group-item-success"><b>Receipt</b></p></center>';
                    if($row->receipt == null){
                    echo'<center><img src="noimage.png" width="300px" height-="300px" class="img-responsive"></center>';} else {echo'<img src="productimages/'.$row->receipt.'" class="img-responsive">';}
                    echo '
                    </div>
                    ';
                }
                ?>



            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include_once 'footer.php'
?>