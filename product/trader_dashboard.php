<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Sort Product</title>
    <link rel="stylesheet" href="trader_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>


    <main class="container">



        <div class="navbar-trader">
            <div class="trader-profile">
                <img src="../resources/user.jpg" alt="trader_profile">
                <h4>John Cena</h4>
            </div>
            <button class="logout">
                Logout
            </button>
        </div>

        <div class="category-selection">
            <select id="category-select" name="category">
                <option value="1">Bakery</option>
                <option value="2">Dairy</option>
                <option value="3">Fruits</option>
                <option value="4">Vegetables</option>
            </select>

            <button>Sort</button>
        </div>


        <div class="main">
            
            <div class="menu">
                <ul>
                    <li><a class="active" href="">Dashboard</a></li>
                    <li><a href="">Shop</a></li>
                    <li><a href="">Product</a></li>
                    <li><a href="">Orders</a></li>
                </ul>
            </div>

            <div class="image-container-group">
                <!-- box1-->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery1.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <div class="category">
                            <p class="price">$49.99 <i class="fa-solid fa-tag"></i></p><br>
                            <h3>Bakery</h3>
                        </div>
                        <!-- <button class="add-to-cart"><a href="cart.html">Add to Cart</a></button> -->
                    </div>
                </div>

                <!-- box2-->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery2.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <div class="category">
                            <p class="price">$49.99 <i class="fa-solid fa-tag"></i></p><br>
                            <h3>Bakery</h3>
                        </div>
                        <!-- <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button> -->
                    </div>
                </div>



                <!-- box3 -->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery2.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <div class="category">
                            <p class="price">$49.99 <i class="fa-solid fa-tag"></i></p><br>
                            <h3>Bakery</h3>
                        </div>
                        <!-- <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button> -->
                    </div>
                </div>


                <!-- box 4 -->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery2.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <div class="category">
                            <p class="price">$49.99 <i class="fa-solid fa-tag"></i></p><br>
                            <h3>Bakery</h3>
                        </div>
                        <!-- <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button> -->
                    </div>
                </div>

                <!-- box5 -->
                   <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery1.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <div class="category">
                            <p class="price">$49.99 <i class="fa-solid fa-tag"></i></p><br>
                            <h3>Bakery</h3>
                        </div>
                        <!-- <button class="add-to-cart"><a href="cart.html">Add to Cart</a></button> -->
                    </div>
                </div>


                <!-- box6 -->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery1.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <div class="category">
                            <p class="price">$49.99 <i class="fa-solid fa-tag"></i></p><br>
                            <h3>Bakery</h3>
                        </div>
                        <!-- <button class="add-to-cart"><a href="cart.html">Add to Cart</a></button> -->
                    </div>
                </div>
            </div>
        </div>
    </main>



</body>
</html>