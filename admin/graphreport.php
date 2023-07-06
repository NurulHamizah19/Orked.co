<?php 
include_once'connectdb.php';
session_start();
error_reporting(0);
if($_SESSION['role'] == "User" or $_SESSION['role'] == "Agent"){
include_once 'headeruser.php';
} else {
    include_once 'header.php';
}
if($_SESSION['useremail']==""){
    
    header('location:index.php');
}
$dt = date('Y-m-d');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Report (Graph)
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
               
               <div class="row">
                    <div class="col-md-5">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" value="<?php echo date("Y-m-01", strtotime($dt)); ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker2" name="date_2" value="<?php echo date("Y-m-t", strtotime($dt)); ?>" data-date-format="yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div align="left">
               <input type="submit" name="btndatefilter" value="Filter by date order" class="btn btn-success">
           </div>
                    </div>
                </div>
               <br><br>
               
               <?php
    $select=$pdo->prepare("SELECT order_date, sum(total) AS price FROM tbl_invoice WHERE order_date BETWEEN :fromdate AND :todate GROUP BY order_date");
      $select->bindParam(':fromdate',$_POST['date_1']);  
             $select->bindParam(':todate',$_POST['date_2']);  
            
    $select->execute();
                  
    $total=[];
    $date=[];              
            
while($row=$select->fetch(PDO::FETCH_ASSOC)  ){
    
extract($row);
    
    $total[]=$price;
    $date[]=$order_date;
    
    
}
               //echo json_encode($total);  
                  
                  ?>
               <div class="chart">
                <canvas id="myChart" class="height:200px"></canvas>
               </div>
               
               <?php
    $select=$pdo->prepare("SELECT product_name, sum(qty) AS q FROM tbl_invoice_details WHERE order_date BETWEEN :fromdate AND :todate GROUP BY product_id");
      $select->bindParam(':fromdate',$_POST['date_1']);  
             $select->bindParam(':todate',$_POST['date_2']);  
            
    $select->execute();
                  
    $pname=[];
    $qty=[];              
            
while($row=$select->fetch(PDO::FETCH_ASSOC)  ){
    
extract($row);
    
    $pname[]=$product_name;
    $qty[]=$q;
    
    
}
               // echo json_encode($total);  
                  
                  ?>
                  
                  <div class="chart">
                <canvas id="topproduct" class="height:200px"></canvas>
               </div>
               
            </div>
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($date);?>,
        datasets: [{
            label: 'Total Earning',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($total);?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
<script>
var ctx = document.getElementById('topproduct').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($pname);?>,
        datasets: [{
            label: 'Top Product',
            backgroundColor: 'rgb(177, 180, 250)',
            borderColor: 'rgb(177, 180, 250)',
            data: <?php echo json_encode($qty);?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
<script>
  $(document).ready( function () {
    $('#salesreporttable').DataTable({
        "order":[[0,"desc"]]    
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
include_once 'footer.php'
?>