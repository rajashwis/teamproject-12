<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 

    if (isset($_GET['searchTerm'])) {
        $searchTerm = $_GET['searchTerm'];
        header('Location: ../product/search_sort_product.php?searchTerm='.$searchTerm.'');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>CFXLocalHub HOME PAGE</title>
</head>
<body>
    <div class="home-page">
       <?php 
            include '../components/header.php';
       ?>
         <!--products-->
         <div class="container">
            <div class="card">
                
                <?php 
                    $query = "SELECT 
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
                    ORDER BY 
                        DBMS_RANDOM.VALUE";

                    $stid=oci_parse($connection, $query);
                    oci_execute($stid);
                    $product = oci_fetch_assoc($stid);

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
                    $query1 = "SELECT CATEGORY_NAME FROM PRODUCTCATEGORY WHERE CATEGORY_ID = $category_id";
                    $stid1=oci_parse($connection, $query1);
                    oci_execute($stid1);
                    $category = oci_fetch_assoc($stid1);
                    $category = $category['CATEGORY_NAME'];

                    echo '<div class="image-container">';
                    echo '<a href = "../product_detail/product_detail.php?product_id='.$product_id.'"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                    echo '</div>';
                    echo '<h1><font color="black">'.$product['PRODUCT_NAME'].'</font></h1></a>';
                    echo '<p class="price"><s>'.$product['PRICE'].'</s><br>'.$product['DISCOUNTED_PRICE'].'<i class="fa-solid fa-tag"></i></p>';
                    echo '<p><a href="#"><font color="black">'.$category.'</font></a></p>';
                    echo '<p><button>Buy</button></p><br>';
                
                ?>
            
            </div>
        </div>

        <!--slide-->
        <div class="slideshow-container">
            <div class="slides">
                <?php 
                    $query = "SELECT * FROM (SELECT * FROM DISCOUNT ORDER BY DBMS_RANDOM.VALUE) WHERE ROWNUM <= 3";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);

                    while($banner=oci_fetch_assoc($statement)) {

                        $imageData = $banner['DISCOUNT_IMAGE']->load();
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
                    }
                ?>
            </div>
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>
        </div>
    </div>
    <!--Sales-->
    <div class="home-page2">
        <label class="text-sales">Sales:</label>
        <div class="container-4">

            <?php 
                $query = "SELECT 
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
                WHERE ROWNUM <= 3";

                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                while(($product=oci_fetch_assoc($statement))) {

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
                    $query1 = "SELECT CATEGORY_NAME FROM PRODUCTCATEGORY WHERE CATEGORY_ID = $category_id";
                    $stid1=oci_parse($connection, $query1);
                    oci_execute($stid1);
                    $category = oci_fetch_assoc($stid1);
                    $category = $category['CATEGORY_NAME'];

                    echo '<div class="card-4">';
                    echo '<div class="image-container">';
                    echo '<a href = "../product_detail/product_detail.php?product_id='.$product_id.'"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                    echo '</div>';
                    echo '<h1><font color="black">'.$product['PRODUCT_NAME'].'</font></h1></a>';
                    echo '<p class="price"><s>'.$product['PRICE'].'</s><br>'.$product['DISCOUNTED_PRICE'].'<i class="fa-solid fa-tag"></i></p>';
                    echo '<p><a href="#"><font color="black">'.$category.'</font></a></p>';
                    echo '<p><button>Buy</button></p><br>';
                    echo '</div>';


                }
            ?>

        </div>
        
    </div>
    <!--New-->
    <div class="new-item">
        <label class="text-new">New:</label>
        <div class="box">

            <?php
                $query = "SELECT * FROM PRODUCT ORDER BY date_added DESC";
                $stid=oci_parse($connection, $query);
                oci_execute($stid);
                $count = 0;
                
                while(($product = oci_fetch_assoc($stid)) && $count < 3) {
                    $product_id = $product['PRODUCT_ID'];
                    $count++;

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

                    echo '<div class="card-5">';
                    echo '<div class="image-container">';
                    echo '<a href = "../product_detail/product_detail.php?product_id='.$product_id.'"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"  style="width:100%"></a><br><br>';
                    echo '</div></div>';

                }
            ?>
        </div>    
    </div>
    <!--For you-->
    <div class="for-you">
        <label class="text-foryou">For You:</label>
        <div class="container-5">

            <?php
                $query = "SELECT *
                FROM (
                    SELECT *
                    FROM PRODUCT
                    ORDER BY DBMS_RANDOM.VALUE
                )
                WHERE ROWNUM <= 6";
                $stid=oci_parse($connection, $query);
                oci_execute($stid);

                while(($product = oci_fetch_assoc($stid))) {
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
                    $query1 = "SELECT CATEGORY_NAME FROM PRODUCTCATEGORY WHERE CATEGORY_ID = $category_id";
                    $stid1=oci_parse($connection, $query1);
                    oci_execute($stid1);
                    $category = oci_fetch_assoc($stid1);
                    $category = $category['CATEGORY_NAME'];

                    echo '<div class="card-6">';
                    echo '<div class="image-container">';
                    echo '<a href = "../product_detail/product_detail.php?product_id='.$product_id.'">';
                    echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                    echo '</div>';
                    echo '<h1><font color="black">'.$product['PRODUCT_NAME'].'</font></h1>';
                    echo '</a>';

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
                        echo '<p class="price"><s>'.$product['PRICE'].'</s><br>'.$discount_product['DISCOUNTED_PRICE'].'<i class="fa-solid fa-tag"></i></p>';
                    }
                    else {
                        echo '<p class="price"><br>'.$product['PRICE'].'&nbsp<i class="fa-solid fa-tag"></i></p>';
                    }

                    echo '<a href = "../category/categories.php?category='.$category.'">';
                    echo '<p><font color="black">'.$category.'</font></p>';
                    echo '</a>';
                    echo '<p><button>Buy</button></p><br>';
                    echo '</div>';
                }

            ?>
        </div>
            <br><br><br><br><br><br><br><br><br><br><br>
            <!--map-->
            <div class="location">
                <p><i class="fa-solid fa-location-dot"></i> Location</p><br>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d441.60166153526745!2d85.31895302088176!3d27.692164950951184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1711632997867!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            
            <!--footer-->
                        <?php include '../components/footer.php'?> 
            </div>



</script>
</body>
</html>

