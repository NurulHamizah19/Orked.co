<?php 
include_once 'connectdb.php';
session_start();
include_once 'header.php';
if($_SESSION['role'] == "User"){
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
        Cash Book 
        <small>
        	Keep track of your expenses
        </small>
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
		<form action="" method="post" name="formproduct" enctype="multipart/form-data">
        <div class="col-md-12">
        	<div class="box box-info">
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
				</div>
			</div>
        </div>
        <div class="col-md-6">
        
        	<div class="box box-info">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title">Debit</h3>
            </div>
            <!-- form start -->
            

            <div class="box-body">
               <table class="table table-hover">
               	<thead>
               		<th>Date</th>
               		<th>Details</th>
               		<th>Amount</th>
               	</thead>
               	<tbody>
               		
               		<?php 
               		$select = $pdo->prepare("SELECT *, DATE_FORMAT(cb_date, '%d/%m/%Y') AS cb_date FROM tbl_cb WHERE dc='Debit' AND (cb_date BETWEEN :fromdate AND :todate)");
					$select->bindParam(':fromdate',$_POST['date_1']);
        			$select->bindParam(':todate',$_POST['date_2']);
					$select->execute();
					while($row = $select->fetch(PDO::FETCH_OBJ)){
						echo '
						<tr>
						<td>'.$row->cb_date.'</td>
               			<td><a href="viewcb.php?id='.$row->cb_id.'">'.$row->detail.'</a></td>
               			<td>'.$row->d_amount.'</td>
						';
					}
               		?>
               	</tbody>
               </table>
               <hr>
               <?php 
				$select = $pdo->prepare("SELECT sum(d_amount) AS debit, sum(c_amount) AS credit FROM tbl_cb WHERE cb_date BETWEEN :fromdate AND :todate");
				$select->bindParam(':fromdate',$_POST['date_1']);
        		$select->bindParam(':todate',$_POST['date_2']);
				$select->execute();
				$row = $select->fetch(PDO::FETCH_OBJ);
				$total_debit = $row->debit;
				$total_credit = $row->credit;
				$total = $total_debit - $total_credit;
			   ?>
               <h4 class="box-title">Total Debit : <?php echo 'RM '.number_format($total_debit,2); ?></h4>
               <h4 class="box-title">Total Balance : <?php echo 'RM '.number_format($total,2); ?></h4>
            </div>
            <div class="box-footer">
            </div>
            
        </div>
        </div>
        <div class="col-md-6">
        	<div class="box box-danger">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title">Credit</h3>
            </div>
            <!-- form start -->

            <div class="box-body">
               <table class="table table-hover">
               	<thead>
               		<th>Date</th>
               		<th>Details</th>
               		<th>Amount</th>
               	</thead>
               	<tbody>
               		<?php 
               		$select = $pdo->prepare("SELECT *, DATE_FORMAT(cb_date, '%d/%m/%Y') AS cb_date FROM tbl_cb WHERE dc='Credit' AND (cb_date BETWEEN :fromdate AND :todate)
					");
					$select->bindParam(':fromdate',$_POST['date_1']);
        			$select->bindParam(':todate',$_POST['date_2']);
					$select->execute();
					while($row = $select->fetch(PDO::FETCH_OBJ)){
						echo '
						<tr>
						<td>'.$row->cb_date.'</td>
               			<td><a href="viewcb.php?id='.$row->cb_id.'">'.$row->detail.'</a></td>
               			<td>'.$row->c_amount.'</td>
						';
					}
               		?>
               	</tbody>
               </table>
               <hr>
               <?php 
				$select = $pdo->prepare("SELECT sum(c_amount) AS credit FROM tbl_cb WHERE cb_date BETWEEN :fromdate AND :todate");
				$select->bindParam(':fromdate',$_POST['date_1']);
        		$select->bindParam(':todate',$_POST['date_2']);
				$select->execute();
				$row = $select->fetch(PDO::FETCH_OBJ);
				$total_credit = $row->credit;
			   ?>
               <h4 class="box-title">Total Credit : <?php echo 'RM '.number_format($total_credit,2); ?></h4>
            </div>
            <div class="box-footer">
            </div>
            </form>

        </div>
        </div>
        
        

    </section>
    <!-- /.content -->
  </div>

    <!-- /.content-wrapper -->
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