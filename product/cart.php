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
    <?php
        include '../HN/navbar.php';

        while($cart = oci_fetch_assoc($stid)) { 
            $product_id = $cart['PRODUCT_ID'];

            $query1 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $product_id";
            $stid1=oci_parse($connection, $query1);
            oci_execute($stid1);
            $product = oci_fetch_assoc($stid1);
    ?> 

    <div class="container">

        <form method = "GET">

            <div class="card">
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
                    <h3><?php echo $product['PRODUCT_NAME'] ?></h3>

                    <div class="price">
                        <?php
                            $query1 = "SELECT 
                                p.*, 
                                d.discount_percentage, 
                                p.price * (1 - d.discount_percentage / 100) AS discounted_price
                            FROM 
                                product p
                            JOIN 
                                shop s ON p.shop_id = s.shop_id
                            JOIN 
                                discount d ON p.discount_id = d.discount_id 
                                        AND s.trader_id = d.trader_id
                            WHERE
                                product_id = $product_id";

                            $stid1=oci_parse($connection, $query1);
                            oci_execute($stid1);
                            $discount_product = oci_fetch_assoc($stid1);

                            $product_id = $discount_product['PRODUCT_ID'];
                            $discount_id = $discount_product['DISCOUNT_ID'];

                            if($discount_id) {
                                echo '<p>Price: <s>'.$product['PRICE'].'</s>   '.$discount_product['DISCOUNTED_PRICE'].'<i class="fa-solid fa-tag"></i></p>';
                            }
                            else {
                                echo '<p><br>'.$product['PRICE'].'&nbsp<i class="fa-solid fa-tag"></i></p>';
                            }
                        ?>
                    </div>

                    <label for="quantity-control">Quantity:</label>
                    <div class="quantity-control">
                        <button class="minus-btn" id="minusBtn">-</button>
                        <input type="number" class="quantity" name="quantity" value="1" min="1" />
                        <button class="plus-btn" id="plusBtn">+</button>
                    </div>

                    <div class="btn-remove">
                        <button type="submit" name="removeBtn" class="btn">Remove</button>
                    </div>
                </div>
            </div>

            <?php } ?>
                        
            <button type="submit" class="checkout" id="checkoutBtn" name="checkoutBtn">Checkout</button>

        </form>
    </div>
    <?php
        include '../HN/footer.php';
    ?> 

    <script src="cart.js"></script>
</body>
</html>
