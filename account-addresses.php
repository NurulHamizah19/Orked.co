<?php

include_once 'template/header.php';
require_once 'Database/database.php';
require_once 'Controller/UserController.php';

use Controller\UserController;

$userDetail = UserController::userDetails($_SESSION['userId']);
?>


<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">My Orders</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index.php"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="dashboard.php">Account</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!--end breadcrumb-->
        <!--start shop cart-->
        <section class="py-4">
            <div class="container">
                <h3 class="d-none">Account</h3>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card shadow-none mb-3 mb-lg-0 border">
                                    <div class="card-body">
                                        <div class="list-group list-group-flush"> <a href="dashboard.php" class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Dashboard <i class="bx bx-tachometer fs-5"></i></a>
                                            <a href="account-orders.php" class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Orders <i class="bx bx-cart-alt fs-5"></i></a>
                                            <a href="account-addresses.php" class="list-group-item active d-flex justify-content-between align-items-center">Addresses <i class="bx bx-home-smile fs-5"></i></a>
                                            <a href="account-details.php" class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Account Details <i class="bx bx-user-circle fs-5"></i></a>
                                            <a href="logout.php" class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Logout <i class="bx bx-log-out fs-5"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card shadow-none mb-0">
                                    <div class="card-body">
                                        <h6 class="mb-4">The following addresses will be used on the checkout page by default.</h6>
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <h5 class="mb-3">Billing Addresses</h5>
                                                <address>
                                                <?= $userDetail['name']; ?><br>
                                                <?= $userDetail['address']; ?><br>
                                                <?= $userDetail['city']; ?><br>
                                                <?= $userDetail['postcode']; ?><br>
                                                <?= $userDetail['state']; ?>
                                                </address>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </section>
        <!--end shop cart-->
    </div>
</div>

<?php include_once 'template/footer.php'; ?>