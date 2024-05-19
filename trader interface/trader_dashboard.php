<?php

    session_start();
    include "../connect.php";

    $trader = $_SESSION['user_id']; 

    if(!$trader) {
        header("Location: trader login.html");
        exit();
    }

    $query = "SELECT * FROM SHOP WHERE TRADER_ID = $trader";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);
    $shop = oci_fetch_assoc($stid);
    $shop_id = $shop['SHOP_ID'];

    $query1 = "SELECT * FROM PRODUCT WHERE SHOP_ID = $shop_id";
    $statement = oci_parse($connection, $query1);
    oci_execute($statement);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Sort Product</title>
    <link rel="stylesheet" href="trader_dashboard.css">
</head>
<body>


    <main class="container">

        <div class="navbar-trader">

            <div class="trader-profile">
                <img src="../resources/user.jpg" alt="trader_profile">
                <h4>John Cena</h4>
            </div>

            <button class="logout">
                Logout
            </button>
        </div>

        


        <div class="main">
            <!-- <div class="menu">
                <ul>
                    <li><a class="active" href="">Dashboard</a></li>
                    <li><a href="">Shop</a></li>
                    <li><a href="">Product</a></li>
                    <li><a href="">Orders</a></li>
                </ul>
            </div> -->
            <div class="vertical-nav">
        <ul>
            <li><a class="active" href="#">Dashboard</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">Order</a></li>
            <li><a  href="desktop10.html">Discount</a></li>
        </ul>
    </div>



            <div class="image-container-group">
                <!-- box1-->
                <?php 
                    while ($product = oci_fetch_assoc($statement)) {
                        $product_id = $product['PRODUCT_ID'];
                    
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

                        $category_id = $product['CATEGORY_ID'];
                        $query2 = "SELECT CATEGORY_NAME FROM PRODUCTCATEGORY WHERE CATEGORY_ID = $category_id";
                        $stid2=oci_parse($connection, $query2);
                        oci_execute($stid2);
                        $category = oci_fetch_assoc($stid2);
                        $category = $category['CATEGORY_NAME'];

                        echo '<div class="image-container">';
                        echo '<div class="image-box">';
                        echo '<a href = "../product_detail/product_detail.php?product_id='.$product_id.'">';
                        echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                        echo '</div>';
                        echo '<div class="description-box">';
                        echo '<h1>'.$product['PRODUCT_NAME'].'</h1></a>';

                        $query3 = "SELECT 
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

                        $stid3=oci_parse($connection, $query3);
                        oci_execute($stid3);
                        $discount_product = oci_fetch_assoc($stid3);

                        echo '<div class="category">';

                        if($discount_product) {
                            $discount_id = $discount_product['DISCOUNT_ID'];
                            echo '<p class="price"><s>'.$product['PRICE'].'</s><br>'.$discount_product['DISCOUNTED_PRICE'].'<i class="fa-solid fa-tag"></i></p>';
                        }
                        else {
                            echo '<p class="price"><br>'.$product['PRICE'].'&nbsp<i class="fa-solid fa-tag"></i></p>';
                        }
                       

                        // echo '<p class="price">$49.99 <i class="fa-solid fa-tag"></i></p><br>';
                        echo '<h3>Bakery</h3>';
                        echo '</div>';
                        echo '<!-- <button class="add-to-cart"><a href="cart.html">Add to Cart</a></button> -->';
                        echo '</div>';
                        echo '</div>';


                    }
                ?>





            </div>






        </div>
    </main>



</body>
</html>