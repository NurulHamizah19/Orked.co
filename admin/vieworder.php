<?php 
include_once'connectdb.php';
session_start();
error_reporting(0);
if($_SESSION['useremail']==""){
    header('location:index.php');
}
date_default_timezone_set('Asia/Kuala_Lumpur');
if($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent"){
include_once 'headeruser.php';
} else {
    include_once 'header.php';
}
include_once 'phpqrcode/qrlib.php'; 

$config = $pdo->prepare("SELECT * FROM config WHERE id=1");
$config->execute();
$set = $config->fetch(PDO::FETCH_OBJ);
$ep_api = $set->ep_api;
$lala_api = $set->lala_api;
$lala_sec = $set->lala_sec;
$ep_env = $set->ep_env;
$lala_env = $set->lala_env;

$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE invoice_id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);
$cid = $row->customer_name;
$ep_code = $row->ep_orderid;
$awb = $row->awb;
$awb_link = $row->awb_link;
$tracking_url = $row->tracking_url;
$delivery_method = $row->shipment_type;
$ostatus = $row->status;

function client_data($pdo,$cid){
  $output='';
  $select = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$cid");
  $select->execute();
  $result = $select->fetchAll();
  
  foreach($result as $row){
    $id = $_GET['id'];
      $output.='
      ';
      
      echo'
      <center><p class="list-group-item list-group-item-success"><b>Product</b></p></center>
      <li class="list-group-item">ID <span class="badge" style="font-size:13px">'.$id.'</span></li>';
      
      echo'
      <li class="list-group-item">Transaction Date <span class="label label-danger pull-right" style="font-size:13px">'.$row["timestamp"].'</span></li>
      <li class="list-group-item">Customer Name <span class="label label-primary pull-right" style="font-size:13px">'.$row["name"].'</span></li>
      <li class="list-group-item">Address <span class="label label-success pull-right" style="font-size:13px">'.$row["address"].'</span></li>
      <li class="list-group-item">Postcode <span class="label label-success pull-right" style="font-size:13px">'.$row["postcode"].'</span></li>
      <li class="list-group-item">City <span class="label label-success pull-right" style="font-size:13px">'.$row["city"].'</span></li>';
      if($row["state"] == "jhr"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Johor</span></li>'; }
      if($row["state"] == "kdh"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Kedah</span></li>'; }
      if($row["state"] == "ktn"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Kelantan</span></li>'; }
      if($row["state"] == "kul"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Kuala Lumpur</span></li>'; }
      if($row["state"] == "lbn"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Labuan</span></li>'; }
      if($row["state"] == "mlk"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Melaka</span></li>'; }
      if($row["state"] == "nsn"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Negeri Sembilan</span></li>'; }
      if($row["state"] == "phg"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Pahang</span></li>'; }
      if($row["state"] == "prk"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Perak</span></li>'; }
      if($row["state"] == "png"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Penang</span></li>'; }
      if($row["state"] == "pls"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Perlis</span></li>'; }
      if($row["state"] == "pjy"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Putrajaya</span></li>'; }
      if($row["state"] == "srw"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Sarawak</span></li>'; }
      if($row["state"] == "sgr"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Selangor</span></li>'; }
      if($row["state"] == "trg"){ echo '<li class="list-group-item">State <span class="label label-success pull-right" style="font-size:13px">Terengganu</span></li>'; }
      echo'
      <li class="list-group-item">Phone Number <span class="label label-danger pull-right" style="font-size:13px">'.$row["phone"].'</span></li>
      <li class="list-group-item">Email Address <span class="label label-info pull-right" style="font-size:13px">'.$row["email"].'</span></li>';
      
      
  }
  return $output;
}

if(isset($_POST['btnstatus'])){
  $status = $_POST['status'];
  $id = $_GET['id'];
  $insert = $pdo->prepare("UPDATE tbl_invoice SET status=:status WHERE invoice_id=$id");
  $insert->bindParam(':status',$status);
  if($insert->execute()){
    echo '<script type="text/javascript">
        jQuery(function validation(){
            swal({
              title: "Success",
              text: "Order status saved",
              icon: "success",
              button: "Ok",
            });
        });
        setTimeout(function() {
          window.location = "vieworder.php?id='.$id.'";
      }, 3000);
        </script>';
    }
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper no-print">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Order (#<?php echo $id; ?>)
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
                <h3 class="box-title"><a href="orderlist.php" class="btn btn-primary" role="button">Back To Order List</a></h3>
            </div>
            
            <div class="box-body">
            <div class="col-md-6">
                <?php
                $id = $_GET['id'];
                $select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE invoice_id=$id");
                $select->execute();
                
                while($row = $select->fetch(PDO::FETCH_OBJ)){
                    echo '
                    
                    <ul class="list-group">
                    
                      '.client_data($pdo,$cid).'
                      <li class="list-group-item">Commissions <span class="label label-success pull-right" style="font-size:13px">RM '.number_format($row->comms,2).'</span></li>
                      <li class="list-group-item">Seller/Agent ID <span class="label label-success pull-right" style="font-size:13px">'.$row->agentid.'</span></li>
                    ';
                    }?>
                    <?php 
                    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
                    $select->execute();
                    $row = $select->fetch(PDO::FETCH_OBJ);
                    if($delivery_method == 0){
                      echo '<li class="list-group-item">Delivery Method <span class="label label-info pull-right" style="font-size:13px">In-store</span></li></ul>';      
                    }
                    if($delivery_method == 2){
                      echo '<li class="list-group-item">Delivery Method <span class="label label-info pull-right" style="font-size:13px">EasyParcel (Postage)</span></li></ul>';      
                    }
                    
                
                    
                    ?>
                    <?php
                    if($delivery_method == 2){
                      echo' 
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Parcel Info</b></p></center>
                    <li class="list-group-item">EasyParcel Order ID <span class="badge" style="font-size:13px">'.$ep_code.'</span></li>
                    <li class="list-group-item">AWB Number <span class="label label-primary pull-right" style="font-size:13px">'.$awb.'</span></li>
                    <li class="list-group-item">Print AWB <a href="'.$awb_link.'" target="_blank"><span class="label label-danger pull-right" style="font-size:13px">Click Here</span></a></li>
                    <li class="list-group-item">Tracking URL <a href="'.$tracking_url.'" target="_blank"><span class="label label-danger pull-right" style="font-size:13px">Click Here</span></a></li>
                    </ul>';
                    }
                    ?>
                    </div>
        <div class="col-md-6">
            
                
            <div class="box-header">
              <h3 class="box-title">Item List</h3>
            </div>
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">No.</th>
                  <th style="width: 10px">Product Name</th>
                  <th style="width: 10px">Quantity</th>
                  <th style="width: 10px">Unit Price</th>
                </tr>
                <?php 
                 $select = $pdo->prepare("SELECT * FROM tbl_invoice_details WHERE invoice_id=$id");
                 $select->execute();

                 $product_list = $select->fetchAll(PDO::FETCH_OBJ);
                foreach ($product_list as $key => $object) {
                    echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$object->product_name .'</td>
                    <td>'.$object->qty .'</td>
                    <td>RM '.$object->price .'</td>
                    </tr>';
                }
                ?>
              </tbody></table>
              
              
            </div>
            <ul class="list-group">


                <center>
                <br>
                    <div class="col-md-4">
                        <form action="postorder.php" method="get">
                        <input type="hidden" value="<?php echo $id; ?>" name="id" required>
                        <?php 
                        if($delivery_method == 2){
                          if($awb_link == ""){
                            echo '<input type="submit" value="Ship Item" class="btn btn-info" ><br><br>';
                          } else {
                            echo '<input type="submit" value="Ship Item" class="btn btn-info" disabled><br><br>';
                          }
                        } else {
                          echo '<input type="submit" value="Ship Item" class="btn btn-info" disabled><br><br>';
                        }
                        
                        ?>
                        
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="invoice.php" method="get">
                        <input type="hidden" value="<?php echo $id; ?>" name="id" required>
                        <input type="submit" value="Print Receipt" class="btn btn-success"><br><br>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form action="invoice_int.php" method="get">
                        <input type="hidden" value="<?php echo $id; ?>" name="id" required>
                        <input type="submit" value="Print Receipt (USD)" class="btn btn-success"><br><br>
                        </form>
                    </div>
                </center>
                <br>
                <br>
                
                
                    <br>
                    <div class="box-header">
              <h3 class="box-title">Order Status</h3>
            </div>
                    <center>
                    <form action="" method="post"> 
                    <input type="hidden" value="<?php echo $id; ?>" name="id" required>
                        <select class="form-control" name="status">
                        <option value="<?php echo $ostatus; ?>"><?php echo $ostatus; ?></option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="On-hold">On Hold</option>
                            <option value="Failed">Failed</option>
                        </select>
                        <br>
                        <input type="submit" value="Update Order" name="btnstatus" class="btn btn-primary">
                        </form>
                    </center>
                    <br>
                
                
                    
            </ul> 
        
                
            
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