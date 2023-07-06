

<?php 
include_once 'connectdb.php';
session_start();

if($_SESSION['useremail']==""){ //check if empty
    header('location:index.php'); //redirect to index
}
                  
            
if($_SESSION['role'] == "User"){
include_once 'headeruser.php';
} else {
    include_once 'header.php';
}

$config = $pdo->prepare("SELECT * FROM config WHERE id=1");
$config->execute();
$set = $config->fetch(PDO::FETCH_OBJ);
$ep_api = $set->ep_api;
$lala_api = $set->lala_api;
$lala_sec = $set->lala_sec;
$ep_env = $set->ep_env;
$lala_env = $set->lala_env;
$shop_name = $set->shop_name;
$saddress = $set->address;
$scity = $set->city;
$spostcode = $set->postcode;
$sstate = $set->state;
$sphone = $set->phone;
$lala_loc = $set->lala_loc;
$send_lat = $set->lat;
$send_lng = $set->lng;


$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE invoice_id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);
$cid = $row->customer_name;

$select = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$cid");
$select->execute();
$result = $select->fetch(PDO::FETCH_OBJ);
$name = $result->name;
$address = $result->address;
$city = $result->city;
$postcode = $result->postcode;
$state = $result->state;
$phone = $result->phone;
$email = $result->email;
$lat = $result->lat;
$lng = $result->lng;




?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ship Order (EasyParcel)
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
                <h3 class="box-title"><a href="vieworder.php?id=<?php echo $id; ?>" class="btn btn-primary" role="button">Return</a></h3>
            </div>
            <form action="ep_getquote.php" method="post">
            <div class="box-body">
                    <div class="col-md-6">
                    <div class="callout callout-success">
                      <h4>Receiver Info</h4> Customer details for order <?php echo '#'.$id ?>
                    </div>
                      <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Address</label>
                      <input type="text" class="form-control" name="addr1" value="<?php echo $address; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >City</label>
                      <input type="text" class="form-control" name="city" value="<?php echo $city; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Postcode</label>
                      <input type="text" class="form-control" name="postcode" value="<?php echo $postcode; ?>" readonly required>
                    </div>

                    
                    <div class="form-group">
                      <label >State</label>
                      <input type="text" class="form-control" name="state" value="<?php echo $state; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Phone Number</label>
                      <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Email Address</label>
                      <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" readonly required>
                    </div>

                    
                    <div class="callout callout-warning">
                      <h4>Item Details</h4>
                      Please review the item dimensions and weight before getting quote
                    </div>
            <div class="box-body no-padding">
                    <div class="form-group">
                      <label >Weight (kg)</label>
                      <input type="number" class="form-control" step="any" name="weight"  required>
                    </div>
                    <div class="form-group">
                      <label >Width (cm)</label>
                      <input type="number" class="form-control" name="width" required>
                    </div>
                    <div class="form-group">
                      <label >Length (cm)</label>
                      <input type="number" class="form-control" name="length" required>
                    </div>
                    <div class="form-group">
                      <label >Height (cm)</label>
                      <input type="number" class="form-control" name="height"  required>
                    </div>
                    <div class="form-group">
                      <label >Content</label>
                      <input type="text" class="form-control" name="content" required>
                    </div>
                    <div class="form-group">
                      <label >Estimated Value</label>
                      <input type="text" class="form-control" name="value" required>
                    </div>
            </div>
                  
                    </div> 
                
                
                    <div class="col-md-6">
                    <div class="callout callout-info">
                      <h4>Sender Info</h4> You can set your default address at settings
                    </div>
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="sname" value="<?php echo $shop_name; ?>"  required>
                    </div>
                    <div class="form-group">
                      <label >Address</label>
                      <input type="text" class="form-control" name="sadd" value="<?php echo $saddress; ?>"  required>
                    </div>
                    <div class="form-group">
                      <label >City</label>
                      <input type="text" class="form-control" name="scity" value="<?php echo $scity; ?>" required>
                    </div>
                    <div class="form-group">
                      <label >Phone Number</label>
                      <input type="text" class="form-control" name="sphone" value="<?php echo $sphone; ?>" required>
                    </div>
                    <div class="form-group">
                      <label >Email Address</label>
                      <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Postcode</label><small> (this will be your chosen dropoff point)</small>
                      <input type="text" class="form-control" name="spostcode" value="<?php echo $spostcode; ?>"  required>
                    </div>
                    <div class="form-group">
                      <label >State</label>
                      <input type="text" class="form-control" name="sstate" value="<?php if($sstate == "jhr"){ echo 'Johor'; }
                      if($sstate == "kdh"){ echo 'Kedah'; }
                      if($sstate == "ktn"){ echo 'Kelantan'; }
                      if($sstate == "kul"){ echo 'Kuala Lumpur'; }
                      if($sstate == "lbn"){ echo 'Labuan'; }
                      if($sstate == "mlk"){ echo 'Melaka'; }
                      if($sstate == "nsn"){ echo 'Negeri Sembilan'; }
                      if($sstate == "phg"){ echo 'Pahang'; }
                      if($sstate == "png"){ echo 'Perlis'; }
                      if($sstate == "pls"){ echo 'Putrajaya'; }
                      if($sstate == "pjy"){ echo 'Sabah'; }
                      if($sstate == "srw"){ echo 'Sarawak'; }
                      if($sstate == "sgr"){ echo 'Selangor'; }
                      if($sstate == "trg"){ echo 'Terengganu'; }; ?>" readonly required>
                    </div>
                
                <div class="callout callout-danger">
                      <h4>Item List</h4>
                      Please review the item and choose appropriate transportation before getting quote
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
                    <br>
                    <center>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="submit" value="Get Quotation " class="btn btn-danger">
</form> <br><br>
                    </center>
                    </ul> 
                
            </div>
            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
  $(document).ready( function () {
    $('#orderlisttable').DataTable({
        "order":[[0,"desc"]]
    });
} );  
</script>
<?php
include_once 'footer.php'
?>
