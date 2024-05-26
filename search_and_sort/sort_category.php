<?php
session_start();
error_reporting(0);

include "../connect.php";

$user = $_SESSION['user_id'];

// Initialize variables for category and sorting
$categorychecked = [];
$sort_product = "PRODUCT_NAME"; // Default sorting

// Check if category or sort options are set in the GET request
if (isset($_GET['category'])) {
    $categorychecked = $_GET['category'];
}

if (isset($_GET['sort-products'])) {
    $sort_options = [
        "default" => "PRODUCT_NAME",
        "product_name" => "PRODUCT_NAME",
        "price" => "PRICE",
        "date_added_desc" => "DATE_ADDED DESC",
        "date_added_asc" => "DATE_ADDED"
    ];
    $sort_product = $sort_options[$_GET['sort-products']] ?? "PRODUCT_NAME";
}

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
    <title>Search and Sort Product</title>
    <link rel="stylesheet" href="search_sort.css">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <main class="container">
        <div class="offer-banner">
            <input type="text" name="offerText" class="offerText" placeholder="Special Offer Here">
        </div>

        <div class="main">
            <section class="shop">
                <form method="GET" action="">
                    <select name="sort-products" id="options">
                        <option value="default" <?= (isset($_GET['sort-products']) && $_GET['sort-products'] == 'default') ? "selected" : ""; ?>>--Sort By--</option>
                        <option value="product_name" <?= (isset($_GET['sort-products']) && $_GET['sort-products'] == 'product_name') ? "selected" : ""; ?>>Product Name</option>
                        <option value="price" <?= (isset($_GET['sort-products']) && $_GET['sort-products'] == 'price') ? "selected" : ""; ?>>Price</option>
                        <option value="date_added_desc" <?= (isset($_GET['sort-products']) && $_GET['sort-products'] == 'date_added_desc') ? "selected" : ""; ?>>Date Added (Newest First)</option>
                        <option value="date_added_asc" <?= (isset($_GET['sort-products']) && $_GET['sort-products'] == 'date_added_asc') ? "selected" : ""; ?>>Date Added (Oldest First)</option>
                    </select>
            
                    <div class="filters">
                        Categories:
                        <?php
                        $query1 = "SELECT * FROM PRODUCTCATEGORY";
                        $statement1 = oci_parse($connection, $query1);
                        oci_execute($statement1);

                        while ($category = oci_fetch_assoc($statement1)) {
                            $checked = in_array($category['CATEGORY_ID'], $categorychecked) ? "checked" : "";
                            ?>
                            <label>
                                <input type="checkbox" name="category[]" value="<?= $category['CATEGORY_ID']; ?>" <?= $checked; ?>> 
                                <?= $category['CATEGORY_NAME']; ?>
                            </label>
                        <?php } ?>
                    </div>

                    <input class="sort-btn" type="submit" value="submit">
                </form>
            </section>

            <div class="image-container-group">
                <?php
                if (!empty($categorychecked)) {
                    $category_list = implode(",", array_map('intval', $categorychecked));
                    $query = "SELECT * FROM PRODUCT WHERE CATEGORY_ID IN ($category_list) ORDER BY $sort_product";
                } else {
                    $query = "SELECT * FROM PRODUCT ORDER BY $sort_product";
                }

                $statement = oci_parse($connection, $query);
                oci_execute($statement);

                while ($product = oci_fetch_assoc($statement)) {
                    $product_id = $product['PRODUCT_ID'];
                    
                    // Handling image data
                    $imageData = $product['PRODUCT_IMAGE']->load();
                    $encodedImageData = base64_encode($imageData);
                    $header = substr($imageData, 0, 4);
                    $imageType = (strpos($header, 'FFD8') === 0) ? 'image/jpeg' : ((strpos($header, '89504E47') === 0) ? 'image/png' : 'image/jpeg');

                    // Fetching discount details
                    $query2 = "SELECT 
                                p.*, 
                                d.DISCOUNT_PERCENTAGE, 
                                p.PRICE * (1 - d.DISCOUNT_PERCENTAGE / 100) AS DISCOUNTED_PRICE
                               FROM 
                                PRODUCT p
                               LEFT JOIN 
                                SHOP s ON p.SHOP_ID = s.SHOP_ID
                               LEFT JOIN 
                                DISCOUNT d ON p.DISCOUNT_ID = d.DISCOUNT_ID AND s.TRADER_ID = d.TRADER_ID
                               WHERE
                                p.PRODUCT_ID = $product_id";
                    $statement2 = oci_parse($connection, $query2);
                    oci_execute($statement2);
                    $discount_product = oci_fetch_assoc($statement2);

                    $product_price = $discount_product['PRICE'];
                    $discounted_price = $discount_product['DISCOUNTED_PRICE'];

                    echo '<div class="image-container">';
                    echo '<div class="image-box">';
                    echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                    echo '</div>';
                    echo '<div class="description-box">';
                    echo '<h1>' . $product['PRODUCT_NAME'] . '</h1>';

                    if($discounted_price) {
                        echo '<p class="price"><strike>'.$product_price.'</strike> '.$discounted_price.' <i class="fa-solid fa-tag"></i></p>';
                    }
                    else {
                        echo '<p class="price">'.$product_price.'<i class="fa-solid fa-tag"></i></p>';  
                    }
                    
                    echo '<div class="bakery">';
                    echo '</div>';
                    echo '<button class="add-to-cart"><a href="cart.html">Add to Cart</a></button>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </main>

    <?php include '../HN/footer.php'; ?>
</body>
</html>
