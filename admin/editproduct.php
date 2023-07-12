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
$variation_db = $row['variation'];

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
  $variation_txt = $_POST['variable_options'];
  $barcode_txt = $barcode;
  $profit_txt = $_POST['txtsprice'] - $_POST['txtpprice'];

//$variableOptions = $_POST['variable_options'];

// Prepare the data
$datavar = [
    'variableOptions' => $variation_txt,
];
$jsonData = json_encode($datavar);

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
            $update = $pdo->prepare("UPDATE tbl_product SET pname=:pname,pcategory=:pcategory,purchaseprice=:pprice,saleprice=:saleprice,profit=:profit,pstock=:pstock,pdescription=:pdescription,pimage=:pimage,barcode=:barcode,variation=:variation WHERE pid = $id");

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
            $update->bindParam(':variation', $jsonData);
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

				setTimeout(function() {
  					window.location.href = window.location.href;
				}, 2000);

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

    $update = $pdo->prepare("UPDATE tbl_product SET pname=:pname,pcategory=:pcategory,purchaseprice=:pprice,saleprice=:saleprice,profit=:profit,pstock=:pstock,pdescription=:pdescription,pimage=:pimage,barcode=:barcode,variation=:variation WHERE pid = $id");

    $update->bindParam(':pname', $productname_txt);
    $update->bindParam(':pcategory', $category_txt);
    $update->bindParam(':pprice', $purchaseprice_txt);
    $update->bindParam(':saleprice', $saleprice_txt);
    $update->bindParam(':profit', $profit_txt);
    $update->bindParam(':pstock', $stock_txt);
    $update->bindParam(':pdescription', $description_txt);
    $update->bindParam(':pimage', $f_newfile);
    $update->bindParam(':barcode', $barcode_txt);
    $update->bindParam(':pimage', $productimage_db);
    $update->bindParam(':variation', $jsonData);
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
	setTimeout(function() {
                                        window.location.href = window.location.href;
                                }, 2000);
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
        <h3 class="box-title"><a href="product-list.php" class="btn btn-primary" role="button">Back To Product List</a></h3>
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
            <hr>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-truck"></i>
                </div>
                <input type="text" class="form-control" name="txtbarcode" value="<?php echo $barcode_db; ?>" id="custominput" placeholder="Barcode" required>
              </div>
            </div>
            <div class="from-group">
              <label>Description</label>
              <textarea class="form-control" name="txtdescription" placeholder="Description" rows="4"><?php echo $description_db; ?></textarea>
            </div>
            <div class="form-group">
              <label>Product Image</label>
              <br />
              <img src="productimages/<?php echo $productimage_db; ?>" class="img-rounded" onerror="imgError(this);" width="50px" height="50px" />
              <hr>
              <input type="file" class="input-group" name="myfile">
            </div>
    <?php if($variation_db) : ?>
	<div class="form-group required">
    <label class="control-label">Variable Options</label>
    <div id="variationContainer">
	<?php echo $variation_db; ?>
        <?php
        $jsonOptions = $variation_db;
        $options = json_decode($jsonOptions, true);

	foreach ($options['variableOptions'] as $option) {
            echo '<div class="variation">';
            echo '<input type="text" class="form-control" name="variable_options[]" placeholder="Enter Option" required value="' . $option . '">';
            echo '</div>';
        }
        ?>
    </div>
  <button type="button" id="addVariationButton" class="btn btn-primary">Add Variation</button>
</div>
    <?php else :  ?>
<div class="form-group required">
    <label class="control-label">Variable Options</label>
    <div id="variationContainer">
        <div class="variation">
            <input type="text" class="form-control" name="variable_options[]" placeholder="Enter Option" required="">
        </div>
    </div>
    <button type="button" id="addVariationButton" class="btn btn-primary">Add Variation</button>
</div>
    <?php endif; ?>
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
  //Red color scheme for iCheck
  $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    checkboxClass: 'icheckbox_minimal-red',
    radioClass: 'iradio_minimal-red'
  })
</script>
<script>
  function imgError(image) {
    image.onerror = "";
    image.src = "noimage.png";
    return true;
  }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var addVariationButton = document.getElementById('addVariationButton');
        var variationContainer = document.getElementById('variationContainer');

        addVariationButton.addEventListener('click', function () {
            var variationDiv = document.createElement('div');
            variationDiv.classList.add('variation');

            var input = document.createElement('input');
            input.type = 'text';
            input.classList.add('form-control');
            input.name = 'variable_options[]';
            input.placeholder = 'Enter Option';
            input.required = true;

            variationDiv.appendChild(input);
            variationContainer.appendChild(variationDiv);
        });
    });
</script>
<?php
include_once 'footer.php'
?>
