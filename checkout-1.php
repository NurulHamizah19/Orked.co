<?php 
include_once 'template/header.php'; 
?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Customer Details</h3>
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
                                        <div class="border p-3">
                                            <h2 class="h5 mb-0">Shipping Address</h2>
                                            <div class="my-3 border-bottom"></div>
                                            <div class="form-body">
                                                <form class="row g-3 customer-details">
                                                    <input type="hidden" name="userId" value="<?= isset($_SESSION['userId']) ? $_SESSION['userId'] : ''; ?>">
                                                    <div class="col-md-6">
                                                        <label class="form-label">First Name</label>
                                                        <input name="firstName" id="firstName" type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Last Name</label>
                                                        <input name="lastName" id="lastName" type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">E-mail</label>
                                                        <input name="email" id="email" type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Phone Number</label>
                                                        <input name="phoneNumber" id="phoneNumber" type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">State/Province</label>
                                                        <select name="state" id="state" class="form-select rounded-0">
                                                            <option value="Johor">Johor</option>
                                                            <option value="Kedah">Kedah</option>
                                                            <option value="Kelantan">Kelantan</option>
                                                            <option value="Melaka">Melaka</option>
                                                            <option value="Negeri Sembilan">Negeri Sembilan</option>
                                                            <option value="Pahang">Pahang</option>
                                                            <option value="Perak">Perak</option>
                                                            <option value="Perlis">Perlis</option>
                                                            <option value="Pulau Pinang">Pulau Pinang</option>
                                                            <option value="Sabah">Sabah</option>
                                                            <option value="Sarawak">Sarawak</option>
                                                            <option value="Selangor">Selangor</option>
                                                            <option value="Terengganu">Terengganu</option>
                                                            <option value="Kuala Lumpur">Kuala Lumpur</option>
                                                            <option value="Labuan">Labuan</option>
                                                            <option value="Putrajaya">Putrajaya</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Postal Code</label>
                                                        <input name="zipCode" id="postcode" type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">City</label>
                                                        <input name="city" id="city" type="text" class="form-control rounded-0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Address</label>
                                                        <textarea name="address" id="address" class="form-control rounded-0"></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-grid"> <a href="cart" class="btn btn-light btn-ecomm"><i class="bx bx-chevron-left"></i>Back to Cart</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-grid"> <a class="btn btn-dark btn-ecomm btn-proceed">Proceed to Checkout<i class="bx bx-chevron-right"></i></a>
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

<script>
    $(document).ready(function() {
        document.querySelector('.btn-proceed').addEventListener('click', function(e) {
            e.preventDefault();

            if (isFormValid()) {
                saveCustomerDataForm();
                window.location.href = "checkout-2.php";
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
                    title: 'Oops..',
                    text: 'Please fill in all the fields!'
                });
            }
        });

        populateForm();
    });
</script>