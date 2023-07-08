<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="icon" href="dist/img/orked.jpeg" type="image/x-icon">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Orked Shop</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- SweetAlert -->
  <script src="bower_components/sweetalert/sweetalert.js"></script>
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


  <!-- AdminLTE App -->
  <script src="bower_components/sweetalert/sweetalert.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <script src="bower_components/Chart.js-2.9.3/dist/Chart.min.js"></script>

  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">

  <!-- iCheck 1.0.1 -->
  <script src="plugins/iCheck/icheck.min.js"></script>

  <!-- Select2 -->
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>

  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">


  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>

  <style>
    .form-group.required .control-label:after {
      content: "*";
      color: red;
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="dashboard.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Orked</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Orked</b>Shop</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="user.png" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="user.png" class="img-circle" alt="User Image">

                  <p>
                    <?php echo $_SESSION['username']; ?>
                    <small><?php echo $_SESSION['role']; ?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">

                  </div>
                  <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="changepassword.php" class="btn btn-default btn-flat">Change Password</a>
                  </div>
                  <div class="pull-right">
                    <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="user.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $_SESSION['username']; ?></p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">

          <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li><a href="category.php"><i class="fa fa-list-alt"></i> <span>Category</span></a></li>
          <li><a href="register.php"><i class="fa fa-registered"></i> <span>Register</span></a></li>
          <li><a href="client-list.php"><i class="fa fa-users"></i> <span>Client</span></a></li>
          <li><a href="createorder.php"><i class="fa fa-first-order"></i> <span>Add Order</span></a></li>
          <li><a href="order-list.php"><i class="fa fa-list-ul"></i> <span>Sales/Order List</span></a></li>


          <li class="treeview">
            <a href="#">
              <i class="fa fa-th-list"></i> <span>Manage Product</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="product-add.php"><i class="fa fa-circle-o"></i> <span>Add Product</span></a></li>
              <li><a href="product-list.php"><i class="fa fa-circle-o"></i> <span>Product List</span></a></li>
              <li><a href="stock-list.php"><i class="fa fa-circle-o"></i> <span>Stock Management</span></a></li>
            </ul>
          </li>





          <!--    <li class="treeview">
          <a href="#">
            <i class="fa fa-list-alt"></i> <span>Quotation</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="quoteorder.php"><i class="fa fa-first-order"></i> <span>Create Quotation</span></a></li>   
          <li><a href="quotelist.php"><i class="fa fa-list-ul"></i> <span>Quotation List</span></a></li>
          </ul>
        </li> -->





          <li class="treeview">
            <a href="#">
              <i class="fa fa-table"></i> <span>Report</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="tablereport.php"><i class="fa fa-circle-o"></i> Sales </a></li>
              <li><a href="report_product.php"><i class="fa fa-circle-o"></i> Product </a></li>
              <li><a href="graphreport.php"><i class="fa fa-circle-o"></i> Graph</a></li>
            </ul>
          </li>

          <li><a href="settings.php"><i class="fa fa-gear"></i> <span>Settings</span></a></li>
          <li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
          <!--
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
          </ul>
        </li> -->
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>