<?php

require_once 'Database/database.php';
require_once 'Controller/CategoryController.php';

use Controller\CategoryController;

$categories = CategoryController::getAllCategories();

?>
<footer>
    <section class="py-5 border-top bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                <div class="col">
                    <div class="footer-section1">
                        <h5 class="mb-4 text-uppercase fw-bold">Contact Info</h5>
                        <div class="address mb-3">
                            <h6 class="mb-0 text-uppercase fw-bold">Address</h6>
                            <p class="mb-0">25 Tingkat Bawah, Jalan Perda Utara, Bandar Perda, 14000 Bukit Mertajam, Penang</p>
                        </div>
                        <div class="phone mb-3">
                            <h6 class="mb-0 text-uppercase fw-bold">Tiktok</h6>
                            <a href="https://www.tiktok.com/@orked.co?_t=8dl0Z3z0jkA&_r=1" class="text-dark mb-0">@orked.co</a>
                        </div>
                        <div class="email mb-3">
                            <h6 class="mb-0 text-uppercase fw-bold">Instagram</h6>
                            <a href="https://instagram.com/orked.co?igshid=MzRlODBiNWFlZA== " class="text-dark mb-0">@orked.co</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="footer-section2">
                        <h5 class="mb-4 text-uppercase fw-bold">Categories</h5>
                        <ul class="list-unstyled">
                        <?php foreach ($categories as $category) : ?>
                            <li class="mb-1"><a href="javascript:;"><i class='bx bx-chevron-right'></i><?php echo $category['category']; ?></li></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </section>

    <section class="footer-strip text-center py-3 border-top positon-absolute bottom-0">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row align-items-center gap-3 justify-content-between">
                <p class="mb-0">Copyright © Orkedco. All right reserved.</p>
            </div>
        </div>
    </section>
</footer>
<!--end footer section-->

<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
</div>
<!--end wrapper-->

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/OwlCarousel/js/owl.carousel.min.js"></script>
<script src="assets/plugins/OwlCarousel/js/owl.carousel2.thumbs.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--app JS-->
<script src="assets/js/app.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/index.js"></script>
</body>

</html>