<?php 
include_once'connectdb.php';
session_start();
include_once 'header.php';

if(isset($_POST['btndebit'])){
    
    // $dtype = $_POST['dtype'];// $_POST['']; 
    $cbdate =  $_POST['ddate']; 
    $detail = $_POST['detail']; 
    $amount = $_POST['amount'];
    $account = $_POST['account'];
    $dc = "Debit";
    $payer = ($_POST['payer'] == null) ? "N/A" : $_POST['payer'];
    $reference = ($_POST['reference'] == null) ? "-" : $_POST['reference'];
            //echo "<pre>";

   $f_name = $_FILES['myfile']['name']; // get file name
	if($f_name == ""){
            $receipt = "";
        } else {
        $f_tmp = $_FILES['myfile']['tmp_name']; // from tmp xampp folder
        $f_size = $_FILES['myfile']['size']; // determine size
        $f_extension = explode('.',$f_name); //change string to array
        $f_extension = strtolower(end($f_extension)); // end takes the last part of file. so it is jpg etc. ADD STRTOLOWER too.
        echo $f_newfile = uniqid().'.'.$f_extension; // do not overwrite file
        $store = "productimages/".$f_newfile;
        if($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'jpeg'){
            if($f_size >= 1000000){
                $error= '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "File should be less than 1MB",
                      icon: "warning",
                      button: "Ok",
                    });
                });

                </script>';
            echo $error;
                
            } else {
                if(move_uploaded_file($f_tmp, $store)){
                    $receipt = $f_newfile;
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
				window.setTimeout(function(){
        window.location.href = "cashbook.php";
        }, 1500);
                </script>
				';
            echo $error;
        }
}
    if(!isset($error)){

      if($account == "Bank"){
        $insert = $pdo->prepare("INSERT INTO bank_ac(dc,tdate,detail,d_amount,name,reference,receipt) values(:dc,:tdate,:detail,:d_amount,:name,:reference,:receipt)");
        $insert->bindParam(':dc',$dc);
        $insert->bindParam(':tdate',$cbdate);
        $insert->bindParam(':detail',$detail);
        $insert->bindParam(':d_amount',$amount);
        $insert->bindParam(':name',$payer);
        $insert->bindParam(':reference',$reference);
        $insert->bindParam(':receipt',$receipt);
          
          if($insert->execute()){
              echo '<script type="text/javascript">
                  jQuery(function validation(){
                      swal({
                        title: "Success",
                        text: "Debit record successfully added",
                        icon: "success",
                        button: "Ok",
                      });
                  });

                  </script>';            
              
          } else {
              echo '<script type="text/javascript">
                  jQuery(function validation(){
                      swal({
                        title: "Error!",
                        text: "Failed to add record",
                        icon: "error",
                        button: "Ok",
                      });
                  });

                  </script>';
        }
      } else if($account == "Cash"){
        $insert = $pdo->prepare("INSERT INTO cash_ac(dc,tdate,detail,d_amount,name,reference,receipt) values(:dc,:tdate,:detail,:d_amount,:name,:reference,:receipt)");
        $insert->bindParam(':dc',$dc);
        $insert->bindParam(':tdate',$cbdate);
        $insert->bindParam(':detail',$detail);
        $insert->bindParam(':d_amount',$amount);
        $insert->bindParam(':name',$payer);
        $insert->bindParam(':reference',$reference);
        $insert->bindParam(':receipt',$receipt);
          
          if($insert->execute()){
              echo '<script type="text/javascript">
                  jQuery(function validation(){
                      swal({
                        title: "Success",
                        text: "Debit record successfully added",
                        icon: "success",
                        button: "Ok",
                      });
                  });

                  </script>';            
              
          } else {
              echo '<script type="text/javascript">
                  jQuery(function validation(){
                      swal({
                        title: "Error!",
                        text: "Failed to add record",
                        icon: "error",
                        button: "Ok",
                      });
                  });

                  </script>';
        }
      }
        
      
    }
    
}
?>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style>
.form-group.required .control-label:after {
  content:"*";
  color:red;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cash Book
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
                <h3 class="box-title">Debit</h3>
            </div>
            <form action="" method="post" name="formproduct" enctype="multipart/form-data">
            <div class="box-body">
            <div class="col-md-6">
                <div class="form-group ">
                  <label class="">Select Account</label>
                  <select class="form-control" name="account" required><option value="Bank">Bank</option><option value="Cash">Cash</option></select>
                </div>
                <div class="form-group required">
                <label class="control-label">Date:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="ddate" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
                </div>
                </div>
                <div class="form-group required">
                  <label class="control-label">Details</label>
                  <input type="text" class="form-control" name="detail" id="debitdetail" required>
                </div>
                <div class="form-group required">
                  <label class="control-label">Amount</label>
                  <input type="text" class="form-control" name="amount" id="amount" required>
                </div>

            </div>
            <div class="col-md-6">
            	<div class="form-group">
                  <label >Payer Name</label>
                  <input type="text" class="form-control" name="payer" id="debitdetail">
                </div>
                <div class="form-group">
                  <label >Reference</label>
                  <input type="text" class="form-control" name="reference" id="reference">
                </div>
                <div class="form-group" id="image_upload">
                    <label>Receipt (optional)</label>
                    <input type="file" class="input-group" name="myfile">
                </div>
            </div>
            
            </div>
            <div class="box-footer">
<center> 
                            <button type="submit" class="btn btn-info" name="btndebit">Proceed</button>
</center>
            </div>
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
    $('#datepicker').datepicker({
      autoclose: true
    })
</script>
<?php
include_once 'footer.php'
?>