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
    include '../component/header.php';
    ?>

    <h1 class="heading">Add Products</h1>
    <hr class="hr-top">

    <div class="container">
        <div class="menu">
            <ul>
                <li><a href="">Dashboard</a></li>
                <li><a href="">Shop</a></li>
                <li><a class="active" href="">Product</a></li>
                <li><a href="">Orders</a></li>
            </ul>
        </div>

        <div class="right">


            <form action="">
                <div class="form-group">
                    <div class="product-name">
                        <label for="name">Product Name: </label>
                        <input type="text" name="name" placeholder="Product Name" required>
                    </div>

                    <div class="category">
                        <label for="category">Category:</label>
                        <select name="category" required>
                            <option value="">Select a category</option>
                            <option value="electronics">A</option>
                            <option value="books">B</option>
                            <option value="books">C</option>
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
                        <input type="text" name="allergy-information" placeholder="Allergy Information" required>
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
                        <select name="discount" required>
                            <option value="">NO</option>
                            <option value="10%">10%</option>
                            <option value="20%">20%</option>
                        </select>
                    </div>

                    <div class="product-image">
                        <label for="image">Product Image</label>
                        <input type="file" class="image-input" name="image" accept=".jpg,.jpeg,.png"><br />
                    </div>

                </div>

                <div class="btn-add-product">
                    <button type="submit">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    include '../component/footer.php';
    ?>
</body>
</html>