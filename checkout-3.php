<?php include_once 'template/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Payment</h3>
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
                            <div class="checkout-payment">
                                <div class="card bg-transparent rounded-0 shadow-none">
                                    <div class="card-body">
                                        <?php include 'template/checkout/step.php'; ?>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none border">
                                    <div class="card-header border-bottom">
                                        <h2 class="h5 my-2">Choose Payment Method</h2>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-pills mb-3 border p-3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active rounded-0" data-bs-toggle="pill" href="#credit-card" role="tab" aria-selected="true">
                                                    <div class="d-flex align-items-center">
                                                        <div class="tab-icon"><i class="bx bx-credit-card font-18 me-1"></i>
                                                        </div>
                                                        <div class="tab-title">Credit Card</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="credit-card" role="tabpanel">
                                                <div class="p-3 border">
                                                    <form class="payment-details">
                                                        <div class="mb-3">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control rounded-0" placeholder="Name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Card Number</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control rounded-0" maxlength="16" placeholder="Card Number"> 
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-lg-8">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Expiration Date</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control rounded-0" maxlength="2" placeholder="MM">
                                                                        <input type="text" class="form-control rounded-0" maxlength="2" placeholder="YY">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label">CVV</label>
                                                                    <input type="text" class="form-control rounded-0" maxlength="4" placeholder="CVV">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-grid">
                                                    <a href="checkout-2" class="btn btn-light btn-ecomm"><i class="bx bx-chevron-left"></i>Back to Shipping</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-grid">
                                                    <a href="checkout-4" class="btn btn-outline-dark btn-ecomm btn-charge">Review Your Order<i class="bx bx-chevron-right"></i></a>
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

<script>
    $(document).ready(function() {
        document.querySelector('.btn-charge').addEventListener('click', function(e) {
            e.preventDefault();

            if (isCardValid()) {
                window.location.href = "checkout-4.php";
            } else {
                Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                }).fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'Please enter payment details'
                });
            }
        });

    });
</script>