
<?php 
include_once 'connectdb.php';
session_start();
include_once 'config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
require __DIR__ . '/vendor/autoload.php';


// get current user data
$current_id = $_SESSION['userid'];
$select = $pdo->prepare("SELECT * FROM tbl_user WHERE userid = $current_id");
$select->execute();
$user = $select->fetch(PDO::FETCH_OBJ);
$comms = $user->comms;


// fetch settings data

if($_SESSION['useremail']==""){
    header('location:index.php');
}

if($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent"){
  include_once 'headeruser.php';
  } else {
      include_once 'header.php';
  }

// store detail from settings
$detail = $pdo->prepare("SELECT * FROM config WHERE id=1");
$detail->execute();
$data = $detail->fetch(PDO::FETCH_OBJ);

function fill_product($pdo){
    $output='';
    $select = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pname asc");
    $select->execute();
    $result = $select->fetchAll();
    
    foreach($result as $row){
        $output.='<option value="'.$row["pid"].'">'.$row["pname"].' - '.$row["barcode"].'</option>';
    }
    return $output;
}

$track = true;
if(isset($_POST['btncreate'])){
    $package_name = $_POST['name'];
    $total = $_POST['txttotal'];
    $ptotal = $_POST['txtptotal'];
    $barcode = $_POST['barcode'];
    $category = $_POST['txtcat'];
    $stock = -1;
    // $ispromo = 1;
    $profit = $_POST['txttotal'] - $_POST['txtptotal'];

    $arr_productid = $_POST['productid'];
    $arr_qty = $_POST['qty'];
    $arr_total = $_POST['total'];

	if(!empty($arr_productid)){
    if($track == true){

   
    $insert = $pdo->prepare("INSERT INTO tbl_package(package_name,total) values(:package_name,:total)");
    $insert->bindParam(':package_name',$package_name);
    $insert->bindParam(':total',$total);
    $insert->execute();

    $invoice_id = $pdo->lastInsertId();

    $update = $pdo->prepare("INSERT INTO tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,profit,barcode,is_promo) values(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:profit,:barcode,:is_promo)");

    $update->bindParam(':pname',$package_name);
    $update->bindParam(':pcategory',$category);
    $update->bindParam(':purchaseprice',$ptotal);
    $update->bindParam(':saleprice',$total);
    $update->bindParam(':pstock',$stock);
    $update->bindParam(':profit',$profit);
    $update->bindParam(':barcode',$barcode);
    $update->bindParam(':is_promo',$invoice_id);
    // var_dump($update);
    $update->execute();

    $track = false;
    // another one
  
    
    if($invoice_id != null){
        for($i=0;$i<count($arr_productid);$i++){
            if($arr_productid[$i]){

              $insert = $pdo->prepare("INSERT INTO tbl_package_details(package_id,pid,qty,ptotal) values(:package_id,:pid,:qty,:ptotal)");
            
              $insert->bindParam(':package_id',$invoice_id);
              $insert->bindParam(':pid',$arr_productid[$i]);
              $insert->bindParam(':qty',$arr_qty[$i]);
              $insert->bindParam(':ptotal',$arr_total[$i]);
              $insert->execute();

            }
        }

        echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success!",
                      text: "Package added",
                      icon: "success",
                      button: "Ok",
                    });
                });
            //     window.setTimeout(function(){
            //       window.location= "promolist.php";
            
            //   }, 3000);
                </script>';
        
    }
}
    } else {
		echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Error!",
                      text: "Product column cannot be empty",
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
        Create Promotion Package
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
           <form action="" method="post" id="order" name="">
            <div class="box-header with-border">
                <h3 class="box-title">New Promotion </h3>
            </div>
            <div class="box-body"><!-- Customer -->
                <div class="col-md-6">
                    <div class="form-group">
                  <label>Package Name</label>
                  
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-shopping-cart"></i>
                  </div>
                  <input type="text" class="form-control" name="name" required>
                  </div>
                  
                </div>
                <!-- <label>Apply Price Type</label> -->
                <!-- <select class="form-control" name="pricetype" id="pricetype" required>
                      <option value="1">Normal Price</option>
                      <option value="2">Stockist Price</option>
                      <option value="3">Wholesale Price</option>
                </select> -->
                </div>
                <div class="col-md-6">
                <div class="form-group required">
                  <label class="control-label">Category</label>
                  <select class="form-control" name="txtcat" required>
                    <option value="" disabled selected>Select category</option>
                   <?php
                      $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid desc");
                      $select->execute();
                      while($row=$select->fetch(PDO::FETCH_ASSOC)){
                          extract($row);
                      ?>
                      <option><?php echo $row['category'];?></option>
                      <?php
                      }
                   ?>
                    
                  </select>
                </div>
                </div>
            <div class="box-body">
                    <div class="col-md-12">
                 <div style="overflow-x:auto;"> 
                        <table class="table table-bordered" id="producttable"  >
                      
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Search Product</th>
                                    <th>Stock</th>
                                    <th>S/Price</th>
                                    <th>Enter Quantity</th>
                                    <th>Total</th>
                                    <!--<th>Total</th> -->
                                    <th>
                       <center> <button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>

                                    </th>
                                </tr>
                            </thead>
                        </table></div>
                    </div>



                </div>
            <div class="box-body">
                <div class="col-md-6">
                <div class="form-group">
                  <label>Set Package Price</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" name="txttotal" id="txttotal" required>
                </div>
                    </div>

                <div class="form-group">
                  <label>Barcode / SKU</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-list"></i>
                  </div>
                  <input type="text" class="form-control" name="barcode" id="barcode" required>
                </div>
                    </div>

                </div>
                
                <div class="col-md-6">
                <div class="form-group">
                  <label>Purchase Price</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" name="txtptotal" id="txtptotal" required>
                </div>
                    </div>
               
        
                </div>
            </div>
               </div>
               <hr>
           <div align="center">
               <input type="submit" name="btncreate" value="Create Package" class="btn btn-info">
         
           </div>
           
           <hr>
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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
            url: "client_get.php",
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
    $('#statelist').select2();
    $(document).on('change','#pricetype' ,function(){
      var pricetype = $('#pricetype option:selected').val();
      console.log(pricetype);
    })
 
    
    $(document).on('click', '.btnadd', function() {
      
        var html = '';
        html += '<tr>';

        html += '<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
        html += '<td><select class="form-control productid" name="productid[]" style="width: 250px";><option value="">Select Option</option><?php echo fill_product($pdo); ?> </select></td>';
        html += '<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
        html += '<td><input type="text" class="form-control price eprice" name="price[]" ></td>';
        html += '<td><input type="number" min="0" step="any" class="form-control qty" name="qty[]" ></td>';
        html += '<td><input type="text" class="form-control total" name="total[]" readonly></td>';
        html += '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>';
        $('#producttable').append(html);
            $('.productid').select2();
            $(".productid").on('change', function(e){
            var productid = this.value;
            var tr = $(this).parent().parent();
            $.ajax({
                url: "getproduct.php",
                method: "get",
                data: {
                    id: productid
                },
                success: function(data) {
                    //console.log(data);
                    if (data["pstock"] != 0) {
                        // console.log("stored value: ",stockistp);
                        tr.find(".pname").val(data["pname"]); //get pname from column
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".pprice").val(data["purchaseprice"]);
                        tr.find(".price").val(data["saleprice"]);
                        tr.find(".profit").val(data["profit"]);
                        tr.find(".stockist").val(data["stkprice"]);
                        tr.find(".profit2").val(data["profit"]);
                        if (data["pstock"] != 0) {
                            tr.find(".qty").val(1);
                        } else {
                            tr.find(".qty").val(0);
                        }
                        tr.find(".total").val(tr.find(".qty").val() * tr.find(".eprice").val());
                        calculate();
                    } else {
                        jQuery(function validation() {
                            swal({
                                title: "Warning!",
                                text: "Product stock is empty, please update",
                                icon: "error",
                                button: "Ok",
                            });
                        });

                    }
                }
                
            })
        })
    })

    $(document).on('click', '.btnremove', function() {
        $(this).closest('tr').remove();
        calculate();
        $("#txtpaid").val(0);
    })
    $("#producttable").delegate(".qty", "keyup change", function() {
        var quantity = $(this);
        var tr = $(this).parent().parent();

        tr.find(".total").val(quantity.val() * tr.find(".price").val());
        calculate();
    })
    $("#producttable").delegate(".pprice, .price", "keyup change", function() {
        var pprice = $(".pprice");
        var tr = $(this).parent().parent(); 
 
           tr.find(".profit2").val(((tr.find(".pprice").val() - tr.find(".price").val()) * -1));
           tr.find(".profit").val(tr.find(".profit2").val() * tr.find(".qty").val());
           calculate();





    })

    function calculate() {
        var subtotal = 0;
        var net_total = 0;
        $(".total").each(function() {
            subtotal = subtotal + ($(this).val() * 1);
        })
        net_total = subtotal;
        $("#txttotal").val(net_total.toFixed(2));
        $("#txtptotal").val(net_total.toFixed(2));

    }

});
</script>

<?php
include_once 'footer.php'
?>
    })
</script>
