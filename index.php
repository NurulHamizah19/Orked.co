<?php
// get header
include_once 'template/header.php';
require_once 'Database/database.php';
require_once 'Controller/productController.php';

use Controller\ProductController;

$products = ProductController::getAllProducts();
?>

<section class="slider-section mb-4">
    <div class="first-slider p-0">

        <div class="banner-slider owl-carousel owl-theme">
            <div class="item">
                <div class="position-relative">
                    <div class="position-absolute top-50 slider-content translate-middle">
                        <h3 class="h3 fw-bold d-none d-md-block">New Trending</h3>
                        <h1 class="h1 fw-bold">Women Fashion</h1>
                        <p class="fw-bold text-dark d-none d-md-block"><i>Last call for upto 15%</i></p>
                        <div class=""><a class="btn btn-dark btn-ecomm px-4" href="shop-grid.html">Shop Now</a>
                        </div>
                    </div>
                    <a href="javascript:;">
                        <img src="assets/images/banners/01.png" class="img-fluid" alt="...">
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="position-relative">
                    <div class="position-absolute top-50 slider-content translate-middle">
                        <h3 class="h3 fw-bold d-none d-md-block">New Trending</h3>
                        <h1 class="h1 fw-bold">Men Fashion</h1>
                        <p class="fw-bold text-dark d-none d-md-block"><i>Last call for upto 15%</i></p>
                        <div class=""><a class="btn btn-dark btn-ecomm px-4" href="shop-grid.html">Shop Now</a>
                        </div>
                    </div>
                    <a href="javascript:;">
                        <img src="assets/images/banners/02.png" class="img-fluid" alt="...">
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="position-relative">
                    <div class="position-absolute top-50 slider-content translate-middle">
                        <h3 class="h3 fw-bold d-none d-md-block">New Trending</h3>
                        <h1 class="h1 fw-bold">Kids Fashion</h1>
                        <p class="fw-bold text-dark d-none d-md-block"><i>Last call for upto 15%</i></p>
                        <div class=""><a class="btn btn-dark btn-ecomm px-4" href="shop-grid.html">Shop Now</a>
                        </div>
                    </div>
                    <a href="javascript:;">
                        <img src="assets/images/banners/04.png" class="img-fluid" alt="...">
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
                                            <div class="h6 fw-bold">$<?php echo $product['saleprice']; ?></div>
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
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/11.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/12.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/13.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/14.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/15.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/16.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/17.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div class="add-cart position-absolute top-0 end-0 mt-3 me-3">
                                        <a href="javascript:;"><i class='bx bx-cart-add'></i></a>
                                    </div>
                                    <div class="quick-view position-absolute start-0 bottom-0 end-0">
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewProduct">Quick View</a>
                                    </div>
                                    <a href="javascript:;">
                                        <img src="assets/images/products/18.png" class="img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="card-body px-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="">
                                            <p class="mb-1 product-short-name">Topwear</p>
                                            <h6 class="mb-0 fw-bold product-short-title">White Polo Shirt</h6>
                                        </div>
                                        <div class="icon-wishlist">
                                            <a href="javascript:;"><i class="bx bx-heart"></i></a>
                                        </div>
                                    </div>
                                    <div class="cursor-pointer rating mt-2">
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                        <i class="bx bxs-star text-warning"></i>
                                    </div>
                                    <div class="product-price d-flex align-items-center justify-content-start gap-2 mt-2">
                                        <div class="h6 fw-light fw-bold text-secondary text-decoration-line-through">$59.00</div>
                                        <div class="h6 fw-bold">$48.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <h5 class="mb-0 fw-bold separator-title">Browse Catergory</h5>
                    <div class="line"></div>
                </div>

                <div class="product-grid">
                    <div class="browse-category owl-carousel owl-theme">
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/01.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-0 text-uppercase fw-bold">Fashion</h6>
                                    <p class="mb-0 font-12 text-uppercase">10 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/02.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Watches</h6>
                                    <p class="mb-0 font-12 text-uppercase">8 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/03.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Shoes</h6>
                                    <p class="mb-0 font-12 text-uppercase">14 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/04.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Bags</h6>
                                    <p class="mb-0 font-12 text-uppercase">6 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/05.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Electronis</h6>
                                    <p class="mb-0 font-12 text-uppercase">6 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/06.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Headphones</h6>
                                    <p class="mb-0 font-12 text-uppercase">5 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/07.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Furniture</h6>
                                    <p class="mb-0 font-12 text-uppercase">20 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/08.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Jewelry</h6>
                                    <p class="mb-0 font-12 text-uppercase">16 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/09.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Sports</h6>
                                    <p class="mb-0 font-12 text-uppercase">28 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/10.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Vegetable</h6>
                                    <p class="mb-0 font-12 text-uppercase">15 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/11.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Medical</h6>
                                    <p class="mb-0 font-12 text-uppercase">24 Products</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card rounded-0">
                                <div class="card-body p-0">
                                    <img src="assets/images/categories/12.png" class="img-fluid" alt="...">
                                </div>
                                <div class="card-footer text-center bg-transparent border">
                                    <h6 class="mb-1 text-uppercase fw-bold">Sunglasses</h6>
                                    <p class="mb-0 font-12 text-uppercase">18 Products</p>
                                </div>
                            </div>
                        </div>
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
