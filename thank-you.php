<?php include_once 'template/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Checkout</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="shop">Shop</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Order Complete</li>
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
                <div class="card py-3 mt-sm-3">
                    <div class="card-body text-center">
                        <h2 class="h4 pb-3">Thank you for your order!</h2>
                        <p class="fs-sm mb-2">Your order has been placed and will be processed as soon as possible.</p>
                        </p>
                        <p class="fs-sm">You will be receiving an email shortly with confirmation of your order.
                        </p><a class="btn btn-light rounded-0 mt-3 me-3" href="index.php">Go back shopping</a>
                    </div>
                </div>
            </div>
        </section>
        <!--end shop cart-->
    </div>
</div>

<?php include_once 'template/footer.php'; ?>
<script>localStorage.removeItem("cartItems");</script>