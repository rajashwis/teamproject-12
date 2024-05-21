<?php
    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 

        
    if (isset($_GET['category'])) {

        $categorychecked = [];
        $categorychecked = $_GET['category'];

    }

    else {
        $query = "SELECT * FROM PRODUCT";
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
    <link rel="stylesheet" href="search_sort.css">
</head>
<body>
    <?php
    include '../component/header.php';
    ?>



    <main class="container">

        <div class="offer-banner">
            <input type="text" name="offerText" class="offerText" placeholder=" Special Offer Here">
        </div>


        <div class="main">

            <section class="shop">
                <form method="GET" action="">
                    <select name="sort-products" id="options">
                        <option value="">--Sort By--</option>
                        <option value="popularity" <?php if(isset($_GET['sort-products']) && (isset($_GET['sort-products']) == 'popularity')) { echo "selected"; } ?>>Popularity</option>
                        <option value="product_name" <?php if(isset($_GET['sort-products']) && (isset($_GET['sort-products'])  == 'product_name')) { echo "selected"; } ?>>Product Name</option>
                        <option value="price" <?php if(isset($_GET['sort-products']) && (isset($_GET['sort-products'])  == 'price')) { echo "selected"; } ?>>Price</option>
                        <option value="rating" <?php if(isset($_GET['sort-products']) && (isset($_GET['sort-products'])  == 'rating')) { echo "selected"; } ?>>Rating</option>
                    </select>
            
                <div class="filters">
                    Categories:
                    <?php

                        $query1 = "SELECT * FROM PRODUCTCATEGORY";
                        $statement1 = oci_parse($connection, $query1);
                        oci_execute($statement1);
                       

                        while($category = oci_fetch_assoc($statement1)) {
                            $checked = [];

                            if(isset($_GET['category'])) {
                                $checked = $_GET['category'];
                            }

                            ?>

                            <label><input type="checkbox" name="category[]" value="<?php echo $category['CATEGORY_ID']; ?>" <?php if(in_array($category['CATEGORY_ID'], $checked)) { echo "checked"; } ?>> 
                                
                                <?php echo $category['CATEGORY_NAME']; ?>
                            </label>


                        <?php } ?>

                </div>

                <input type="submit" value="submit">

                </form>

            </section>




            <div class="image-container-group">
                <?php
                
                if($categorychecked) {
                    foreach ($categorychecked as $rowcategory) {
                        $rowcategory = intval($rowcategory);
                        
                        $query = "SELECT * FROM PRODUCT WHERE CATEGORY_ID = $rowcategory";
                        $statement = oci_parse($connection, $query);
                        oci_execute($statement);
                       
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
                            // echo '<!--<a href = "../product_detail/product_detail.php?product_id='.$product_id.'">--> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                            echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                            echo '</div>';
                            echo '<div class="description-box">';
                            echo '<h1>'.$product['PRODUCT_NAME'].'</h1>';
        
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
                    }
                }

                else {
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
                        // echo '<!--<a href = "../product_detail/product_detail.php?product_id='.$product_id.'">--> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                        echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                        echo '</div>';
                        echo '<div class="description-box">';
                        echo '<h1>'.$product['PRODUCT_NAME'].'</h1>';

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
                }


                ?>
            </div>
        </div>
    </main>

    <?php
    include '../HN/footer.php';
    ?>

</body>
</html>