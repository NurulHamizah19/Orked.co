<?php 
include_once'connectdb.php';
error_reporting(0);
session_start();
if($_SESSION['role'] == "User"){
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
$dt = date('Y-m-d');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product Sold
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
           <form  action="" method="post" name="">
            <div class="box-header with-border">
                <h3 class="box-title">Showing data from  <?php echo $_POST['date_1'];?> to <?php echo $_POST['date_2'];?>  </h3>
            </div>
            
            <div class="box-body">
                <?php
        $select = $pdo->prepare("SELECT sum(total) as total, sum(profit) as profit, count(invoice_id) as invoice FROM tbl_invoice WHERE order_date BETWEEN :fromdate AND :todate");
        
        $select->bindParam(':fromdate',$_POST['date_1']);
        $select->bindParam(':todate',$_POST['date_2']);
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);
            $net_total = $row->total;
            $profit = $row->profit;
            $invoice = $row->invoice;
         ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker1" value="<?php echo date("Y-m-01", strtotime($dt)); ?>" name="date_1" data-date-format="yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker2"value="<?php echo date("Y-m-t", strtotime($dt)); ?>"  name="date_2" data-date-format="yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div align="left">
               <input type="submit" name="btndatefilter" value="Filter by date order" class="btn btn-success">
           </div>
                    </div>
                </div>
      
   
      <!-- /.row -->
                <br><br>
                <div style="overflow-x:auto;"> 
                <table id="salesreporttable" class="table table-striped">
        <thead>
        <tr>
        <th>Product Name</th>
         <th>Total Sold</th>   
          
        </tr>    
            
        </thead> 
           
<!--
                  <?php
//                        $select = $pdo->prepare("SELECT * FROM tbl_invoice ORDER BY invoice_id DESC LIMIT 10");
//                        $select->execute();
//                        while($row = $select->fetch(PDO::FETCH_OBJ)){
//                            echo '
//                            <tr>
//                            <td><a href="editorder.php?id='.$row->invoice_id.'">'.$row->invoice_id.'</a></td>
//                            <td>'.$row->customer_name.'</td>
//                            <td>'.$row->order_date.'</td>
//                            <td><span class="label label-info">'.$row->total.'</span></td>';
//                            
//                            if($row->payment_type == "Cash"){
//                                echo '<td><span class="label label-success">'.$row->payment_type.'</span></td>';
//                            } else {
//                                echo '<td><span class="label label-danger">'.$row->payment_type.'</span></td>';
//                            }
//                        }
                        ?>
-->
        <tbody>
        <?php
           $select=$pdo->prepare("SELECT product_name, sum(qty) AS q FROM tbl_invoice_details WHERE order_date BETWEEN :fromdate AND :todate GROUP BY product_id");
           $select->bindParam(':fromdate',$_POST['date_1']);  
                  $select->bindParam(':todate',$_POST['date_2']);  
                 
         $select->execute();      
         $pname=[];
         $qty=[];              
                 
     while($row=$select->fetch(PDO::FETCH_ASSOC)  ){
         
     extract($row);
     
     $data = json_encode($row);
     $store = array($row);
     
         $pname[]=$product_name;
         $qty[]=$q;
     
     
          $total = count($pname);
          echo '<tr>';
          foreach($store as $key){
              echo '<td>'.$key['product_name'].'</td>'; $key['q'];
              echo '<td>'.$key['q'].'</td>'; 
          }
          echo '</tr>';
     }
     
?>
                
         </tbody>               
                     </table>
                </div>
<!-- TODO EXPORT DATA -->
            </div>
            </form>
        </div>
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
  $(document).ready( function () {
    $('#salesreporttable').DataTable({
        "order":[[0,"desc"]],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
} );  
</script>
<script>
    $('#datepicker1').datepicker({
      autoclose: true
    })
    $('#datepicker2').datepicker({
      autoclose: true
    })
</script>
<?php
include_once 'footer.php';
?>