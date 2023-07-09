<?php include_once 'template/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Sign Up</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="index.php"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!--end breadcrumb-->
        <!--start shop cart-->
        <section class="py-0 py-lg-5">
            <div class="container">
                <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5">
                    <div class="row row-cols-1 row-cols-lg-1 row-cols-xl-2">
                        <div class="col mx-auto">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="text-center">
                                            <h3 class="">Sign Up</h3>
                                            <p>Already have an account? <a href="sign-in.php">Sign in here</a>
                                            </p>
                                        </div>


                                        <div class="form-body">
                                            <form class="row g-3 rego" method="POST" action="authenticate.php">
                                                <div class="col-sm-6">
                                                    <label for="inputFirstName" class="form-label">First Name</label>
                                                    <input type="name" name="fname" class="form-control" id="fname" placeholder="Azwan">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="inputLastName" class="form-label">Last Name</label>
                                                    <input type="name" name="lname" class="form-control" id="lname" placeholder="Ali">
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputEmailAddress" class="form-label">Email Address <span id="email-validation-result" class="text-bold"></span></label>
                                                    <input type="email" name="email" class="form-control" id="emailRego" placeholder="example@user.com">
                                                    <input type="hidden" id="emailValid" value="">
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputChoosePassword" class="form-label">Password</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password" name="password" class="form-control border-end-0" id="password" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="authType" value="1" id="flexSwitchCheckChecked">
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms &amp; Conditions</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-dark submit disabled"><i class="bx bx-user"></i>Sign up</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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