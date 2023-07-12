<?php
include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "") {
  header('location:index.php');
}
if ($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent") {
  include_once 'headeruser.php';
} else {
  include_once 'header.php';
}

if (isset($_POST['btnaddclient'])) {

  $agentid = $_SESSION['userid'];
  $name = $_POST['name'];
  $age = $_POST['age'];
  $dob = $_POST['dob'];
  // $company = $_POST['company'];
  $address = $_POST['address'];  // $_POST['']; 
  $postcode = $_POST['postcode'];
  $city =  $_POST['city'];
  $state = $_POST['state'];
  $phone = $_POST['phone'];
  $phone2 = $_POST['phone2'];
  $email = ($_POST['email'] == null) ? "N/A" : $_POST['email'];
  $icnum = ($_POST['email'] == null) ? "N/A" : $_POST['icnum'];

  $sname = $_POST['sname'];
  // $scompany = $_POST['scompany'];
  $saddress = $_POST['saddress'];
  $spostcode = $_POST['spostcode'];
  $scity = $_POST['scity'];
  $sstate = $_POST['sstate'];
  $sphone = $_POST['sphone'];

  $insert = $pdo->prepare("INSERT INTO tbl_client(agentid,name,age,dob,address,postcode,city,state,phone,phone2,sname,saddress,spostcode,scity,sstate,sphone,email,icnum) values(:agentid,:name,:age,:dob,:address,:postcode,:city,:state,:phone,:phone2,:sname,:saddress,:spostcode,:scity,:sstate,:sphone,:email,:icnum)");

  $insert->bindParam(':agentid', $agentid);
  $insert->bindParam(':age', $age);
  $insert->bindParam(':dob', $dob);
  $insert->bindParam(':name', $name);
  $insert->bindParam(':address', $address);
  $insert->bindParam(':postcode', $postcode);
  $insert->bindParam(':city', $city);
  $insert->bindParam(':state', $state);
  $insert->bindParam(':phone', $phone);
  $insert->bindParam(':phone2', $phone2);
  $insert->bindParam(':sname', $sname);
  $insert->bindParam(':saddress', $saddress);
  $insert->bindParam(':spostcode', $spostcode);
  $insert->bindParam(':scity', $scity);
  $insert->bindParam(':sstate', $sstate);
  $insert->bindParam(':sphone', $sphone);
  $insert->bindParam(':email', $email);
  $insert->bindParam(':icnum', $icnum);

  if ($insert->execute()) {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Client successfully added",
                      icon: "success",
                      button: "Ok",
                    });
                });

                </script>';

    $cid = $pdo->lastInsertId();

    $sql = "INSERT INTO `client_pres` (`cid`, `sph_dv_r`, `cyl_dv_r`, `axix_dv_r`, `vn_dv_r`, `sph_nv_r`, `cyl_nv_r`, `axix_nv_r`, `vn_nv_r`, `add_r`, `sph_dv_l`, `cyl_dv_l`, `axix_dv_l`, `vn_dv_l`, `sph_nv_l`, `cyl_nv_l`, `axix_nv_l`, `vn_nv_l`, `add_l`)
        VALUES (:cid, :sph_dv_r, :cyl_dv_r, :axix_dv_r, :vn_dv_r, :sph_nv_r, :cyl_nv_r, :axix_nv_r, :vn_nv_r, :add_r, :sph_dv_l, :cyl_dv_l, :axix_dv_l, :vn_dv_l, :sph_nv_l, :cyl_nv_l, :axix_nv_l, :vn_nv_l, :add_l)";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind the parameter values
    $stmt->bindParam(':cid', $cid);
    $stmt->bindParam(':sph_dv_r', $_POST['sph_dv_r']);
    $stmt->bindParam(':cyl_dv_r', $_POST['cyl_dv_r']);
    $stmt->bindParam(':axix_dv_r', $_POST['axix_dv_r']);
    $stmt->bindParam(':vn_dv_r', $_POST['vn_dv_r']);
    $stmt->bindParam(':sph_nv_r', $_POST['sph_nv_r']);
    $stmt->bindParam(':cyl_nv_r', $_POST['cyl_nv_r']);
    $stmt->bindParam(':axix_nv_r', $_POST['axix_nv_r']);
    $stmt->bindParam(':vn_nv_r', $_POST['vn_nv_r']);
    $stmt->bindParam(':add_r', $_POST['add_r']);
    $stmt->bindParam(':sph_dv_l', $_POST['sph_dv_l']);
    $stmt->bindParam(':cyl_dv_l', $_POST['cyl_dv_l']);
    $stmt->bindParam(':axix_dv_l', $_POST['axix_dv_l']);
    $stmt->bindParam(':vn_dv_l', $_POST['vn_dv_l']);
    $stmt->bindParam(':sph_nv_l', $_POST['sph_nv_l']);
    $stmt->bindParam(':cyl_nv_l', $_POST['cyl_nv_l']);
    $stmt->bindParam(':axix_nv_l', $_POST['axix_nv_l']);
    $stmt->bindParam(':vn_nv_l', $_POST['vn_nv_l']);
    $stmt->bindParam(':add_l', $_POST['add_l']);

    // Execute the statement
    $stmt->execute();
  } else {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Failed to add client",
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
      Add Client
      <small>Customer Management</small>
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
      <div class="box-header with-border">
        <h3 class="box-title"><a href="client-list.php" class="btn btn-primary" role="button">Back To Client List</a></h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form action="" method="post">

        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label>Customer Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
              <label>Age</label>
              <input type="text" class="form-control" name="age" placeholder="Enter Age" required>
            </div>
            <div class="form-group">
              <label>Date of Birth</label>
              <input type="text" class="form-control" name="dob" placeholder="Enter DOB" required>
            </div>
            <div class="form-group">
              <label>Address</label>
              <input type="text" class="form-control" name="address" placeholder="Enter Address">
            </div>
            <div class="form-group">
              <label>Postcode</label>
              <input type="number" class="form-control" maxlength="5" name="postcode" placeholder="Enter Postcode">
            </div>
            <div class="form-group">
              <label>City</label>
              <input type="text" class="form-control" name="city" placeholder="Enter City">
            </div>
            <div class="form-group">
              <label>State</label>
              <input type="text" class="form-control" name="state" placeholder="Enter State">
            </div>

            <hr>

            <div class="form-group">
              <label>Customer Name (Shipping)</label>
              <input type="text" class="form-control" name="sname" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label>Shipping Address</label>
              <input type="text" class="form-control" name="saddress" placeholder="Enter Address">
            </div>
            <div class="form-group">
              <label>Shipping Postcode</label>
              <input type="number" class="form-control" maxlength="5" name="spostcode" placeholder="Enter Postcode">
            </div>
            <div class="form-group">
              <label>Shipping City</label>
              <input type="text" class="form-control" name="scity" placeholder="Enter City">
            </div>
            <div class="form-group">
              <label>Shipping State</label>
              <input type="text" class="form-control" name="sstate" placeholder="Enter State">
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number" required>
            </div>
            <div class="form-group">
              <label>Phone Number (Secondary)</label>
              <input type="text" class="form-control" name="phone2" placeholder="Enter Phone Number (optional)">
            </div>
            <div class="form-group">
              <label>Phone Number (Shipping)</label>
              <input type="text" class="form-control" name="sphone" placeholder="Enter Phone Number">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter Email">
            </div>
            <div class="form-group">
              <label>IC Number</label>
              <input type="text" class="form-control" name="icnum" placeholder="Enter IC">
            </div>
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Right (Prescription)</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-3">
                    <input type="text" name="sph_dv_r" class="form-control" placeholder="SPH (DV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="cyl_dv_r" class="form-control" placeholder="CYL (DV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="axix_dv_r" class="form-control" placeholder="AXIX (DV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="vn_dv_r" class="form-control" placeholder="V/N (DV)">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                    <input type="text" name="sph_nv_r" class="form-control" placeholder="SPH (NV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="cyl_nv_r" class="form-control" placeholder="CYL (NV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="axix_nv_r" class="form-control" placeholder="AXIX (NV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="vn_nv_r" class="form-control" placeholder="V/N (NV)">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <input type="text" name="add_r" class="form-control" placeholder="ADD">
                  </div>
                </div>
              </div>
            </div>
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Left (Prescription)</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-3">
                    <input type="text" name="sph_dv_l" class="form-control" placeholder="SPH (DV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="cyl_dv_l" class="form-control" placeholder="CYL (DV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="axix_dv_l" class="form-control" placeholder="AXIX (DV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="vn_dv_l" class="form-control" placeholder="V/N (DV)">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3">
                    <input type="text" name="sph_nv_l" class="form-control" placeholder="SPH (NV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="cyl_nv_l" class="form-control" placeholder="CYL (NV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="axix_nv_l" class="form-control" placeholder="AXIX (NV)">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" name="vn_nv_l" class="form-control" placeholder="V/N (NV)">
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <input type="text" name="add_l" class="form-control" placeholder="ADD">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <center><button type="submit" class="btn btn-info" name="btnaddclient">Add client</button></center>

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