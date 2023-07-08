<?php include_once 'template/header.php';

require_once 'Database/database.php';
require_once 'Controller/ProductController.php';

use Controller\ProductController;

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = ProductController::getProductById($productId);

    if (!$product) {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid product ID.";
    exit;
}

?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3"><?= $product['pname']; ?></h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="shop">Shop</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Product Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!--end breadcrumb-->
        <!--start product detail-->
        <section class="py-4">
            <div class="container">
                <div class="product-detail-card">
                    <div class="product-detail-body">
                        <div class="row g-0">
                            <div class="col-12 col-lg-5">
                                <div class="image-zoom-section">
                                    <div class="product-gallery owl-carousel owl-theme border mb-3 p-3 owl-loaded owl-drag" data-slider-id="1">
                                        <div class="owl-stage-outer">
                                            <div class="owl-stage" style="transform: translate3d(-1032px, 0px, 0px); transition: all 0s ease 0s; width: 4128px;">
                                                <div class="owl-item cloned" style="width: 506px; margin-right: 10px;">
                                                    <div class="item">
                                                        <?php if (!empty($product['pimage']) && file_exists("admin/productimages/" . $product['pimage'])) : ?>
                                                            <img src="admin/productimages/<?= $product['pimage']; ?>" class="img-fluid" alt="">
                                                        <?php else : ?>
                                                            <img src="admin/productimages/noimage.png" class="img-fluid" alt="">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div>
                                        <div class="owl-dots disabled"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="product-info-section p-3">
                                    <h3 class="mt-3 mt-lg-0 mb-0"><?= $product['pname']; ?></h3>
                                    <div class="d-flex align-items-center mt-3 gap-2">
                                        <h4 class="mb-0">RM<?= number_format($product['saleprice'], 2); ?></h4>
                                    </div>
                                    <div class="mt-3">
                                        <h6>Description :</h6>
                                        <p class="mb-0"><?= $product['pdescription']; ?></p>
                                    </div>
                                    <dl class="row mt-3">
                                        <dt class="col-sm-3">Product id</dt>
                                        <dd class="col-sm-9">ORKED-<?= $product['pid']; ?></dd>
                                    </dl>
                                    <div class="row row-cols-auto align-items-center mt-3">
                                        <div class="col">
                                            <label class="form-label">Quantity</label>
                                            <select class="form-select form-select-sm qty">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Size</label>
                                            <select class="form-select form-select-sm size">
                                                <option>S</option>
                                                <option>M</option>
                                                <option>L</option>
                                                <option>XS</option>
                                                <option>XL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end row-->
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="javascript:;" class="btn btn-dark btn-ecomm" onclick="addToCart(<?= $product['pid']; ?>)"><i class="bx bxs-cart-add"></i>Add to Cart</a>
                                    </div>
                                    <hr>
                                    <div class="product-sharing">
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <div class="">
                                                <button type="button" class="btn-social bg-twitter" onclick="shareOnTwitter()"><i class="bx bxl-twitter"></i></button>
                                            </div>
                                            <div class="">
                                                <button type="button" class="btn-social bg-facebook" onclick="shareOnFacebook()"><i class="bx bxl-facebook"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </section>
        <!--end product detail-->
    </div>
</div>

<?php include_once 'template/footer.php'; ?>