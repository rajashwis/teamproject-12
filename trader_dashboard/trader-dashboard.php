<?php

    session_start();
    error_reporting(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../connect.php";

    if(isset($_SESSION['trader_id'])) {
        $trader_id = $_SESSION['trader_id'];

        $shop_query = "SELECT * FROM SHOP WHERE TRADER_ID = $trader_id";
        $shop_statement = oci_parse($connection, $shop_query);
        oci_execute($shop_statement);

        $shop = oci_fetch_assoc($shop_statement);
        $shop_id = $shop['SHOP_ID'];
        $shop_name = $shop['SHOP_NAME'];
        $shop_address = $shop['ADDRESS'];
    }

    else {
        header('Location: ../component/home.php');    
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category'])) {
        $edit_category_id = $_POST['editCategoryId'];
        $edit_category_name = $_POST['editCategoryName'];
    
    
        $query = "UPDATE PRODUCTCATEGORY SET CATEGORY_NAME = '$edit_category_name' WHERE CATEGORY_ID = $edit_category_id";
        $statement = oci_parse($connection, $query);
    
        if (oci_execute($statement)) {
            // Redirect to the same page to prevent form resubmission
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $e = oci_error($statement);
            echo "Error updating category: " . $e['message'];
        }
    
        oci_free_statement($statement);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
        $add_category_name = $_POST['addCategoryName'];
    
        $query = "INSERT INTO PRODUCTCATEGORY VALUES(SEQ_CATEGORY_ID.NEXTVAL, '$add_category_name', $trader_id)";
        $statement = oci_parse($connection, $query);
    
        if (oci_execute($statement)) {
            // Redirect to the same page to prevent form resubmission
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $e = oci_error($statement);
            echo "<script>alert('Error inserting category: " . $e['message']."')";
        }
    
        oci_free_statement($statement);
    }

    ?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="trader-dashboard.css">
    <title>Document</title>
</head>
<style>


    /*Products*/

.product-card {
    width: 200px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    margin: 10px;
    overflow: hidden;
}

.product-card span{
    display: block;
    margin: 10px;

}

.product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.product-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(1, auto);
    gap: 20px;
    margin-left: 13%;
}

.add-product-btn {
    margin: 20px;
    font-size: 16px;
    border: none;
    background-color: #f99f1b;
    position: relative;
    padding: 10px;
    left: 80%;
    border-radius: 10px;
    cursor: pointer;
}

.add-product-btn a{
    text-decoration: none;
    color: black;
}

.add-product-btn a:hover{
    color: white;
}

.category-option{
    padding: 10px;
    border-radius: 10px;
}

.filter-btn{
    padding: 10px;
    border: 1px solid black;
    border-radius: 10px;
    background-color: white;
    cursor: pointer;
}

/* Orders */

.order-table-container {
    overflow-x: auto;
}

.order-table {
    border-collapse: collapse;
    width: 100%;
}

.order-table th,
.order-table td {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.order-table th {
    background-color: #b0b0b0;
}

.order-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.order-table tbody tr:hover {
    background-color: #ddd;
}

.order-table button{
    border: 1px solid black;
    cursor: pointer;
    border-radius: 3px;
    padding: 5px;
}

.order-table button:hover{
    background-color: #bebebe;
}

/* category */

.category-table-container {
    overflow-x: auto;
}

.category-table {
    border-collapse: collapse;
    width: 100%;
}

.category-table th,
.category-table td {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.category-table th {
    background-color: #b0b0b0;
}

.category-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.category-table tbody tr:hover {
    background-color: #ddd;
}

.category-table button{
    border: 1px solid black;
    cursor: pointer;
    border-radius: 3px;
    padding: 5px;
}

.category-table button:hover{
    background-color: #bebebe;
}


/*shop*/
.shop-container {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
}

.shop-info {
    display: flex;
    align-items: center;
}

.shop-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 20px;
}

.shop-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.shop-details {
    flex: 1;
}

#shopName {
    margin-bottom: 5px;
    font-size: 20px;
    font-weight: bold;
}

#shopAddress {
    margin-bottom: 10px;
    font-size: 16px;
}

#editShopBtn {
    background-color: #f99f1b;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
}

#editShopBtn:hover {
    background-color: #f77f00;
}

.popup {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.popup-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
}

.popup-content input{
    display: block;
    margin: 10px;
}

.popup-content button{
    border: none;
    background-color: #f99f1b;
    padding: 10px;
    border-radius: 10px;
    cursor: pointer;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}


.category-popup-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 80%;
    max-width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.category-popup-content button{
    cursor: pointer;
}


/*discount*/

.discount-table-container {
    position: relative;
    right: 20%;
    top: 15%;
    border: 1px solid black;
}

.discount-table {
    border-collapse: collapse;
    width: 100%;
}

.discount-table th,
.discount-table td {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    width: 700px;
}

.discount-table th {
    background-color: #b0b0b0;
}

.discount-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.discount-table tbody tr:hover {
    background-color: #ddd;
}

.discount-table button{
    border: 1px solid black;
    cursor: pointer;
    border-radius: 3px;
    padding: 5px;
}

.discount-table a{
    color: rgb(0, 0, 0);
    text-decoration: none;
}

.discount-table button:hover{
    background-color: #bebebe;
}


.text{
    position: relative;
    top: 15%;
    right: 20%;
}

</style>

<body>
    <div class="navbar">
        <div class="profile">
        <div class="profile-img">
                <a href="view-profile.php"><img src="../resources/dummy images/dummy_product.png" alt="Profile Picture"></a>
            </div>
            <span>Trader Name</span>
        </div>
        <a href="../sign_out.php"><button class="sign-out-btn">Sign Out</button></a>
    </div>


    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="#dashboard" onclick="showContent('dashboard')"><i class="fa-solid fa-chart-simple"></i> Dashboard</a></li>
                <li><a href="#products" onclick="showContent('products')"><i class="fa-solid fa-box-open"></i> Products</a></li>
                <li><a href="#orders" onclick="showContent('orders')"><i class="fa-solid fa-truck-fast"></i> Orders</a></li>
                <li><a href="#shop" onclick="showContent('shop')"><i class="fa-solid fa-shop"></i> Shop</a></li>
                <li><a href="#discount" onclick="showContent('discount')"><i class="fa-solid fa-tag"></i> Discount</a></li>
                <li><a href="http://localhost:8080/apex/f?p=4550:1:4922449651102:::::"><i class="fa-solid fa-chart-pie"></i> Reports</a></li>


            </ul>
        </div>
        <div class="main-content">
            <div id="dashboard" class="content active">
                <h1>Dashboard</h1>
                <div class="stats">
                    <div>Total Sales: $10,000</div>
                    <div>Visitors: 5,000</div>
                    <div>Total Orders: 1,200</div>
                    <div>Refunded: $500</div>
                </div>
                <!-- <div class="graph">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div> -->
        
                <div class="top-items">
                    <h2>Top Selling Items</h2>
                    <ul>

                        <?php 
                            $query6 = "SELECT * FROM (
                                SELECT P.PRODUCT_ID, P.PRODUCT_NAME, COUNT(OP.PRODUCT_ID) AS ORDER_PRODUCT_COUNT
                                FROM ORDERPRODUCT OP
                                JOIN PRODUCT P ON P.PRODUCT_ID = OP.PRODUCT_ID
                                JOIN SHOP S ON P.SHOP_ID = S.SHOP_ID
                                WHERE S.TRADER_ID = $trader_id
                                GROUP BY P.PRODUCT_ID, P.PRODUCT_NAME
                                ORDER BY ORDER_PRODUCT_COUNT DESC
                            )
                            WHERE ROWNUM <= 5";
                            
                            $statement6 = oci_parse($connection, $query6);
                            oci_execute($statement6);

                            while($order_product = oci_fetch_assoc($statement6)) {
                                $order_product_id = $order_product['PRODUCT_ID'];

                                $image_query = "SELECT PRODUCT_IMAGE FROM PRODUCT WHERE PRODUCT_ID = $order_product_id";
                                $image_statement = oci_parse($connection, $image_query);
                                oci_execute($image_statement);

                                $order_product_image = oci_fetch_assoc($image_statement);

                                echo '<li class="item">';

                                if ($order_product_image['PRODUCT_IMAGE'] !== null && $order_product_image['PRODUCT_IMAGE']->load()) {
                                    $imageData = $order_product_image['PRODUCT_IMAGE']->load();
                                } else {
                                    // Use a dummy file if no file was uploaded
                                    $dummyFilePath = '../resources/user.jpg'; // Path to your dummy image file
                                    $imageData = file_get_contents($dummyFilePath);
                                }

                                $encodedImageData = base64_encode($imageData);
                                // Determine the image type based on the first few bytes of the image data
                                $header = substr($imageData, 0, 4);
                                $imageType = 'image/jpeg'; // default to JPEG
                                if (strpos($header, 'FFD8') === 0) {
                                    $imageType = 'image/jpeg'; // JPEG
                                } elseif (strpos($header, '89504E47') === 0) {
                                    $imageType = 'image/png'; // PNG
                                }
                                echo '<a href="edit-product.php?product_id='.$order_product_id.'"><img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"></a>';

                                // echo '<img src="../resources/products/bakery1.jpg" alt="Item 1">';
                                echo '<span>'.$order_product['PRODUCT_NAME'].'</span>';
                                echo '<span>Total Sold: '.$order_product['ORDER_PRODUCT_COUNT'].'</span>';
                                echo '</li>';
                            }
                            
                        ?>

                    </ul>
                </div>
                
                
            </div>
            <div id="products" class="content">
                <h1>Products</h1>
                <button class="add-product-btn"><a href="add-products.php"><i class="fa-solid fa-plus"></i> Add Product</a></button>

                <form method="GET">
                    <select class="category-option" name="category">

                        <option value="" >Select Category</option>

                        <?php
                        $query3 = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
                        $statement3 = oci_parse($connection, $query3);
                        oci_execute($statement3);

                        while ($category_list = oci_fetch_assoc($statement3)) {
                            $category_id_ = $category_list['CATEGORY_ID'];
                            $category_name = $category_list['CATEGORY_NAME'];

                            $selected = (isset($_GET['category']) && $_GET['category'] == $category_id_) ? ' selected' : '';
                            echo "<option value='" . htmlspecialchars($category_id_) . "' " . $selected . ">" . htmlspecialchars($category_name) . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" value="filter" class="filter-btn"><i class="fa-solid fa-filter"></i> Filter</button>
                </form>

                <div class="product-container">

                    <?php 

                        if (isset($_GET['category']) && $_GET['category'] != "") {
                            $category_id_filter = $_GET['category'];

                            $query1 = "SELECT * FROM PRODUCT WHERE SHOP_ID = $shop_id AND CATEGORY_ID = $category_id_filter";
                            $statement1 = oci_parse($connection, $query1);
                            oci_execute($statement1);

                        }

                        else {

                            $query1 = "SELECT * FROM PRODUCT WHERE SHOP_ID = $shop_id";
                            $statement1 = oci_parse($connection, $query1);
                            oci_execute($statement1);

                        }

                        while($product = oci_fetch_array($statement1)) {
                            
                            $product_id = $product['PRODUCT_ID'];
                            $category_id = $product['CATEGORY_ID'];

                            $query2 = "SELECT * FROM PRODUCTCATEGORY WHERE CATEGORY_ID = $category_id";
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);
                            $category = oci_fetch_assoc($statement2);
                            $category_name = $category['CATEGORY_NAME'];

                            echo '<div class="product-card">';
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
                            echo '<a href = "edit-product.php?product_id='.$product_id.'"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"></a>';


                            //echo '<img src="../resources/products/jordan.jpg" alt="Product 1">';

                            echo '<span>'.$product['PRODUCT_NAME'].'</span>';
                            echo '<span>Price: '.$product['PRICE'].'</span>';
                            echo '<a href="?category='.$category['CATEGORY_ID'].'"><span>'.$category_name.'</span></a>';
                            echo '<span>Stock Available: '.$product['STOCK_AVAILABLE'].'</span>';
                            echo '</div>';

                        }
                    ?>

                </div>
                
            </div>
            <div id="orders" class="content">
                <h1>Orders</h1>
                <div class="order-table-container">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Item Quantity</th>
                                <th>Collection Date</th>
                                <th>Collection Time</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php

                            $query = "SELECT
                                O.order_id,
                                u.first_name || ' ' || u.last_name AS customer_name,
                                P.product_name,
                                OP.item_quantity,
                                CS.day_of_week,
                                CS.time_slot,
                                O.collection_date, 
                                O.status
                            FROM 
                                Trader T
                                JOIN Shop S ON T.trader_id = S.trader_id
                                JOIN Product P ON S.shop_id = P.shop_id
                                JOIN OrderProduct OP ON P.product_id = OP.product_id
                                JOIN OrderDetail O ON OP.order_id = O.order_id
                                JOIN Customer C ON O.customer_id = C.customer_id
                                JOIN User_ U ON C.customer_id = U.user_id
                                JOIN CollectionSlot CS ON O.collection_slot_id = CS.collection_slot_id
                            WHERE 
                                T.trader_id = $trader_id
                            ORDER BY 
                                O.order_id";

                            $statement = oci_parse($connection, $query);
                            oci_execute($statement);

                            while($orderdetail = oci_fetch_assoc($statement)) {
                                echo '<tr>';
                                echo '<td>'.$orderdetail['ORDER_ID'].'</td>';
                                echo '<td>'.$orderdetail['CUSTOMER_NAME'].'</td>';
                                echo '<td>'.$orderdetail['PRODUCT_NAME'].'</td>';
                                echo '<td>'.$orderdetail['ITEM_QUANTITY'].'</td>';
                                echo '<td>'.$orderdetail['COLLECTION_DATE'].'</td>';
                                echo '<td>'.$orderdetail['TIME_'].'</td>';
                                echo '<td>'.$orderdetail['STATUS'].'</td>';
                                echo '<td><a href="order-details.php?order_id='.$orderdetail['ORDER_ID'].'"><button>View Order</button></a></td>';
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
           
            <div id="shop" class="content">
                <h1>Shop</h1>
                <div class="shop-container">
                    <div class="shop-info">
                        <?php                             
                        
                            if ($shop['SHOP_IMAGE'] !== null && $shop['SHOP_IMAGE']->load()) {
                                $imageData = $shop['SHOP_IMAGE']->load();
                            } else {
                                // Use a dummy file if no file was uploaded
                                $dummyFilePath = '../resources/user.jpg'; // Path to your dummy image file
                                $imageData = file_get_contents($dummyFilePath);
                            }

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
       
                            echo '<div class="shop-image">';
                            echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                            echo '</div>';
                            echo '<div class="shop-details">';
                            echo '<h2 id="shopName">'.$shop_name.'</h2>';
                            echo '<p id="shopAddress">'.$shop_address.'</p>';
                            echo '</div>';
                        ?>
        
                        <button type="button" id="editShopBtn"><a href="edit-shop.php?shop_id=<?php echo $shop_id;?>">Edit</a></button>
                    </div>
                </div>

                <h1>Category</h1>

                <?php
                    echo '<button onclick="openAddCategoryPopup()">Add Category</button>';
                ?>

                <div class="category-table-container">
                    <table class="category-table">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>No. of Products</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query4 = "SELECT 
                                        pc.*,
                                        COUNT(p.PRODUCT_ID) AS NUMBER_OF_PRODUCTS
                                    FROM 
                                        PRODUCTCATEGORY pc
                                    LEFT JOIN 
                                        PRODUCT p ON pc.CATEGORY_ID = p.CATEGORY_ID
                                    WHERE 
                                        pc.TRADER_ID = $trader_id
                                    GROUP BY 
                                        pc.CATEGORY_ID, pc.CATEGORY_NAME, pc.TRADER_ID";

                                //$query4 = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
                                $statement4 = oci_parse($connection, $query4);
                                oci_execute($statement4);

                                while ($category = oci_fetch_assoc($statement4)) {
                                    echo '<tr>';
                                    echo '<td>'.$category['CATEGORY_ID'].'</td>';
                                    echo '<td>'.$category['CATEGORY_NAME'].'</td>';
                                    echo '<td>'.$category['NUMBER_OF_PRODUCTS'].'</td>';
                                    echo '<td>';
                                    echo '<button onclick="openEditCategoryPopup(this, '.$category['CATEGORY_ID'].', \''.$category['CATEGORY_NAME'].'\')">Edit</button>';
                                    ?>
                                    <a href="delete-category.php?delete=<?php echo $category['CATEGORY_ID']?>" onclick="return confirm('Are you sure you want to delete this category?');"><button type="submit" class="btn-1">Delete</a></button>
                                    <?php
                                    // echo '<button type="submit" name="delete_category">Delete</button>';
                                    echo '</td>';
                                    echo '</tr>';

                                }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            
            <!-- Edit Popup Box -->
            <div id="editPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeEditPopup()">&times;</span>
                    <form id="editForm">
                        <label for="editImage">Upload Image:</label>
                        <input type="file" id="editImage" name="editImage">
            
                        <label for="editName">Edit Shop Name:</label>
                        <input type="text" required id="editName" name="editName">
            
                        <label for="editAddress">Edit Shop Address:</label>
                        <input type="text" required id="editAddress" name="editAddress">
            
                        <button type="button" onclick="saveChanges()">Save</button>
                    </form>
                </div>
            </div>

                <div id="editCategoryPopup" class="popup">
                    <div class="popup-content category-popup-content">
                        <span class="close" onclick="closeEditCategoryPopup()">&times;</span>
                        <form id="editCategoryForm" method="POST">
                            <input type="hidden" id="editCategoryId" name="editCategoryId">
                            <label for="editCategoryName">Category Name:</label>
                            <input type="text" id="editCategoryName" name="editCategoryName">
                            <button type="submit" name="edit_category" >Save</button>
                        </form>
                    </div>
                </div>
                
                <!-- ADD CATEGORY POPUP -->
                <div id="addCategoryPopup" class="popup">
                    <div class="popup-content category-popup-content">
                        <span class="close" onclick="closeAddCategoryPopup()">&times;</span>
                        <form id="addCategoryForm" method="POST">
                            <input type="hidden" id="addCategoryId" name="addCategoryId">
                            <label for="addCategoryName">Category Name:</label>
                            <input type="text" id="addCategoryName" name="addCategoryName">
                            <button type="submit" name="add_category" >Save</button>
                        </form>
                    </div>
                </div>
            
           
            <div id="discount" class="content">
                <h1 class="text">Discount</h1>
                <button class="add-product-btn"><a href="add-discount.php"><i class="fa-solid fa-plus"></i> Add Discount</a></button>

                <div class="discount-table-container">
                    <table class="discount-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Discount Percentage</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                                
                                $query5 = "SELECT * FROM DISCOUNT WHERE TRADER_ID = $trader_id";
                                $statement5 = oci_parse($connection, $query5);
                                oci_execute($statement5);

                                while($discount = oci_fetch_assoc($statement5)) {
                                    $discount_id = $discount['DISCOUNT_ID'];
                                    echo '<tr>';

                                    $imageData = $discount['DISCOUNT_IMAGE']->load();
                                    $encodedImageData = base64_encode($imageData);
                                    // Determine the image type based on the first few bytes of the image data
                                    $header = substr($imageData, 0, 4);
                                    $imageType = 'image/jpeg'; // default to JPEG
                                    if (strpos($header, 'FFD8') === 0) {
                                        $imageType = 'image/jpeg'; // JPEG
                                    } elseif (strpos($header, '89504E47') === 0) {
                                        $imageType = 'image/png'; // PNG
                                    }

                                    echo '<td><img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image" width="200px"></td>';
                                    echo '<td>'.$discount['DISCOUNT_PERCENTAGE'].'</td>';
                                    echo '<td>'.$discount['START_DATE'].'</td>';
                                    echo '<td>'.$discount['END_DATE'].'</td>';
                                    echo '<td><button><a href="edit-discount.php?discount_id='.$discount_id.'">Edit</a></button></td>';
                                    ?>
                                    <td><a href="delete-discount.php?delete=<?php echo $discount['DISCOUNT_ID']?>" onclick="return confirm('Are you sure you want to delete this discount?');" class="btn-1"><button type="submit">Delete</a></button></td>
                                    <?php ;
                                    echo '</tr>';
                                }
                                
                            ?>

                    
                            
                       
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="edit.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Initialize the chart

    // Show content based on the link clicked
    window.showContent = function(id) {
        var contents = document.querySelectorAll('.content');
        contents.forEach(content => {
            content.classList.remove('active');
        });
        document.getElementById(id).classList.add('active');
        localStorage.setItem('activeTab', id); // Save the active tab's ID
    };

    // Retrieve the saved active tab's ID from localStorage
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        showContent(activeTab);
    } else {
        showContent('dashboard'); // Default to dashboard if no tab is saved
    }
});
    
function openEditPopup(button, shopId, shopName, shopAddress) {

    document.getElementById("editPopup").style.display = "block";
}

function closeEditPopup() {
    document.getElementById("editPopup").style.display = "none";
}

function saveChanges() {
    var newName = document.getElementById("editName").value;
    var newAddress = document.getElementById("editAddress").value;
    var newImage = document.getElementById("editImage").files[0]; // Get the uploaded image file
    var reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById("shopImage").src = e.target.result; // Update the shop image source
    };

    if (newImage) {
        reader.readAsDataURL(newImage); // Read the image file as a data URL
    }

    document.getElementById("shopName").innerText = newName;
    document.getElementById("shopAddress").innerText = newAddress;
    closeEditPopup();
}

// Load the data when the page loads
window.onload = function() {
    loadShopData();
};

function loadShopData() {
    // Retrieve the data from localStorage
    var shopName = localStorage.getItem("shopName");
    var shopAddress = localStorage.getItem("shopAddress");
    var shopImage = localStorage.getItem("shopImage");

    // Update the UI with the retrieved data
    document.getElementById("shopName").innerText = shopName;
    document.getElementById("shopAddress").innerText = shopAddress;
    document.getElementById("shopImage").src = shopImage;
}

function saveChanges() {
    var newName = document.getElementById("editName").value;
    var newAddress = document.getElementById("editAddress").value;
    var newImage = document.getElementById("editImage").files[0];

    var reader = new FileReader();

    reader.onload = function(e) {
        // Update the shop image source
        document.getElementById("shopImage").src = e.target.result;

        // Save the updated data to localStorage
        localStorage.setItem("shopName", newName);
        localStorage.setItem("shopAddress", newAddress);
        localStorage.setItem("shopImage", e.target.result);
    };

    if (newImage) {
        reader.readAsDataURL(newImage);
    }

    document.getElementById("shopName").innerText = newName;
    document.getElementById("shopAddress").innerText = newAddress;
    closeEditPopup();
}

// Edit category functions
let currentCategoryRow = null;

function openEditCategoryPopup(button, categoryId, categoryName) {
    document.getElementById("editCategoryId").value = categoryId;
    document.getElementById("editCategoryName").value = categoryName;

    // Get the row being edited and store it in the variable
    currentCategoryRow = button.parentNode.parentNode;
    // Get the category name from the row
    var categoryName = currentCategoryRow.cells[1].textContent;
    // Set the category name in the popup's input field
    document.getElementById("editCategoryName").value = categoryName;
    // Display the popup
    document.getElementById("editCategoryPopup").style.display = "block";
}

function openAddCategoryPopup(button) {
    document.getElementById("addCategoryPopup").style.display = "block";
}

function closeAddCategoryPopup() {
    // Hide the popup
    document.getElementById("addCategoryPopup").style.display = "none";
}

function closeEditCategoryPopup() {
    // Hide the popup
    document.getElementById("editCategoryPopup").style.display = "none";
}

function saveCategoryChanges() {
    // Get the edited category name from the input field
    var editedCategory = document.getElementById("editCategoryName").value;
    // Update the category name in the current row
    if (currentCategoryRow) {
        currentCategoryRow.cells[1].textContent = editedCategory;
    }
    // Hide the popup
    closeEditCategoryPopup();
}

function deleteRow(button) {
    // Get the row to be deleted
    var row = button.parentNode.parentNode;
    // Remove the row from the table
    row.parentNode.removeChild(row);
}

//discount






</script>

</body>
</html>