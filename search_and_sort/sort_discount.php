<?php
    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 

        
    if (isset($_GET['discount'])) {

        $discountchecked = [];
        $discountchecked = $_GET['discount'];

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
        include '../components/header.php';
    ?>



    <main class="container">

        <div class="offer-banner">
            <input type="text" name="offerText" class="offerText" placeholder=" Special Offer Here">
        </div>


        <div class="main">

            <section class="shop">
                <form method="GET" action="">
                    <select name="sort-products" id="options">
                        <option value="default" <?php if(isset($_GET['sort-products']) && ($_GET['sort-products']) == 'product_name') { echo "selected"; } ?>>--Sort By--</option>
                        <option value="product_name" <?php if(isset($_GET['sort-products']) && ($_GET['sort-products']) == 'product_name') { echo "selected"; } ?>>Product Name</option>
                        <option value="price" <?php if(isset($_GET['sort-products']) && ($_GET['sort-products'])  == 'price') { echo "selected"; } ?>>Price</option>
                        <option value="date_added_desc" <?php if(isset($_GET['sort-products']) && ($_GET['sort-products'])  == 'date_added_desc') { echo "selected"; } ?>>Date Added (Newest First)</option>
                        <option value="date_added_asc" <?php if(isset($_GET['sort-products']) && ($_GET['sort-products'])  == 'date_added_asc') { echo "selected"; } ?>>Date Added (Oldest First)</option>
                    </select>
            
                <div class="filters">
                    Categories:
                    <?php

                        $query1 = "SELECT * FROM DISCOUNT";
                        $statement1 = oci_parse($connection, $query1);
                        oci_execute($statement1);
                       

                        while($discount = oci_fetch_assoc($statement1)) {
                            $checked = [];

                            if(isset($_GET['discount'])) {
                                $checked = $_GET['discount'];
                            }

                            ?>

                            <label><input type="checkbox" name="discount[]" value="<?php echo $discount['DISCOUNT_ID']; ?>" <?php if(in_array($discount['DISCOUNT_ID'], $checked)) { echo "checked"; } ?>> 
                                
                                <?php echo $discount['DISCOUNT_PERCENTAGE']; ?>
                            </label>


                        <?php } ?>

                </div>

                <input type="submit" value="submit">

                </form>

            </section>




            <div class="image-container-group">
                <?php

                $sort_product = "";
                
                if(isset($_GET['sort-products'])) {

                    if (($_GET['sort-products'] == "product_name") || ($_GET['sort-products'] == "default")) {
                        $sort_product = "PRODUCT_NAME";
                    }

                    else if ($_GET['sort-products'] == "price") {
                        $sort_product = "PRICE";
                    }

                    else if ($_GET['sort-products'] == "date_added_desc") {
                        $sort_product = "DATE_ADDED DESC";
                    }

                    else if ($_GET['sort-products'] == "date_added_asc") {
                        $sort_product = "DATE_ADDED";
                    }

                }

                if($discountchecked) {

                    $discount_list = implode(",", array_map('intval', $discountchecked));

                    $query1 = "SELECT * FROM PRODUCT WHERE DISCOUNT_ID IN ($discount_list) ORDER BY $sort_product";
                    $statement1 = oci_parse($connection, $query1);
                    oci_execute($statement1);
                       
                    while($product=oci_fetch_assoc($statement1)) {

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


                else {

                    $query = "SELECT * FROM PRODUCT ORDER BY $sort_product";
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


                ?>
            </div>
        </div>
    </main>

    <?php
    include '../components/footer.php';
    ?>

</body>
</html>