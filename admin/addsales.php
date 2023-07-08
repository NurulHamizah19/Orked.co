
<?php 
include_once 'connectdb.php';
session_start();
include_once 'config.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
require __DIR__ . '/vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\Devices\AuresCustomerDisplay;

// fetch settings data

if($_SESSION['useremail']==""){
    header('location:index.php');
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

function list_client($pdo){
  $output='';
  $select = $pdo->prepare("SELECT * FROM tbl_client ORDER BY name asc");
  $select->execute();
  $result = $select->fetchAll();
  
  foreach($result as $row){
      $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
  }
  return $output;
}

$track = true;
if(isset($_POST['btnsaveorder'])){
    $customer_name = $_POST['txtcustomer'];
    $order_date = date('Y-m-d',strtotime($_POST['orderdate']));
    $subtotal = $_POST['txtsubtotal'];
    $tax = $_POST['txttax'];
    $discount = $_POST['txtdiscount'];
    $total = $_POST['txttotal'];
    $paid = $_POST['txtpaid'];
    $due = number_format($_POST['txtdue'],2);
    $payment_type = $_POST['rb'];
    $delivery = $_POST['ship'];
    $profit = $_POST['txtprofit'];
    $print = $_POST['print'];
    $createdo = $_POST['dorder'];
    $remark = $_POST['remark'];
    $timestamp = date('Y-m-d H:i:s');

    if($delivery == "3"){
      $delivery = $_POST['cship'];
    }
    
    $arr_productid = $_POST['productid'];
    $arr_productname = $_POST['productname'];
    $arr_stock = $_POST['stock'];
    $arr_qty = $_POST['qty'];
    $arr_price = $_POST['price'];
    $arr_total = $_POST['total'];

	if(!empty($arr_productid)){
    if($track == true){

   
    $insert = $pdo->prepare("INSERT INTO tbl_invoice(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type,profit,shipment_type,remark) values(:cust,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype,:profit,:shipment_type,:remark)");
    
    $insert->bindParam(':cust',$customer_name);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':stotal',$subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':total',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':ptype',$payment_type);
    $insert->bindParam(':shipment_type',$delivery);
    $insert->bindParam(':remark',$remark);
    $insert->bindParam(':profit',$profit);
    
    $insert->execute();

    $invoice_id = $pdo->lastInsertId();

    if($createdo == "1"){
      $insert = $pdo->prepare("INSERT INTO tbl_do(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type,shipment_type,remark) values(:cust,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype,:shipment_type,:remark)");
      
      $insert->bindParam(':cust',$customer_name);
      $insert->bindParam(':orderdate',$order_date);
      $insert->bindParam(':stotal',$subtotal);
      $insert->bindParam(':tax',$tax);
      $insert->bindParam(':disc',$discount);
      $insert->bindParam(':total',$total);
      $insert->bindParam(':paid',$paid);
      $insert->bindParam(':due',$due);
      $insert->bindParam(':ptype',$payment_type);
      $insert->bindParam(':shipment_type',$delivery);
      $insert->bindParam(':remark',$remark);

      $insert->execute();  

      $do_id = $pdo->lastInsertId();

    }
    
    $track = false;
    // another one
  
    
    if($invoice_id != null){
        for($i=0;$i<count($arr_productid);$i++){
            
                $update = $pdo->prepare("UPDATE tbl_product SET pstock = pstock - '$arr_qty[$i]', sold = sold + '$arr_qty[$i]' WHERE pid='".$arr_productid[$i]."'");
                
                $update->execute();
            

            if($arr_productid[$i]){

              $insert = $pdo->prepare("INSERT INTO tbl_invoice_details(invoice_id,product_id,product_name,qty,price,order_date) values(:invid,:pid,:pname,:qty,:price,:orderdate)");
            
              $insert->bindParam(':invid',$invoice_id);
              $insert->bindParam(':pid',$arr_productid[$i]);
              $insert->bindParam(':pname',$arr_productname[$i]);
              $insert->bindParam(':qty',$arr_qty[$i]);
              $insert->bindParam(':price',$arr_price[$i]);
              $insert->bindParam(':orderdate',$order_date);
              
              $insert->execute();

              if($createdo == "1"){
                $insert = $pdo->prepare("INSERT INTO tbl_do_details(do_id,product_id,product_name,qty,price,order_date) values(:invid,:pid,:pname,:qty,:price,:orderdate)");
            
                $insert->bindParam(':invid',$do_id);
                $insert->bindParam(':pid',$arr_productid[$i]);
                $insert->bindParam(':pname',$arr_productname[$i]);
                $insert->bindParam(':qty',$arr_qty[$i]);
                $insert->bindParam(':price',$arr_price[$i]);
                $insert->bindParam(':orderdate',$order_date);
                
                $insert->execute();

                $delivery_id = $pdo->lastInsertId();

                $assign = $pdo->prepare("INSERT INTO tbl_client_details(cid,invid,delid,inv_date,do_date) VALUES(:cid,:invid,:delid,:date,:date)");
                $assign -> bindParam(':cid',$customer_name);
                $assign -> bindParam(':invid',$invoice_id);
                $assign -> bindParam(':date',$timestamp);
                $assign -> bindParam(':delid',$do_id);
                $assign -> execute();
              }
            }
            

            
                
        }

        echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                      title: "Success!",
                      text: "Sales added",
                      icon: "success",
                      button: "Ok",
                    });
                });
                window.setTimeout(function(){
                  window.location= "orderlist.php";
            
              }, 3000);
                </script>';

                // link sales to account
                $dc = "Debit";
                $cbdate = $order_date;
                $detail = "Sales #".$invoice_id;
                $amount = $total;
                $payer = "Sales";
                $reference = "-";

                if($payment_type == "Cash"){
                  $insert = $pdo->prepare("INSERT INTO cash_ac(dc,tdate,detail,d_amount,name,reference) values(:dc,:tdate,:detail,:d_amount,:name,:reference)");
                  $insert->bindParam(':dc',$dc);
                  $insert->bindParam(':tdate',$cbdate);
                  $insert->bindParam(':detail',$detail);
                  $insert->bindParam(':d_amount',$amount);
                  $insert->bindParam(':name',$payer);
                  $insert->bindParam(':reference',$reference);
                  $insert->execute();
                } else {
                  $insert = $pdo->prepare("INSERT INTO bank_ac(dc,tdate,detail,d_amount,name,reference) values(:dc,:tdate,:detail,:d_amount,:name,:reference)");
                  $insert->bindParam(':dc',$dc);
                  $insert->bindParam(':tdate',$cbdate);
                  $insert->bindParam(':detail',$detail);
                  $insert->bindParam(':d_amount',$amount);
                  $insert->bindParam(':name',$payer);
                  $insert->bindParam(':reference',$reference);
                  $insert->execute();
                }

                if($print == 1){
                  $printer = "epson20";
                  if(!empty($data->pnetwork)){
                    $connector = new NetworkPrintConnector($data->pnetwork, $data->pport); //ethernet printer
                  }
                  if(!empty($data->pname)){
                    $connector = new WindowsPrintConnector($data->pname); //shared name printer
                  }
                  if(!empty($data->psmb)){
                    $connector = new WindowsPrintConnector($data->psmb); //smb printer
                  }
                  $printer = new Printer($connector);
                  $printer -> setJustification(Printer::JUSTIFY_CENTER);
                  
                  $printer -> feed(1); //feed paper 1 time*/
                  $printer -> text($data->shop_name."\n");//shop name
                  if($data->ssm != ""){
                    $printer -> text($data->ssm."\n");//ssm / company ID
                  } else {
                    $printer -> text(""."\n");
                  }
                  $printer -> text($data->address." ".$data->city."\n"); //Company address
                  $printer -> text($data->postcode." ".$data->state."\n"); //Company address
                  $printer -> text("Tel: ".$data->phone."\n");//phone
        
                  $printer -> feed(1); //feed paper 1 time*/
                  $printer->setJustification(Printer::JUSTIFY_LEFT);
                  $printer -> text("Invoice: $invoice_id  "."Cashier: ".$_SESSION["username"]."\n");//Invoice number
                  $printer -> text("Customer: $customer_name  "."Payment: $payment_type"."\n");//Invoice number
        
                  $printer -> feed(1); //feed paper 1 time*/
        
                  $printer->text("________________________________"."\n");
                  $printer->setJustification(Printer::JUSTIFY_LEFT);
                  $printer->text("Item    Qty     U/Price    Total"."\n");
                  $printer->text("________________________________"."\n");
        
                  $select = $pdo->prepare("SELECT * FROM tbl_invoice_details WHERE invoice_id=$invoice_id");
                  $select->execute();
                  while($item = $select->fetch(PDO::FETCH_OBJ)){
        
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->text($item->product_name."\n");
                    $printer->setJustification(Printer::JUSTIFY_RIGHT);
                    $printer->text($item->qty." * ".number_format($item->price,2)." - ".number_format($item->price * $item->qty,2)."\n");
                  }
        
                  $printer->text("--------\n");
                  $printer->text("Total: RM $total"."\n");
                  $printer -> feed(1); //feed paper 1 time*/
                  $printer->text("Total (RM): $total"."\n"); //net price
                  $printer->text("Discount (RM): $discount"."\n"); //net price
                  $printer->text("Amount Due (RM): $due"."\n"); //tax value
                  $printer->text("Payment (RM): $paid"."\n"); //tax value
        
                  $printer -> feed(1); //feed paper 1 time*/	
                  $printer->setJustification(Printer::JUSTIFY_CENTER);
                  $printer->text("Thank You"."\n"); //footer
                  $printer -> text(date("Y-m-d H:i:s")."\n");// date
                  $printer -> feed(3); //feed paper 3 times*/
                  $printer -> cut(); //cut paper
                  $printer -> pulse(); //send a pulse to open the cash drawer.
                  $printer -> initialize();
                  $printer -> close(); 
        
                }
        
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
<?php 
include 'connectdb.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Orked Shop</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- SweetAlert -->
<script src="bower_components/sweetalert/sweetalert.js"></script>
 <!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


<!-- AdminLTE App -->
<script src="bower_components/sweetalert/sweetalert.js"></script>
<script src="dist/js/adminlte.min.js"></script>
 
 <!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
 
<script src="Chart.js-2.9.3/dist/Chart.min.js"></script>
  
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  
   <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
     <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        
    <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">   
            
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->     
       
 <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">  
                                             
  <!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>                         
                                              
 <!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

   <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  

  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<style>
  .form-group.required .control-label:after {
  content:"*";
  color:red;
}
</style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="order-list.php" class="navbar-brand"><b>Orked</b>Shop</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Sales
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
                <h3 class="box-title">New Order </h3>
            </div>
            <div class="box-body"><!-- Customer -->
                <div class="col-md-6">
                    <div class="form-group">
                  <label>Customer Name</label>
                  
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <select class="form-control postName" id="clientid" onChange="getUser(this.value)" name="txtcustomer" required><option value="0">WALK-IN</option></select>
                  <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCustomer" data-dismiss="modal">Add Customer</button></span>
                  </div>
                  <span id="check-user"></span>
                  
                </div>
                </div>
                <div class="col-md-6">
                 <div style="overflow-x:auto;"> 
                        <table class="table table-bordered" id="producttable"  >
                      
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Search Product</th>
                                    <th>S/Price</th>
                                    <th>Enter Quantity</th>
                                    <th>Total</th>
                                    <th>
                       <center> <button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>

                                    </th>

                                </tr>

                            </thead>


                        </table></div>



                    </div>
            
            <div class="box-body">
                <div class="col-md-6">
                <div class="form-group">
                <label>Date:</label>
                  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
                </div>
                    </div>
                <div class="form-group">
                  <label>Subtotal</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required readonly>
                </div>
                    </div>
                <div class="form-group">
                  <label>Tax</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txttax" id ="txttax" required readonly>
                    </div> </div>
                <div class="form-group">
                  <label>Paid</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtpaid" id="txtpaid" required>
                    </div></div>

                    <label>Delivery method</label>
                    <div class="form-group">
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-truck"></i>
                  </div>
                  <input type="text" class="form-control" name="cship" id="custominput" placeholder="Custom Option (if option below not available)" >
                    </div> </div>
              <div class="form-group">
              <label>
                  <input type="radio" name="ship" id="custom" onclick="Checkradiobutton()" value="3" > Custom 
                </label>
                <label>
                  <input type="radio" name="ship" id="store" onclick="Checkradiobutton()" checked value="0" > In-store 
                </label>
                <label>
                  <input type="radio" name="ship" id="lala" onclick="Checkradiobutton()" value="1"> Lalamove (Runner Service)
                </label>
                <label>
                  <input type="radio" name="ship" id="ep" onclick="Checkradiobutton()" value="2"> EasyParcel (Postage)
                </label>

              </div>

              <label>Print Receipt</label>
              <div class="form-group">
                <label>
                  <input type="radio" name="print" class="minimal-red" value="0" checked> No
                </label>
                <label>
                  <input type="radio" name="print" class="minimal-red" value="1"> Yes
                </label>

              </div>
                </div>
                
                <div class="col-md-6">
                <div class="form-group">
                  <label>Total</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txttotal" id="txttotal"  required readonly>
                    </div> </div>
                    <div class="form-group">
                  <label>Discount</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" required>
                    </div> </div>
                
                <div class="form-group">
                  <label>Due</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtdue" id="txtdue" required readonly>
                    </div> </div>

                    <div class="form-group">
                  <label>Delivery Cost</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtdeliver" id="txtdeliver" required>
                    </div> </div>
            
                  <input type="hidden" class="form-control" name="txtprofit" id="txtprofit"   readonly>
                    <!-- radio -->
              <label>Payment method</label>
              <div class="form-group">
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Cash" checked> Cash 
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Card"> Card 
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="E-Wallet"> E-Wallet 
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Online Transfer"> Online Transfer 
                </label>

              </div>
              <label>Create Delivery Order</label>
              <div class="form-group">
                <label>
                  <input type="radio" name="dorder" class="minimal-red" value="0" checked> No
                </label>
                <label>
                  <input type="radio" name="dorder" class="minimal-red" value="1"> Yes
                </label>

              </div>
              
                </div>
            </div>
               </div>
               <hr>
           <div align="center">
               <input type="submit" name="btnsaveorder" value="Save Order" class="btn btn-info">
         
           </div>
           
           <hr>
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div id="modalAddCustomer" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" id="formcustomer" method="POST">
        <div class="modal-header" style="background: #3c8dbc; color: #fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Customer</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">

            <!--Input name -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input-lg" type="text" name="cname" id="cname" placeholder=" Customer Name" required>
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

            <!--Input phone -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                <input class="form-control input-lg" type="text" name="cicnum" id="cicnum" placeholder="IC Number" required>
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
<script>
function getUser($userid){
    
    jQuery.ajax({
    url: "checkuser.php?userid="+$userid,
    data:'username='+$("#username").val(),
    type: "POST",
    success:function(data){
        $("#check-user").html(data);
    },
    error:function (){}
    });
}
</script>
<script>
 $(document).on("change", ".radioBtnClass", function () {
   console.log($(this).val());    // Here you will get the current selected/checked radio option value
});
</script>
<script>
 $(document).ready(function () {

  // Variable to hold request
var request;

// Bind to the submit event of our form
$("#formcustomer").submit(function(event){

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
        url: "process_cdata.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Hooray, it worked!");
        swal({
              title: "Success!",
              text: "Customer data recorded",
              icon: "success",
              button: "Ok",
            });
        $('#modalAddCustomer').modal('toggle');
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});
});
</script>
<script>
    $('#datepicker').datepicker({
      autoclose: true
    })
</script>
<script type="text/javascript">
  function Checkradiobutton()
 {
  
  if(document.getElementById('store').checked || document.getElementById('ep').checked || document.getElementById('lala').checked)
 {

        document.getElementById('custominput').disabled=true; 
   }else{
                    document.getElementById('custominput').disabled = false;
                    
          }
 }
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
        html += '<td><input type="text" class="form-control price eprice" name="price[]" ></td>';
        html += '<td><input type="number" min="0" step="any" class="form-control qty" name="qty[]" ></td>';
        html += '<td><input type="text" class="form-control total" name="total[]" readonly>';
        html += '<input type="hidden" class="form-control profit" readonly>';
        html += '<input type="hidden" class="form-control profit2" name="profit[]" readonly></td>';
        html += '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>';
        $('#producttable').append(html);
            $('.productid').select2();
            $('.productid').select2("open");
            
            $(".productid").on('change', function(e){

              $(".btnadd").click();


              $('.productid').select2("open");
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
                        
                        tr.find(".pname").val(data["pname"]); //get pname from column
                        tr.find(".stock").val(data["pstock"]);
                        tr.find(".pprice").val(data["purchaseprice"]);
                        tr.find(".price").val(data["saleprice"]);
                        // console.log(pricetype);
                        tr.find(".profit").val(data["profit"]);
                        tr.find(".profit2").val(data["profit"]);
                        if (data["pstock"] != 0) {
                            tr.find(".qty").val(1);
                        } else {
                            tr.find(".qty").val(0);
                        }
                        tr.find(".total").val(tr.find(".qty").val() * tr.find(".eprice").val());
                        tr.find(".profit").val(tr.find(".qty").val() * tr.find(".profit2").val());
                        calculate(0, 0, 0);
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
        calculate(0,0,0);
        $("#txtpaid").val(0);
    })
    $("#producttable").delegate(".qty", "keyup change", function() {
        var quantity = $(this);
        var tr = $(this).parent().parent();

        tr.find(".total").val(quantity.val() * tr.find(".price").val());
        tr.find(".profit").val(quantity.val() * tr.find(".profit2").val());
        calculate(0, 0, 0);




    })
    $("#producttable").delegate(".pprice, .price", "keyup change", function() {
        var pprice = $(".pprice");
        var tr = $(this).parent().parent(); 
 
           tr.find(".profit2").val(((tr.find(".pprice").val() - tr.find(".price").val()) * -1));
           tr.find(".profit").val(tr.find(".profit2").val() * tr.find(".qty").val());
           calculate(0,0,0);





    })

    function calculate(dis, paid, del) {
        var subtotal = 0;
        var tax = 0;
        var discount = dis;
        var deliver = del;
        var net_total = 0;
        var paid_amt = paid;
        var due = 0;
        var profit = 0;
        $(".profit").each(function() {
            profit = profit + ($(this).val() * 1);
            $("#txtprofit").val(profit.toFixed(2));
        })
        $(".total").each(function() {
            subtotal = subtotal + ($(this).val() * 1);

        })
        $("#txtpaid").keyup(function() {
            var paid = $(this).val();
            var discount = $("#txtdiscount").val();
            var deliver = $("#txtdeliver").val();
            due = net_total - paid_amt;
            calculate(discount, paid, deliver);
        })

        tax = (<?php echo $data->tax; ?> * 0.01) * subtotal;
        net_total = tax + subtotal;
        net_total = (net_total - discount) ;
        net_total = (net_total + parseFloat(deliver)) ;
        due = net_total - paid_amt;


        $("#txtsubtotal").val(subtotal.toFixed(2));
        $("#txttax").val(tax.toFixed(2));
        $("#txttotal").val(net_total.toFixed(2));
        $("#txtdiscount").val(discount);
        $("#txtdeliver").val(deliver);
        $("#txtdue").val(due.toFixed(2));

        // end calc
        $("#txtdiscount").keyup(function() {
            var discount = $("#txtdiscount").val();
            var deliver = $("#txtdeliver").val();
            var paid = $("#txtpaid").val();
            calculate(discount, paid, deliver);
        })
        $("#txtdeliver").keyup(function() {
            var discount = $("#txtdiscount").val();
            var deliver = $("#txtdeliver").val();
            calculate(discount, 0, deliver);
        })
        

    }

});
</script>

<?php
include_once 'footer.php'
?>
    })
</script>
