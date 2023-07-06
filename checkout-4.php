<?php include_once 'template/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Shop Cart</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript:;">Shop</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Shop Cart</li>
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
                            <div class="checkout-review">
                                <div class="card bg-transparent rounded-0 shadow-none">
                                    <div class="card-body">
                                        <?php include 'template/checkout/step.php'; ?>
                                    </div>
                                </div>
                                <div class="card  rounded-0 shadow-none mb-3 border">
                                    <div class="card-body">
                                        <h5 class="mb-0">Review Your Order</h5>
                                        <div class="my-3 border-bottom"></div>
                                        <div class="row align-items-center g-3">
                                            <div class="col-12 col-lg-6">
                                                <div class="d-lg-flex align-items-center gap-3">
                                                    <div class="cart-img text-center text-lg-start">
                                                        <img src="assets/images/products/01.png" width="130" alt="">
                                                    </div>
                                                    <div class="cart-detail text-center text-lg-start">
                                                        <h6 class="mb-2">White Regular Fit Polo T-Shirt</h6>
                                                        <p class="mb-0">Size: <span>Regular</span>
                                                        </p>
                                                        <p class="mb-2">Color: <span>White &amp; Blue</span>
                                                        </p>
                                                        <h5 class="mb-0">$19.00</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="cart-action text-center">
                                                    <input type="number" class="form-control rounded-0" value="2" min="1">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center justify-content-lg-end"> <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-x-circle me-0"></i></a>
                                                        <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-edit"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-4 border-top"></div>
                                        <div class="row align-items-center g-3">
                                            <div class="col-12 col-lg-6">
                                                <div class="d-lg-flex align-items-center gap-3">
                                                    <div class="cart-img text-center text-lg-start">
                                                        <img src="assets/images/products/17.png" width="130" alt="">
                                                    </div>
                                                    <div class="cart-detail text-center text-lg-start">
                                                        <h6 class="mb-2">Fancy Red Sneakers</h6>
                                                        <p class="mb-0">Size: <span>Small</span>
                                                        </p>
                                                        <p class="mb-2">Color: <span>White &amp; Red</span>
                                                        </p>
                                                        <h5 class="mb-0">$16.00</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="cart-action text-center">
                                                    <input type="number" class="form-control rounded-0" value="2" min="1">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center justify-content-lg-end"> <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-x-circle me-0"></i></a>
                                                        <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-edit"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-4 border-top"></div>
                                        <div class="row align-items-center g-3">
                                            <div class="col-12 col-lg-6">
                                                <div class="d-lg-flex align-items-center gap-3">
                                                    <div class="cart-img text-center text-lg-start">
                                                        <img src="assets/images/products/04.png" width="130" alt="">
                                                    </div>
                                                    <div class="cart-detail text-center text-lg-start">
                                                        <h6 class="mb-2">Yellow Shine Blazer</h6>
                                                        <p class="mb-0">Size: <span>Medium</span>
                                                        </p>
                                                        <p class="mb-2">Color: <span>Yellow &amp; Blue</span>
                                                        </p>
                                                        <h5 class="mb-0">$22.00</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="cart-action text-center">
                                                    <input type="number" class="form-control rounded-0" value="2" min="1">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center justify-content-lg-end"> <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-x-circle me-0"></i></a>
                                                        <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-edit"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-4 border-top"></div>
                                        <div class="row align-items-center g-3">
                                            <div class="col-12 col-lg-6">
                                                <div class="d-lg-flex align-items-center gap-3">
                                                    <div class="cart-img text-center text-lg-start">
                                                        <img src="assets/images/products/09.png" width="130" alt="">
                                                    </div>
                                                    <div class="cart-detail text-center text-lg-start">
                                                        <h6 class="mb-2">Men Black Hat Cap</h6>
                                                        <p class="mb-0">Size: <span>Medium</span>
                                                        </p>
                                                        <p class="mb-2">Color: <span>Black</span>
                                                        </p>
                                                        <h5 class="mb-0">$14.00</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="cart-action text-center">
                                                    <input type="number" class="form-control rounded-0" value="1" min="1">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center justify-content-lg-end"> <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-x-circle me-0"></i></a>
                                                        <a href="javascript:;" class="btn btn-light rounded-0 btn-ecomm"><i class="bx bx-edit"></i> Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none mb-3 border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="shipping-aadress">
                                                    <h5 class="mb-3">Shipping to:</h5>
                                                    <p class="mb-1"><span class="text-dark">Customer:</span> Jhon Michle</p>
                                                    <p class="mb-1"><span class="text-dark">Address:</span> 47-A, Street Name, City, Australia</p>
                                                    <p class="mb-1"><span class="text-dark">Phone:</span> (123) 472-796</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="payment-mode">
                                                    <h5 class="mb-3">Payment Mode:</h5>
                                                    <img src="assets/images/icons/visa.png" width="150" class="p-2 border bg-light rounded" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none mb-3 border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-grid"><a href="javascript:;" class="btn btn-light btn-ecomm"><i class="bx bx-chevron-left"></i>Back to Payment</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-grid"><a href="thank-you" class="btn btn-outline-dark btn-ecomm">Complete Order<i class="bx bx-chevron-right"></i></a>
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