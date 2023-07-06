<?php 
include_once 'connectdb.php';
session_start();
$id = $_GET['id'];
// DISPLAY DATA
$select = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$coord = $row->coord;

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SferaPOS</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/sweetalert/sweetalert.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="Chart.js-2.9.3/dist/Chart.min.js"></script>
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootsrap.min.css">
<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="plugins/iCheck/all.css">
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
  <header class="main-header">
    <a href="#" class="logo">
      <span class="logo-mini"><b>S</b>POS</span>
      <span class="logo-lg"><b>Sfera</b>POS</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
  </aside>


<?php

if(isset($_POST['btnmap'])){
    $id = $_GET['id'];
    $coord = "0";
    $lat = $_POST['lat'];  // $_POST['']; 
    $lng = $_POST['lng']; 
      
        $insert = $pdo->prepare("UPDATE tbl_client SET coord=:coord,lat=:lat,lng=:lng WHERE id=$id");
        
        $insert->bindParam(':coord',$lat);
        $insert->bindParam(':lat',$lat);
        $insert->bindParam(':lng',$lng);
        
        if($insert->execute()){
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Map record sent",
                      icon: "success",
                      button: "Ok",
                    });
                });
                setTimeout(function () {
                    window.location.href = "clientlist.php"; 
                 }, 2000);
                </script>';
        } else {
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Failed to send data",
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
        Please pinpoint the delivery location of your order<?php echo " (ID:".$id.")"; ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <?php 
        if($coord == "1"){
            echo '
            <div class="box box-info">
            <!-- <div class="box-header with-border">
                <h3 class="box-title"><a href="clientlist.php" class="btn btn-primary" role="button">Back To Client List</a></h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post">

            <div class="box-body">
            <div class="col-md-6">
                
            <div class="form-group">
                  <label>Coordinate</label>
                  <input type="text" class="form-control" name="lat" id="lat" readonly>
                  <input type="text" class="form-control" name="lng" id="long" readonly>
                </div>
                <div id="mapCanvas"></div>
  <div id="infoPanel">
    <b>Marker status:</b>
    <div id="markerStatus"><i>Click and drag the marker.</i></div>
    <b>Current position:</b>
    <div id="info"></div>
  </div>
                
               
            </div>
            </div>
            <div class="box-footer">
<center><button type="submit" class="btn btn-info" name="btnmap">Send data</button></center>
                            
            </div>
            </form>

        </div>
            
            ';
        } else {
            echo '<div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">You are not permitted to view this page</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post">

            <div class="box-body">
            

        </div>';
        }
        ?>
        
        

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
  var latLng = new google.maps.LatLng(3.134364348338916, 101.6902154091797);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 12,
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