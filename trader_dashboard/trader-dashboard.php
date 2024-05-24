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
                <div class="graph">
                    <canvas id="salesChart" width="400" height="200"></canvas>
                </div>
        
                <div class="top-items">
                    <h2>Top Selling Items</h2>
                    <ul>

                        <?php 
                            $query6 = "SELECT * FROM (
                                SELECT P.PRODUCT_ID, P.PRODUCT_NAME, COUNT(OP.PRODUCT_ID) AS ORDER_PRODUCT_COUNT
                                FROM ORDERPRODUCT OP
                                JOIN PRODUCT P ON P.PRODUCT_ID = OP.PRODUCT_ID
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

                                $imageData = $order_product_image['PRODUCT_IMAGE']->load();
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
                            echo '<a href = "edit-product.php?product_id='.$product_id.'"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"></a>';


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
                </div>

                <h1>Category</h1>
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
                                $query4 = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
                                $statement4 = oci_parse($connection, $query4);
                                oci_execute($statement4);

                                while ($category = oci_fetch_assoc($statement4)) {

                                    echo '<tr>';
                                    echo '<td>'.$category['CATEGORY_ID'].'</td>';
                                    echo '<td>'.$category['CATEGORY_NAME'].'</td>';
                                    echo '<td>5</td>';
                                    echo '<td>';
                                    echo '<button onclick="openEditCategoryPopup(this)">Edit</button>';
                                    echo '<button onclick="deleteRow(this)">Delete</button>';
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
            
            <!-- Edit Category Popup Box -->
                <div id="editCategoryPopup" class="popup">
                    <div class="popup-content category-popup-content">
                        <span class="close" onclick="closeEditCategoryPopup()">&times;</span>
                        <form id="editCategoryForm">
                            <label for="editCategoryName">Category Name:</label>
                            <input type="text" id="editCategoryName" name="editCategoryName">
                            <button type="button" onclick="saveCategoryChanges()">Save</button>
                        </form>
                    </div>
                </div>
                <!--DO NOT EDIT ABOVE-->

                
            
           
            <div id="discount" class="content">
                <h1 class="text">Discount</h1>
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
                                    echo '<td><button><a href="discount-edit.html">Edit</a></button></td>';
                                    echo '<td><button><a href="discount-edit.html">Delete</button></a></td>';
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

function openEditPopup() {
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

function openEditCategoryPopup(button) {
    // Get the row being edited and store it in the variable
    currentCategoryRow = button.parentNode.parentNode;
    // Get the category name from the row
    var categoryName = currentCategoryRow.cells[1].textContent;
    // Set the category name in the popup's input field
    document.getElementById("editCategoryName").value = categoryName;
    // Display the popup
    document.getElementById("editCategoryPopup").style.display = "block";
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