$(document).ready(function() {
  $('.btn-pay').click(function() {
    Swal.fire({
      title: 'Payment Confirmed',
      text: 'Your payment has been successfully processed.',
      icon: 'success',
      confirmButtonText: 'OK'
    });

    setTimeout(function() {
      window.location.href = 'thank-you.php'; 
    }, 3000); 
  });
});

function shareOnTwitter() {
    var currentPageUrl = window.location.href;
    var twitterShareUrl = "https://twitter.com/intent/tweet?text=Check%20out%20this%20product:&url=" + encodeURIComponent(currentPageUrl);
    window.open(twitterShareUrl, "_blank");
}

function shareOnFacebook() {
    var currentPageUrl = window.location.href;
    var facebookShareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(currentPageUrl);
    window.open(facebookShareUrl, "_blank");
}

function clearCart() {
  localStorage.removeItem("cartItems");
  cartListContainer.innerHTML = "";
  Swal.fire({
    icon: 'success',
    title: 'Cart cleared!',
    showConfirmButton: true,
    timer: 1500
  });
  setTimeout(() => {
    location.reload();
  }, 2000); 
}

function updateCart() {
  const quantityInputs = document.querySelectorAll(".product-info-section select:nth-child(1)");

  cartItems.forEach((item, index) => {
    const updatedQuantity = parseInt(quantityInputs[index].value, 10);
    if (!isNaN(updatedQuantity) && updatedQuantity >= 1) {
      item.quantity = updatedQuantity;
    }
  });

  localStorage.setItem("cartItems", JSON.stringify(cartItems));

  Swal.fire({
    icon: 'success',
    title: 'Cart updated!',
    showConfirmButton: true,
    timer: 1500
  });

  setTimeout(() => {
    location.reload();
  }, 2000); 
}

  function addToCart(productId) {

    getProductById(productId)
      .then(product => {
        if (product) {
          const productName = product.name;
          const price = product.price;
          const quantity = document.querySelector(".product-info-section select:nth-child(1)").value;
          const size = document.querySelector(".product-info-section select:nth-child(2)").value;

          const cartItem = {
            productName: productName,
            price: price,
            quantity: quantity,
            size: size
          };

          let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
          cartItems.push(cartItem);
          localStorage.setItem("cartItems", JSON.stringify(cartItems));

          Swal.fire({
            icon: 'success',
            title: 'Item added to cart!',
            showConfirmButton: false,
            timer: 1500
          });

          setTimeout(() => {
            location.reload();
          }, 2000); 

        } else {
          Swal.fire({
              icon: 'error',
              title: 'Product not found!',
              showConfirmButton: false,
              timer: 1500
            });
        }
      })
      .catch(error => {
        console.error("Error fetching product:", error);
        alert("Error fetching product. Please try again.");
      });
  }

  function getProductById(productId) {
    return fetch(`/product-get?id=${productId}`)
      .then(response => response.json())
      .catch(error => {
        throw new Error("Failed to fetch product");
      });
  }

function saveCustomerData() {
  var firstName = document.querySelector('input[name="firstName"]').value;
  var lastName = document.querySelector('input[name="lastName"]').value;
  var email = document.querySelector('input[name="email"]').value;
  var phoneNumber = document.querySelector('input[name="phoneNumber"]').value;
  var state = document.querySelector('select[name="state"]').value;
  var city = document.querySelector('select[name="city"]').value;
  var zipCode = document.querySelector('input[name="zipCode"]').value;
  var address = document.querySelector('textarea[name="address"]').value;
  
  var customer = {
    name: firstName + ' ' + lastName,
    address: address,
    postcode: zipCode,
    city: city,
    state: state,
    phone: phoneNumber,
    email: email
  };
  
  localStorage.setItem('customerData', JSON.stringify(customer));
}

function populateForm() {
  if (localStorage.getItem('customerData')) {
    var customer = JSON.parse(localStorage.getItem('customerData'));
    document.querySelector('input[name="firstName"]').value = customer.name.split(' ')[0];
    document.querySelector('input[name="lastName"]').value = customer.name.split(' ')[1];
    document.querySelector('input[name="email"]').value = customer.email;
    document.querySelector('input[name="phoneNumber"]').value = customer.phone;
    document.querySelector('select[name="state"]').value = customer.state;
    document.querySelector('input[name="zipCode"]').value = customer.postcode;
    document.querySelector('textarea[name="address"]').value = customer.address;
  }
}