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
<link rel="stylesheet" type="text/css" href="add-products.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<title>Product Form</title>
</head>
<body>

<div class="container">
  <h1><i class="fa-solid fa-plus"></i>Add Product</h1>
  <form method="POST">
    <label for="image">Product Image:</label>
    <input type="file" id="image" name="image" accept="image/*">

    <label for="product-name">Product Name:</label>
    <input type="text" id="product-name" name="product-name" required>

    <label for="category">Category:</label>
    <select id="category" name="category" required>
      <?php 
        $query1 = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
        $statement1 = oci_parse($connection, $query1);
        oci_execute($statement1);

        while($category_list = oci_fetch_assoc($statement1)) {
            $category_id_ = $category_list['CATEGORY_ID']; 
            $category_name = $category_list['CATEGORY_NAME'];

            echo "<option value='".$category_id."'>".$category_name."</option>";

        }
      ?>
    </select>

    <label for="description">Product Description:</label>
    <textarea id="description" name="description" rows="4" required></textarea>

    <label for="allergy-info">Allergy Information:</label>
    <textarea id="allergy-info" name="allergy-info" rows="2"></textarea>

    <label for="stock">Stock Available:</label>
    <input type="number" id="stock" name="stock" min="0" required>

    <label for="price">Product Price:</label>
    <input type="number" id="price" name="price" step="0.01" min="0" required>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" required>

    <label for="discount">Discount:</label>
    <select id="discount" name="discount">
      <option value="">None</option>
      <?php 
        $query2 = "SELECT * FROM DISCOUNT WHERE TRADER_ID = $trader_id";
        $statement2 = oci_parse($connection, $query2);
        oci_execute($statement2);
  
        while($discount_list = oci_fetch_assoc($statement2)) {
            $discount_id = $discount_list['DISCOUNT_ID']; 
            $discount_percent = $discount_list['DISCOUNT_PERCENTAGE'];
  
            echo "<option value='".$discount_id."'>".$discount_percent."</option>";
  
        }
      ?>
    </select>

    <button type="submit">Submit</button>
  </form>
</div>

</body>
</html>
