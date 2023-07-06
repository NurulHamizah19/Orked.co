<?php
// get header
include_once 'template/header.php';

require_once 'Database/database.php';
require_once 'Controller/CategoryController.php';
require_once 'Controller/ProductController.php';

use Controller\CategoryController;
use Controller\ProductController;

$categories = CategoryController::getAllCategories();
$products = ProductController::getAllProducts();
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : 'All';
$sortFilter = isset($_GET['sort']) ? $_GET['sort'] : '';
$searchFilter = isset($_GET['search']) ? $_GET['search'] : '';
$filteredProducts = ProductController::filterProducts($products, $categoryFilter, $sortFilter, $searchFilter);

?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Products</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="shop">Shop</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">All Products</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!--end breadcrumb-->
        <!--start shop area-->
        <section class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="product-wrapper">
                            <div class="toolbox d-lg-flex align-items-center mb-3 gap-2 p-3 bg-white border">
                                <form action="" method="GET">
                                    <div class="d-flex flex-wrap flex-grow-1 gap-1">
                                        <div class="">
                                            <select name="category" class="form-select rounded-0">
                                                <option value="All" <?php if ($categoryFilter == 'All') echo 'selected'; ?>>Category: All</option>
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?= $category['category']; ?>" <?php if ($categoryFilter == $category['category']) echo 'selected'; ?>><?= $category['category']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <select name="sort" class="form-select rounded-0">
                                                <option value="price" <?php if ($sortFilter == 'price') echo 'selected'; ?>>Sort by price: low to high</option>
                                                <option value="price-desc" <?php if ($sortFilter == 'price-desc') echo 'selected'; ?>>Sort by price: high to low</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <button type="submit" class="btn btn-dark rounded-0 text-uppercase">Search</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="product-grid">
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-3 g-sm-4">
                                    <?php foreach ($filteredProducts as $product) : ?>
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
                                                        <div class="h6 fw-bold">RM<?php echo $product['saleprice']; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div><!--end row-->

                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </section>
        <!--end shop area-->
    </div>
</div>
<!--end page wrapper -->

<?php
// get footer
include_once 'template/footer.php';
