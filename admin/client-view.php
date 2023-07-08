<?php
include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "") {
    header('location:index.php');
}
date_default_timezone_set('Asia/Kuala_Lumpur');
if ($_SESSION['role'] == "User") {
    include_once 'headeruser.php';
} else {
    include_once 'header.php';
}
include_once 'phpqrcode/qrlib.php';
$id = $_GET['id'];

?>
<style>
    .hidden {
        display: none;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var divsToHide = document.getElementsByClassName('div-to-hide');

        function hideDivsOnPrint() {
            for (var i = 0; i < divsToHide.length; i++) {
                divsToHide[i].classList.add('hidden');
            }
        }

        function showDivsAfterPrint() {
            for (var i = 0; i < divsToHide.length; i++) {
                divsToHide[i].classList.remove('hidden');
            }
        }
        if (window.matchMedia) {
            var mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                if (mql.matches) {
                    hideDivsOnPrint();
                } else {
                    showDivsAfterPrint();
                }
            });
        }
        window.onbeforeprint = hideDivsOnPrint;
        window.onafterprint = showDivsAfterPrint;
    });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Client
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
                <?php
                if ($_SESSION['role'] != "Agent") {
                    echo '
                <h3 class="box-title div-to-hide"><a href="client-list.php" class="btn btn-primary" role="button">Back To Client List</a></h3>
                ';
                } else {
                    echo '
                <h3 class="box-title div-to-hide"><a href="my_clientlist.php" class="btn btn-primary" role="button">Back To Client List</a></h3>
                ';
                }
                ?> </div>

            <div class="box-body">
                <?php
                $id = $_GET['id'];
                $select = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$id");
                $select->execute();

                while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                    echo '
                    <div class="col-md-6">
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Client Detail</b></p></center>
                      <li class="list-group-item div-to-hide" style="font-size:12px;">ID <span class="badge">' . $row->id . '</span></li>
                      <li class="list-group-item">Name <span class="label label-primary pull-right" style="font-size:14px;">' . $row->name . '</span></li>
                      <li class="list-group-item">Address <span class="label label-warning pull-right" style="font-size:14px;">' . $row->address . '</span></li>
                      <li class="list-group-item">Postcode <span class="label label-warning pull-right" style="font-size:14px;">' . $row->postcode . '</span></li>
                      <li class="list-group-item">City <span class="label label-success pull-right" style="font-size:14px;">' . $row->city . '</span></li>
                      <li class="list-group-item">State <span class="label label-danger pull-right" style="font-size:14px;">' . $row->state . '</span></li>
                      <li class="list-group-item">Phone Number <span class="label label-danger pull-right" style="font-size:14px;">' . $row->phone . '</span></li>
                      <li class="list-group-item">Email <span class="label label-info pull-right" style="font-size:14px;">' . $row->email . '</span></li>
                      <li class="list-group-item div-to-hide">Membership Points <span class="label label-success pull-right" style="font-size:14px;">' . $row->point . '</span></li>
                      <li class="list-group-item div-to-hide">Last Updated <span class="label label-info pull-right" style="font-size:14px;">' . $row->timestamp . '</span></li>
                    </ul>';
                } ?>
                <button class="btn btn-primary div-to-hide" onclick="window.print()">Print</button>

            </div>
            <div class="col-md-6 div-to-hide">
                <div style="overflow-x:auto;">
                    <table id="producttable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date Generated</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <center>
                                <p class="list-group-item list-group-item-success"><b>Invoice</b></p>
                            </center>
                            <?php
                            $select = $pdo->prepare("SELECT * FROM tbl_client_details WHERE cid=$id");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                                if ($row->cid == $id) {
                                    if ($row->invid != 0) {
                                        echo '
                                <tr>
                                <td>' . $row->invid . '</td>
                                <td>' . $row->inv_date . '</td>
                                <td><a href="invoice.php?id=' . $row->invid . '" class="btn btn-info" role="button"><span class="glyphicon glyphicon-eye-open" style ="color:#fffff" data-toggle="tooltip" title="View Product"
                            </td></a>
                               ';
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

</div>

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once 'footer.php'
?>