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

      if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $file = file_get_contents($_FILES['image']['tmp_name']);
      } else {
          // Use a dummy file if no file was uploaded
          $dummyFilePath = '../resources/dummy images/dummy_product.png'; // Path to your dummy image file
          $file = file_get_contents($dummyFilePath);
      }
      
      $query="SELECT shop_id, shop_name from SHOP WHERE trader_id = '$trader'";
      $stid=oci_parse($connection, $query);
      oci_execute($stid);
      $row = oci_fetch_assoc($stid);
      
      $shop_id = $row['SHOP_ID'];
      $shop_name = $row['SHOP_NAME'];
      
      $sql = "INSERT INTO Product (product_id, product_name, description_, price, quantity_per_item, stock_available, allergy_information, date_added, is_approved, shop_id, category_id, discount_id, product_image) VALUES (SEQ_PRODUCT_ID.NEXTVAL, '$productName', '$description', '$price', '$quantity', '$stock', '$alleryInfo', SYSDATE, 0, '$shop_id', '$category', '$discount', EMPTY_BLOB()) RETURNING product_image INTO :image";

      $statement = oci_parse($connection, $sql);
      $blob = oci_new_descriptor($connection, OCI_D_LOB);
      oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);
      $result = oci_execute($statement, OCI_DEFAULT);
  
      if($result && $blob->save($file)) {
        oci_commit($connection);

        $sql1 = "SELECT SEQ_PRODUCT_ID.CURRVAL FROM DUAL";
        $stid1=oci_parse($connection, $sql1);
        oci_execute($stid1);
        $currval = oci_fetch_assoc($stid1);

        $currval = $currval['CURRVAL'];

        header('Location: edit_product.php?product_id='.$currval.'');
        exit();
      }
      else {
        echo "<script>alert('Error!')</script>";
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
  <h1><i class="fa-solid fa-plus"></i>Add Product</h1>
  <form method="POST" enctype="multipart/form-data" class="profile-form">

    <div class="profile-image">
      <img id="profileImg" src="https://via.placeholder.com/100" alt="Profile Image">
      <input type="file" id="imgUpload" accept=".jpg,.jpeg,.png">
      <label for="imgUpload">Change Image</label>
    </div>

    <!-- <label for="image">Product Image:</label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png"> -->

    <label for="product-name">Product Name:</label>
    <input type="text" id="product-name" name="product-name" required>

    <label for="category">Category:</label>
    <select id="category" name="category" required>
      <?php 
        $query1 = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
        $statement1 = oci_parse($connection, $query1);
        oci_execute($statement1);

        while($category_list = oci_fetch_assoc($statement1)) {
            $category_id = $category_list['CATEGORY_ID']; 
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

    <button type="submit" name="submit">Submit</button>
  </form>
</div>

<script>
        const imgUpload = document.getElementById('imgUpload');
        const profileImg = document.getElementById('profileImg');

        imgUpload.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profileImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>
</html>
