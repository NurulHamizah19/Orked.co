<?php
include_once 'connectdb.php';
session_start();
include_once 'header.php';
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}

$detail = $pdo->prepare("SELECT * FROM config WHERE id=1");
$detail->execute();
$data = $detail->fetch(PDO::FETCH_OBJ);

$getid = $pdo->prepare("SELECT * from tbl_product ORDER BY pid DESC LIMIT 1");
$getid->execute();
$pid = $getid->fetch(PDO::FETCH_OBJ);
$genid = $pid->pid + 1;

if (isset($_POST['btnaddproduct'])) {

  $productname = $_POST['txtproductname'];
  $category = $_POST['txtselect_option'];  // $_POST['']; 
  $purchaseprice =  $_POST['txtpprice'];
  $saleprice =  $_POST['txtsprice'];
  $stock = $_POST['txtstock'];
  $description = $_POST['txtdescription'];
  $system_barcode = $data->prefix . '-' . $genid;
  if (isset($_POST['txtbarcode'])) {
    $barcode = $_POST['txtbarcode'];
  } else {
    $barcode = $system_barcode;
  }
  // $barcode = ($_POST['txtbarcode'] == null) ? $system_barcode : $_POST['txtbarcode'];
  // $barcode = ($_POST['txtbarcode'] == null) ? $system_barcode : $_POST['txtbarcode'];
  $profit = $_POST['txtsprice'] - $_POST['txtpprice'];
  //echo "<pre>";

  $f_name = $_FILES['myfile']['name']; // get file name
  if ($f_name == "") {
    $productimage = "";
  } else {
    $f_tmp = $_FILES['myfile']['tmp_name']; // from tmp xampp folder
    $f_size = $_FILES['myfile']['size']; // determine size
    $f_extension = explode('.', $f_name); //change string to array
    $f_extension = strtolower(end($f_extension)); // end takes the last part of file. so it is jpg etc. ADD STRTOLOWER too.
    echo $f_newfile = uniqid() . '.' . $f_extension; // do not overwrite file
    $store = "productimages/" . $f_newfile;
    if ($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'gif' || $f_extension == 'jpeg') {
      if ($f_size >= 5000000) {
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
    $insert = $pdo->prepare("INSERT INTO tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage,profit,barcode) values(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage,:profit,:barcode)");

    $insert->bindParam(':pname', $productname);
    $insert->bindParam(':pcategory', $category);
    $insert->bindParam(':purchaseprice', $purchaseprice);
    $insert->bindParam(':saleprice', $saleprice);
    $insert->bindParam(':pstock', $stock);
    $insert->bindParam(':pdescription', $description);
    $insert->bindParam(':pimage', $productimage);
    $insert->bindParam(':profit', $profit);
    $insert->bindParam(':barcode', $barcode);


    if ($insert->execute()) {
      echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success",
                      text: "Product successfully added",
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
                      text: "Failed to add product",
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
      Add Product
      <small>Add your product to the inventory</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">

    <!--------------------------
        | Your Page Content Here |
        -------------------------->

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><a href="product-list.php" class="btn btn-primary" role="button">Back To Product List</a></h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form action="" method="post" name="formproduct" enctype="multipart/form-data">

        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group required">
              <label class="control-label">Product Name</label>
              <input type="text" class="form-control" name="txtproductname" placeholder="Enter Name" required>
            </div>
            <div class="form-group required">
              <label class="control-label">Category</label>
              <select class="form-control" name="txtselect_option" required>
                <option value="" disabled selected>Select category</option>
                <?php
                $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid desc");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                ?>
                  <option><?php echo $row['category']; ?></option>
                <?php
                }
                ?>

              </select>
            </div>


            <div class="form-group required">
              <label class="control-label">Purchase price</label>
              <input type="number" min="0" step="any" class="form-control" name="txtpprice" placeholder="Price" required>
            </div>
            <div class="form-group required">
              <label class="control-label">Sale price</label>
              <input type="number" min="0" step="any" class="form-control" name="txtsprice" placeholder="Price" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group required">
              <label class="control-label">Stock</label>
              <input type="number" step="any" class="form-control" name="txtstock" placeholder="Stock" required>
            </div>
            <div class="form-group">
              <label class="control-label">Product Barcode / SKU</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-truck"></i>
                </div>
                <input type="text" class="form-control" name="txtbarcode" id="custominput" placeholder="Barcode">
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
            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" name="txtdescription" placeholder="Description" rows="4"></textarea>
            </div>
            <div class="form-group" id="image_upload">
              <label>Product Image</label>
              <input type="file" class="input-group" name="myfile">
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-info" name="btnaddproduct">Add product</button>
        </div>
      </form>

    </div>


  </section>
  <!-- /.content -->
</div>

<div id="modalAddCustomer" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" id="formcustomer" method="POST">
        <div class="modal-header" style="background: #3c8dbc; color: #fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Supplier</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">

            <!--Input name -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" name="cname" id="cname" placeholder=" Supplier Name" required>
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="caddress" id="caddress" placeholder="Address" required>
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="city" id="city" placeholder="City" required>
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="cpostcode" id="cpostcode" placeholder="Postcode" required>
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <select class="form-control" name="state" id="state" required>
                  <option value="">Select State</option>
                  <option value="jhr">Johor</option>
                  <option value="kdh">Kedah</option>
                  <option value="ktn">Kelantan</option>
                  <option value="kul">Kuala Lumpur</option>
                  <option value="lbn">Labuan</option>
                  <option value="mlk">Melaka</option>
                  <option value="nsn">Negeri Sembilan</option>
                  <option value="phg">Pahang</option>
                  <option value="prk">Perak</option>
                  <option value="png">Penang</option>
                  <option value="pls">Perlis</option>
                  <option value="pjy">Putrajaya</option>
                  <option value="sbh">Sabah</option>
                  <option value="srw">Sarawak</option>
                  <option value="sgr">Selangor</option>
                  <option value="trg">Terengganu</option>
                </select>
                <select class="form-control" name="country" id="" required>
                  <option value="Malaysia">Malaysia</option>
                  <option value="Indonesia">Indonesia</option>
                  <option value="Thailand">Thailand</option>
                  <option value="India">India</option>
                  <option value="Singapore">Singapore</option>
                  <option value="China">China</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <select class="form-control" name="country" id="" required>
                  <option value="Malaysia">Malaysia</option>
                  <option value="Indonesia">Indonesia</option>
                  <option value="Thailand">Thailand</option>
                  <option value="India">India</option>
                  <option value="Singapore">Singapore</option>
                  <option value="China">China</option>
                </select>
              </div>
            </div>

            <!--Input phone -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input class="form-control input-lg" type="text" name="cphone" id="cphone" placeholder="Phone Number" required>
              </div>
            </div>

            <!--Input phone -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input class="form-control input-lg" type="text" name="cemail" id="cemail" placeholder="Email" required>
              </div>
            </div>


          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="sumbit" id="datasend" class="btn btn-primary">Save Customer</button>
        </div>
      </form>

    </div>

  </div>
</div>

<script type="text/javascript">
  function Checkradiobutton() {

    if (document.getElementById('supplier').checked) {

      document.getElementById('custominput').disabled = true;
      document.getElementById("custominput").value = "<?php echo $data->prefix . '-' . $genid; ?>";
    } else {
      document.getElementById('custominput').disabled = false;
      document.getElementById("custominput").value = "";
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
  $('#datepicker1').datepicker({
    autoclose: true
  })
  $('#datepicker2').datepicker({
    autoclose: true
  })
</script>
<?php
include_once 'footer.php';
?>