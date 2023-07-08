<?php
include_once 'connectdb.php';
session_start();
include_once 'header.php';
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('Location:index.php');
}
$id = $_GET['id'];
// DISPLAY DATA
$select = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$name = $row->name;
$address = $row->address;
$postcode = $row->postcode;
$city = $row->city;
$state = $row->state;
$phone = $row->phone;
$email = $row->email;
$points = $row->point;

if (isset($_POST['btnaddclient'])) {
  $id = $_GET['id'];
  $name = $_POST['name'];
  $address = $_POST['address'];  // $_POST['']; 
  $postcode = $_POST['postcode'];
  $city =  $_POST['city'];
  $state = $_POST['state'];
  $phone = $_POST['phone'];
  $points = $_POST['point'];
  $email = ($_POST['email'] == null) ? "N/A" : $_POST['email'];


  $insert = $pdo->prepare("UPDATE tbl_client SET name=:name,address=:address,postcode=:postcode,city=:city,state=:state,phone=:phone,point=:point,email=:email WHERE id=$id");

  $insert->bindParam(':name', $name);
  $insert->bindParam(':address', $address);
  $insert->bindParam(':postcode', $postcode);
  $insert->bindParam(':city', $city);
  $insert->bindParam(':state', $state);
  $insert->bindParam(':phone', $phone);
  $insert->bindParam(':point', $points);
  $insert->bindParam(':email', $email);

  if ($insert->execute()) {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Client successfully updated",
                      icon: "success",
                      button: "Ok",
                    });
                });
                setTimeout(function () {
                    window.location.href = "client-list.php"; 
                 }, 2000);
                </script>';
  } else {
    echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Failed to update client",
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
      Edit Client <?php echo "(ID:" . $id . ")"; ?>
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
              <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
              <label>Address</label>
              <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" placeholder="Enter Address">
            </div>
            <div class="form-group">
              <label>Postcode</label>
              <input type="number" class="form-control" maxlength="5" value="<?php echo $postcode; ?>" name="postcode" placeholder="Enter Postcode">
            </div>
            <div class="form-group">
              <label>City</label>
              <input type="text" class="form-control" name="city" value="<?php echo $city; ?>" placeholder="Enter City">
            </div>
            <div class="form-group">
              <label>State</label>
              <input type="text" class="form-control" name="state" value="<?php echo $state; ?>" placeholder="Enter State">
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Phone Number</label>
              <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" placeholder="Enter Phone Number" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Enter Email" >
            </div>
            <div class="form-group">
              <label>Adjust Point</label>
              <input type="number" min="0" class="form-control" name="point" value="<?php echo $points; ?>" required>
            </div>

          </div>
        </div>
        <div class="box-footer">
          <center><button type="submit" class="btn btn-info" name="btnaddclient">Edit client</button></center>

        </div>
      </form>

    </div>


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style>
  #mapCanvas {
    width: 500px;
    height: 400px;
    float: left;
  }

  #infoPanel {
    float: left;
    margin-left: 10px;
  }

  #infoPanel div {
    margin-bottom: 5px;
  }
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAq2rK2ypqHd2gyWUgFAy7CfuIMzHQPibs&callback=initMap"></script>
<script type="text/javascript">
  var geocoder = new google.maps.Geocoder();

  function geocodePosition(pos) {
    geocoder.geocode({
      latLng: pos
    }, function(responses) {
      if (responses && responses.length > 0) {
        updateMarkerAddress(responses[0].formatted_address);
      } else {
        updateMarkerAddress('Cannot determine address at this location.');
      }
    });
  }

  function updateMarkerStatus(str) {
    document.getElementById('markerStatus').innerHTML = str;
  }

  function updateMarkerPosition(latLng) {
    document.getElementById('info').innerHTML = [
      latLng.lat(),
      latLng.lng()
    ].join(', ');
    $("#lat").val(latLng.lat());
    $("#long").val(latLng.lng());
  }

  function initialize() {
    var latLng = new google.maps.LatLng(2.939631, 101.454696);
    var map = new google.maps.Map(document.getElementById('mapCanvas'), {
      zoom: 8,
      center: latLng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
      position: latLng,
      title: 'Point A',
      map: map,
      draggable: true
    });

    // Update current position info.
    updateMarkerPosition(latLng);
    geocodePosition(latLng);

    // Add dragging event listeners.
    google.maps.event.addListener(marker, 'dragstart', function() {
      updateMarkerAddress('Dragging...');
    });

    google.maps.event.addListener(marker, 'drag', function() {
      updateMarkerStatus('Dragging...');
      updateMarkerPosition(marker.getPosition());
    });

    google.maps.event.addListener(marker, 'dragend', function() {
      updateMarkerStatus('Drag ended');
      geocodePosition(marker.getPosition());
    });
  }

  // Onload handler to fire off the app.
  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php
include_once 'footer.php';
?>