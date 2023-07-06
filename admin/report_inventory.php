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
        Inventory Report 
        
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
            <div class="col-md-8">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-list"></i>
                          </div>
                          <form method="POST">
                          <select class="form-control" name="category" required>
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
                    <div class="col-md-2">
                        <div align="left">
               <input type="submit" name="btndatefilter" value="Filter by category" class="btn btn-success">
               </form>
               
            </div>
                    </div>
                    <div class="col-md-2">
                       
               <a href class="btn btn-info">Show All Products</a>
               
                    </div>
            </div>
            <div class="box-body">
               <div style="overflow-x:auto;"> 
                <table id="producttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Unit Price</th>
                            <th>Inventory Value (RM)</th>
                            <th>View Product</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(isset($_POST['category'])){
                            $category = $_POST['category'];
                            $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pcategory='$category'");
                            $select->execute();
                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                    $pid = $row->pid;
                                    echo '
                                    <tr>
                                    <td>'.$row->pid.'</td>
                                    <td>'.$row->pname.'</td>
                                    <td>'.$row->pcategory.'</td>
                                    <td>'.$row->pstock.'</td>
                                    <td>'.$row->saleprice.'</td>
                                    <td>'.$row->saleprice * $row->pstock.'</td>';
                                    echo '
                                    <td>
                                    <a href="product-view.php?id='.$row->pid.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-eye-open" style ="color:#fffff" data-toggle="tooltip" title="View Product"
                                    </td></a>
                                    
                                    ';
                                }
                        } else {
                        $select = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pid desc");
                        $select->execute();
                            while($row = $select->fetch(PDO::FETCH_OBJ)){
                                $pid = $row->pid;
                                echo '
                                <tr>
                                <td>'.$row->pid.'</td>
                                <td>'.$row->pname.'</td>
                                <td>'.$row->pcategory.'</td>
                                <td>'.$row->pstock.'</td>
                                <td>'.$row->saleprice.'</td>
                                <td>'.$row->saleprice * $row->pstock.'</td>';
                                echo '
                                <td>
                                <a href="product-view.php?id='.$row->pid.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-eye-open" style ="color:#fffff" data-toggle="tooltip" title="View Product"
                                </td></a>
                                
                                ';
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
    $('#producttable').DataTable({
      "order":[[0,"desc"]],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "sSearch": "Search products/keywords"
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