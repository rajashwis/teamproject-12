<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css" />
</head>
<body>
    <?php
        include '../HN/navbar.php';
    ?> 
    <div class="container">
        <h1>Your Cart</h1>
        <div class="product-details">
            <div class="image-container">
                <img src="../resources/products/bakery1.jpg" alt="Product Image" />
            </div>
            <div class="content">
                <h3>Product Name</h3>
                <p>
                    Description: Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit.
                </p>
                <div class="price">
                    <p>Price: $19.99</p>
                </div>
                <label for="quantity-control">Quantity:</label>
                <div class="quantity-control">
                    <button class="minus-btn" id="minusBtn">-</button>
                    <input type="number" class="quantity" name="quantity" value="1" min="1" />
                    <button class="plus-btn" id="plusBtn">+</button>
                </div>

                <button class="btn">Remove</button>
            </div>
        </div>
    </div>
    <?php
        include '../HN/footer.php';
    ?> 


    <script src="cart.js"></script>
</body>
</html>