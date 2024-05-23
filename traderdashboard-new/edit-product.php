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

    if(isset($_POST['submit'])) {
        $productName = $_POST['product-name'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $alleryInfo = $_POST['allergy-info'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $discount = $_POST['discount'];
        $stock = $_POST['stock'];

        $discount = !empty($discount) ? $discount : NULL;
        
        $query="SELECT shop_id, shop_name from SHOP WHERE trader_id = $trader_id";
        $stid=oci_parse($connection, $query);
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);
        
        $shop_id = $row['SHOP_ID'];
        $shop_name = $row['SHOP_NAME'];

        if(isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
        }

        echo "<script>alert('".$product_id."')</script>";
        
        $sql = "UPDATE PRODUCT SET 
                    product_name = '$productName',
                    description_ = '$description', 
                    price = $price, 
                    quantity_per_item = $quantity, 
                    stock_available = $stock, 
                    allergy_information = '$alleryInfo', 
                    date_updated = SYSDATE,
                    category_id = $category, 
                    discount_id = $discount
                WHERE PRODUCT_ID = $product_id";

        $statement = oci_parse($connection, $sql);
        oci_execute($statement);
    
        if($result) {
            oci_commit($connection);

            header('edit-product?product_id');
            exit();
        }
        else {
            echo "<script>alert('Error!')</script>";
        }
    
    }

    else if($_SERVER["REQUEST_METHOD"]=='GET'){

        if(isset($_GET['product_id'])) {

            $product_id = $_GET['product_id'];

            $query="SELECT * from PRODUCT WHERE PRODUCT_ID = $product_id";
            $stid=oci_parse($connection, $query);
            oci_execute($stid);
            $row = oci_fetch_assoc($stid);

            if(!$row){
                echo("Error!");
                exit();
            }

            $productName = $row['PRODUCT_NAME'];
            $description = $row['DESCRIPTION_'];
            $alleryInfo = $row['ALLERGY_INFORMATION'];
            $price = $row['PRICE'];
            $quantity = $row['QUANTITY_PER_ITEM'];
            $stock = $row['STOCK_AVAILABLE'];

            $category_id = $row['CATEGORY_ID'];

            if($row['DISCOUNT_ID']) {
                $discount_id = $row['DISCOUNT_ID'];
                $query1 = "SELECT * FROM DISCOUNT WHERE DISCOUNT_ID = $discount_id";
                $stid1=oci_parse($connection, $query1);
                oci_execute($stid1);
                $edit_discount = oci_fetch_assoc($stid1);
            }
            

            $query2 = "SELECT * FROM PRODUCTCATEGORY WHERE CATEGORY_ID = $category_id";
            $stid2=oci_parse($connection, $query2);
            oci_execute($stid2);
            $edit_category = oci_fetch_assoc($stid2);
        }
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
  <h1><i class="fa-solid fa-plus"></i>Edit Product</h1>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
  
    <label for="image">Product Image:</label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png">

    <label for="product-name">Product Name:</label>
    <input type="text" id="product-name" name="product-name" value="<?php echo $productName; ?>" required>

    <label for="category">Category:</label>
    <select id="category" name="category" required>
      <?php 
        $query1 = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
        $statement1 = oci_parse($connection, $query1);
        oci_execute($statement1);

        while($category_list = oci_fetch_assoc($statement1)) {
            $category_id = $category_list['CATEGORY_ID']; 
            $category_name = $category_list['CATEGORY_NAME'];

            $selected = ($category_id == $edit_category['CATEGORY_ID']) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($category_id) . '"' . $selected . '>' . htmlspecialchars($category_name) . '</option>';
        }
      ?>
    </select>

    <label for="description">Product Description:</label>
    <textarea id="description" name="description" rows="4" required><?php echo $description; ?></textarea>

    <label for="allergy-info">Allergy Information:</label>
    <textarea id="allergy-info" name="allergy-info" rows="2" value="<?php echo $alleryInfo; ?>"></textarea>

    <label for="stock">Stock Available:</label>
    <input type="number" id="stock" name="stock" min="0" value="<?php echo $stock; ?>" required>

    <label for="price">Product Price:</label>
    <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $price; ?>" required>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" value="<?php echo $quantity; ?>" required>

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
            
            $selected = ($discount_id == $edit_discount['DISCOUNT_ID']) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($discount_id) . '"' . $selected . '>' . htmlspecialchars($discount_percent) . '</option>';
  
        }
      ?>
    </select>

    <button type="submit" name="submit">Submit</button>
  </form>
</div>

</body>
</html>