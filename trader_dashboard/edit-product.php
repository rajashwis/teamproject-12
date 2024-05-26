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

        if(isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
        }
        else {
            header('Location: ../homepage');
            exit();
        }

        $query="SELECT * from PRODUCT WHERE product_id = '$product_id'";
        $stid=oci_parse($connection, $query);
        oci_execute($stid);
        $product = oci_fetch_assoc($stid);

        if(!$product){
            echo("Error!");
            exit();
        }

        $imageData = $product['PRODUCT_IMAGE']->load();

    }

    else {
      header('Location: ../homepage/');    
      exit();
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        if(isset($_GET['product_id'])) {
            $product_id = intval($_GET['product_id']); 


            $productName = $product['PRODUCT_NAME'];
            $description = $product['DESCRIPTION_'];
            $allergyInfo = $product['ALLERGY_INFORMATION'];
            $price = $product['PRICE'];
            $quantity = $product['QUANTITY_PER_ITEM'];
            $stock = $product['STOCK_AVAILABLE'];

            $discount_id = $product['DISCOUNT_ID'];
            $category_id = $product['CATEGORY_ID'];

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

            if($discount_id) {
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

    if(isset($_POST['submit'])) {

      $productName = $_POST['product-name'];
      $category = $_POST['category'];
      $description = $_POST['description'];
      $allergyInfo = $_POST['ai'];
      $quantity = $_POST['quantity'];
      $stock = $_POST['stock-available'];
      $discount = $_POST['discount'];
      $price = $_POST['price'];

      $discount = !empty($discount) ? $discount : NULL;
      
      if (isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] == UPLOAD_ERR_OK) {
        $file = file_get_contents($_FILES['imgUpload']['tmp_name']);
      } elseif($imageData) {
        $file = $imageData;
      } else {
          // Use a dummy file if no file was uploaded
          $dummyFilePath = '../resources/dummy images/dummy_product.png'; // Path to your dummy image file
          $file = file_get_contents($dummyFilePath);
      }

      $query = "UPDATE PRODUCT SET 
        product_name = :productName, 
        description_ = :description, 
        price = :price, 
        quantity_per_item = :quantity, 
        stock_available = :stock, 
        allergy_information = :allergyInfo, 
        date_updated = SYSDATE, 
        category_id = :category, 
        discount_id = :discount, 
        product_image = EMPTY_BLOB()
        WHERE PRODUCT_ID = :product_id
      RETURNING product_image INTO :image";

        $statement = oci_parse($connection, $query);

        oci_bind_by_name($statement, ':productName', $productName);
        oci_bind_by_name($statement, ':description', $description);
        oci_bind_by_name($statement, ':price', $price);
        oci_bind_by_name($statement, ':quantity', $quantity);
        oci_bind_by_name($statement, ':stock', $stock);
        oci_bind_by_name($statement, ':allergyInfo', $allergyInfo);
        oci_bind_by_name($statement, ':category', $category);
        oci_bind_by_name($statement, ':discount', $discount);
        oci_bind_by_name($statement, ':product_id', $product_id);

        $blob = oci_new_descriptor($connection, OCI_D_LOB);
        oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);

        $result = oci_execute($statement, OCI_NO_AUTO_COMMIT);

        if ($result && $blob->save($file)) {
            oci_commit($connection);
            oci_free_descriptor($blob);
            echo "<script>alert('Product Updated!')</script>";
            header('Location: trader-dashboard.php#');
            exit();
        } else {
            oci_rollback($connection);
            echo "<script>alert('Error updating product!')</script>";
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
        <h2><i class="fa-solid fa-plus"></i> Edit Product</h2>
        
        <div class="discount-image">
            <!-- <img id="profileImg" src="../resources/dummy images/dummy_product.png" alt="Banner Image"> -->
            <?php echo '<img id="profileImg" src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';?>
            <input type="file" id="imgUpload" name="imgUpload" accept="image/*">
            <label for="imgUpload">Upload Product Image</label>
        </div>
        
        <div class="form-group">
            <label for="product-name">Product Name</label>
            <input type="product-name" id="product-name" name="product-name" value=<?php echo $productName; ?> required>
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
            <option value = "<?php echo $row['CATEGORY_ID'];?>" <?php if($row['CATEGORY_ID'] == $edit_category['CATEGORY_ID']){echo "selected";} ?>><?php echo $row['CATEGORY_NAME'];?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
            <label for="pdesc">Product Description</label>
            <textarea name="description"><?php echo $description;?></textarea>
        </div>

        <div class="form-group">
          <label for="ai">Allergy Information</label>
          <input type="ai" id="ai" name="ai" value=<?php echo $allergyInfo; ?> required>
        </div>

        <div class="form-group">
          <label for="price">Product Price</label>
          <input type="number" id="price" name="price" value=<?php echo $price; ?> required>
        </div>

        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" id="quantity" name="quantity" value=<?php echo $quantity; ?> required>
        </div>

        <div class="form-group">
          <label for="stock-available">Stock Availabe</label>
          <input type="number" id="stock-available" name="stock-available" value=<?php echo $stock; ?> required>
        </div>

        <div class="form-group">
          <label for="discount">Discount:</label>
          <select id="discount" name="discount">
            <option value="">None</option>
            <?php 
                
                $query = "SELECT * FROM DISCOUNT WHERE TRADER_ID=$trader_id";
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
  
                while($row=oci_fetch_assoc($statement)) {
            ?>
                <option value = "<?php echo $row['DISCOUNT_ID']; ?>" <?php if($row['DISCOUNT_ID'] == $edit_discount['DISCOUNT_ID']){echo "selected";} ?>><?php echo $row['DISCOUNT_PERCENTAGE'];?></option>
            <?php } ?>

          </select>
        </div>
        
        <button type="submit" name="submit">Save</button><br/>
        <a href="delete-product.php?delete=<?php echo $product['PRODUCT_ID']?>" onclick="return confirm('Are you sure you want to delete this product?');" class="btn-1"><button type="submit">Delete</a></button>
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