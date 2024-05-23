<?php

    session_start();
    error_reporting(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../connect.php";

    if(isset($_SESSION['trader_id'])) {
        $trader_id = $_SESSION['trader_id'];

        $query = "SELECT * FROM SHOP WHERE TRADER_ID = $trader_id";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);

        $shop = oci_fetch_assoc($statement);
        $shop_id = $shop['SHOP_ID'];
    }

    else {
        header('Location: ../component/home.php');    
        exit();
    }
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


</style>

<body>
    <div class="navbar">
        <div class="profile">
            <div class="profile-img">
                <img src="../resources/dummy images/dummy_product.png" alt="Profile Picture">
            </div>
            <span>Trader Name</span>
        </div>
        <button class="sign-out-btn">Sign Out</button>
    </div>


    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a class="active" href="#dashboard" onclick="showContent('dashboard')"><i class="fa-solid fa-chart-simple"></i> Dashboard</a></li>
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
                <div class="graph">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
        
                <div class="top-items">
                    <h2>Top Selling Items</h2>
                    <ul>
                        <li class="item">
                            <img src="../resources/products/bakery1.jpg" alt="Item 1">
                            <span>Product Name</span>
                            <span>Total Sold: 50</span>
                        </li>
                        <li class="item">
                            <img src="../resources/products/jordan.jpg" alt="Item 2">
                            <span>Product Name</span>
                            <span>Total Sold: 30</span>
                        </li>
                        <li class="item">
                            <img src="../resources/products/watch.jpg" alt="Item 3">
                            <span>Product Name</span>
                            <span>Total Sold: 20</span>
                        </li>
                        <li class="item">
                            <img src="../resources/products/watch.jpg" alt="Item 3">
                            <span>Product Name</span>
                            <span>Total Sold: 20</span>
                        </li>
                        <li class="item">
                            <img src="../resources/products/watch.jpg" alt="Item 3">
                            <span>Product Name</span>
                            <span>Total Sold: 20</span>
                        </li>
                    </ul>
                </div>
                
                
            </div>

            <div id="products" class="content">
                <h1>Products</h1>
                <button class="add-product-btn"><a href="add-products.php"><i class="fa-solid fa-plus"></i> Add Product</a></button>

                <!--FIX THISSSS-->
                <form method="GET">
                    <select class="category-option" name="category">
                        <!-- <option value="" >Select Category</option> -->
                        <?php
                        $query3 = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
                        $statement3 = oci_parse($connection, $query3);
                        oci_execute($statement3);

                        while ($category_list = oci_fetch_assoc($statement3)) {
                            $category_id_ = $category_list['CATEGORY_ID'];
                            $category_name = $category_list['CATEGORY_NAME'];

                            error_log("Category ID from DB: " . $category_id_);
                            error_log("Category ID from GET: " . $_GET['category']);

                            $selected = (isset($_GET['category']) && $_GET['category'] == $category_id_) ? ' selected' : '';
                            echo "<option value='" . htmlspecialchars($category_id_) . "' " . $selected . ">" . htmlspecialchars($category_name) . "</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" value="filter" class="filter-btn"><i class="fa-solid fa-filter"></i> Filter</button>
                </form>

                <div class="product-container">

                    <?php 

                        if(isset($_GET['category'])) {
                            $category_id_filter = $_GET['category'];

                            $query1 = "SELECT * FROM PRODUCT WHERE SHOP_ID = $shop_id";
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
                            $category = $category['CATEGORY_NAME'];

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
                            echo '<a href = "#"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"></a>';


                            //echo '<img src="../resources/products/jordan.jpg" alt="Product 1">';

                            echo '<span>'.$product['PRODUCT_NAME'].'</span>';
                            echo '<span>Price: '.$product['PRICE'].'</span>';
                            echo '<span>'.$category.'</span>';
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
                                <th>Date</th>
                                <th>Price</th>
                                <th>Delivery Status</th>
                                <th>Order Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Customer Name</td>
                                <td>2024-05-22</td>
                                <td>$50</td>
                                <td>Delivered</td>
                                <td><button>View Order</button></td>
                            </tr>
                            
                            <tr>
                                <td>2</td>
                                <td>Customer Name</td>
                                <td>2024-05-22</td>
                                <td>$50</td>
                                <td>Delivered</td>
                                <td><button>View Order</button></td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Customer Name</td>
                                <td>2024-05-22</td>
                                <td>$50</td>
                                <td>Delivered</td>
                                <td><button>View Order</button></td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>Customer Name</td>
                                <td>2024-05-22</td>
                                <td>$50</td>
                                <td>Delivered</td>
                                <td><button>View Order</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           
            <div id="shop" class="content">
                <h1>Shop</h1>
                <div class="shop-container">
                    <form id="shopForm">
                        <div class="shop-info">
                            <div class="shop-image">
                                <img id="shopImage" src="../resources/dummy images/dummy_product.png" alt="Shop Image">
                            </div>
                            <div class="shop-details">
                                <h2 id="shopName">Shop Name</h2>
                                <p id="shopAddress">Shop Address</p>
                            </div>
                            <button type="button" id="editShopBtn" onclick="openEditPopup()">Edit</button>
                        </div>
                    </form>
                </div>

                <h1>Category</h1>
                <div class="order-table-container">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>No. of Products</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Cake</td>
                                <td>5</td>
                                <td>
                                    <button>Edit</button>
                                    <button>Delete</button>
                                </td>
                            </tr>

                            <tr>
                                <td>1</td>
                                <td>Cake</td>
                                <td>5</td>
                                <td>
                                    <button>Edit</button>
                                    <button>Delete</button>
                                </td>
                            </tr>

                            <tr>
                                <td>1</td>
                                <td>Cake</td>
                                <td>5</td>
                                <td>
                                    <button>Edit</button>
                                    <button>Delete</button>
                                </td>
                            </tr>
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
                        <input type="text" id="editName" name="editName">
            
                        <label for="editAddress">Edit Shop Address:</label>
                        <input type="text" id="editAddress" name="editAddress">
            
                        <button type="button" onclick="saveChanges()">Save</button>
                    </form>
                </div>
            </div>
            

                <!--DO NOT EDIT ABOVE-->

                
            
           
            <div id="discount" class="content">
                <h1>Discount</h1>
                <!-- Shop content goes here -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Initialize the chart
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Sales ($)',
                data: [0, 100, 300, 200, 250, 200, 300, 200, 450, 500, 550, 500],
                backgroundColor: 'rgba(0, 181, 21, 0.2)',
                borderColor: 'rgba(0, 181, 21, 1)',
                borderWidth: 1,
                fill: true,
                tension: 0.4 // This makes the line curve
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Show content based on the link clicked
    window.showContent = function(id) {
        var contents = document.querySelectorAll('.content');
        contents.forEach(content => {
            content.classList.remove('active');
        });
        document.getElementById(id).classList.add('active');
    };

    // Initially display the dashboard
    showContent('dashboard');


    function openEditPopup() {
    document.getElementById("editPopup").style.display = "block";
}

function closeEditPopup() {
    document.getElementById("editPopup").style.display = "none";
}

function saveChanges() {
    var newName = document.getElementById("editName").value;
    var newAddress = document.getElementById("editAddress").value;
    // Code to update image, name, and address
    document.getElementById("shopName").textContent = newName;
    document.getElementById("shopAddress").textContent = newAddress;
    closeEditPopup();
}


});





    </script>

</body>
</html>