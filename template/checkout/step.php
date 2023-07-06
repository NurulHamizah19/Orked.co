<!-- <?php var_dump(strpos($_SERVER['REQUEST_URI'], 'checkout-1') !== false); ?> -->
<div class="steps steps-light">
    <a class="step-item active <?= (strpos($_SERVER['REQUEST_URI'], 'cart.php') !== false) ? 'current' : '' ?>" href="cart.php">
        <div class="step-progress"><span class="step-count">1</span>
        </div>
        <div class="step-label"><i class="bx bx-cart"></i>Cart</div>
    </a>
    <a class="step-item active <?= (strpos($_SERVER['REQUEST_URI'], 'checkout-1') !== false) ? ' current' : '' ?>" href="checkout-1.php">
        <div class="step-progress"><span class="step-count">2</span>
        </div>
        <div class="step-label"><i class="bx bx-user-circle"></i>Details</div>
    </a>
    <a class="step-item <?= (strpos($_SERVER['REQUEST_URI'], 'checkout-1') !== false) ? '' : 'active' ?> <?= (strpos($_SERVER['REQUEST_URI'], 'checkout-2.php') !== false) ? ' current' : '' ?>" href="checkout-2.php">
        <div class="step-progress"><span class="step-count">3</span>
        </div>
        <div class="step-label"><i class="bx bx-cube"></i>Shipping</div>
    </a>
    <a class="step-item <?= (strpos($_SERVER['REQUEST_URI'], 'checkout-4') !== false) ? 'active ' : '' ?> <?= (strpos($_SERVER['REQUEST_URI'], 'checkout-3') !== false) ? 'active current' : '' ?>" href="checkout-3.php">
        <div class="step-progress"><span class="step-count">4</span>
        </div>
        <div class="step-label"><i class="bx bx-credit-card"></i>Payment</div>
    </a>
    <a class="step-item  <?= (strpos($_SERVER['REQUEST_URI'], 'checkout-4') !== false) ? 'active current' : '' ?>" href="checkout-4.php">
        <div class="step-progress"><span class="step-count">5</span>
        </div>
        <div class="step-label"><i class="bx bx-check-circle"></i>Review</div>
    </a>
</div>