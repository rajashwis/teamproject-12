<?php

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

    else if($_SERVER["REQUEST_METHOD"]=='GET'){

        if(isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];

            $query="SELECT * from PRODUCT WHERE product_id = '$product_id'";
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

            $discount_id = $row['DISCOUNT_ID'];
            $category_id = $row['CATEGORY_ID'];

            $query1 = "SELECT * FROM DISCOUNT WHERE DISCOUNT_ID = $discount_id";
            $stid1=oci_parse($connection, $query1);
            oci_execute($stid1);
            $edit_discount = oci_fetch_assoc($stid1);

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
    <title>UPDATE PRODUCT</title>
    <link rel="stylesheet" href="update_product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

 

        <div class="navbar-trader">
            <div class="trader-profile">
                <img src="../resources/user.jpg" alt="trader_profile">
                <h4>John Cena</h4>
            </div>
            <button class="logout">
                Logout
            </button>
        </div>

       

        <div class="main">
      
                <div class="vertical-nav">
                    <ul>
                        <li><a class="active" href="#">Dashboard</a></li>
                        <li><a href="#">Products</a></li>
                        <li><a href="#">Order</a></li>
                        <li><a href="#">Discount</a></li>
                    </ul>
                </div>

                <div class="right">
                   
                        <h1 class="heading">Update Product</h1>
                        <hr class="hr-top">
                
                    
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="product-name">
                                <label for="name">Product Name: </label>
                                <input type="text" name="productName" placeholder="Product Name" value="<?php echo $productName; ?>" required>
                            </div>

                            <div class="category">
                                <label for="category">Category:</label>
                                <select name="category" required>
                                    <?php
                                    
                                        $query = "SELECT * FROM PRODUCTCATEGORY WHERE TRADER_ID=$trader";
                                        $statement = oci_parse($connection, $query);
                                        oci_execute($statement);

                                        while($row1=oci_fetch_assoc($statement)) {
                                    ?>
                                    <option value = "<?php echo $row1['CATEGORY_ID']?>" <?php if($row1['CATEGORY_ID'] == $edit_category['CATEGORY_ID']){echo "selected";} ?>><?php echo $row1['CATEGORY_NAME']?></option>
                                    <?php } 
                                    
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="description">
                                <label for="description">Description: </label>
                                <input type="text" name="description" placeholder="Description" value="<?php echo $description; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="allergy-information">
                                <label for="allergy-information">Allergy Information: </label>
                                <input type="text" name="allergyInfo" placeholder="Allergy Information" value="<?php echo $alleryInfo; ?>" required>
                            </div>


                            <div class="stock">
                                <label for="stock">Stock Available: </label>
                                <input type="number" name="stock" placeholder="Stock" value="<?php echo $stock; ?>" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="price">
                                <label for="price">Price: </label>
                                <input type="number" name="price" placeholder="Price" value="<?php echo $price; ?>" required>
                            </div>

                            <div class="quantity">
                                <label for="quantity">Quantity: </label>
                                <input type="number" name="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="discount">
                                <label for="discount">Discount:</label>
                                <select name="discount">
                                    <option value="">None</option>
                                    <?php
                                
                                        $query = "SELECT * FROM DISCOUNT WHERE TRADER_ID = $trader";
                                        $statement = oci_parse($connection, $query);
                                        oci_execute($statement);

                                        while($row=oci_fetch_assoc($statement)) {
                                    ?>
                                    <option value = "<?php echo $row['DISCOUNT_ID']?>"><?php echo $row['DISCOUNT_PERCENTAGE']?></option>
                                    <?php } 
                                    ?>
                                    
                                </select>
                            </div>

                            <div class="product-image">
                                <label for="image">Product Image</label>
                                <input type="file" class="image-input" name="image" accept=".jpg,.jpeg,.png"><br />
                            </div>

                        </div>
                        <div class="btn-ctrl">
                            <input type="submit" name="submit" class="btn-prod" value="Save">
                            <input type="submit" name="submit" class="btn-prod" value="Delete">
                        </div>
                    </form>
                </div>
        </div>
    
    <?php
    include '../HN/footer.php';
    ?>
</body>
</html>