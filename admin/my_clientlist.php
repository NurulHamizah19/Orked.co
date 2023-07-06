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
$agentid = $_SESSION['userid'];
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       My Client List
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
                <h3 class="box-title"><a href="addclient.php" class="btn btn-primary" role="button">Add Client</a></h3>
            </div>
            
            <div class="box-body">
                <div style="overflow-x:auto;"> 
                <table id="orderlisttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Address</th>
                            <th>Postcode</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>IC Number</th>
                        
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = $pdo->prepare("SELECT * FROM tbl_client WHERE agentid=$agentid ORDER BY id desc");
                        $select->execute();
                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            echo '
                            <tr>
                            <td>'.$row->id.'</td>
                            <td>'.$row->name.'</td>
                            <td>'.$row->address.'</td>
                            <td>'.$row->postcode.'</td>
                            <td>'.$row->city.'</td>
                            <td>'.$row->state.'</td>
                            <td>'.$row->phone.'</td>
                            <td>'.$row->email.'</td>
                            <td>'.$row->icnum.'</td>
                            <td>
                            <a href="viewclient.php?id='.$row->id.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" style ="color:#fffff" data-toggle="tooltip" title="Edit Order"
                            </td></a>
                            <td>
                            <a href="editclient.php?id='.$row->id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style ="color:#fffff" data-toggle="tooltip" title="Edit Order"
                            </td></a>';
                            if($row->id != 0){
                              echo '<td>
                              <button id='.$row->id.' class="btn btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Order"></span></button>
                              ';
                            } else {
                              echo '<td>
                              <button id='.$row->id.' class="btn btn-danger disabled" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Order"></span></button>
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
          url: 'clientdelete.php',
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