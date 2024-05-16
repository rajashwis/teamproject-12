<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 
    $username = $_SESSION['username'];
    $cart_id = $_SESSION['cart_id'];

    $query = "SELECT * FROM CARTPRODUCT WHERE CART_ID = $cart_id";
    $stid=oci_parse($connection, $query);
    oci_execute($stid);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Cart</title>
        <link rel="stylesheet" href="cart.css" />
    </head>
    <body>
        <div class="big-box-container">
            <h1>Your Cart</h1>

            <?php
                while($cart = oci_fetch_assoc($stid)) { 
                    $product_id = $cart['PRODUCT_ID'];

                    $query1 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $product_id";
                    $stid1=oci_parse($connection, $query1);
                    oci_execute($stid1);
                    $product = oci_fetch_assoc($stid1);
                    ?>

                    
                    <div class="container">
                    <div class="product-details">
                    <div class="image-container">
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
                    </div>

                    <div class="content">
                        <h3><?php echo $product['PRODUCT_NAME'];?></h3>
                        <p>
                            <?php echo $product['DESCRIPTION_'];?>
                        </p>
                    </div>

                    <div class="quantity-input">
                        <div class="price"><p>Price: <?php echo $product['PRICE'];?></p></div>
                        <!-- <label for="quantity">Quantity:</label> -->
                        <div class="quantity-control">
                            <button class="minus-btn" id="minusBtn">-</button>
                            <input
                                type="number"
                                class="quantity"
                                name="quantity"
                                value="1"
                                min="1"
                            />
                            <button class="plus-btn" id="plusBtn">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php    }
            ?>

            <a href = "../checkout/check-out.php"><b>CHECKOUT</b></a>


        </div>
        <script src="cart.js"></script>
    </body>
</html>
