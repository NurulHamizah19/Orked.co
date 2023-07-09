<?php include_once 'template/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Shipping</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript:;">Shop</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
                <div class="shop-cart">
                    <div class="row">
                        <div class="col-12 col-xl-8">
                            <div class="checkout-shipping">
                                <div class="card bg-transparent rounded-0 shadow-none">
                                    <div class="card-body">
                                        <?php include 'template/checkout/step.php'; ?>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none">
                                    <div class="card-body">
                                        <h2 class="h5 mb-0">Review Shipping Method</h2>
                                        <div class="my-3 border-bottom"></div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Method</th>
                                                        <th>Time</th>
                                                        <th>Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Flat Rate</td>
                                                        <td>2 days</td>
                                                        <td>RM10.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-grid">
                                                    <a href="checkout-1.php" class="btn btn-light btn-ecomm"><i class="bx bx-chevron-left"></i>Back to Details</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-grid">
                                                    <a href="checkout-3.php" class="btn btn-dark btn-ecomm">Proceed to Payment<i class="bx bx-chevron-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <?php include 'template/checkout/widget.php'; ?>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
        </section>
        <!--end shop cart-->
    </div>
</div>

<?php include_once 'template/footer.php'; ?>