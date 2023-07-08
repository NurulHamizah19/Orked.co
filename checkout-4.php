<?php include_once 'template/header.php'; ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Review Order</h3>
                    <div class="ms-auto">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i> Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript:;">Shop</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Shop Cart</li>
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
                            <div class="checkout-review">
                                <div class="card bg-transparent rounded-0 shadow-none">
                                    <div class="card-body">
                                        <?php include 'template/checkout/step.php'; ?>
                                    </div>
                                </div>
                                <div class="card  rounded-0 shadow-none mb-3 border">
                                    <div class="card-body">
                                        <div id="cartListContainer"></div>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none mb-3 border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="shipping-address">
                                                    <h5 class="mb-3">Shipping to:</h5>
                                                    <p class="mb-1"><span class="text-dark">Customer:</span> <span id="customerName"></span></p>
                                                    <p class="mb-1"><span class="text-dark">Address:</span> <span id="customerAddress"></span></p>
                                                    <p class="mb-1"><span class="text-dark">Phone:</span> <span id="customerPhone"></span></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="payment-mode">
                                                    <h5 class="mb-3">Payment Method:</h5>
                                                    <p class="mb-1">Credit Card</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-0 shadow-none mb-3 border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-grid"><a href="javascript:;" class="btn btn-light btn-ecomm"><i class="bx bx-chevron-left"></i>Back to Payment</a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-grid"><a href="thank-you" class="btn btn-outline-dark btn-ecomm thank-you">Complete Order<i class="bx bx-chevron-right"></i></a>
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
    const thankYouButton = document.querySelector(".thank-you");
    thankYouButton.addEventListener('click', function(e) {
        e.preventDefault();
        var getCustomerData = JSON.parse(localStorage.getItem('customerData'));
        var getCartItems = JSON.parse(localStorage.getItem('cartItems'));

        var data = {
            customerData: getCustomerData,
            cartItems: getCartItems
        };

        $.ajax({
            url: 'customer-save.php',
            type: 'POST',
            data: data,
            success: function(response) {
                if (response === 'success') {
                    console.log('Data saved successfully');
                } else {
                    console.log('Error occurred while saving data');
                }
            },
            error: function() {
                console.log('Error occurred while making the AJAX request');
            }
        });

    });

    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    const customerData = JSON.parse(localStorage.getItem("customerData"));
    const cartListContainer = document.getElementById("cartListContainer");

    let subtotal = 0;
    cartItems.forEach(item => {
        subtotal += parseFloat(item.price) * parseInt(item.quantity);
    });

    if (customerData) {
        const customerNameElement = document.getElementById("customerName");
        const customerAddressElement = document.getElementById("customerAddress");
        const customerPhoneElement = document.getElementById("customerPhone");

        customerNameElement.textContent = customerData.name;
        customerAddressElement.textContent = customerData.address + ' ' + customerData.postcode + ' ' + customerData.city + ' ' + customerData.state;
        customerPhoneElement.textContent = customerData.phone;
    }

    if (cartItems.length === 0) {
        const emptyCartMessage = document.createElement("p");
        emptyCartMessage.textContent = "Your cart is empty.";
        cartListContainer.appendChild(emptyCartMessage);
    } else {
        cartItems.forEach((item, index) => {
            const cartItemDiv = document.createElement("div");
            cartItemDiv.className = "row align-items-center g-3";

            // Cart Detail Container
            const cartDetailDiv = document.createElement("div");
            cartDetailDiv.className = "col-12 col-lg-6";

            const cartDetailInnerDiv = document.createElement("div");
            cartDetailInnerDiv.className = "d-lg-flex align-items-center gap-3";

            const cartImageDiv = document.createElement("div");
            cartImageDiv.className = "cart-img text-center text-lg-start";

            const cartImage = document.createElement("img");
            cartImage.src = "admin/productimages/" + item.productImage;
            cartImage.width = "130";
            cartImage.alt = "";

            cartImageDiv.appendChild(cartImage);
            cartDetailInnerDiv.appendChild(cartImageDiv);

            const cartDetailTextDiv = document.createElement("div");
            cartDetailTextDiv.className = "cart-detail text-center text-lg-start";

            const productNameH6 = document.createElement("h6");
            productNameH6.className = "mb-2";
            productNameH6.textContent = item.productName;

            const productLink = document.createElement("a");
            productLink.href = "product-details?id=" + item.productId;

            const sizeP = document.createElement("p");
            sizeP.className = "mb-0";
            sizeP.innerHTML = `Size: <span>${item.size}</span>`;

            // const colorP = document.createElement("p");
            // colorP.className = "mb-2";
            // colorP.innerHTML = `Color: <span>${item.color}</span>`;

            const priceH5 = document.createElement("h5");
            priceH5.className = "mb-0";
            priceH5.textContent = 'RM ' + parseFloat(item.price).toFixed(2);

            cartDetailTextDiv.appendChild(productLink);
            productLink.appendChild(productNameH6);
            cartDetailTextDiv.appendChild(sizeP);
            // cartDetailTextDiv.appendChild(colorP);
            cartDetailTextDiv.appendChild(priceH5);
            cartDetailInnerDiv.appendChild(cartDetailTextDiv);

            cartDetailDiv.appendChild(cartDetailInnerDiv);
            cartItemDiv.appendChild(cartDetailDiv);

            const quantityDiv = document.createElement("div");
            quantityDiv.className = "col-12 col-lg-3";

            const quantityChildDiv = document.createElement("div");
            quantityChildDiv.className = "cart-action text-center";

            const quantityInput = document.createElement("input");
            quantityInput.type = "number";
            quantityInput.className = "form-control rounded-0 totalQty";
            quantityInput.value = item.quantity;
            quantityInput.min = "1";

            quantityChildDiv.appendChild(quantityInput);
            quantityDiv.appendChild(quantityChildDiv);
            cartItemDiv.appendChild(quantityDiv);

            const cartActionDiv = document.createElement("div");
            cartActionDiv.className = "col-12 col-lg-3";

            const cartActionCenterDiv = document.createElement("div");
            cartActionCenterDiv.className = "text-center";

            const cartActionChildDiv = document.createElement("div");
            cartActionChildDiv.className = "d-flex gap-3 justify-content-center justify-content-lg-end";

            const removeButton = document.createElement("a");
            removeButton.href = "javascript:;";
            removeButton.className = "btn btn-outline-dark rounded-0 btn-ecomm";
            removeButton.innerHTML = '<i class="bx bx-x"></i> Remove';
            removeButton.addEventListener("click", () => {
                cartItems.splice(index, 1);
                localStorage.setItem("cartItems", JSON.stringify(cartItems));
                location.reload();
            });

            cartActionDiv.appendChild(cartActionCenterDiv);
            cartActionCenterDiv.appendChild(cartActionChildDiv);
            cartActionChildDiv.appendChild(removeButton);
            cartItemDiv.appendChild(cartActionDiv);

            cartListContainer.appendChild(cartItemDiv);
            cartListContainer.appendChild(document.createElement("hr"));
        });
    }
</script>