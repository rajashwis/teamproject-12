<?php
    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 

    if (isset($_GET['searchTerm'])) {
        $searchTerm = $_GET['searchTerm'];
        
        $query = "SELECT * FROM PRODUCT WHERE CONCAT(product_name, description_) LIKE '%$searchTerm%'";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Sort Product</title>
    <link rel="stylesheet" href="search_and_sort.css">
</head>
<body>
    <?php
        include '../components/header.php';
    ?>



    <main class="container">

        <div class="offer-banner">
            <input type="text" name="offerText" class="offerText" placeholder=" Special Offer Here">
        </div>


        <div class="main">


            <section class="shop">
                <!-- <select id="options">
                    <option value="A">Butcher</option>
                    <option value="B">Greengrocer</option>
                    <option value="C">Fishmonger</option>
                    <option value="D">Bakery</option>
                    <option value="E">Delicatessen</option>
                </select> -->

                <div class="filters">
                    Shop:
                    <label><input type="checkbox" id="cat1"> Category 1</label>
                    <label><input type="checkbox" id="cat2"> Category 2</label>
                    <label><input type="checkbox" id="cat3"> Category 3</label>
                </div>

                <div class="filters">
                    Categories:
                    <label><input type="checkbox" id="cat1"> Category 1</label>
                    <label><input type="checkbox" id="cat2"> Category 2</label>
                    <label><input type="checkbox" id="cat3"> Category 3</label>
                </div>

                <div class="filters">
                    Discount:
                    <label><input type="checkbox" id="cat1"> Category 1</label>
                    <label><input type="checkbox" id="cat2"> Category 2</label>
                    <label><input type="checkbox" id="cat3"> Category 3</label>
                </div>

            </section>




            <div class="image-container-group">

                <!-- box1-->

                <?php

                while($product=oci_fetch_assoc($statement)) {

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

                    echo '<div class="image-container">';
                    echo '<div class="image-box">';
                    echo '<a href = "../product_detail/product_detail.php?product_id='.$product_id.'"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                    echo '</div>';
                    echo '<div class="description-box">';
                    echo '<h1>'.$product['PRODUCT_NAME'].'</h1></a>';

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
                    
                    // echo '<p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>';
                    echo '<div class="bakery">';
                    echo '<p>'.$category.'</p>';
                    echo '</div>';
                    echo '<button class="add-to-cart"><a href="cart.html">Add to Cart</a></button>';
                    echo '</div>';
                    echo '</div>';
                }

                ?>
            </div>




            <!-- <aside class="sort-by">
                <label for="sort">Sort by:</label>
                <select id="sort">
                    <option value="price">Price</option>
                    <option value="name">Rating</option>
                </select>
            </aside> -->

        </div>
    </main>

    <?php
    include '../HN/footer.php';
    ?>

</body>
</html>