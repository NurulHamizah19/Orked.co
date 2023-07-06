<?php 
include_once'connectdb.php';
session_start();
if($_SESSION['role'] == "User" OR $_SESSION['role'] == "Agent"){
include_once 'headeruser.php';
} else {
    include_once 'header.php';
}
if($_SESSION['useremail']==""){
    header('location:index.php');
}
function client_data($pdo ,$cid){
  $output='';
  $select = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$cid");
  $select->execute();
  $result = $select->fetchAll(PDO::FETCH_OBJ);
  
  foreach($result as $rows){
    if($rows->name != ""){
      $output.='
      <td>'.$rows->name.'</td>';
      
      echo'
      ';
    }
      
  }
    return $output;
  
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order List
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
            <h3 class="box-title"><a href="sales.php" class="btn btn-primary" role="button">Add Sales</a></h3>
            <h3 class="box-title"><a href="createorder.php" class="btn btn-info" role="button">Add Order</a></h3>
            <?php 
            if($_SESSION['role'] == "Admin"){
                echo '<h3 class="box-title"><a href="orderlist.php" class="btn btn-info" role="button">Return</a></h3>';
            }
            ?>
            </div>
            
            <div class="box-body">
                <div class="row">
                    <form action="" method="post">
                    <div class="col-md-5">
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-users"></i>
                          </div>
                          <input type="text" class="form-control pull-right" name="loginid" id="loginid" placeholder="Search by User ID" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div align="left">
                            <input type="submit" name="btnlogin" value="Search" class="btn btn-success">
                        </div>
                    </div>
                    </form>
                </div>
                <div style="overflow-x:auto;"> 
                <table id="orderlisttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment Type</th>
                            <th>Commissions (RM)</th>
                            <th>View</th>
                            
                            <th>Print</th>
                            <th>Print (Thermal)</th>
                            <?php 
                            if($_SESSION['role'] != "User"){
                              echo '<th>Edit</th>
                              <th>Delete</th>';
                            }
                            ?>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_POST['btnlogin'])){
                            $current_id = $_POST['loginid'];
                            $select = $pdo->prepare("SELECT * FROM tbl_invoice WHERE agentid = $current_id ORDER BY invoice_id DESC");
                            $select->execute();
                            while($row = $select->fetch(PDO::FETCH_OBJ)){
                              $cid = $row->customer_name;
                                echo '
                                <tr>
                                <td>'.$row->invoice_id.'</td>'.client_data($pdo ,$cid);
                                if(client_data($pdo ,$cid) == ""){
                                  echo '<td>-</td>';
                                }
                                echo'
                                <td>'.$row->order_date.'</td>
                                <td>RM '.number_format($row->total,2).'</td>
                                <td>RM '.number_format($row->paid,2).'</td>';
                                if($row->due == 0){
                                  echo '<td><span class="label label-success">RM '.number_format($row->due,2).'</span></td>';
                                } else {
                                  echo '<td><span class="label label-danger">RM '.number_format($row->due,2).'</span></td>';
                                }
                                echo'
                                <td>'.$row->payment_type.'</td>
                                <td>'.number_format($row->comms,2).'</td>
                                <td>
                                <a href="vieworder.php?id='.$row->invoice_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-eye-open" style ="color:#fffff" data-toggle="tooltip" title="Ship Order"
                                </td></a>
                                <td>
                                <a href="invoice.php?id='.$row->invoice_id.'" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-print" style ="color:#fffff" data-toggle="tooltip" title="Print Invoice"
                                </td></a>
                                <td>
                                <a href="invoice_thermal.php?id='.$row->invoice_id.'" class="btn btn-success" role="button" target="_blank"><span class="glyphicon glyphicon-print" style ="color:#fffff" data-toggle="tooltip" title="Edit Order"
                                </td></a>
                                <td>';
                                if($_SESSION['role'] != "User"){
                                  echo '
                                <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style ="color:#fffff" data-toggle="tooltip" title="Edit Order"
                                </td></a>
                                <td>
                                <button id='.$row->invoice_id.' class="btn btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Order"></span></button>
                                ';
                                }
                            }   
                        }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  $(document).ready( function () {
    $('#orderlisttable').DataTable({
      "order":[[0,"desc"]],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
} );  
</script>
<script>
  $(document).ready( function () {
   $('[data-toggle="tooltip"]').tooltip();
} );  

</script>
<script>
$(document).ready(function() {
    $('.btndelete').click(function() {
            var tdh = $(this);
            var id = $(this).attr("id");
             swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this order!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
    })
.then((willDelete) => {
  if (willDelete){
      $.ajax({
          url: 'orderdelete.php',
          type: 'post',
          data: {
              pidd: id
          },
          success: function(data) {
              tdh.parents('tr').hide();
          }
    });
      
    swal("Your order has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Order is not deleted");
  }
});
        });
    });  
</script>

<?php
include_once 'footer.php'
?>