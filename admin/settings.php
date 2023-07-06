<?php 
include_once 'connectdb.php';
session_start();
include_once 'header.php';
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    header('location:index.php');
}

$select = $pdo->prepare("SELECT * FROM config WHERE id=1");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$shop_name = $row->shop_name;
$ssm = $row->ssm;
$address= $row->address;  // $_POST['']; 
$city =  $row->city; 
$postcode =  $row->postcode; 
$state = $row->state; 
$phone = $row->phone; 
$tax = $row->tax; 
$prefix = $row->prefix; 
$dollar = $row->dollar; 
$lat = $row->lat;
$lng = $row->lng;

$ep_api = $row->ep_api;
$lala_api = $row->lala_api;
$lala_sec = $row->lala_sec;
$ep_env = $row->ep_env;
$lala_env = $row->lala_env;
$lala_loc = $row->lala_loc;
$logo = $row->image;
$printer = $row->printer;
$pname = $row->pname;
$pnetwork = $row->pnetwork;
$psmb = $row->psmb;
$pport = $row->pport;
$order_ac = $row->order_ac;

if(isset($_POST['btnupdate'])){
    
    $shop_name = $_POST['shop_name'];
    $ssm = $_POST['ssm'];
    $address= $_POST['address'];  // $_POST['']; 
    $city =  $_POST['city']; 
    $postcode = $_POST['postcode']; 
    $state = $_POST['sstate']; 
    $phone = $_POST['phone']; 
    $tax = $_POST['tax']; 
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $ep_api = $_POST['ep_api'];
    $lala_api = $_POST['lala_api'];
    $lala_sec = $_POST['lala_sec'];
    $ep_env = $_POST['ep_env'];
    $lala_env = $_POST['lala_env'];
    $printer = $_POST['printer'];
    $pname_new = $_POST['pname'];
    $pnetwork = $_POST['pnetwork'];
    $psmb = $_POST['psmb'];
    $pport = $_POST['pport'];
    $prefix = $_POST['prefix'];
    $prefix = $_POST['dollar'];
    $order_ac = $_POST['order_ac'];
    

        //echo "<pre>";

        $f_name = $_FILES['myfile']['name']; // get file name
	    if($f_name == ""){
            $productimage = $logo;
        } else {
        $f_tmp = $_FILES['myfile']['tmp_name']; // from tmp xampp folder
        $f_size = $_FILES['myfile']['size']; // determine size
        $f_extension = explode('.',$f_name); //change string to array
        $f_extension = strtolower(end($f_extension)); // end takes the last part of file. so it is jpg etc. ADD STRTOLOWER too.
        $f_newfile = uniqid().'.'.$f_extension; // do not overwrite file
        $store = "images/".$f_newfile;
        if($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'jpeg'){
            if($f_size >= 5000000){
                $error= '<script type="text/javascript">
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
                if(move_uploaded_file($f_tmp, $store)){
                    $productimage = $f_newfile;
                }
            }
        } else {
            $error= '<script type="text/javascript">
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
    if(!isset($error)){
        $insert = $pdo->prepare("UPDATE config SET shop_name=:shop_name,ssm=:ssm,address=:address,city=:city,postcode=:postcode,state=:state,phone=:phone,tax=:tax,prefix=:prefix,dollar=:dollar,lat=:lat,lng=:lng,ep_api=:ep_api,lala_api=:lala_api,lala_sec=:lala_sec,ep_env=:ep_env,lala_env=:lala_env,lala_loc=:lala_loc,printer=:printer,pname=:pname,pnetwork=:pnetwork,pport=:pport,psmb=:psmb,image=:image,order_ac=:order_ac WHERE id=1");
        
        $insert->bindParam(':shop_name',$shop_name);
        $insert->bindParam(':ssm',$ssm);
        $insert->bindParam(':address',$address);
        $insert->bindParam(':city',$city);
        $insert->bindParam(':postcode',$postcode);
        $insert->bindParam(':state',$state);
        $insert->bindParam(':phone',$phone);
        $insert->bindParam(':tax',$tax);
        $insert->bindParam(':prefix',$prefix);
        $insert->bindParam(':dollar',$dollar);
        $insert->bindParam(':lat',$lat);
        $insert->bindParam(':lng',$lng);
        $insert->bindParam(':ep_api',$ep_api);
        $insert->bindParam(':lala_api',$lala_api);
        $insert->bindParam(':lala_sec',$lala_sec);
        $insert->bindParam(':ep_env',$ep_env);
        $insert->bindParam(':lala_env',$lala_env);
        $insert->bindParam(':lala_loc',$lala_loc);
        $insert->bindParam(':printer',$printer);
        $insert->bindParam(':pname',$pname_new);
        $insert->bindParam(':pnetwork',$pnetwork_new);
        $insert->bindParam(':pport',$pport_new);
        $insert->bindParam(':psmb',$psmb_new);
        $insert->bindParam(':image',$productimage);
        $insert->bindParam(':order_ac',$order_ac);
        
        if($insert->execute()){
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
                  <input type="text" class="form-control" name="shop_name" placeholder="Company / Store Name" value= "<?php echo $shop_name; ?>" required>
                </div>
                
                <div class="form-group">
                  <label>Company ID / SSM</label>
                  <input type="text" class="form-control" name="ssm" placeholder="SSM / Company ID" value= "<?php echo $ssm; ?>" >
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" name="address" placeholder="Address" value= "<?php echo $address; ?>" required>
                </div>
                <div class="form-group">
                  <label>City</label>
                  <input type="text" class="form-control" name="city" placeholder="City" value= "<?php echo $city; ?>" required>
                </div>
                <div class="form-group">
                  <label>Postcode</label>
                  <input type="text" class="form-control" name="postcode" placeholder="Postcode" value= "<?php echo $postcode; ?>" required>
                </div>
                <div class="form-group">
                  <label>State</label>
                  <input type="text" class="form-control" name="sstate" placeholder="State" value="<?php echo $state; ?>" required>

                </div>
                <div class="form-group">
                  <label>Phone Number</label>
                  <input type="number" class="form-control" name="phone" placeholder="Phone Number" value= "<?php echo $phone; ?>" required>
                </div>
                <div class="form-group">
                  <label>Tax (%)</label>
                  <input type="number" step="any" class="form-control" name="tax" placeholder="Tax" value= "<?php echo $tax; ?>" required>
                </div>
                <div class="form-group">
                  <label>Barcode Prefix</label>
                  <input type="text" class="form-control" name="prefix" placeholder="SP-XXX (only input letters, suffix ID will be generated by system)" value= "<?php echo $prefix; ?>" required>
                </div>
                <div class="form-group">
                  <label>MYR/USD Rate </label>
                  <input type="text" class="form-control" name="dollar" placeholder="Current USD rate" value= "<?php echo $dollar; ?>" required>
                </div>
                <div class="form-group">
                  <label>Store Coordinate (For Lalamove use - pickup point)</label>
                  <input type="text" class="form-control" name="lat" value= "<?php echo $lat; ?>" id="lat" >
                  <input type="text" class="form-control" name="lng" value= "<?php echo $lng; ?>" id="long" >
                </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-danger">
                <h4>API Integration</h4> EasyParcel, Lalamove API
            </div>
                <div class="form-group">
                  <label>EasyParcel API Key</label>
                  <input type="text" class="form-control" name="ep_api" placeholder="API Key" value= "<?php echo $ep_api; ?>" required>
                </div>
                <div class="form-group">
                <label>
                <input type="radio" name="ep_env" class="minimal-red" value="0"<?php echo ($ep_env == 0)?'checked':''?>> Demo 
                </label>
                <label>
                <input type="radio" name="ep_env" class="minimal-red" value="1"<?php echo ($ep_env == 1)?'checked':''?>> Live 
                </label>
              </div>
              <hr>
              <div class="form-group">
                  <label>Lalamove API Key</label>
                  <input type="text" min="1" step="1" class="form-control" name="lala_api" placeholder="API Key" value= "<?php echo $lala_api; ?>" required>
                </div>
                <div class="form-group">
                  <label>Lalamove Secret Key</label>
                  <input type="text" min="1" step="1" class="form-control" name="lala_sec" placeholder="Secret Key" value= "<?php echo $lala_sec; ?>" required>
                </div>
                <div class="form-group">
                <label>
                  <input type="radio" name="lala_env" class="minimal-red" value="0"<?php echo ($lala_env == 0)?'checked':''?>> Demo 
                </label>
                <label>
                <input type="radio" name="lala_env" class="minimal-red" value="1"<?php echo ($lala_env == 1)?'checked':''?>> Live 
                </label>
              </div>
              <div class="form-group">
                  <label>Lalamove Market</label>
                  <select class="form-control" name="state" id="" required>
                      <option value="<?php echo $state;?>" ><?php 
                      if($lala_loc == "MY_KUL"){ echo 'Kuala Lumpur (Klang Valley)'; }
                      if($lala_loc == "MY_JHB"){ echo 'Johor Bahru'; }
                      if($lala_loc == "MY_NTL"){ echo 'Penang'; }
                      ?></option>
                      <option value="MY_KUL">Kuala Lumpur (Klang Valley)</option>
                      <option value="MY_JHB">Johor Bahru</option>
                      <option value="MY_NTL">Penang</option>
                  </select>
                </div>
                <hr>
                <div class="from-group" id="image_upload">
                    <label>Company/Shop Logo (For invoice creation)</label>
                    <input type="file" class="input-group" name="myfile">
                    <img class="img-thumbnail" style="width: 200px; length:200px;" src="images/<?php echo $logo;?>" alt=""/>
                </div>
                <br><hr>

                <div class="callout callout-info">
                <h4>Hardware Setting</h4> Thermal Printer - choose only ONE connection, leave blank if not applicable
                </div>
                <div class="form-group">
                  <label>Receipt Printer </label>
                  <div class="form-group">
                <label>
                  <input type="radio" name="printer" class="minimal-red" value="0"<?php echo ($printer == 0)?'checked':''?>> Disabled 
                </label>
                <label>
                <input type="radio" name="printer" class="minimal-red" value="1"<?php echo ($printer == 1)?'checked':''?>> Enabled 
                </label>
              </div>
            </div>

            <div class="form-group">
                  <label>Printer Name </label>
                  <input type="text" class="form-control" name="pname" placeholder="eg. \\DESKTOP-XXXXXX\epson20 - only input epson20" value= "<?php echo $pname; ?>" >
            </div>

            <div class="form-group">
                  <label>Printer IP (LAN Connection only)</label>
                  <input type="text" class="form-control" name="pnetwork" placeholder="192.168.x.x OR 10.x.x.x" value= "<?php echo $pnetwork; ?>" >
                  <input type="text" class="form-control" name="pport" placeholder="9100" value= "<?php echo $pport; ?>" >
            </div>

            <div class="form-group">
                  <label>Printer Address (SMB)</label>
                  <input type="text" class="form-control" name="psmb" placeholder="eg. smb://computername/printer " value= "<?php echo $psmb; ?>" >
            </div>
            <hr>
            <div class="callout callout-success">
                <h4>Database Settings</h4>
                Manage database
            </div>

            <div class="form-group">
            <label>Account database synchronization</label>
            <br>
                <label>
                <input type="radio" name="order_ac" class="minimal-red" value="1"<?php echo ($order_ac == 1)?'checked':''?>> Connect orders to Account
                </label>
                <label>
                <input type="radio" name="order_ac" class="minimal-red" value="0"<?php echo ($order_ac == 0)?'checked':''?>> Disconnect and clean Account database
                </label>
             </div>
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
      radioClass   : 'iradio_minimal-red'
    })
</script>
<?php
include_once 'footer.php';
?>