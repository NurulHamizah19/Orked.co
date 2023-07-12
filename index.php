<?php
// get header
include_once 'template/header.php';
require_once 'Database/database.php';
require_once 'Controller/ProductController.php';
require_once 'Controller/ReviewController.php';

use Controller\ProductController;
use Controller\ReviewController;

$products = ProductController::getAllProducts();
$new_products = ProductController::getAllNewProducts();
$reviews = ReviewController::getLatestReviews();

?>

<section class="slider-section mb-4">
    <div class="first-slider p-0">

        <div class="banner-slider owl-carousel owl-theme">
            <div class="item">
                <div class="position-relative">
                    <div class="position-absolute top-50 slider-content translate-middle">
                        <h3 class="h3 fw-bold d-none d-md-block"></h3>
                        <h1 class="h1 fw-bold"></h1>
                        <p class="fw-bold text-dark d-none d-md-block"><i></i></p>
                        <div class="">
                        </div>
                    </div>
                    <a href="javascript:;">
                        <img src="assets/images/banners/3.png" class="img-fluid" alt="...">
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="position-relative">
                    <div class="position-absolute top-50 slider-content translate-middle">
                        <h3 class="h3 fw-bold d-none d-md-block">New Collection</h3>
                        <h1 class="h1 fw-bold">shawl X bawal</h1>
                        <p class="fw-bold text-dark d-none d-md-block"><i></i></p>
                        <div class=""><a class="btn btn-dark btn-ecomm px-4" href="shop-grid.html">Shop Now</a>
                        </div>
                    </div>
                    <a href="javascript:;">
                        <img src="assets/images/banners/2.png" class="img-fluid" alt="...">
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="position-relative">
                    <div class="position-absolute top-50 slider-content translate-middle">
                        <h3 class="h3 fw-bold d-none d-md-block"></h3>
                        <h1 class="h1 fw-bold">Kurung & Kebaya</h1>
                        <p class="fw-bold text-dark d-none d-md-block"><i></i></p>
                        <div class=""><a class="btn btn-dark btn-ecomm px-4" href="shop-grid.html">Shop Now</a>
                        </div>
                    </div>
                    <a href="javascript:;">
                        <img src="assets/images/banners/1.png" class="img-fluid" alt="...">
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
<!--end slider section-->
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--start information-->
        <section class="py-4">
            <div class="container">

                <div class="row row-cols-1 row-cols-lg-3 g-4">
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center p-3 border">
                            <div class="fs-1 text-content"><i class='bx bx-taxi'></i>
                            </div>
                            <div class="info-box-content ps-3">
                                <h6 class="mb-0 fw-bold">FREE SHIPPING &amp; RETURN</h6>
                                <p class="mb-0">Free shipping on all orders over $49</p>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center p-3 border">
                            <div class="fs-1 text-content"><i class='bx bx-dollar-circle'></i>
                            </div>
                            <div class="info-box-content ps-3">
                                <h6 class="mb-0 fw-bold">MONEY BACK GUARANTEE</h6>
                                <p class="mb-0">100% money back guarantee</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-center p-3 border">
                            <div class="fs-1 text-content"><i class='bx bx-support'></i>
                            </div>
                            <div class="info-box-content ps-3">
                                <h6 class="mb-0 fw-bold">ONLINE SUPPORT 24/7</h6>
                                <p class="mb-0">Awesome Support for 24/7 Days</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </section>
        <!--end information-->
        <!--start Featured product-->
        <section class="py-4">
            <div class="container">
                <div class="separator pb-4">
                    <div class="line"></div>
                    <h5 class="mb-0 fw-bold separator-title">FEATURED PRODUCTS</h5>
                    <div class="line"></div>
                </div>
                <div class="product-grid">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-3 g-sm-4">
                        <?php foreach ($products as $product) : ?>
                            <div class="col">
                                <div class="card">
                                    <div class="position-relative overflow-hidden">
                                        <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                            <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                        </div>
                                        <a href="product-details.php?id=<?= $product['pid']; ?>">
                                            <?php if (!empty($product['pimage'])) : ?>
                                                <img src="admin/productimages/<?php echo $product['pimage']; ?>" class="img-fluid" alt="Product Image">
                                            <?php else : ?>
                                                <img src="admin/noimage.png" class="img-fluid" alt="Product Image">
                                            <?php endif; ?> </a>
                                    </div>
                                    <div class="card-body px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-1 product-short-name"><?php echo $product['pcategory']; ?></p>
                                                <h6 class="mb-0 fw-bold product-short-title"><?php echo $product['pname']; ?></h6>
                                            </div>
                                        </div>
                                        <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                            <div class="h6 fw-bold">RM <?php echo $product['saleprice']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div><!--end row-->

                </div>
            </div>
        </section>
        <!--end Featured product-->
        <!--start New Arrivals-->
        <section class="py-4">
            <div class="container">
                <div class="separator pb-4">
                    <div class="line"></div>
                    <h5 class="mb-0 fw-bold separator-title">New Arrivals</h5>
                    <div class="line"></div>
                </div>
                <div class="product-grid">
                    <div class="new-arrivals owl-carousel owl-theme position-relative">
                        <?php foreach ($new_products as $product) : ?>
                            <div class="item">
                                <div class="card">
                                    <div class="position-relative overflow-hidden">
                                        <a href="product-details.php?id=<?= $product['pid']; ?>">
                                            <?php if (!empty($product['pimage'])) : ?>
                                                <img src="admin/productimages/<?php echo $product['pimage']; ?>" class="img-fluid" alt="Product Image">
                                            <?php else : ?>
                                                <img src="admin/noimage.png" class="img-fluid" alt="Product Image">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="card-body px-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">
                                                <p class="mb-1 product-short-name"><?= $product['pcategory']; ?></p>
                                                <h6 class="mb-0 fw-bold product-short-title"><?= $product['pname']; ?></h6>
                                            </div>
                                        </div>
                                        <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                            <div class="h6 fw-bold">RM <?= $product['saleprice']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </section>
        <!--end New Arrivals-->
        <!--start categories-->
        <section class="py-4">
            <div class="container">
                <div class="separator pb-4">
                    <div class="line"></div>
                    <h5 class="mb-0 fw-bold separator-title"> Customer</h5>
                    <div class="line"></div>
                </div>

                <div class="product-review">
                    <h5 class="mb-4">Our Testimony</h5>
                    <div class="review-list">
                        <?php foreach ($reviews as $review) : ?>
                            <div class="d-flex align-items-start">
                                <div class="review-content ms-3">
                                    <div class="rates cursor-pointer fs-6">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <i class="bx bxs-star text-<?php echo ($i <= $review['rating']) ? 'warning' : 'secondary'; ?>"></i>
                                        <?php } ?>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mb-0"><?= $review['name']; ?></h6>
                                        <p class="mb-0 ms-3"><?= date('j F Y', strtotime($review['timestamp'])); ?></p>
                                    </div>
                                    <p><?= $review['comment']; ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <!--end categories-->
    </div>
</div>
<!--end page wrapper -->
<?php
include_once 'template/footer.php';