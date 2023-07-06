<?php 
include_once'connectdb.php';
session_start();
if($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent"){
include_once 'headeruser.php';
} else {
    include_once 'header.php';
}
if($_SESSION['useremail']==""){
    header('location:index.php');
}

function get_pname($pid,$pdo){
    $product = $pdo->prepare("SELECT pname FROM tbl_product WHERE pid=$pid");
    $product -> execute();
    $get = $product -> fetch(PDO::FETCH_OBJ);
    $pname = $get -> pname;
    return $pname;
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Stock Management 
        
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
                <h3 class="box-title">Stock History</h3>
            </div>
            <div class="box-body">
               <div style="overflow-x:auto;"> 
                <table id="producttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Total Stock</th>
                            <th>Stock Date</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = $pdo->prepare("SELECT * FROM stock_log ORDER BY id desc");
                        $select->execute();
                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            $pid = $row->pid;
                            echo '
                            <tr>
                            <td>'.$row->id.'</td>
                            <td>'.get_pname($pid,$pdo).'</td>';

                            if($row->restock != 0){
                                echo '<td>Restock</td>';
                                echo '<td>'.$row->restock.'</td>';
                            }
                            if($row->withdraw != 0){
                                echo '<td>Withdraw</td>';
                                echo '<td>'.$row->withdraw.'</td>';
                            }
                            echo'
                            <td>'.$row->total_stock.'</td>
                            <td>'.$row->timestamp.'</td>';
                            echo '
                            <td>
                            <a href="stock-view.php?id='.$row->pid.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-eye-open" style ="color:#fffff" data-toggle="tooltip" title="View Product"
                            </td></a>
                            
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
    $('#producttable').DataTable({
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
  text: "Once product is deleted, you can not recover it!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
      
       $.ajax({
        url: 'productdelete.php',
        type: 'post',
        data: {
        pidd: id
        },
        success: function(data) {
        tdh.parents('tr').hide();
        }
        });
      
    swal("Your product has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Keeping it there...");
  }
});
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
<?php
include_once 'footer.php'
?>