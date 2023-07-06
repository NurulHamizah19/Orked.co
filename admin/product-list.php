<?php 
include_once 'connectdb.php';
session_start();
if($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent"){
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
        Product List
        
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
                <h3 class="box-title"><a href="product-add.php" class="btn btn-primary" role="button">Add Product</a></h3>
              </div>
            <div class="box-body">
               <div style="overflow-x:auto;"> 
                <table id="producttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Stock</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>View</th>
                            <?php
                            if($_SESSION['role'] == "Admin"){
                              echo '
                              <th>Edit</th>
                            <th>Delete</th>
                              ';
                            }
                            ?>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pid desc");
                        $select->execute();
                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            echo '
                            <tr>
                            <td>'.$row->pid.'</td>
                            <td>'.$row->pname.'</td>
                            <td>'.$row->pcategory.'</td>
                            <td>'.number_format($row->purchaseprice,2).'</td>
                            <td>'.number_format($row->saleprice,2).'</td>';
                            if($row->pstock == 0){
                              echo '<td><span class="label label-danger">'.$row->pstock.'</span></td>';
                            } else if($row->pstock < 5) {
                              echo '<td><span class="label label-warning">'.$row->pstock.'</span></td>';
                            } else {
                              echo '<td><span class="label label-success">'.$row->pstock.'</span></td>';
                            }
                            echo ' <td>'.$row->pdescription.'</td>';
                            echo'
                            <td><img src="productimages/'.$row->pimage.'" class="img-rounded" width="40px" height="40px" onerror="imgError(this);" ></td>
                            <td>
                            <a href="product-view.php?id='.$row->pid.'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-eye-open" style ="color:#fffff" data-toggle="tooltip" title="View Product"
                            </td></a>';
                            if($_SESSION['role'] != "User" and $_SESSION['role'] != "Agent"){
                              echo '<td>
                              <a href="editproduct.php?id='.$row->pid.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style ="color:#fffff" data-toggle="tooltip" title="Edit Product"
                              </td></a>
                              <td>
                              <button id='.$row->pid.' class="btn btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Product"></span></button>
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