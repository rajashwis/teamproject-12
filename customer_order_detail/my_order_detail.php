<?php
// Include the footer.php file from the component folder
include '../component/navbar.php';
?>

<!-- Your content for myorder.php goes here -->



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Order</title>
  <link rel="stylesheet" href="my_order_detail.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body>
  <oiv class="container">
    <div class="menu">
        <ul>
          <li><a href="#">My Profile</a></li>
          <li><a class="active" href="#">My Order</a></li>
          <li><a href="#">My Wishlist</a></li>
          <li><a href="#">Reviews</a></li>
        </ul>
    </div>

    <div class="right">
      <div class="row">
        <div class="item"><a href="">Order Number</a></div>
        <div class="item"><a href="">Order Placed</a></div>
        <div class="item"><a href="">Price</a></div>
        <div class="item"><a href="">Status</a></div>
      </div>

      <div class="order-item">
        <span class="order-number">5202</span>
        <span class="order-placed">5/12/2024</span>
        <span class="price">Rs 1000</span>
        <span class="status">Processing</span>
        <button class="btn-view-details"><a href="cart.html">View Details</a></button>
      </div>


      <div class="order-item">
        <span class="order-number">5202</span>
        <span class="order-placed">5/12/2024</span>
        <span class="price">Rs 1000</span>
        <span class="status">Processing</span>
        <button class="btn-view-details"><a href="cart.html">View Details</a></button>
      </div>


      <div class="order-item">
        <span class="order-number">5202</span>
        <span class="order-placed">5/12/2024</span>
        <span class="price">Rs 1000</span>
        <span class="status">Processing</span>
        <button class="btn-view-details"><a href="cart.html">View Details</a></button>
      </div>

      <div class="order-item">
        <span class="order-number">5202</span>
        <span class="order-placed">5/12/2024</span>
        <span class="price">Rs 1000</span>
        <span class="status">Processing</span>
        <button class="btn-view-details"><a href="cart.html">View Details</a></button>
      </div>

      
    </div>
  </div>
  <script src="MyOrder.js"></script>
</body>
</html>