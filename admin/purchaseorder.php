<?php 
include_once 'connectdb.php';
session_start();
include_once 'config.php';

if($_SESSION['useremail']==""){
    
    header('location:index.php');
}

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
    $profit = $_POST['txtprofit'];
    $addr1 = $_POST['addr1'];
    $addr2 = $_POST['addr2'];
    $remark = $_POST['remarks'];
    $description = $_POST['description'];
    
    $arr_productid = $_POST['productid'];
    $arr_productname = $_POST['productname'];
    $arr_stock = $_POST['stock'];
    $arr_qty = $_POST['qty'];
    $arr_price = $_POST['price'];
    $arr_total = $_POST['total'];
    $itemcode = $_POST['itemcode'];
    
	if(!empty($arr_productid)){
    $insert = $pdo->prepare("INSERT INTO tbl_po(supplier,order_date,subtotal,total,paid,due,payment_type,addr1,addr2,remark,descr) values(:supplier,:orderdate,:stotal,:total,:paid,:due,:ptype,:addr1,:addr2,:remark,:descr)");
    
    $insert->bindParam(':supplier',$customer_name);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':stotal',$subtotal);
    $insert->bindParam(':total',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':ptype',$payment_type);
    $insert->bindParam(':addr1',$addr1);
    $insert->bindParam(':addr2',$addr2);
    $insert->bindParam(':remark',$remark);
    $insert->bindParam(':descr',$description);
		
    $insert->execute();
    
    // another one
    
    $invoice_id = $pdo->lastInsertId();
    if($invoice_id != null){
        for($i=0;$i<count($arr_productid);$i++){
            
        //    $rem_qty = $arr_stock[$i] - $arr_qty[$i];
           
        //    if($rem_qty < 0){
        //        return "Order failed";
        //    } else {
        //        $update = $pdo->prepare("UPDATE tbl_product SET pstock='$rem_qty' WHERE pid='".$arr_productid[$i]."'");
               
        //        $update->execute();
        //    }
            
            $insert = $pdo->prepare("INSERT INTO tbl_po_details(invoice_id,product_id,product_name,qty,price,order_date,itemcode) values(:invid,:pid,:pname,:qty,:price,:orderdate,:itemcode)");
            
            $insert->bindParam(':invid',$invoice_id);
            $insert->bindParam(':pid',$arr_productid[$i]);
            $insert->bindParam(':pname',$arr_productname[$i]);
            $insert->bindParam(':qty',$arr_qty[$i]);
            $insert->bindParam(':price',$arr_price[$i]);
            $insert->bindParam(':orderdate',$order_date);
            $insert->bindParam(':itemcode',$itemcode[$i]);
            
            $insert->execute();
                
        }
        // echo 'todo sweetalert success';
        header('location:purchaselist.php');
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

if($_SESSION['role'] == "User"){
include_once 'headeruser.php';
} else {
    include_once 'header.php';
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchase Order
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
           <form action="" method="post" name="">
            <div class="box-header with-border">
                <h3 class="box-title">New Order</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                  <label>Supplier</label>
                  
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtcustomer" placeholder="Supplier Name" required>
                  </div>
            
                </div>
                <div class="form-group">
                  <label>Address Line 1</label>
                  
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="addr1" placeholder="Line 1" required>
                  </div>
            
                </div>
                </div>
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
                  <label>Address Line 2</label>
                  
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="addr2" placeholder="Line 1" required>
                  </div>
                </div>
                
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label>Description</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="description" placeholder="" required>
                  </div>
                </div>
                </div>
            <div class="box-body">
                    <div class="col-md-12">
                 <div style="overflow-x:auto;"> 
                        <table class="table table-bordered" id="producttable"  >
                      
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Code</th>
                                    <th>Search Product</th>
<!--                                    <th>Stock</th>-->
                                    <th>Price</th>
                                    <th>Enter Quantity</th>
                                    <th>Total</th>
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
                  <label>Subtotal</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" name="txtsubtotal" id="txtsubtotal" required readonly>
                </div>
                    </div>
                    <div class="form-group">
                  <label>Paid</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtpaid" id="txtpaid" required>
                    </div></div>

               
                  <input type="hidden" class="form-control" name="txttax" id ="txttax" required readonly>
                 


                  <input type="hidden" class="form-control" name="txtdiscount" id="txtdiscount" required>
                  <div class="from-group">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" placeholder="Notes/Remarks" rows="4"></textarea>
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
                  <label>Due</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" name="txtdue" id="txtdue" required readonly>
                    </div> </div>
            
                  <input type="hidden" class="form-control" name="txtprofit" id="txtprofit"   readonly>
           <br>

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
<script>
    $('#datepicker').datepicker({
      autoclose: true
    })
</script>
<script>
//Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    
    $(document).ready(function(){
        $(document).on('click','.btnadd',function(){
            var html='';
            html+='<tr>';
        
            html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html+='<td><input type="text" class="form-control" name="itemcode[]"></td>';
            html+='<td><select class="form-control productid" name="productid[]" style="width: 250px";><option value="">Select Option</option><?php echo fill_product($pdo); ?> </select></td>';
            html+='<td><input type="text" class="form-control price" name="price[]" ></td>';
            html+='<td><input type="number" min="1" class="form-control qty" name="qty[]" ></td>';
            html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
            html+='<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button><center></td></center>'; 
            
            $('#producttable').append(html);
            $('.productid').select2()
            
            $(".productid").on('change', function(e){
                var productid = this.value;
                var tr=$(this).parent().parent();
                $.ajax({
                    url:"getproduct.php",
                    method:"get",
                    data:{id:productid},
                    success:function(data){
                        //console.log(data);
                    tr.find(".pname").val(data["pname"]); //get pname from column
                    tr.find(".stock").val(data["pstock"]);
                    tr.find(".price").val(data["saleprice"]);
                    tr.find(".profit").val(data["profit"]);
                    tr.find(".profit2").val(data["profit"]);
                    tr.find(".qty").val(1);
                    tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
                    tr.find(".profit").val(tr.find(".qty").val() * tr.find(".profit2").val());
                        calculate(0,0);
                    }
                })
            })
            })
        
        $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculate(0,0);
            $("#txtpaid").val(0);
        })
        $("#producttable").delegate(".qty","keyup change" ,function(){
        var quantity = $(this);
        var tr = $(this).parent().parent(); 
        if((quantity.val()-0)>(tr.find(".stock").val()-0)){
            swal("Warning","Quantity exceeds stock value","warning");
            
        quantity.val(1);
            
        tr.find(".total").val(quantity.val() *  tr.find(".price").val());
        tr.find(".profit").val(quantity.val() * tr.find(".profit2").val());
        calculate(0,0);
       } else{
           tr.find(".total").val(quantity.val() *  tr.find(".price").val());
           tr.find(".profit").val(quantity.val() * tr.find(".profit2").val());
           calculate(0,0);
       }    
    })    
        $("#producttable").delegate(".price","keyup change" ,function(){
        var price = $(this);
        var tr = $(this).parent().parent(); 
        tr.find(".total").val(price.val());
        calculate(0,0);
          
    })  
    
     function calculate(dis,paid){
         var subtotal = 0;
         var tax = 0;
         var discount = dis;
         var net_total = 0;
         var paid_amt = paid;
         var due = 0;
         var profit = 0;
         $(".profit").each(function(){
             profit = profit+($(this).val()*1);
             $("#txtprofit").val(profit.toFixed(2));
         })
         $(".total").each(function(){
             subtotal = subtotal+($(this).val()*1);
         })
         
         tax = <?php echo $tax_rate; ?> * subtotal;
         net_total = tax + subtotal;
         net_total -= discount;
         due = net_total - paid_amt;
         
         
         $("#txtsubtotal").val(subtotal.toFixed(2));
         $("#txttax").val(tax.toFixed(2));
         $("#txttotal").val(subtotal.toFixed(2));
         $("#txtdiscount").val(discount);
         $("#txtdue").val(due.toFixed(2));
         // end calc
         $("#txtdiscount").keyup(function(){
             var discount = $(this).val();
             calculate(discount,0);
         })
         $("#txtpaid").keyup(function(){
             var paid = $(this).val();
             var discount = $("#txtdiscount").val();
             calculate(discount,paid);
         })
     }   
        
    });
</script>
<?php
include_once 'footer.php'
?>