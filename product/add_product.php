<?php

/*
    session_start();
    include "../connect.php";

    $trader = $_SESSION['user_id']; 

    if(!$trader) {
        header("Location: trader login.html");
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

            header('Location: ../product_detail/product_detail.php?product_id='.$currval.'');
            exit();
        }
        else {
            echo "<script>alert('Error!')</script>";
        }
    
    }
    */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD PRODUCT</title>
    <link rel="stylesheet" href="add_product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>


    <?php
    include '../HN/navbar.php';
    ?>

    <h1 class="heading">Add Products</h1>
    <hr class="hr-top">

    <div class="main">

    

    <div class="container">
      


        <div class="vertical-nav">
            <ul>
                <li><a class="active" href="#">Dashboard</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">Order</a></li>
                <li><a href="desktop10.html">Discount</a></li>
            </ul>
        </div>

        <div class="right">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="product-name">
                        <label for="name">Product Name: </label>
                        <input type="text" name="productName" placeholder="Product Name" required>
                    </div>

                    <div class="category">
                        <label for="category">Category:</label>
                        <select name="category" required>
                            <?php
                            /*
                                $query = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID=$trader";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);

                                while($row=oci_fetch_assoc($statement)) {
                            ?>
                            <option value = "<?php echo $row['CATEGORY_ID']?>"><?php echo $row['CATEGORY_NAME']?></option>
                            <?php } 
                            */ ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="description">
                        <label for="description">Description: </label>
                        <input type="text" name="description" placeholder="Description" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="allergy-information">
                        <label for="allergy-information">Allergy Information: </label>
                        <input type="text" name="allergyInfo" placeholder="Allergy Information" required>
                    </div>


                    <div class="stock">
                        <label for="stock">Stock Available: </label>
                        <input type="number" name="stock" placeholder="Stock" required>
                    </div>
                </div>


                <div class="form-group">
                    <div class="price">
                        <label for="price">Price: </label>
                        <input type="number" name="price" placeholder="Price" required>
                    </div>

                    <div class="quantity">
                        <label for="quantity">Quantity: </label>
                        <input type="number" name="quantity" placeholder="Quantity" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="discount">
                        <label for="discount">Discount:</label>
                        <select name="discount">
                            <option value="">None</option>
                            <?php
                            /*
                                $query = "SELECT * FROM DISCOUNT WHERE TRADER_ID = $trader";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);

                                while($row=oci_fetch_assoc($statement)) {
                            ?>
                            <option value = "<?php echo $row['DISCOUNT_ID']?>"><?php echo $row['DISCOUNT_PERCENTAGE']?></option>
                            <?php } 
                            */ ?>
                        </select>
                    </div>

                    <div class="product-image">
                        <label for="image">Product Image</label>
                        <input type="file" class="image-input" name="image" accept=".jpg,.jpeg,.png"><br />
                    </div>

                </div>

                <input type="submit" name="submit" class="btn-add-product" value="Add Product">

            </form>
        </div>
    </div>
    
    </div>

    <?php
    include '../HN/footer.php';
    ?>
</body>
</html>