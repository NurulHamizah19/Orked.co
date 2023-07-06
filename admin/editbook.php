<?php 
include_once 'connectdb.php';
session_start();
include_once 'header.php';
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('Location:index.php');
}
$id = $_GET['id'];
// DISPLAY DATA
$select = $pdo->prepare("SELECT * FROM tbl_booking WHERE id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$name = $row->name;
$service = $row->service;
$location = $row->location;
$timestamp = date("Y-m-d H:i:s",strtotime($row->datetime));
$phone = $row->phone;
$email = $row->email;
$note = $row->note;

if(isset($_POST['btnaddclient'])){
    $id = $_GET['id'];
    $name = $_POST['name'];
    $service = $_POST['service'];  // $_POST['']; 
    $location = $_POST['location']; 
    $timestamp = date("Y-m-d H:i:s",strtotime($_POST['timestamp'])); 
    $phone = $_POST['phone'];
    $note = $_POST['note'];
    $email = ($_POST['email'] == null) ? "N/A" : $_POST['email'];
      
    $insert = $pdo->prepare("UPDATE tbl_booking SET name=:name,service=:service,location=:location,phone=:phone,datetime=:datetime,email=:email,note=:note WHERE id=$id");
        
        $insert->bindParam(':name',$name);
        $insert->bindParam(':service',$service);
        $insert->bindParam(':location',$location);
        $insert->bindParam(':phone',$phone);
        $insert->bindParam(':datetime',$timestamp);
        $insert->bindParam(':email',$email);
        $insert->bindParam(':note',$note);
        
        if($insert->execute()){
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Booking successfully updated",
                      icon: "success",
                      button: "Ok",
                    });
                });
                setTimeout(function () {
                    window.location.href = "bookinglist.php"; 
                 }, 2000);
                </script>';
        } else {
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Failed to update customer",
                      icon: "error",
                      button: "Ok",
                    });
                });

                </script>';
        }
    
    
}

?>
<link rel="stylesheet" type="text/css" href="datetimepicker/jquery.datetimepicker.css"/ >
<script src="datetimepicker/jquery.js"></script>
<script src="datetimepicker/build/jquery.datetimepicker.full.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Booking <?php echo "(ID:".$id.")"; ?>
        <small>Booking System</small>
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
            <h3 class="box-title"><a href="bookinglist.php" class="btn btn-primary" role="button">Back To Booking List</a></h3>
        </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post">

            <div class="box-body">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Customer Name</label>
                  <input type="text" class="form-control" name="name" value="<?php echo $name;?>" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                  <label>Service</label>
                  <input type="text" class="form-control" name="service" value="<?php echo $service;?>"  placeholder="Enter Service" required>
                </div>
                <div class="form-group">
                  <label>Location</label>
                  <input type="text" class="form-control" name="location" value="<?php echo $location;?>" placeholder="Enter Location" required>
                </div>
                <div class="form-group">
                  <label>Note</label>
                  <input type="text" class="form-control" name="note" value="<?php echo $note;?>" placeholder="Enter Note" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label>Phone Number</label>
                  <input type="text" class="form-control" name="phone"  value="<?php echo $phone;?>" placeholder="Enter Phone Number" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Enter Email" required>
                </div>
                <label>Date/Time</label>
                <div class="form-group">
                  
                  <input type="text" class="form-control pull-right" id="datetimepicker3" name="timestamp" >
                </div>
               
            </div>
            </div>
            <div class="box-footer">
            <center><button type="submit" class="btn btn-info" name="btnaddclient">Edit booking</button></center>
                            
            </div>
            </form>

        </div>
        

    </section>
    <!-- /.content -->
  </div>
  <!-- this should go after your </body> -->
  <!-- this should go after your </body> -->

<script>

$('#datetimepicker3').datetimepicker({
//   format:'Y-m-d H:i:s',
  inline:true,
});

</script>
<?php
include_once 'footer.php';
?>