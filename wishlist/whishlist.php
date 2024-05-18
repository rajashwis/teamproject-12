<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist</title>
  <link rel="stylesheet" href="wishlist.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="../component/header.php">
</head>
<body>

  <?php

  include '../component/header.php';
  ?>

<div class="container">
  <div class="menu">
    <ul>
      <li><a href="">My Profile</a></li>
      <li><a href="">My Order</a></li>
      <li><a class="active" href="">My Wishlist</a></li>
      <li><a href="">Reviews</a></li>
    </ul>
  </div>

  <div class="right">

    <div class="row">
      <div class="item"><a href="">Product</a></div>
      <div class="item"><a href="">Name</a></div>
      <div class="item"><a href="">Price</a></div>
      <div class="item"><a href=""></a></div>
    </div>


    <div class="wishlist-item">
      <div class="item product">
        <img src="../resources/products/bakery1.jpg" alt="Product Image">
      </div>
      <div class="item product">
        <p>Product Name</p>
      </div>
      <div class="item price">$2.99</div>
      <div>
      <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </div>

    <div class="wishlist-item">
      <div class="item product">
        <img src="../resources/products/bakery1.jpg" alt="Product Image">
      </div>
      <div class="item product">
        <p>Product Name</p>
      </div>
      <div class="item price">$2.99</div>
      <div>
      <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </div>

    <div class="wishlist-item">
      <div class="item product">
        <img src="../resources/products/bakery1.jpg" alt="Product Image">
      </div>
      <div class="item product">
        <p>Product Name</p>
      </div>
      <div class="item price">$2.99</div>
      <div>
      <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </div>

    <div class="wishlist-item">
      <div class="item product">
        <img src="../resources/products/bakery1.jpg" alt="Product Image">
      </div>
      <div class="item product">
        <p>Product Name</p>
      </div>
      <div class="item price">$2.99</div>
      <div>
      <button class="btn-add-to-cart">Add to Cart</button>
      </div>
    </div>



  </div>
</div>


  <?php
  include '../component/footer.php';
  ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const minusBtns = document.querySelectorAll('.btn-minus');
      const plusBtns = document.querySelectorAll('.btn-plus');
      const quantityInputs = document.querySelectorAll('.quantity');

      // Decrease quantity when minus button is clicked
      minusBtns.forEach((btn, index) => {
        btn.addEventListener('click', function () {
          let currentValue = parseInt(quantityInputs[index].value);
          if (currentValue > 1) {
            quantityInputs[index].value = currentValue - 1;
          }
        });
      });

      // Increase quantity when plus button is clicked
      plusBtns.forEach((btn, index) => {
        btn.addEventListener('click', function () {
          let currentValue = parseInt(quantityInputs[index].value);
          quantityInputs[index].value = currentValue + 1;
        });
      });
    });
  </script>
</body>
</html>