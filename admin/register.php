<?php 
include_once 'connectdb.php';
session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
}

include_once 'header.php';

error_reporting(0);
$id = $_GET['id'];
if(isset($id)){
$delete = $pdo->prepare("DELETE FROM tbl_user WHERE userid=".$id);
if($delete->execute()){
    echo '
        <script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Success",
          text: "User deleted",
          icon: "success",
        });
        });
        window.setTimeout(function(){
                  window.location= "register.php";
            
              }, 3000);
                </script>';
} 
}
if(isset($_POST['btnsave'])){
$username = $_POST['txtname'];
$useremail = $_POST['txtemail'];
$login = $_POST['txtlogin'];
$password = $_POST['txtpassword'];
$userrole = $_POST['txtselect_option'];

// echo $username ."-".$useremail."-".$password."-".$userrole;
    
    if(isset($_POST['txtemail'])){
        $select = $pdo->prepare("SELECT useremail FROM tbl_user WHERE login='$login'");
        $select->execute();
        if($select->rowCount() > 0){
            echo '
        <script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Failed!",
          text: "User ID already existed!",
          icon: "warning",
        });
        });
        
        </script>';
        } else{
    
    $insert = $pdo->prepare("INSERT INTO tbl_user(username,useremail,password,role,login) values(:name,:email,:pass,:role,:login)");
    
    $insert->bindParam(':name',$username);
    $insert->bindParam(':email',$useremail);
    $insert->bindParam(':login',$login);
    $insert->bindParam(':pass',$password);
    $insert->bindParam(':role',$userrole);
    
    if($insert->execute()){
        echo '
        <script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Success",
          text: "'.$_POST['txtname'].' is registered!",
          icon: "success",
        });
        });
        
        </script>';
    } else {
        echo '
        <script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Failed!",
          text: "Query problem",
          icon: "error",
        });
        });
        
        </script>';
    }
        }
}
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Register
        <small>Allowing additional user to use the platform with their own credentials</small>
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
    <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registration form</h3>
            </div>
            <!-- /.box-header -->
            
            <!-- form start  -->
            <form role="form" action="" method="post">
              <div class="box-body">
                          <div class="col-md-4">
                                 
                <div class="form-group">
                  <label >Name</label>
                  <input type="text" class="form-control" name="txtname" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                  <label >Login ID</label>
                  <input type="text" class="form-control" name="txtlogin" placeholder="Enter Login ID" required>
                </div>         
                <div class="form-group">
                  <label >Email address</label>
                  <input type="email" class="form-control" name="txtemail" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <label >Password</label>
                  <input type="password" class="form-control" name="txtpassword" placeholder="Password" required>
                </div>
               
 <div class="form-group">
                  <label>Role</label>
                  <select class="form-control" name="txtselect_option" required>
                    <option value="" disabled selected>Select role</option>
                   <option>User</option>
                     <option>Admin</option>
                     <option>Agent</option>
                    
                  </select>
                </div>
                
                 <button type="submit" class="btn btn-info" name="btnsave">Save</button>  
                  
              </div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Login ID</th>
                            <th>Role</th>
                            <th>View</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = $pdo->prepare("SELECT * FROM tbl_user ORDER BY userid desc");
                        $select->execute();
                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            echo '
                            <tr>
                            <td>'.$row->userid.'</td>
                            <td>'.$row->username.'</td>
                            <td>'.$row->useremail.'</td>
                            <td>'.$row->login.'</td>
                            <td>'.$row->role.'</td>
                            <td>
                            <a href="viewuser.php?id='.$row->userid.'" class="btn btn-primary viewUser" role="button"><span class="glyphicon glyphicon-eye-open" title="view"
                            </td></a>
                            <td>
                            <a href="register.php?id='.$row->userid.'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"
                            </td></a>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
                <!-- 
                 -->
              </div>
              <!-- /.box-body -->
            </form>
          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php 
if(!empty($_GET['view_id'])){
  $userid = $_GET['view_id'];
  $select = $pdo->prepare("SELECT * FROM tbl_user WHERE userid = $userid");
  $row = $select->fetch(PDO::FETCH_OBJ);
  $user_name = $row->username;
  $user_email = $row->useremail;
  $user_role = $row->role;
  $user_comms = $row->comms;
  
}
?>

<?php
include_once 'footer.php'
?>