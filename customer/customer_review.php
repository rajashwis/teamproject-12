<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 

    if(isset($_SESSION['user_id'])) {
        $customer_id = $_SESSION['user_id'];
    }
    else {
        echo '<script>
        alert("Sorry, you need to be logged in to access this!");
        window.location.href = "../homepage/home.php";
        </script>';
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="customer_review.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Customer Reviews</title>
</head>
<body>
   
    <?php 
        include('../components/header.php');
    ?>

    
    <h2 class="heading">MY REVIEWS</h2>
    <div class="container">
        <div class="menu">
            <ul>
                <li><a href="customer_profile.php">My Profile</a></li>
                <li><a href="customer_order.php">My Order</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a class="active" href="customer_review.php">Reviews</a></li>
            </ul>
            </ul>
        </div>
        <div class="cart-heading">

            <?php 
                $query = "SELECT R.*, P.PRODUCT_NAME, S.SHOP_NAME, P.PRODUCT_IMAGE
                    FROM REVIEW R
                    JOIN PRODUCT P ON P.PRODUCT_ID = R.PRODUCT_ID
                    JOIN SHOP S ON P.SHOP_ID = S.SHOP_ID
                    JOIN CUSTOMER C ON C.CUSTOMER_ID = R.CUSTOMER_ID
                    WHERE C.CUSTOMER_ID = $customer_id";
                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                while($review = oci_fetch_assoc($statement)){

                    $imageData = $review['PRODUCT_IMAGE']->load();

                    // Encode the BLOB data as base64
                    $encodedImageData = base64_encode($imageData);

                    // Determine the image type based on the first few bytes of the image data
                    $header = substr($imageData, 0, 4);
                    $imageType = 'image/jpeg'; // default to JPEG
                    if (strpos($header, 'FFD8') === 0) {
                        $imageType = 'image/jpeg'; // JPEG
                    } elseif (strpos($header, '89504E47') === 0) {
                        $imageType = 'image/png'; // PNG
                    }

                ?>
                    <div class="product-item">
                    <?php echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Product Image">';?>
                    <div class="product-details">
                        <h3><?php echo $review['PRODUCT_NAME'];?></h3>
                        <p><?php echo $review['SHOP_NAME'];?></p>
                        <div class="rating">
                            <?php

                            $rating = $review['RATING'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="fas fa-star"></i>'; // Full star
                                } else {
                                    echo '<i class="far fa-star"></i>'; // Empty star
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="additional-info">
                        <p><?php echo $review['COMMENT_'];?></p>
                        <div class="additional-info-ctrl">

                            <button class="delete">Delete</button>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>

        </div>
    </div>


</body>
</html>

