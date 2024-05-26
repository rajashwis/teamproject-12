<?php

    session_start();
    error_reporting(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../connect.php";

    if(isset($_SESSION['trader_id'])) {
        $trader_id = $_SESSION['trader_id'];

        $sql = "SELECT * FROM SHOP WHERE TRADER_ID = $trader_id";
        $stmt = oci_parse($connection, $sql);
        oci_execute($stmt);

        $shop = oci_fetch_assoc($stmt);
        $shop_id = $shop['SHOP_ID'];

    }

    else {
      header('Location: ../homepage/');    
      exit();
    }
    
    if(isset($_POST['submit'])) {

      $product_name = $_POST['product-name'];
      $category = $_POST['category'];
      $description = $_POST['description'];
      $allergyInfo = $_POST['ai'];
      $quantity = $_POST['quantity'];
      $stock = $_POST['stock-available'];
      $discount = $_POST['discount'];
      $price = $_POST['price'];
      
      if (isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] == UPLOAD_ERR_OK) {
        $file = file_get_contents($_FILES['imgUpload']['tmp_name']);
      } else {
          // Use a dummy file if no file was uploaded
          $dummyFilePath = '../resources/dummy images/dummy_product.png'; // Path to your dummy image file
          $file = file_get_contents($dummyFilePath);
      }

      $query = "INSERT INTO Product (product_id, product_name, description_, price, quantity_per_item, stock_available, allergy_information, date_added, is_approved, shop_id, category_id, discount_id, product_image) VALUES (SEQ_PRODUCT_ID.NEXTVAL, '$product_name', '$description', $price, $quantity, $stock, '$allergyInfo', SYSDATE, 0, '$shop_id', '$category', '$discount', EMPTY_BLOB()) RETURNING product_image INTO :image";

      $statement = oci_parse($connection, $query);
      $blob = oci_new_descriptor($connection, OCI_D_LOB);
      oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);
      $result = oci_execute($statement, OCI_DEFAULT);
      
      if($result && $blob->save($file)) {
          oci_commit($connection);
          oci_free_descriptor($blob);
          echo "<script>alert('Product Uploaded!')</script>";
      }
    }

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="add-products.css">
    <title>Document</title>
</head>
<body>


    <form class="discount-form" method="POST" enctype="multipart/form-data">
        <h2><i class="fa-solid fa-plus"></i> Add Product</h2>
        
        <div class="discount-image">
            <img id="profileImg" src="../resources/dummy images/dummy_product.png" alt="Banner Image">
            <input type="file" id="imgUpload" name="imgUpload" accept="image/*">
            <label for="imgUpload">Upload Product Image</label>
        </div>
        
        <div class="form-group">
            <label for="product-name">Product Name</label>
            <input type="product-name" id="product-name" name="product-name" required>
        </div>
        
        <div class="form-group">
          <label for="category">Categories</label>
          <select id="category" name="category" required>
            <?php
              $query = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID=$trader_id";
              $statement = oci_parse($connection, $query);
              oci_execute($statement);

              while($row=oci_fetch_assoc($statement)) {
            ?>
            <option value = "<?php echo $row['CATEGORY_ID']?>"><?php echo $row['CATEGORY_NAME']?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
            <label for="pdesc">Product Description</label>
            <textarea name="description"></textarea>
        </div>

        <div class="form-group">
          <label for="ai">Allergy Information</label>
          <input type="ai" id="ai" name="ai" required>
        </div>

        <div class="form-group">
          <label for="price">Product Price</label>
          <input type="number" id="price" name="price" required>
        </div>

        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" id="quantity" name="quantity" required>
        </div>

        <div class="form-group">
          <label for="stock-available">Stock Availabe</label>
          <input type="number" id="stock-available" name="stock-available" required>
        </div>

        <div class="form-group">
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
        </div>
        
        

        <button type="submit" name="submit">Submit</button>
    </form>

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