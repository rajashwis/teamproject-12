<?php

    session_start();
    error_reporting(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../connect.php";

    if(isset($_GET['product_id'])) {
      $product_id = $_GET['product_id'];

      if(isset($_SESSION['trader_id'])) {
        $trader_id = $_SESSION['trader_id'];

        $query = "SELECT * FROM SHOP WHERE TRADER_ID = $trader_id";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);

        $shop = oci_fetch_assoc($statement);
        $shop_id = $shop['SHOP_ID'];
    }

    }
    else {
      echo "<script>alert('Noooo!')</script>";
      // header('Location: ../component/home.php');    
      // exit();
    }

    if(isset($_POST['submit'])) {
        $product_id = $_POST['product_id'];
        $productName = $_POST['product-name'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $alleryInfo = $_POST['allergy-info'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $discount = $_POST['discount'];
        $stock = $_POST['stock'];

        $discount = !empty($discount) ? $discount : NULL;

        $file = file_get_contents($_FILES['image']['tmp_name']);
        
        $query="SELECT shop_id, shop_name from SHOP WHERE trader_id = $trader_id";
        $stid=oci_parse($connection, $query);
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);
        
        $shop_id = $row['SHOP_ID'];
        $shop_name = $row['SHOP_NAME'];
        
        $sql = "UPDATE PRODUCT SET 
                    product_name = '$productName',
                    description_ = '$description', 
                    price = $price, 
                    quantity_per_item = $quantity, 
                    stock_available = $stock, 
                    allergy_information = '$alleryInfo', 
                    date_updated = SYSDATE,
                    category_id = $category, 
                    discount_id = $discount,
                    product_image = EMPTY_BLOB()
                WHERE PRODUCT_ID = $product_id
                RETURNING product_image INTO :image";

        $statement = oci_parse($connection, $sql);
        $blob = oci_new_descriptor($connection, OCI_D_LOB);
        oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);
        $result = oci_execute($statement, OCI_DEFAULT);
    
        if($result && $blob->save($file)) {
            oci_commit($connection);
            oci_free_descriptor($blob);

            echo "<script>alert('Yass!')</script>";
            header("Location: /edit-product.php?product_id=" . $product_id);
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

            
            $imageData = $row['PRODUCT_IMAGE']->load();

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
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" class="profile-form">

    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">

    <div class="profile-image">
      <?php 
        echo '<img id="profileImg" src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Profile Image">';
      ?>
      <input type="file" id="imgUpload" name="image" accept="image/*">
      <label for="imgUpload">Change Image</label>
    </div>
  
    <!-- <label for="image">Product Image:</label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png"> -->

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