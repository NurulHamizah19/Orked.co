<?php
include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}
include_once 'header.php';

$detail = $pdo->prepare("SELECT * FROM config WHERE id=1");
$detail->execute();
$data = $detail->fetch(PDO::FETCH_OBJ);

$id = $_GET['id'];
$select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);

$id_db = $row['pid'];
$productname_db = $row['pname'];
$category_db = $row['pcategory'];
$purchaseprice_db = $row['purchaseprice'];
$saleprice_db = $row['saleprice'];
$stock_db = $row['pstock'];
$description_db = $row['pdescription'];
$productimage_db = $row['pimage'];
$barcode_db = $row['barcode'];
$sid = $supplier_db;

if (isset($_POST['btnupdate'])) {


  $system_barcode = $data->prefix . '-' . $id_db;
  if (isset($_POST['txtbarcode'])) {
    $barcode = $_POST['txtbarcode'];
  } else {
    $barcode = $system_barcode;
  }


  $productname_txt = $_POST['txtproductname'];
  $category_txt = $_POST['txtselect_option'];  // $_POST['']; 
  $purchaseprice_txt =  $_POST['txtpprice'];
  $saleprice_txt =  $_POST['txtsprice'];
  $stock_txt = $_POST['txtstock'];
  $description_txt = $_POST['txtdescription'];
  $barcode_txt = $barcode;
  $profit_txt = $_POST['txtsprice'] - $_POST['txtpprice'];

  $f_name = $_FILES['myfile']['name']; // get file name
  if (!empty($f_name)) {

    $f_tmp = $_FILES['myfile']['tmp_name']; // from tmp xampp folder
    $f_size = $_FILES['myfile']['size']; // determine size
    $f_extension = explode('.', $f_name); //change string to array
    $f_extension = strtolower(end($f_extension)); // end takes the last part of file. so it is jpg etc. ADD STRTOLOWER too.
    echo $f_newfile = uniqid() . '.' . $f_extension; // do not overwrite file
    $store = "productimages/" . $f_newfile;
    if ($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'jpeg') {
      if ($f_size >= 1000000) {
        $error = '<script type="text/javascript">
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
        if (move_uploaded_file($f_tmp, $store)) {
          $f_newfile;
          if (!isset($error)) {
            $update = $pdo->prepare("UPDATE tbl_product SET pname=:pname,pcategory=:pcategory,purchaseprice=:pprice,saleprice=:saleprice,profit=:profit,pstock=:pstock,pdescription=:pdescription,pimage=:pimage,barcode=:barcode WHERE pid = $id");

            $update->bindParam(':pname', $productname_txt);
            $update->bindParam(':pcategory', $category_txt);
            $update->bindParam(':pprice', $purchaseprice_txt);
            $update->bindParam(':saleprice', $saleprice_txt);
            $update->bindParam(':profit', $profit_txt);
            $update->bindParam(':pstock', $stock_txt);
            $update->bindParam(':pdescription', $description_txt);
            $update->bindParam(':pimage', $f_newfile);
            $update->bindParam(':barcode', $barcode_txt);
            $update->bindParam(':pimage', $f_newfile);
            if ($update->execute()) {
              $error = '<script type="text/javascript">
                                jQuery(function validation(){
                                    swal({
                                      title: "Success",
                                      text: "Product updated",
                                      icon: "success",
                                      button: "Ok",
                                    });
                                });
                                </script>';
              echo $error;
            } else {
              $error = '<script type="text/javascript">
                                jQuery(function validation(){
                                    swal({
                                      title: "Failed",
                                      text: "Product failed to update",
                                      icon: "warning",
                                      button: "Ok",
                                    });
                                });
                                </script>';
              echo $error;
            }
          }
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
  } else {

    $update = $pdo->prepare("UPDATE tbl_product SET pname=:pname,pcategory=:pcategory,purchaseprice=:pprice,saleprice=:saleprice,profit=:profit,pstock=:pstock,pdescription=:pdescription,pimage=:pimage,barcode=:barcode WHERE pid = $id");

    $update->bindParam(':pname', $productname_txt);
    $update->bindParam(':pcategory', $category_txt);
    $update->bindParam(':pprice', $purchaseprice_txt);
    $update->bindParam(':saleprice', $saleprice_txt);
    $update->bindParam(':stkprice', $stkprice_txt);
    $update->bindParam(':wholeprice', $wholeprice_txt);
    $update->bindParam(':profit', $profit_txt);
    $update->bindParam(':pstock', $stock_txt);
    $update->bindParam(':pdescription', $description_txt);
    $update->bindParam(':pimage', $f_newfile);
    $update->bindParam(':barcode', $barcode_txt);
    $update->bindParam(':supplier', $supplier_db);
    $update->bindParam(':expdate', $expdate_txt);
    $update->bindParam(':pimage', $productimage_db);

    if ($update->execute()) {
      $error = '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Product updated",
                      icon: "success",
                      button: "Ok",
                    });
                });
                </script>';
      echo $error;
    } else {
      $error = '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Failed",
                      text: "Product failed to update",
                      icon: "warning",
                      button: "Ok",
                    });
                });
                </script>';
      echo $error;
    }
  }
}

$select = $pdo->prepare("SELECT * FROM tbl_product WHERE pid=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_ASSOC);

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Edit Product
      <small>Optional description</small>
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
        <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back To Product List</a></h3>
      </div>

      <form action="" method="post" name="formproduct" enctype="multipart/form-data">

        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label>Product Name</label>
              <input type="text" class="form-control" name="txtproductname" value="<?php echo $productname_db; ?>" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
              <label>Category</label>
              <select class="form-control" name="txtselect_option" required>
                <option value="<?php echo $category_db; ?>" disabled selected><?php echo $category_db; ?></option>
                <?php
                $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid DESC");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                ?>
                  <option <?php if ($row['category'] == $category_db) { ?> selected="selected" <?php } ?>>
                    <?php echo $row['category']; ?></option>
                <?php } ?>
              </select>
            </div>


            <div class="form-group">
              <label>Purchase price</label>
              <input type="number" min="0" step="any" class="form-control" name="txtpprice" value="<?php echo $purchaseprice_db; ?>" placeholder="Price" required>
            </div>
            <div class="form-group">
              <label>Sale price</label>
              <input type="number" min="0" step="any" class="form-control" name="txtsprice" value="<?php echo $saleprice_db; ?>" placeholder="Price" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Stock</label>
              <input type="number" min="1" step="1" class="form-control" name="txtstock" value="<?php echo $stock_db; ?>" placeholder="Stock" required>
            </div>
            <!-- <div class="form-group">
                  <label>Supplier Name</label>
                  
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <select class="form-control postName" id="clientid" name="txtsupplier" required><?php echo supplier_data($pdo, $sid); ?></select>
                  <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCustomer" data-dismiss="modal">Add Supplier</button></span>
                  </div>
                  
                </div> -->
            <hr>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-truck"></i>
                </div>
                <input type="text" class="form-control" name="txtbarcode" value="<?php echo $barcode_db; ?>" id="custominput" placeholder="Barcode" required>
              </div>
            </div>
            <div class="form-group">
              <label>
                <input type="radio" name="barcode_type" id="self" onclick="Checkradiobutton()" checked value="supplier"> Supplier barcode
              </label>
              <label>
                <input type="radio" name="barcode_type" id="supplier" onclick="Checkradiobutton()" value="system"> System barcode
              </label>

            </div>
            <div class="from-group">
              <label>Description</label>
              <textarea class="form-control" name="txtdescription" placeholder="Description" rows="4"><?php echo $description_db; ?></textarea>
            </div>
            <div class="from-group">
              <label>Product Image</label>
              <br />
              <img src="productimages/<?php echo $productimage_db; ?>" class="img-rounded" onerror="imgError(this);" width="50px" height="50px" />
              <hr>
              <input type="file" class="input-group" name="myfile">
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-warning" name="btnupdate">Edit product</button>
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<script type="text/javascript">
  function Checkradiobutton() {

    if (document.getElementById('supplier').checked) {

      document.getElementById('custominput').disabled = true;
      document.getElementById("custominput").value = "<?php echo $data->prefix . '-' . $id_db; ?>";
    } else {
      document.getElementById('custominput').disabled = false;
      document.getElementById("custominput").value = "<?php echo $barcode_db; ?>";;
    }
  }
</script>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function() {
    // Variable to hold request
    var request;

    // Bind to the submit event of our form
    $("#formcustomer").submit(function(event) {

      // Prevent default posting of form - put here to work in case of errors
      event.preventDefault();

      // Abort any pending request
      if (request) {
        request.abort();
      }
      // setup some local variables
      var $form = $(this);

      // Let's select and cache all the fields
      var $inputs = $form.find("input, select, button, textarea");

      // Serialize the data in the form
      var serializedData = $form.serialize();
      console.log(serializedData);
      $inputs.prop("disabled", true);

      request = $.ajax({
        url: "process_sdata.php",
        type: "post",
        data: serializedData
      });

      // Callback handler that will be called on success
      request.done(function(response, textStatus, jqXHR) {
        // Log a message to the console
        console.log("Hooray, it worked!");
        swal({
          title: "Success!",
          text: "Supplier data recorded",
          icon: "success",
          button: "Ok",
        });
        $('#modalAddCustomer').modal('toggle');
      });

      // Callback handler that will be called on failure
      request.fail(function(jqXHR, textStatus, errorThrown) {
        // Log the error to the console
        console.error(
          "The following error occurred: " +
          textStatus, errorThrown
        );
      });

      // Callback handler that will be called regardless
      // if the request failed or succeeded
      request.always(function() {
        // Reenable the inputs
        $inputs.prop("disabled", false);
      });

    });
  });
</script>
<script>
  //Red color scheme for iCheck
  $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    checkboxClass: 'icheckbox_minimal-red',
    radioClass: 'iradio_minimal-red'
  })

  $(document).ready(function() {
    $('#clientid').select2({
      placeholder: 'Select customer',
      ajax: {
        url: "supplier_get.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });

  });
</script>
<script>
  function imgError(image) {
    image.onerror = "";
    image.src = "noimage.png";
    return true;
  }
</script>
<script>
  $('#datepicker1').datepicker({
    autoclose: true
  })
  $('#datepicker2').datepicker({
    autoclose: true
  })
</script>
<?php
include_once 'footer.php'
?>