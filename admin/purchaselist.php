<?php 
include_once'connectdb.php';
session_start();
if($_SESSION['role'] == "User"){
include_once 'headeruser.php';
} else {
    include_once 'header.php';
}
if($_SESSION['useremail']==""){
    header('location:index.php');
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PO List
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
               
            </div>
            
            <div class="box-body">
                <div style="overflow-x:auto;"> 
                <table id="orderlisttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Supplier</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Print</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = $pdo->prepare("SELECT * FROM tbl_po ORDER BY invoice_id desc");
                        $select->execute();
                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            echo '
                            <tr>
                            <td>'.$row->invoice_id.'</td>
                            <td>'.$row->supplier.'</td>
                            <td>'.$row->order_date.'</td>
                            <td>'.$row->total.'</td>
                            <td>
                            <a href="poinvoice.php?id='.$row->invoice_id.'" class="btn btn-warning" target="_blank" role="button"><span class="glyphicon glyphicon-print" style ="color:#fffff" data-toggle="tooltip" title="Print Invoice"
                            </td></a>
                          
                            <td>
                            <button id='.$row->invoice_id.' class="btn btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Order"></span></button>
                            ';
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
        "order":[[0,"desc"]]
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
          url: 'podelete.php',
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