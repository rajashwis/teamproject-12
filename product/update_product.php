
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

    <div class="wrapper">
        <div class="navbar-trader">
            <div class="trader-profile">
                <img src="../resources/user.jpg" alt="trader_profile">
                <h4>John Cena</h4>
            </div>
            <button class="logout">
                Logout
            </button>
        </div>

        <div class="head">
            <h1 class="heading">Update Product</h1>
            <hr class="hr-top">
        </div>

        <div class="main">
            <div class="container">
                <div class="vertical-nav">
                    <ul>
                        <li><a class="active" href="#">Dashboard</a></li>
                        <li><a href="#">Products</a></li>
                        <li><a href="#">Order</a></li>
                        <li><a href="#">Discount</a></li>
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
        </div>

    </div>
    
    <?php
    include '../HN/footer.php';
    ?>
</body>
</html>