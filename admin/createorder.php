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

// get current user data
$current_id = $_SESSION['userid'];
$select = $pdo->prepare("SELECT * FROM tbl_user WHERE userid = $current_id");
$select->execute();
$user = $select->fetch(PDO::FETCH_OBJ);
$comms = $user->comms;


// fetch settings data

function client_data($pdo, $cid)
{
  $output = '';
  $select = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$cid");
  $select->execute();
  $result = $select->fetchAll(PDO::FETCH_OBJ);

  foreach ($result as $rows) {
    if ($rows->name != "") {
      $output .= $rows->name;

      echo '
      ';
    }
  }
  return $output;
}

if ($_SESSION['useremail'] == "") {
  header('location:index.php');
}

if ($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent") {
  include_once 'headeruser.php';
} else {
  include_once 'header.php';
}

// store detail from settings
$detail = $pdo->prepare("SELECT * FROM config WHERE id=1");
$detail->execute();
$data = $detail->fetch(PDO::FETCH_OBJ);

function fill_product($pdo)
{
  $output = '';
  $select = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pname asc");
  $select->execute();
  $result = $select->fetchAll();

  foreach ($result as $row) {
    $output .= '<option value="' . $row["pid"] . '">' . $row["pname"] . ' - ' . $row["barcode"] . '</option>';
  }
  return $output;
}

function list_client($pdo)
{
  $output = '';
  $select = $pdo->prepare("SELECT * FROM tbl_client ORDER BY name asc");
  $select->execute();
  $result = $select->fetchAll();

  foreach ($result as $row) {
    $output .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
  }
  return $output;
}

$track = true;
if (isset($_POST['btnsaveorder'])) {
  $customer_name = $_POST['txtcustomer'];
  $name = client_data($pdo, $customer_name);
  $agentid = $_SESSION['userid'];
  $order_date = date('Y-m-d', strtotime($_POST['orderdate']));
  $subtotal = $_POST['txtsubtotal'];
  $tax = $_POST['txttax'];
  $discount = $_POST['txtdiscount'];
  $total = $_POST['txttotal'];
  $paid = $_POST['txtpaid'];
  $due = number_format($_POST['txtdue'], 2);
  $payment_type = $_POST['rb'];
  $trans_id = $_POST['trans_id'];
  $delivery = $_POST['ship'];
  $profit = $_POST['txtprofit'];
  $comms = $_POST['txtcomms'];
  $print = $_POST['print'];
  $createdo = $_POST['dorder'];
  $remark = isset($_POST['remark']) ? $_POST['remark'] : "";
  $timestamp = date('Y-m-d H:i:s');
  $extid = $_POST['extid'];

  if ($delivery == "3") {
    $delivery = $_POST['cship'];
  }

  $arr_productid = $_POST['productid'];
  $arr_productname = $_POST['productname'];
  $arr_stock = $_POST['stock'];
  $arr_qty = $_POST['qty'];
  $arr_price = $_POST['price'];
  $arr_total = $_POST['total'];
  $arr_ispromo = $_POST['ispromo'];
  $arr_remark = $_POST['remark_arr'];

  if (!empty($arr_productid)) {
    if ($track == true) {


      $insert = $pdo->prepare("INSERT INTO tbl_invoice(extid,customer_name,name,agentid,order_date,subtotal,tax,discount,total,paid,due,payment_type,trans_id,profit,comms,shipment_type,remark) values(:extid,:cust,:name,:agentid,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype,:tid,:profit,:comms,:shipment_type,:remark)");

      $insert->bindParam(':extid', $extid);
      $insert->bindParam(':cust', $customer_name);
      $insert->bindParam(':name', $name);
      $insert->bindParam(':agentid', $agentid);
      $insert->bindParam(':orderdate', $order_date);
      $insert->bindParam(':stotal', $subtotal);
      $insert->bindParam(':tax', $tax);
      $insert->bindParam(':disc', $discount);
      $insert->bindParam(':total', $total);
      $insert->bindParam(':paid', $paid);
      $insert->bindParam(':due', $due);
      $insert->bindParam(':ptype', $payment_type);
      $insert->bindParam(':tid', $trans_id);
      $insert->bindParam(':shipment_type', $delivery);
      $insert->bindParam(':remark', $remark);
      $insert->bindParam(':profit', $profit);
      $insert->bindParam(':comms', $comms);

      $insert->execute();

      $invoice_id = $pdo->lastInsertId();

      if ($createdo == "1") {
        $insert_do = $pdo->prepare("INSERT INTO tbl_do(customer_name,agentid,order_date,subtotal,tax,discount,total,paid,due,payment_type,shipment_type,remark) values(:cust,:agentid.:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype,:shipment_type,:remark)");

        $insert_do->bindParam(':cust', $customer_name);
        $insert_do->bindParam(':agentid', $agentid);
        $insert_do->bindParam(':orderdate', $order_date);
        $insert_do->bindParam(':stotal', $subtotal);
        $insert_do->bindParam(':tax', $tax);
        $insert_do->bindParam(':disc', $discount);
        $insert_do->bindParam(':total', $total);
        $insert_do->bindParam(':paid', $paid);
        $insert_do->bindParam(':due', $due);
        $insert_do->bindParam(':ptype', $payment_type);
        $insert_do->bindParam(':shipment_type', $delivery);
        $insert_do->bindParam(':remark', $remark);

        // $insert_do->execute();  
        $insert_do->execute();

        $do_id = $pdo->lastInsertId();
      }

      $track = false;
      // another one


      if ($invoice_id != null) {
        for ($i = 0; $i < count($arr_productid); $i++) {

          if($arr_stock[$i] != null){
            $rem_qty = $arr_stock[$i] - $arr_qty[$i];
          } else {
            $rem_qty = 0 - $arr_qty[$i];
          }
          
          $update = $pdo->prepare("UPDATE tbl_product SET pstock='$rem_qty', sold = sold + '$arr_qty[$i]' WHERE pid='" . $arr_productid[$i] . "'");
          $update->execute();

          if ($arr_productid[$i] != null) {

            $insert = $pdo->prepare("INSERT INTO tbl_invoice_details(invoice_id,product_id,product_name,remark,qty,price,order_date) values(:invid,:pid,:pname,:remark,:qty,:price,:orderdate)");

            $insert->bindParam(':invid', $invoice_id);
            $insert->bindParam(':pid', $arr_productid[$i]);
            $insert->bindParam(':pname', $arr_productname[$i]);
            $insert->bindParam(':qty', $arr_qty[$i]);
            $insert->bindParam(':price', $arr_price[$i]);
            $insert->bindParam(':orderdate', $order_date);
            $insert->bindParam(':remark', $arr_remark[$i]);

            $insert->execute();

            $assign = $pdo->prepare("INSERT INTO tbl_client_details(cid,invid,inv_date,do_date) VALUES(:cid,:invid,:date,:date)");
            $assign->bindParam(':cid', $customer_name);
            $assign->bindParam(':invid', $invoice_id);
            $assign->bindParam(':date', $timestamp);
            //$assign -> bindParam(':delid',$do_id);
            $assign->execute();

            if ($createdo == "1") {
              $insert = $pdo->prepare("INSERT INTO tbl_do_details(do_id,product_id,product_name,qty,price,order_date) values(:invid,:pid,:pname,:qty,:price,:orderdate)");

              $insert->bindParam(':invid', $do_id);
              $insert->bindParam(':pid', $arr_productid[$i]);
              $insert->bindParam(':pname', $arr_productname[$i]);
              $insert->bindParam(':qty', $arr_qty[$i]);
              $insert->bindParam(':price', $arr_price[$i]);
              $insert->bindParam(':orderdate', $order_date);

              $insert->execute();

              $delivery_id = $pdo->lastInsertId();
            }
          } else {
            echo '<script type="text/javascript">
            jQuery(function validation(){
                swal({
                  title: "Error!",
                  text: "' . $arr_productid[$i] . '",
                  icon: "error",
                  button: "Ok",
                });
            });

            </script>';
            die();
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
                  window.location= "invoice.php?id=' . $invoice_id . '";
            
              }, 3000);
                </script>';

        // link sales to account
        $dc = "Debit";
        $cbdate = $order_date;
        $detail = "Sales #" . $invoice_id;
        $amount = $total;
        $payer = "Sales";
        $reference = "-";

        if ($payment_type == "Cash") {
          $insert = $pdo->prepare("INSERT INTO cash_ac(oid,dc,tdate,detail,d_amount,name,reference) values(:oid,:dc,:tdate,:detail,:d_amount,:name,:reference)");
          $insert->bindParam(':dc', $dc);
          $insert->bindParam(':oid', $invoice_id);
          $insert->bindParam(':tdate', $cbdate);
          $insert->bindParam(':detail', $detail);
          $insert->bindParam(':d_amount', $amount);
          $insert->bindParam(':name', $payer);
          $insert->bindParam(':reference', $reference);
          $insert->execute();
        } else {
          $insert = $pdo->prepare("INSERT INTO bank_ac(oid,dc,tdate,detail,d_amount,name,reference) values(:oid,:dc,:tdate,:detail,:d_amount,:name,:reference)");
          $insert->bindParam(':dc', $dc);
          $insert->bindParam(':oid', $invoice_id);
          $insert->bindParam(':tdate', $cbdate);
          $insert->bindParam(':detail', $detail);
          $insert->bindParam(':d_amount', $amount);
          $insert->bindParam(':name', $payer);
          $insert->bindParam(':reference', $reference);
          $insert->execute();
        }

        if ($print == 1) {
          $printer = "epson20";
          if (!empty($data->pnetwork)) {
            $connector = new NetworkPrintConnector($data->pnetwork, $data->pport); //ethernet printer
          }
          if (!empty($data->pname)) {
            $connector = new WindowsPrintConnector($data->pname); //shared name printer
          }
          if (!empty($data->psmb)) {
            $connector = new WindowsPrintConnector($data->psmb); //smb printer
          }
          $printer = new Printer($connector);
          $printer->setJustification(Printer::JUSTIFY_CENTER);

          $printer->feed(1); //feed paper 1 time*/
          $printer->text($data->shop_name . "\n"); //shop name
          if ($data->ssm != "") {
            $printer->text($data->ssm . "\n"); //ssm / company ID
          } else {
            $printer->text("" . "\n");
          }
          $printer->text($data->address . " " . $data->city . "\n"); //Company address
          $printer->text($data->postcode . " " . $data->state . "\n"); //Company address
          $printer->text("Tel: " . $data->phone . "\n"); //phone

          $printer->feed(1); //feed paper 1 time*/
          $printer->setJustification(Printer::JUSTIFY_LEFT);
          $printer->text("Invoice: $invoice_id  " . "Cashier: " . $_SESSION["username"] . "\n"); //Invoice number
          $printer->text("Customer: $customer_name  " . "Payment: $payment_type" . "\n"); //Invoice number

          $printer->feed(1); //feed paper 1 time*/

          $printer->text("________________________________" . "\n");
          $printer->setJustification(Printer::JUSTIFY_LEFT);
          $printer->text("Item    Qty     U/Price    Total" . "\n");
          $printer->text("________________________________" . "\n");

          $select = $pdo->prepare("SELECT * FROM tbl_invoice_details WHERE invoice_id=$invoice_id");
          $select->execute();
          while ($item = $select->fetch(PDO::FETCH_OBJ)) {

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($item->product_name . "\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text($item->qty . " * " . number_format($item->price, 2) . " - " . number_format($item->price * $item->qty, 2) . "\n");
          }

          $printer->text("--------\n");
          $printer->text("Total: RM $total" . "\n");
          $printer->feed(1); //feed paper 1 time*/
          $printer->text("Total (RM): $total" . "\n"); //net price
          $printer->text("Discount (RM): $discount" . "\n"); //net price
          $printer->text("Amount Due (RM): $due" . "\n"); //tax value
          $printer->text("Payment (RM): $paid" . "\n"); //tax value

          $printer->feed(1); //feed paper 1 time*/	
          $printer->setJustification(Printer::JUSTIFY_CENTER);
          $printer->text("Thank You" . "\n"); //footer
          $printer->text(date("Y-m-d H:i:s") . "\n"); // date
          $printer->feed(3); //feed paper 3 times*/
          $printer->cut(); //cut paper
          $printer->pulse(); //send a pulse to open the cash drawer.
          $printer->initialize();
          $printer->close();
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create Order
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
                <select class="form-control postName" id="clientid" onChange="getUser(this.value)" name="txtcustomer" required>
                  <option value="0">WALK-IN</option>
                </select>
                <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCustomer" data-dismiss="modal">Add Customer</button></span>
              </div>
              <span id="check-user"></span>

            </div>
            <label>Apply Price Type</label>
            <select class="form-control" name="pricetype" id="pricetype" required>
              <option value="1">Normal Price</option>
              <option value="2">Stockist Price</option>
              <option value="3">Wholesale Price</option>
            </select>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Date:</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d"); ?>" data-date-format="yyyy-mm-dd">
              </div>
            </div>
          </div>
          <div class="box-body">
            <div class="col-md-12">

              <div style="overflow-x:auto;">
                <table class="table table-bordered" id="producttable">

                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Search Product</th>
                      <th>Remark</th>
                      <th>Stock</th>
                      <th>S/Price</th>
                      <th>Enter Quantity</th>
                      <th>Total</th>
                      <!-- <th>Total</th>
                                    <th>Total</th> -->
                      <th>
                        <center> <button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>

                      </th>

                    </tr>

                  </thead>


                </table>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddProduct" data-dismiss="modal">New Product/Custom</button>
                <button type="button" class="btn btn-primary btncustom" data-toggle="modal">Custom Input</button>

              </div>



            </div>



          </div>
          <div class="box-body">
            <div class="col-md-6">
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
                  <input type="text" class="form-control" name="txttax" id="txttax" required readonly>
                </div>
              </div>
              <div class="form-group">
                <label>Paid</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtpaid" id="txtpaid" required>
                </div>
              </div>

              <label>Delivery method</label>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-truck"></i>
                  </div>
                  <input type="text" class="form-control" name="cship" id="custominput" placeholder="Custom Option (if option below not available)">
                </div>
              </div>

              <label>External Ref ID (optional)</label>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-list"></i>
                  </div>
                  <input type="text" class="form-control" name="extid" id="extid" placeholder="External Invoice Reference">
                </div>
              </div>

              <div class="form-group">
                <label>
                  <input type="radio" name="ship" id="custom" onclick="Checkradiobutton()" value="3"> Custom
                </label>
                <label>
                  <input type="radio" name="ship" id="store" onclick="Checkradiobutton()" checked value="0"> In-store
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
                  <input type="text" class="form-control" name="txttotal" id="txttotal" required readonly>
                </div>
              </div>

              <div class="form-group">
                <label>Delivery Cost</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtdeliver" id="txtdeliver" required>
                </div>
              </div>

              <div class="form-group">
                <label>Discount</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtdiscount" id="txtdiscount" required>
                </div>
              </div>

              <div class="form-group">
                <label>Due</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtdue" id="txtdue" required readonly>
                </div>
              </div>

              <input type="hidden" class="form-control" name="txtprofit" id="txtprofit" readonly>
              <input type="hidden" class="form-control" name="txtcomms" id="txtcomms" readonly>
              <br>
              <div class="form-group">
                <label>Order Remark</label>
                <textarea class="form-control" name="remark" placeholder="Details" rows="2"></textarea>
              </div>
              <!-- radio -->
              <label>Payment method</label>
              <div class="form-group">
                <label>
                  <input type="radio" name="rb" id="pmethod" class="minimal-red" onclick="paymentState()" value="Cash" checked> Cash
                </label>
                <label>
                  <input type="radio" name="rb" id="card_method" class="minimal-red" onclick="paymentState()" value="Card"> Card
                </label>
                <label>
                  <input type="radio" name="rb" id="pmethod" class="minimal-red" onclick="paymentState()" value="E-Wallet"> E-Wallet
                </label>
                <label>
                  <input type="radio" name="rb" id="pmethod" class="minimal-red" onclick="paymentState()" value="Online Transfer"> Online Transfer
                </label>

                <div class="form-group" id="card_trans" style="display:none">
                  <label>Transaction ID</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-credit-card"></i>
                    </div>
                    <input type="text" class="form-control" name="trans_id" id="trans_id">
                  </div>
                </div>

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
                <input type="hidden" name="agentid" id="agentid" value="<?php echo $_SESSION['userid']; ?>" required>
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="caddress" id="caddress" placeholder="Address">
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="city" id="city" placeholder="City">
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input class="form-control input-lg" type="text" name="cpostcode" id="cpostcode" placeholder="Postcode">
              </div>
            </div>

            <!--Input address -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <select class="form-control" name="state" id="state">
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
                <input class="form-control input-lg" type="text" name="cemail" id="cemail" placeholder="Email">
              </div>
            </div>

            <!--Input phone -->
            <!-- <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                <input class="form-control input-lg" type="text" name="cicnum" id="cicnum" placeholder="IC Number">
              </div>
            </div> -->


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
<div id="modalAddProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form role="form" id="formproduct" method="POST">
        <div class="modal-header" style="background: #3c8dbc; color: #fff">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Product/Custom</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">

            <!--Input name -->
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
            <div class="form-group required">
              <label class="control-label">Stock</label>
              <input type="number" min="0" step="any" class="form-control" name="txtstock" placeholder="Stock" required>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-truck"></i>
                </div>
                <input type="text" class="form-control" name="txtbarcode" id="custominput" placeholder="Barcode (optional)">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="sumbit" id="datasend" class="btn btn-primary">Save Product</button>
        </div>
      </form>

    </div>

  </div>
</div>
<script>
  $(document).ready(function() {
    $("#pmethod").change(function() {
      if ($(this).val() !== "Card") {
        var selectedValue = $(this).val();
        console.log(selectedValue);
      }
    });
  });

  function getUser($userid) {
    jQuery.ajax({
      url: "checkuser.php?userid=" + $userid,
      data: 'username=' + $("#username").val(),
      type: "POST",
      success: function(data) {
        $("#check-user").html(data);
      },
      error: function() {}
    });
  }
</script>
<script>
  $(document).on("change", ".radioBtnClass", function() {
    console.log($(this).val()); // Here you will get the current selected/checked radio option value
  });
</script>
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
        url: "process_cdata.php",
        type: "post",
        data: serializedData
      });

      // Callback handler that will be called on success
      request.done(function(response, textStatus, jqXHR) {
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

    $("#formproduct").submit(function(event) {
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
        url: "process_pdata.php",
        type: "post",
        data: serializedData
      });

      // Callback handler that will be called on success
      request.done(function(response, textStatus, jqXHR) {
        // Log a message to the console
        console.log("Hooray, it worked!");
        swal({
          title: "Success!",
          text: "Product addded",
          icon: "success",
          button: "Ok",
        });
        $('#modalAddProduct').modal('toggle');
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
  $('#datepicker').datepicker({
    autoclose: true
  })
</script>
<script type="text/javascript">
  //   function paymentState(){
  //   const formGroup = document.querySelector('#card_trans')
  //   if(document.getElementById('#card_method').checked){
  //     formGroup.style.display = "block"
  //     console.log('SH7WSaDFGHWSEIUYFAWSE')
  //   } else {
  //     formGroup.style.display = "none"
  //   }
  //   console.log('FYCJASDFHSDIFHSDUIF')
  // }
  $(document).ready(function() {
    $("input[name='rb']").change(function() {
      if ($(this).val() == "Card") {
        $("#card_trans").show();
      } else {
        $("#card_trans").hide();
      }
    });
  });

  function Checkradiobutton() {
    if (document.getElementById('store').checked || document.getElementById('ep').checked || document.getElementById('lala').checked) {
      document.getElementById('custominput').disabled = true;
    } else {
      document.getElementById('custominput').disabled = false;
    }
  }
</script>
<script>
  //Red color scheme for iCheck


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
    $(document).on('change', '#pricetype', function() {
      var pricetype = $('#pricetype option:selected').val();
      console.log(pricetype);
    })




    $(document).on('click', '.btnadd', function() {

      var html = '';
      html += '<tr>';

      html += '<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
      html += '<td><select class="form-control productid" id="productid" name="productid[]" style="width: 250px";><option value="">Select Option</option><?php echo fill_product($pdo); ?> </select></td>';
      html += '<td><input type="text" class="form-control remark" name="remark_arr[]"></td>';
      html += '<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
      html += '<td><input type="number" class="form-control price eprice" name="price[]" ></td>';
      html += '<td><input type="number" min="0" step="any" class="form-control qty" name="qty[]" ></td>';
      html += '<td><input type="text" class="form-control total" name="total[]" readonly></td>';

      html += '<input type="hidden" class="form-control profit" readonly>';
      html += '<input type="hidden" class="form-control stockist" readonly>';
      html += '<input type="hidden" class="form-control pprice" readonly>';
      html += '<input type="hidden" class="form-control ispromo" name="ispromo[]" readonly>';
      html += '<input type="hidden" class="form-control comms" name="comms[]">';
      html += '<input type="hidden" class="form-control profit2" name="profit[]" readonly></td>';
      html += '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>';
      $('#producttable').append(html);
      // $('.productid').select2();
      // $('.productid').select2("open");


      $('#productid').select2({
        placeholder: 'Select product',
        ajax: {
          url: "product-get.php",
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

      $(".productid").on('change', function(e) {

        // $(".btnadd").click();

        // $('.productid').select2("open");
        var productid = this.value;
        var tr = $(this).parent().parent();
        var pricetype = $('#pricetype option:selected').val();
        var comms = <?php echo $comms ?>;
        $.ajax({
          url: "getproduct.php",
          method: "get",
          data: {
            id: productid
          },
          success: function(data) {
            //console.log(data);
            // if (data["pstock"] != 0) {

            tr.find(".pname").val(data["pname"]); //get pname from column
            tr.find(".stock").val(data["pstock"]);
            tr.find(".pprice").val(data["purchaseprice"]);
            tr.find(".sprice").val(data["saleprice"]);
            if (pricetype == '2') {
              tr.find(".price").val(data["stkprice"]);
            } else if (pricetype == '3') {
              tr.find(".price").val(data["wholeprice"]);
            } else if (pricetype == '1') {
              tr.find(".price").val(data["saleprice"]);
            }
            // console.log(pricetype);
            tr.find(".profit").val(data["profit"]);
            tr.find(".stockist").val(data["stkprice"]);
            tr.find(".ispromo").val(data["is_promo"]);
            tr.find(".profit2").val(data["profit"]);
            if (data["pstock"] != 0) {
              tr.find(".qty").val(1);
            } else {
              tr.find(".qty").val(0);
            }
            tr.find(".total").val(tr.find(".qty").val() * tr.find(".eprice").val());
            tr.find(".comms").val(tr.find(".qty").val() * (tr.find(".price").val() * (comms / 100)));
            tr.find(".profit").val(tr.find(".qty").val() * tr.find(".profit2").val());
            calculate(0, 0, 0);
            // } else {
            //   jQuery(function validation() {
            //     swal({
            //       title: "Warning!",
            //       text: "Product stock is empty, please update",
            //       icon: "error",
            //       button: "Ok",
            //     });
            //   });
            // }
          }
        })

      })
    })

    $(document).on('click', '.btncustom', function() {
      var html = '';
      html += '<tr>';

      html += '<td><input type="hidden" class="form-control productid" name="productid[]" value="0" readonly></td>';
      html += '<td><input type="text" class="form-control pname" name="productname[]" ></td>';
      html += '<td><input type="text" class="form-control remark" name="remark_arr[]"></td>';
      html += '<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
      html += '<td><input type="number" class="form-control price eprice" name="price[]" ></td>';
      html += '<td><input type="number" min="0" step="any" class="form-control qty" value="1" name="qty[]" ></td>';
      html += '<td><input type="text" class="form-control total" name="total[]" readonly></td>';
      html += '<input type="hidden" class="form-control profit" readonly>';
      html += '<input type="hidden" class="form-control stockist" readonly>';
      html += '<input type="hidden" class="form-control pprice" readonly>';
      html += '<input type="hidden" class="form-control ispromo" name="ispromo[]" readonly>';
      html += '<input type="hidden" class="form-control comms" name="comms[]">';
      html += '<input type="hidden" class="form-control profit2" name="profit[]" readonly></td>';
      html += '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>';
      $('#producttable').append(html);
    })

    $(document).on('click', '.btnremove', function() {
      $(this).closest('tr').remove();
      calculate(0, 0, 0);
      $("#txtpaid").val(0);
    })
    $("#producttable").delegate(".qty", "keyup change", function() {
      var quantity = $(this);
      var tr = $(this).parent().parent();
      var comms = <?php echo $comms; ?>;

      tr.find(".total").val(quantity.val() * tr.find(".price").val());
      tr.find(".comms").val(quantity.val() * (tr.find(".price").val() * (comms / 100)));
      tr.find(".profit").val(quantity.val() * tr.find(".profit2").val());
      calculate(0, 0, 0);

    })
    $("#producttable").delegate(".price", "keyup change", function() {
      console.log('maybee?')
      var pprice = $(".pprice").val();
      var tr = $(this).parent().parent();

      tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
      tr.find(".profit2").val(((tr.find(".pprice").val() - tr.find(".price").val()) * -1));
      tr.find(".profit").val(tr.find(".profit2").val() * tr.find(".qty").val());
      calculate(0, 0, 0);
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
      var comms = 0;
      $(".profit").each(function() {
        profit = profit + ($(this).val() * 1);
        $("#txtprofit").val(profit.toFixed(2));
      })
      $(".comms").each(function() {
        comms = comms + ($(this).val() * 1);
        $("#txtcomms").val(comms.toFixed(2));
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
      net_total = (net_total - discount);
      net_total = (net_total + parseFloat(deliver));
      due = net_total - paid_amt;



      $("#txtsubtotal").val(subtotal.toFixed(2));
      $("#txttax").val(tax.toFixed(2));
      $("#txttotal").val(net_total.toFixed(2));
      $("#txtdiscount").val(discount);
      $("#txtdeliver").val(deliver);
      $("#txtdue").val(due.toFixed(2));

      $("#txtdiscount").keyup(function() {
        var discount = $("#txtdiscount").val();
        var deliver = $("#txtdeliver").val();
        var paid = $("#txtpaid").val();
        calculate(discount, paid, deliver);
      })
      // $('#txtdiscount_val').removeAttr("disabled");

      // end calc

      $("#txtdeliver").keyup(function() {
        var discount = $("#txtdiscount_val").val();
        var deliver = $("#txtdeliver").val();
        calculate(0, 0, deliver);
      })


    }

  });
</script>

<?php
include_once 'footer.php'
?>
})
</script>