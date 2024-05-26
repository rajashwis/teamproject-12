<?php

session_start();
include "../connect.php";

$user = $_SESSION['user_id'];
$username = $_SESSION['username'];
$cart_id = $_SESSION['cart_id'];
$wishlist_id = $_SESSION['wishlist_id'];

if(!$user){
    echo '<script>
    alert("Sorry, you need to be logged in to access this!");
    window.location.href = "../homepage/home.php";
    </script>';
    exit();
}

$query = "SELECT * FROM WISHLISTPRODUCT WHERE WISHLIST_ID = $wishlist_id";
$stid = oci_parse($connection, $query);
oci_execute($stid);

if (isset($_POST['add_to_cart'])) {

  $product_id = $_POST['product_id'];
  header('Location: ../cart/add_to_cart.php?product_id='.$product_id);
  exit();     

}

?>

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

<?php include "../components/header.php"; ?>
<h2 class="heading"2>MY WISHLIST</h2>

<div class ="container">
  <div class="menu">
        <ul>
        <li><a href="customer_profile.php">My Profile</a></li>
                <li><a href="customer_order.php">My Order</a></li>
                <li><a class="active" href="wishlist.php">Wishlist</a></li>
                <li><a href="customer_review.php">Reviews</a></li>
        </ul>
  </div>

 

    <div class="right">

      <div class="row">
        <div class="item"><span>Product</span></div>
        <div class="item"><span>Name</span></div>
        <div class="item"><span>Price</apan></div>
        <div class="item"><span> </span></div>
      </div>


    <?php
      while ($wishlist = oci_fetch_assoc($stid)) {
        $product_id = $wishlist['PRODUCT_ID'];

        $query1 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $product_id";
        $stid1 = oci_parse($connection, $query1);
        oci_execute($stid1);
        $product = oci_fetch_assoc($stid1);

    ?>

    <div class="wishlist-item">

      <div class="item product">

        <?php

          $imageData = $product['PRODUCT_IMAGE']->load();
          $encodedImageData = base64_encode($imageData);
          // Determine the image type based on the first few bytes of the image data
          $header = substr($imageData, 0, 4);
          $imageType = 'image/jpeg'; // default to JPEG
          if (strpos($header, 'FFD8') === 0) {
            $imageType = 'image/jpeg'; // JPEG
          } elseif (strpos($header, '89504E47') === 0) {
            $imageType = 'image/png'; // PNG
          }

          echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';

        ?>
        <!-- <img src ="../resources/products/bakery1.jpg"> -->
      </div>

      <div class="item product">
        <p>
          <?php echo $product['PRODUCT_NAME']; ?>
        </p>
      </div>
      <div class="item price">
        <?php echo $product['PRICE']; ?>
      </div>
      <div class="func-btn">
        <button type="submit" name="add_to_cart" class="btn-add-to-cart">Add to Cart</button>
        <a href="delete-wishlist.php?delete=<?php echo $product['PRODUCT_ID']?>" onclick="return confirm('Are you sure you want to remove this from your wishlist?');"> <button type="submit" name="remove" class="btn-order-now">Remove</button></a>
      </div>
    </div>

    <?php }
    ?>

  </div>
  </div>


  <?php
  include '../component/footer.php';
  ?>

</body>

</html>