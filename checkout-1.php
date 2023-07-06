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
                            <div class="checkout-details">
                                <div class="card bg-transparent rounded-0 shadow-none">
                                    <div class="card-body">
                                        <?php include 'template/checkout/step.php'; ?>
                                    </div>
                                </div>
                                <div class="card rounded-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="">
                                                <img src="assets/images/avatars/avatar-1.png" width="90" alt="" class="rounded-circle p-1 border">
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-0">Jhon Michle</h6>
                                                <p class="mb-0">michle@example.com</p>
                                            </div>
                                            <div class="ms-auto"> <a href="javascript:;" class="btn btn-light btn-ecomm"><i class="bx bx-edit"></i> Edit Profile</a>
                                            </div>
                                        </div>
                                        <div class="border p-3">
                                            <h2 class="h5 mb-0">Shipping Address</h2>
                                            <div class="my-3 border-bottom"></div>
                                            <div class="form-body">
                                                <form class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">First Name</label>
                                                        <input type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">E-mail id</label>
                                                        <input type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Company</label>
                                                        <input type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">State/Province</label>
                                                        <select class="form-select rounded-0">
                                                            <option>United Kingdom</option>
                                                            <option>California</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Zip/Postal Code</label>
                                                        <input type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Country</label>
                                                        <select class="form-select rounded-0">
                                                            <option>United States</option>
                                                            <option>India</option>
                                                            <option>China</option>
                                                            <option>Turkey</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Address 1</label>
                                                        <textarea class="form-control rounded-0"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Address 2</label>
                                                        <textarea class="form-control rounded-0"></textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <h6 class="mb-0 h5">Billing Address</h6>
                                                        <div class="my-3 border-bottom"></div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="gridCheck" checked="">
                                                            <label class="form-check-label" for="gridCheck">Same as shipping address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-grid"> <a href="cart" class="btn btn-light btn-ecomm"><i class="bx bx-chevron-left"></i>Back to Cart</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-grid"> <a href="checkout-2" class="btn btn-dark btn-ecomm">Proceed to Checkout<i class="bx bx-chevron-right"></i></a>
                                                        </div>
                                                    </div>
                                                </form>
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