<?php

    session_start();
    include "../connect.php";

    $trader = $_SESSION['user_id']; 

    if(!$trader) {
        header("Location: trader login.php");
        exit();
    }

    if(isset($_POST['submit'])) {
        $productName = $_POST['productName'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $alleryInfo = $_POST['allergyInfo'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $discount = $_POST['discount'];
        $stock = $_POST['stock'];

        $query="SELECT shop_id, shop_name from SHOP WHERE trader_id = '$trader'";
        $stid=oci_parse($connection, $query);
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);
        
        $shop_id = $row['SHOP_ID'];
        $shop_name = $row['SHOP_NAME'];
        
        $sql = "INSERT INTO Product (product_id, product_name, description_, price, quantity_per_item, stock_available, allergy_information, date_added, is_approved, shop_id, category_id, discount_id) VALUES (SEQ_PRODUCT_ID.NEXTVAL, '$productName', '$description', '$price', '$quantity', '$stock', '$alleryInfo', SYSDATE, 0, '$shop_id', '$category', '$discount')";
    
        if(oci_execute(oci_parse($connection,$sql))) {
            header("Location: ../login/login.html");
            exit();
        }
        else {
            echo "error!";
        }
    
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <link rel="stylesheet" href="add product.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
    <div class="box">
            <!--navbar-->
        <!--
        <div class="navbar" id="nav">
            <nav>
                <ul>
                    <li><img class="logo" src="CFXLocalHub - White_Logo.png"></li>
                    <div class="search-bar">
                        <form action="search.php" method="GET">
                            <div class="search">
                                <input type="text" name="searchTerm" class="searchTerm" placeholder="   NIKE SHOES...">
                                <button type="submit" class="searchButton">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="user-box">
                        <div class="signin">
                            <form action="signin.html" method="get">
                                <button class="btn">
                                    <u><i class="fa-solid fa-user"></i> Sign in</u>
                                </button>
                            </form>
                        </div>
                        <div class="signup">
                            <form action="signup.html" method="get">
                                <button class="btn-2">
                                    Sign up
                                </button>
                            </form>
                        </div>
                    </div>
                    <li class="basket"><a href="cart.html"><img src="trolley.png" height="30px"></a></li>
                </ul>
            </nav>
        </div>-->
        <div class="menu">
            <ul>
                <li><a href="">Dashboard</a></li>
                <li><a href="">Shop</a></li>
                <li><a class="active" href="">Product</a></li>
                <li><a href="">Orders</a></li>
            </ul>
        </div>
        <form method="POST">
            <div class="container">

                <h1>Add Products</h1>
                <hr class="hr-top-left">
                <div class="product-info">
                    <img src="Images/image1.jpeg" alt="Product Image">
                    <div class="details">
                        <div class="field">
                            <div class="productName">
                                <label for="productName">Product Name:</label>
                                <input type="text" id="productName" name="productName">
                            </div> 

                            <div class="Category">
                                <label for="category">Category:</label>
                                <select name="category">
                                    <?php
                                        $query = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID=$trader";
                                        $statement = oci_parse($connection, $query);
                                        oci_execute($statement);

                                        while($row=oci_fetch_assoc($statement)) {
                                    ?>
                                    <option value = "<?php echo $row['CATEGORY_ID']?>"><?php echo $row['CATEGORY_NAME']?></option>
                                    <?php } ?>
                                </select>
                            </div>   
                            
                        </div>
                        
                        <div class="field">
                            <div class="Description">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <div class="Allergy">
                                <label for="allergyInfo">Allergy Information:</label>
                                <textarea id="allergyInfo" rows="2" name="allergyInfo"></textarea>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="Price">
                                <label for="price">Price:</label>
                                <input type="text" id="price" name="price">
                            </div>
                                
                            
                            <div class="Quantity">
                                <label for="quantity">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="20">
                            </div>   
                        </div>


                        <div class="field">
                            <div class="Discount">
                                <label for="discount">Discount:</label>
                                <select name="discount" value="discount">
                                    <?php
                                        $query = "SELECT * FROM DISCOUNT WHERE TRADER_ID = $trader";
                                        $statement = oci_parse($connection, $query);
                                        oci_execute($statement);

                                        while($row=oci_fetch_assoc($statement)) {
                                    ?>
                                    <option value = "<?php echo $row['DISCOUNT_ID']?>"><?php echo $row['DISCOUNT_PERCENTAGE']?></option>
                                    <?php } ?>
                                    <option value=0>None</option>
                                </select>
                            </div>

                            <div class="Stock">
                                <label for="stock">Stock Available:</label>
                                <input type="number" id="stock" name="stock" value="1" min="1" max="20">
                            </div> 
                        </div>


                        <div class="submit-box">
                            <button type="submit" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

    
</body>
</html>