<?php 
include_once'connectdb.php';
session_start();
if($_SESSION['useremail']==""){
    header('location:index.php');
}
date_default_timezone_set('Asia/Kuala_Lumpur');
if($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent"){
    include_once 'headeruser.php';
} else {
    include_once 'header.php';
}

$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_user WHERE userid=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

if(isset($_POST['btnupdate'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comms = $_POST['comms'];
    print_r("sssssssssssssssssssssssssssss".$name);

    $update = $pdo->prepare("UPDATE tbl_user SET username=:name,useremail=:email,comms=:comms WHERE userid = $id");
    $update->bindParam(":name", $name);
    $update->bindParam(":email", $email);
    $update->bindParam(":comms", $comms);
    if($update->execute()){
        echo '<script type="text/javascript">
            jQuery(function validation(){
                swal({
                  title: "Success",
                  text: "User settings saved!",
                  icon: "success",
                  button: "Ok",
                });
            });
            window.setTimeout(function(){
              window.location= "register.php";
            }, 2000);

            </script>';
    }

}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View User (ID:<?php echo $id; ?>)
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="register.php" class="btn btn-primary" role="button">Back To User List</a></h3>
            </div>
            
            <div class="box-body">
                <form action="" method="post">
                
                    <div class="form-group">
                    <label>Login ID</label>
                    <input type="text" class="form-control" name="login" value="<?php echo $row->login; ?>" readonly required>
                    </div>
                    <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $row->username; ?>" required>
                    </div>
                    <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $row->useremail; ?>" required>
                    </div>
                    <div class="form-group">
                    <label>Role</label>
                    <input type="text" class="form-control" name="role" value="<?php echo $row->role; ?>" readonly required>
                    </div>
                    <div class="form-group">
                    <label>Commissions (%)</label>
                    <input type="number" step="any" min="0" class="form-control" name="comms" value="<?php echo $row->comms; ?>"  required>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-info" name="btnupdate">Edit</button>
                    </div>
                </form>
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