<!-- <div class="checkout-form p-3 bg-light">
    <div class="card rounded-0 border bg-transparent mb-0 shadow-none">
        <div class="card-body">
            <p class="mb-2">Subtotal: <span class="float-end">$198.00</span>
            </p>
            <p class="mb-2">Shipping: <span class="float-end">--</span>
            </p>
            <p class="mb-2">Taxes: <span class="float-end">$14.00</span>
            </p>
            <p class="mb-0">Discount: <span class="float-end">--</span>
            </p>
            <div class="my-3 border-top"></div>
            <h5 class="mb-0">Order Total: <span class="float-end">212.00</span></h5>
            <div class="my-4"></div>
            <div class="d-grid"> <a href="javascript:;" class="btn btn-dark btn-ecomm">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div> -->

<div class="order-summary">
  <div class="card rounded-0">
    <div class="card-body">
      <div class="card rounded-0 border bg-transparent shadow-none">
        <div class="card-body">
          <p class="fs-5">Order summary</p>
          <div class="my-3 border-top"></div>
          <!-- item pergi sini -->
          <div id="orderDetailsContainer"></div>

          <div class="my-3 border-top"></div>
        </div>
      </div>
      <div class="card rounded-0 border bg-transparent mb-0 shadow-none">
        <div class="card-body">
          <p class="mb-2">Subtotal: <span class="float-end" id="subtotal">$198.00</span>
          </p>
          <p class="mb-2">Shipping (Flat rate): <span class="float-end">RM 10.00</span>
          </p>
          <div class="my-3 border-top"></div>
          <h5 class="mb-0">Order Total: <span class="float-end" id="orderTotal"></span></h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- reload jquery just in case -->
<script src="assets/js/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    const orderDetailsContainer = document.getElementById("orderDetailsContainer");

    function populateOrderDetails() {
      orderDetailsContainer.innerHTML = "";
      let subtotal = 0;
      cartItems.forEach(item => {
        const orderItemDiv = document.createElement("div");
        orderItemDiv.className = "d-flex align-items-center";

        const itemDetailDiv = document.createElement("div");
        itemDetailDiv.className = "ps-2";

        const itemNameH6 = document.createElement("h6");
        itemNameH6.className = "mb-1";
        itemNameH6.innerHTML = `<a href="javascript:;" class="text-dark">${item.productName}</a>`;

        const itemMetaDiv = document.createElement("div");
        itemMetaDiv.className = "widget-product-meta";

        const itemPriceSpan = document.createElement("span");
        itemPriceSpan.className = "me-2";
        itemPriceSpan.textContent = `RM ${item.price}`;

        const itemQuantitySpan = document.createElement("span");
        itemQuantitySpan.textContent = `x ${item.quantity}`;

        itemMetaDiv.appendChild(itemPriceSpan);
        itemMetaDiv.appendChild(itemQuantitySpan);

        itemDetailDiv.appendChild(itemNameH6);
        itemDetailDiv.appendChild(itemMetaDiv);

        orderItemDiv.appendChild(itemDetailDiv);

        orderDetailsContainer.appendChild(orderItemDiv);

        subtotal += item.price * item.quantity;
      });

      const shippingRate = 10.0;
      const orderTotal = subtotal + shippingRate;

      const subtotalElement = document.getElementById("subtotal");
      const orderTotalElement = document.getElementById("orderTotal");
      subtotalElement.textContent = `RM ${subtotal.toFixed(2)}`;
      orderTotalElement.textContent = `RM ${orderTotal.toFixed(2)}`;
    }

    populateOrderDetails();
  });
</script>