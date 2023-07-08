<?php
// get header
include_once 'template/header.php';
?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Leave a Review</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Feedback</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!--end breadcrumb-->
        <!--start page content-->
        <section class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="add-review border">
                            <form class="review">
                            <div class="form-body p-3">
                                <div class="mb-3">
                                    <label class="form-label">Your Name</label>
                                    <input name="name" type="text" class="form-control name rounded-0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Your Email</label>
                                    <input name="email" type="email" class="form-control email rounded-0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <select name="rating" class="form-select rating rounded-0">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option selected value="5">5</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Comment</label>
                                    <textarea name="comment" class="form-control comment rounded-0" rows="3"></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-dark btn-ecomm btn-review">Submit a Review</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </section>
        <!--end start page content-->
    </div>
</div>
<!--end page wrapper -->
<?php
include_once 'template/footer.php';
