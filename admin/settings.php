<?php
include_once 'connectdb.php';
session_start();
include_once 'header.php';
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}

$select = $pdo->prepare("SELECT * FROM config WHERE id=1");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$shop_name = $row->shop_name;
$ssm = $row->ssm;
$address = $row->address;  // $_POST['']; 
$city =  $row->city;
$postcode =  $row->postcode;
$state = $row->state;
$phone = $row->phone;
$tax = $row->tax;
$prefix = $row->prefix;
$logo = $row->image;

if (isset($_POST['btnupdate'])) {

  $shop_name = $_POST['shop_name'];
  $ssm = $_POST['ssm'];
  $address = $_POST['address'];  // $_POST['']; 
  $city =  $_POST['city'];
  $postcode = $_POST['postcode'];
  $state = $_POST['sstate'];
  $phone = $_POST['phone'];
  $tax = $_POST['tax'];
  $prefix = $_POST['prefix'];

  //echo "<pre>";

  $f_name = $_FILES['myfile']['name']; // get file name
  if ($f_name == "") {
    $productimage = $logo;
  } else {
    $f_tmp = $_FILES['myfile']['tmp_name']; // from tmp xampp folder
    $f_size = $_FILES['myfile']['size']; // determine size
    $f_extension = explode('.', $f_name); //change string to array
    $f_extension = strtolower(end($f_extension)); // end takes the last part of file. so it is jpg etc. ADD STRTOLOWER too.
    $f_newfile = uniqid() . '.' . $f_extension; // do not overwrite file
    $store = "images/" . $f_newfile;
    if ($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'jpeg') {
      if ($f_size >= 5000000) {
        $error = '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "File should be less than 5MB",
                      icon: "warning",
                      button: "Ok",
                    });
                });

                </script>';
        echo $error;
      } else {
        if (move_uploaded_file($f_tmp, $store)) {
          $productimage = $f_newfile;
        }
      }
    } else {
      $error = '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Only image files are accepted (JPG, PNG, GIF, JPEG)",
                      icon: "warning",
                      button: "Ok",
                    });
                });

                </script>';
      echo $error;
    }
  }
  if (!isset($error)) {
    $insert = $pdo->prepare("UPDATE config SET shop_name=:shop_name,ssm=:ssm,address=:address,city=:city,postcode=:postcode,state=:state,phone=:phone,tax=:tax,prefix=:prefix,image=:image WHERE id=1");

    $insert->bindParam(':shop_name', $shop_name);
    $insert->bindParam(':ssm', $ssm);
    $insert->bindParam(':address', $address);
    $insert->bindParam(':city', $city);
    $insert->bindParam(':postcode', $postcode);
    $insert->bindParam(':state', $state);
    $insert->bindParam(':phone', $phone);
    $insert->bindParam(':tax', $tax);
    $insert->bindParam(':prefix', $prefix);
    $insert->bindParam(':image', $productimage);

    if ($insert->execute()) {
      echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Shop settings successfully saved",
                      icon: "success",
                      button: "Ok",
                    });
                });
                window.setTimeout(function(){
                  window.location= "settings.php";
            
              }, 2000);
                </script>';
    } else {
      echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Failed to add save",
                      icon: "error",
                      button: "Ok",
                    });
                });

                </script>';
    }
  }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Store Settings
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

    <div class="box box-info">
      <!-- /.box-header -->
      <!-- form start -->
      <form action="" method="post" name="formproduct" enctype="multipart/form-data">

        <div class="box-body">
          <div class="col-md-6">
            <div class="callout callout-success">
              <h4>Shop Details</h4>
              Basic Information of Store - Data will be used for delivery fulfillment
            </div>
            <div class="form-group">
              <label>Company / Store Name</label>
              <input type="text" class="form-control" name="shop_name" placeholder="Company / Store Name" value="<?php echo $shop_name; ?>" required>
            </div>

            <div class="form-group">
              <label>Company ID / SSM</label>
              <input type="text" class="form-control" name="ssm" placeholder="SSM / Company ID" value="<?php echo $ssm; ?>">
            </div>

            <div class="form-group">
              <label>Address</label>
              <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $address; ?>" required>
            </div>
            <div class="form-group">
              <label>City</label>
              <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo $city; ?>" required>
            </div>
            <div class="form-group">
              <label>Postcode</label>
              <input type="text" class="form-control" name="postcode" placeholder="Postcode" value="<?php echo $postcode; ?>" required>
            </div>
            <div class="form-group">
              <label>State</label>
              <input type="text" class="form-control" name="sstate" placeholder="State" value="<?php echo $state; ?>" required>

            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Phone Number</label>
              <input type="number" class="form-control" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>" required>
            </div>
            <div class="form-group">
              <label>Tax (%)</label>
              <input type="number" step="any" class="form-control" name="tax" placeholder="Tax" value="<?php echo $tax; ?>" required>
            </div>
            <div class="form-group">
              <label>Barcode Prefix</label>
              <input type="text" class="form-control" name="prefix" placeholder="SP-XXX (only input letters, suffix ID will be generated by system)" value="<?php echo $prefix; ?>" required>
            </div>
            <div class="form-group" id="image_upload">
              <label>Company/Shop Logo (For invoice creation)</label>
              <input type="file" class="input-group" name="myfile">
              <img class="img-thumbnail" style="width: 200px; length:200px;" src="images/<?php echo $logo; ?>" alt="" />
            </div>
            <br>
            <hr>
          </div>
        </div>
        <div class="box-footer">
          <center><button type="submit" class="btn btn-info" name="btnupdate">Update</button></center>
        </div>
      </form>

    </div>


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    checkboxClass: 'icheckbox_minimal-red',
    radioClass: 'iradio_minimal-red'
  })
</script>
<?php
include_once 'footer.php';
?>