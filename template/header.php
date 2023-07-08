<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/orked.jpeg" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/OwlCarousel/css/owl.carousel.min.css" rel="stylesheet" />

    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <title>Orked Shop</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--start top header wrapper-->
        <div class="header-wrapper">
            <div class="header-content" style="background-color: #628a60;">
                <div class="container">
                    <div class="row align-items-center gx-4">
                        <div class="col-auto">
                            <div class="d-flex align-items-center gap-3">
                                <div class="mobile-toggle-menu d-inline d-xl-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                                    <i class="bx bx-menu"></i>
                                </div>
                                <div class="logo">
                                    <a href="index.php">
                                        <img src="assets/images/orked.jpeg" class="logo-icon" alt="" />
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-12 col-xl order-4 order-xl-0"> -->
                        <form class="col-12 col-xl order-4 order-xl-0" method="GET" action="shop">
                            <div class="input-group flex-nowrap pb-3 pb-xl-0">
                                <input type="hidden" name="category" value="All">
                                <input type="text" name="search" class="form-control w-100 border-dark border border-3" placeholder="Search for Products">
                                <button class="btn btn-dark btn-ecomm border-3" type="submit">Search</button>
                            </div>
                        </form>
                        <!-- </div> -->

                        <div class="col-auto ms-auto">
                            <div class="top-cart-icons">
                                <nav class="navbar navbar-expand">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown dropdown-large">
                                            <a href="#" class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative cart-link" data-bs-toggle="dropdown"> <span class="alert-count totalItems">8</span>
                                                <i class='bx bx-shopping-bag'></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="cart.php">
                                                    <div class="cart-header">
                                                        <p class="cart-header-title mb-0"><span class="totalItems"></span> ITEMS</p>
                                                        <p class="cart-header-clear ms-auto mb-0">VIEW CART</p>
                                                    </div>
                                                </a>
                                                <div class="cart-list" id="minicartItemsContainer">
                                                    <!-- <a class="dropdown-item" href="javascript:;">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1">
                                                                <h6 class="cart-product-title">Men White T-Shirt</h6>
                                                                <p class="cart-product-price">1 X $29.00</p>
                                                            </div>
                                                            <div class="position-relative">
                                                                <div class="cart-product-cancel position-absolute"><i class='bx bx-x'></i>
                                                                </div>
                                                                <div class="cart-product">
                                                                    <img src="assets/images/products/01.png" class="" alt="product image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a> -->
                                                </div>
                                                <a href="cart.php">
                                                    <div class="text-center cart-footer d-flex align-items-center">
                                                        <h5 class="mb-0">TOTAL</h5>
                                                        <h5 class="mb-0 ms-auto totalCart">RM0</h5>
                                                    </div>
                                                </a>
                                                <div class="d-grid p-3 border-top"> <a href="checkout-1" class="btn btn-dark btn-ecomm">CHECKOUT</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
            <div class="primary-menu">
                <nav class="navbar navbar-expand-xl w-100 navbar-dark container mb-0 p-0">
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
                        <div class="offcanvas-header">
                            <div class="offcanvas-logo"><img src="assets/images/logo-icon.png" width="100" alt="">
                            </div>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body primary-menu">
                            <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item"> <a class="nav-link" href="shop.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="about-us.php">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="feedback.php">Feedback</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!--end top header wrapper-->

        <script>
            // Retrieve cartItems from localStorage
            let minicartItems = JSON.parse(localStorage.getItem('cartItems'));

            // Get the container element where the cart items will be populated
            let miniContainer = document.getElementById('minicartItemsContainer');
            let totalCart = 0;
            // Iterate over each cart item and generate the HTML dynamically
            minicartItems.forEach(function(cartItem) {

                let itemPrice = parseFloat(cartItem.price);
                let itemQuantity = parseInt(cartItem.quantity);
                let itemTotalPrice = itemPrice * itemQuantity;

                totalCart += itemTotalPrice;

                // Create the elements for each cart item
                let itemMiniContainer = document.createElement('a');
                itemMiniContainer.classList.add('dropdown-item');
                itemMiniContainer.href = 'product-details?id=' + cartItem.productId;

                let itemMiniContent = document.createElement('div');
                itemMiniContent.classList.add('d-flex', 'align-items-center');

                let itemMiniDetails = document.createElement('div');
                itemMiniDetails.classList.add('flex-grow-1');

                let itemMiniTitle = document.createElement('h6');
                itemMiniTitle.classList.add('cart-product-title');
                itemMiniTitle.textContent = cartItem.productName;

                let itemMiniPrice = document.createElement('p');
                itemMiniPrice.classList.add('cart-product-price');
                itemMiniPrice.textContent = cartItem.quantity + ' X RM' + cartItem.price;

                let itemMiniCancel = document.createElement('div');
                itemMiniCancel.classList.add('cart-product-cancel', 'position-absolute');
                itemMiniCancel.innerHTML = '<i class="bx bx-x"></i>';

                let itemMiniImage = document.createElement('div');
                itemMiniImage.classList.add('cart-product');

                let image = document.createElement('img');
                image.src = 'admin/productImages/' + cartItem.productImage;

                // Assemble the elements
                itemMiniDetails.appendChild(itemMiniTitle);
                itemMiniDetails.appendChild(itemMiniPrice);
                itemMiniContent.appendChild(itemMiniDetails);
                itemMiniContent.appendChild(itemMiniCancel);
                itemMiniImage.appendChild(image);
                itemMiniContent.appendChild(itemMiniImage);
                itemMiniContainer.appendChild(itemMiniContent);

                // Append the cart item to the container
                miniContainer.appendChild(itemMiniContainer);
            });

            let totalCartElement = document.querySelector('.totalCart');
            totalCartElement.textContent = 'RM ' + totalCart.toFixed(2);
            let totalItemsElement = document.querySelector('.totalItems');
            totalItemsElement.textContent = minicartItems.length.toString();
        </script>