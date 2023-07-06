<?php 
include_once 'connectdb.php';
session_start();

if($_SESSION['useremail']==""){ //check if empty
    header('location:index.php'); //redirect to index
}

$select = $pdo->prepare("SELECT sum(total) AS t, count(invoice_id) AS inv FROM tbl_invoice");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$total_order = $row->inv;
$net_total = $row->t;


    $select=$pdo->prepare("SELECT order_date, total FROM tbl_invoice GROUP BY order_date LIMIT 20");
    $select->execute();
                  
    $ttl=[];
    $date=[];              
            
while($row=$select->fetch(PDO::FETCH_ASSOC)){
    
extract($row);
    
    $ttl[]=$total;
    $date[]=$order_date;
    
    
}
               //echo json_encode($total);  
                  
            
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
        User Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
    
    <div class="box-body">
        
        <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h2><?php echo $total_order; ?></h2>

              <p>Total Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="orderlist.php" class="small-box-footer">View order <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h2><?php echo "RM ".number_format($net_total,2); ?></h2>

              <p>Total Revenue</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="tablereport.php" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <?php
        
            $select = $pdo->prepare("SELECT count(pname) as p FROM tbl_product");
            $select->execute();
            $row = $select->fetch(PDO::FETCH_OBJ);

            $total_product = $row->p;
        
        ?>
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h2><?php echo $total_product; ?></h2>

              <p>Total Product</p>
            </div>
            <div class="icon">
              <i class="ion ion-plus"></i>
            </div>
            <a href="productlist.php" class="small-box-footer">View products <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <?php
        
            $select = $pdo->prepare("SELECT count(category) as cat FROM tbl_category");
            $select->execute();
            $row = $select->fetch(PDO::FETCH_OBJ);

            $total_category = $row->cat;
        
        ?>
        
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h2><?php echo $total_category; ?></h2>

              <p>Total Category</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="category.php" class="small-box-footer">View category <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
       
       <div class="row">
                
                <div class="col-md-6">
                    <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Best Selling Products </h3>
            </div>
            
            <div class="box-body">
            <table id="bestsellingproduct" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sales Total</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = $pdo->prepare("SELECT product_id,product_name,price,sum(qty) as q, sum(price*qty) as total FROM tbl_invoice_details GROUP BY product_id ORDER BY sum(qty) DESC LIMIT 30");
                        $select->execute();
                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            echo '
                            <tr>
                            <td>'.$row->product_id.'</td>
                            <td>'.$row->product_name.'</td>
                            <td><span class="label label-info">'.$row->q.'</span></td>
                            <td><span class="label label-success">RM '.number_format($row->price,2).'</span></td>
                            <td><span class="label label-warning">RM '.number_format($row->total,2).'</span></td>
                            
                            ';
                        }
                        ?>
                    </tbody>
                </table>
            
            </div></div>
                </div>
                <div class="col-md-6">
                    <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Orders </h3>
            </div>
            
            <div class="box-body">
            <table id="orderlisttable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Payment Method</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select = $pdo->prepare("SELECT * FROM tbl_invoice ORDER BY invoice_id DESC LIMIT 10");
                        $select->execute();
                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                            echo '
                            <tr>
                            <td><a href="editorder.php?id='.$row->invoice_id.'">'.$row->invoice_id.'</a></td>
                            <td>'.$row->customer_name.'</td>
                            <td>'.$row->order_date.'</td>
                            <td><span class="label label-info">RM '.number_format($row->total,2).'</span></td>';
                            
                            if($row->payment_type == "Cash"){
                                echo '<td><span class="label label-success">'.$row->payment_type.'</span></td>';
                            } else {
                                echo '<td><span class="label label-danger">'.$row->payment_type.'</span></td>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            
            </div></div>
                </div>
            </div>
        
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Earning by date </h3>
            </div>
            
            <div class="box-body">
            <div class="chart">
                <canvas id="earningbydate" class="height:150px"></canvas>
               </div>
            
            </div></div>
        
    </div>
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script>
var ctx = document.getElementById('earningbydate').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($date);?>,
        datasets: [{
            label: 'Total Earning',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($ttl);?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>

<?php
include_once 'footer.php'
?>