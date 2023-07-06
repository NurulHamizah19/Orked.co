<?php 
include 'connectdb.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Top Navigation</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="orderlist.php" class="navbar-brand"><b>Sfera</b>POS</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
      <div class="col-md-12">
            <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Search Product</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                    <div class="input-group">
                    <input class="form-control postName" name="search_text" id="search_text" placeholder="Seach Product Name / SKU / Barcode" required>
                    <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCustomer" data-dismiss="modal">Add Customer</button></span>
                    </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="col-md-7">
            <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Product</h3>
            </div>
            <div class="box-body">
            <div id="result"></div>
            </div>
            <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Cart</h3>
            </div>
         
            <div class="box-body">

              <div id="productList">

              </div>
            </div>
            <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.18
      </div>
      <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>
$(document).ready(function(){

 load_data();

 function load_data(query)
 {
  $.ajax({
   url:"fetchproduct.php",
   method:"POST",
   data:{query:query},
   success:function(data)
   {
    $('#result').html(data);
   }
  });
 }
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
});
</script>

<script>
var jsonData = { "name": "name1" };

$(document).ready(function () {        
    $(".btnadd").data("num",jsonData);
    $(".btnadd").on("click", function () {
        console.log($(this).data("num"));
    });
});
</script>

<script>

  // const dbParam = JSON.stringify({"limit":10});

  // const xmlhttp = new XMLHttpRequest();
  // xmlhttp.onload = function() {
  //   document.getElementById("demo").innerHTML = this.responseText;
  // }
  // xmlhttp.open("GET", "productdb.ajax.php?x=" + dbParam);
  // xmlhttp.send();

  //   var productData = [
  //     {id: 1, name: 'Sunglasses', price: 25},
  //     {id: 2, name: 'Jeans', price: 10},
  //     {id: 3, name: 'Shirts', price: 15},
  //     {id: 4, name: 'Cables', price: 20}
  // ]
  // var productData = JSON.parse(fs.readFileSync('./productdb.ajax.php').toString());
  // console.log(productData);
  //
  // var productData = null;
  // $.getJSON( "productdb.ajax.php", function( data ) {
  //   productData = data;
  //   console.log(data); //json output 
  // });

  var productData;
  $.ajax({
    url: "productdb.ajax.php",
    async: false,
    dataType: 'json',
    success: function (json) {
      assignVariable(json);
    }
  });

  function assignVariable(data){
    productData = data;
  }

  
    
    var newLaundryValue = [];

    for (var i in productData) {
        var wrap = productData[i];
        
        wrap =  JSON.stringify(wrap)
       
        document.getElementById('productList').innerHTML += 
        '<li>' + 
            '<div class="laundry-name">' + productData[i].pname + '</div>' + 
            '<div class="laundry-price">RM ' + productData[i].saleprice + '</div>' + 
            '<button class="laundry-btn" onclick=\'getLaundryClick(' + wrap+' ) \'>' + 'Add' + '</button>' +  
        '</li>';
        
    }
    
    function getLaundryClick(wrap) {
        console.log(wrap)
    }
</script>
<script>
  
</script>
</body>
</html>
