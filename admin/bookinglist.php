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
        Data Table
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
                          <input type="text" class="form-control pull-right" id="datepicker1" value="<?php echo $dt; ?>" name="date_1" data-date-format="yyyy-mm-dd" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div align="left">
               <input type="submit" name="btndatefilter" value="Filter by date order" class="btn btn-success">
           </div>
                    </div>
                </div>
                <hr>

                <div style="overflow-x:auto;"> 
                
                    <?php
                    $select = $pdo->prepare("SELECT * FROM tbl_booking WHERE DATE(timestamp) = :fromdate ");
                    $select->bindParam(':fromdate',$_POST['date_1']);
                    $select->execute();
                    
                   
                    $grouped_hours = array();
                    while($group = $select->fetch(PDO::FETCH_OBJ)){
                    $hour = date('H', strtotime($group->timestamp));
                        $grouped_hours[$hour][] = $group;
                       
                    }

                    foreach ($grouped_hours as $hour => $rows) {
                        // do something with $hour and $rows
                        // echo "Hour: " . $hour . ":00<br>";

                        // echo '';
                        echo '
                        <table id="salesreporttable" class="table table-striped">
                        <thead>
                        <span class="label label-danger" style="font-size:16px;" >Hour: '. $hour .':00</span>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer Name</th>   
                            <th>Phone</th> 
                            <th>Location</th>  
                            <th>Service</th>   
                            <th>Note</th>   
                            <th>Date & Time</th> 
                            <th>View/Edit</th> 
                        </tr>    
                        </thead> 
                        <tbody>
                        
                        ';
                        foreach ($rows as $row) {
                            // do something with $hour and $rows
                            echo'
                          
                            <tr>
                            <td>'.$row->id.'</td>
                            <td>'.$row->name.'</td>
                            <td>'.$row->phone.'</td>
                            <td>'.$row->location.'</td>
                            <td>'.$row->service.'</td>
                            <td>'.$row->note.'</td>
                            <td>'.$row->datetime.'</td>
                            <td>
                            <a href="editbook.php?id='.$row->id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style ="color:#fffff" data-toggle="tooltip" title="Edit Order"
                            </td></a>
                            </tr>
                            ';
                            
                        }
                        echo '</tbody></table>';
                    }

                        
                    
                    // while($row=$select->fetch(PDO::FETCH_OBJ)){
                        
                    //     echo'
                    //     <tbody>
                    //     <tr>
                    //     <td>'.$row->id.'</td>
                    //     <td>'.$row->name.'</td>
                    //     <td>'.$row->phone.'</td>
                    //     <td>'.$row->location.'</td>
                    //     <td>'.$row->service.'</td>
                    //     <td>'.$row->timestamp.'</td>
                    //     </tbody>
                    //     ';
                
                    // }       
                    ?>
                            
                                   
                </table>
                </div>
            </div>
            </form>
        </div>
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- <script>
  $(document).ready( function () {
    $('#salesreporttable').DataTable({
        "order":[[0,"desc"]]    
     });
} );  
    
    
</script> -->
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