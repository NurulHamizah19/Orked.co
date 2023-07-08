<?php
include_once 'template/header.php';
?>

<div class="page-wrapper">
    <div class="page-content">
        <!--start breadcrumb-->
        <section class="py-3 border-bottom border-top d-none d-md-flex bg-light">
            <div class="container">
                <div class="page-breadcrumb d-flex align-items-center">
                    <h3 class="breadcrumb-title pe-3">Shop Cart</h3>
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
                            <div class="shop-cart-list mb-3 p-3">
                                <div id="cartListContainer">
                                </div>
                                <!-- Items -->
                                <div class="d-lg-flex align-items-center gap-2">
                                    <a href="shop" class="btn btn-dark btn-ecomm"><i class="bx bx-shopping-bag"></i> Continue Shopping</a>
                                    <a href="javascript:;" class="btn btn-light btn-ecomm ms-auto" onclick="clearCart()"><i class="bx bx-x-circle"></i> Clear Cart</a>
                                    <a href="javascript:;" class="btn btn-white btn-ecomm" onclick="updateCart()"><i class="bx bx-refresh"></i> Update Cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="checkout-form p-3 bg-light">
                                <div class="card rounded-0 border bg-transparent mb-0 shadow-none">
                                    <div class="card-body">
                                        <p class="mb-2">Subtotal: <span class="float-end" id="subtotalAmount"></span></p>
                                        <p class="mb-2">Shipping: <span class="float-end">RM 10.00</span></p>
                                        <div class="my-3 border-top"></div>
                                        <h5 class="mb-0">Order Total: <span class="float-end" id="orderTotalAmount"></span></h5>
                                        <div class="my-4"></div>
                                        <div class="d-grid">
                                            <a href="checkout-1" class="btn btn-dark btn-ecomm">Proceed to Checkout</a>
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

<?php
include_once 'template/footer.php';
?>
<script>
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    const cartListContainer = document.getElementById("cartListContainer");
    const subtotalElement = document.getElementById("subtotalAmount");
    const orderTotalElement = document.getElementById("orderTotalAmount");

    let subtotal = 0;
    cartItems.forEach(item => {
        subtotal += parseFloat(item.price) * parseInt(item.quantity);
    });

    const shippingFee = 10;
    const orderTotal = subtotal + shippingFee;

    subtotalElement.textContent = `RM ${subtotal.toFixed(2)}`;
    orderTotalElement.textContent = `RM ${orderTotal.toFixed(2)}`;

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

            // Quantity Input
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

            // Cart Action
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

            // Append the cart item row to the container
            cartListContainer.appendChild(cartItemDiv);
            cartListContainer.appendChild(document.createElement("hr"));
        });
    }
</script>