$(document).ready(function () {
  $('.thank-you').click(function () {
    Swal.fire({
      title: 'Payment Confirmed',
      text: 'Your payment has been successfully processed.',
      icon: 'success',
      confirmButtonText: 'OK'
    });

    setTimeout(function () {
      window.location.href = 'thank-you.php';
    }, 3000);
  });

  $('.btn-review').click(function () {

    var name = $('.name').val();
    var email = $('.email').val();
    var rating = $('.rating').val();
    var comment = $('.comment').val();

    // Perform client-side validation
    if (name.trim() === '' || email.trim() === '' || rating.trim() === '' || comment.trim() === '') {
      Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      }).fire({
        icon: 'warning',
        title: 'Oops..',
        text: 'Please fill in all the fields!'
      });
      return;
    }

    var formData = $('.review').serialize();

    $.ajax({
      url: 'review-save.php',
      type: 'POST',
      data: formData,
      success: function (response) {
        console.log(response)
        if (response) {
          $('.add-review').empty().html('<h6 class="form-body p-3">Thank you for your review!</h6>');
        } else {
          console.log('failed to save');
        }
      },
      error: function () {
        console.log('error');
      }
    });
  });

  $('#emailRego').on('blur', function () {
    var email = $(this).val();

    $.ajax({
      url: 'authenticate.php',
      type: 'POST',
      data: {
        email: email,
        action: 'checkUserExists'
      },
      success: function (response) {
        if (response === 'exists') {
          $('#email-validation-result').text('- User with this email already exists.').removeClass('text-success').addClass('text-danger');
          $('#emailValid').val(0);
        } else {
          $('#email-validation-result').text('- Email is available.').removeClass('text-danger').addClass('text-success');
          $('#emailValid').val(1);
          $('#password').val('');
        }
      }
    });
  });

  $('.rego').on('input', function () {
    var firstName = $('#fname').val();
    var lastName = $('#lname').val();
    var email = $('#emailRego').val();
    var password = $('#password').val();
    var emailValid = $('#emailValid').val() === '1';
    var authType = $('#flexSwitchCheckChecked').is(':checked');

    var isValid = firstName !== '' && lastName !== '' && email !== '' && password !== '' && authType && emailValid;

    var submitButton = $('.submit');
    if (isValid) {
      submitButton.removeClass('disabled');
    } else {
      submitButton.addClass('disabled');
    }
  });

  $('.updateDetails').on('input', function () {
    var firstName = $('#name').val();
    var email = $('#email').val();
    var password = $('#password').val();

    var isValid = firstName !== '' && email !== '' && password !== '';

    var submitButton = $('.submit');
    if (isValid) {
      submitButton.removeClass('disabled');
    } else {
      submitButton.addClass('disabled');
    }
  });

  if (window.location.search.includes('?login=failed')) {
    Swal.fire({
      icon: 'error',
      title: 'Failed Login',
      text: 'Your login attempt was unsuccessful.',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'OK'
    });
  }


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
  const quantityInputs = document.querySelectorAll(".totalQty");

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
        const productName = product.pname;
        const productImage = product.pimage;
        const price = product.saleprice;
        const quantity = document.querySelector(".qty").value;
        const size = document.querySelector(".size").value;

        const cartItem = {
          productImage: productImage,
          productName: productName,
          productId: productId,
          price: price,
          quantity: quantity,
          size: size
        };
        console.log(cartItem)
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
      alert("Error fetching product. Please try again." + error);
    });
}

function getProductById(productId) {
  return fetch(`product-get.php?id=${productId}`)
    .then(response => response.json())
    .catch(error => {
      throw new Error("Failed to fetch product");
    });
}

function saveCustomerDataForm() {
  var firstName = document.querySelector('input[name="firstName"]').value;
  var lastName = document.querySelector('input[name="lastName"]').value;
  var email = document.querySelector('input[name="email"]').value;
  var phoneNumber = document.querySelector('input[name="phoneNumber"]').value;
  var state = document.querySelector('select[name="state"]').value;
  var city = document.querySelector('input[name="city"]').value;
  var zipCode = document.querySelector('input[name="zipCode"]').value;
  var address = document.querySelector('textarea[name="address"]').value;
  var userId = document.querySelector('input[name="userId"]').value;

  var customer = {
    name: firstName + ' ' + lastName,
    address: address,
    postcode: zipCode,
    city: city,
    state: state,
    phone: phoneNumber,
    email: email,
    userId: userId
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
    document.querySelector('input[name="city"]').value = customer.city;
    document.querySelector('select[name="state"]').value = customer.state;
    document.querySelector('input[name="zipCode"]').value = customer.postcode;
    document.querySelector('textarea[name="address"]').value = customer.address;
  }
}

function isFormValid() {
  var formElements = document.querySelectorAll('.customer-details .form-control');
  for (var i = 0; i < formElements.length; i++) {
    if (formElements[i].value.trim() === '') {
      return false;
    }
  }
  return true;
}

function isCardValid() {
  var formElements = document.querySelectorAll('.payment-details .form-control');
  for (var i = 0; i < formElements.length; i++) {
    if (formElements[i].value.trim() === '') {
      return false;
    }
  }
  return true;
}

function saveCustomerData() {
  const customerData = JSON.parse(localStorage.getItem("customerData"));
  const cartItems = JSON.parse(localStorage.getItem("cartItems"));

  if (customerData && cartItems) {
    const url = 'customer-save.php';

    const requestData = {
      customerData: customerData,
      cartItems: cartItems
    };

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: JSON.stringify(requestData),
      contentType: 'application/json',
      success: function (data) {
        console.log(data);
      },
      error: function (xhr, status, error) {
        console.error('Error:', error);
      }
    });
  } else {
    console.log('Customer data or cart items not found.');
  }
}