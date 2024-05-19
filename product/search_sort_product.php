<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Sort Product</title>
    <link rel="stylesheet" href="search_sort_product.css">
</head>
<body>
    <?php
    include '../component/header.php';
    ?>

    <main class="container">

        <div class="offer-banner">
            <input type="text" name="offerText" class="offerText" placeholder=" Special Offer Here">
        </div>


        <div class="main">


            <section class="shop">
                <!-- <select id="options">
                    <option value="A">Butcher</option>
                    <option value="B">Greengrocer</option>
                    <option value="C">Fishmonger</option>
                    <option value="D">Bakery</option>
                    <option value="E">Delicatessen</option>
                </select> -->

                <div class="filters">
                    Shop:
                    <label><input type="checkbox" id="cat1"> Category 1</label>
                    <label><input type="checkbox" id="cat2"> Category 2</label>
                    <label><input type="checkbox" id="cat3"> Category 3</label>
                </div>

                <div class="filters">
                    Categories:
                    <label><input type="checkbox" id="cat1"> Category 1</label>
                    <label><input type="checkbox" id="cat2"> Category 2</label>
                    <label><input type="checkbox" id="cat3"> Category 3</label>
                </div>

                <div class="filters">
                    Discount:
                    <label><input type="checkbox" id="cat1"> Category 1</label>
                    <label><input type="checkbox" id="cat2"> Category 2</label>
                    <label><input type="checkbox" id="cat3"> Category 3</label>
                </div>

            </section>




            <div class="image-container-group">

                <!-- box1-->

                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery1.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                        <div class="bakery">
                            <p>Bakery</p>
                        </div>

                        <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button>

                    </div>
                </div>

                <!-- box2-->
                <div class="image-container">
                    <div class="image-box">
                    <img src="../resources/products/bakery2.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                        <div class="bakery">
                            <p>Bakery</p>
                        </div>

                        <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button>

                    </div>
                </div>



                <!-- box3 -->
                <div class="image-container">
                    <div class="image-box">
                    <img src="../resources/products/bakery2.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                        <div class="bakery">
                            <p>Bakery</p>
                        </div>
                        <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button>
                    </div>
                </div>


                <!-- box 4 -->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery2.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                        <div class="bakery">
                            <p>Bakery</p>
                        </div>

                        <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button>

                    </div>
                </div>

                <!-- box5 -->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery1.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                        <div class="bakery">
                            <p>Bakery</p>
                        </div>

                        <button class="add-to-cart"><a href="cart.html">Add-to-Cart</a></button>

                    </div>
                </div>


                <!-- box6 -->
                <div class="image-container">
                    <div class="image-box">
                        <img src="../resources/products/bakery1.jpg" alt="Image 1">
                    </div>
                    <div class="description-box">
                        <h1>BLACK FOREST CAKE </h1>
                        <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                        <div class="bakery">
                            <p>Bakery</p>
                        </div>

                        <button class="add-to-cart"><a href="cart.html">Add to Cart</a></button>
                    </div>
                </div>
            </div>




            <!-- <aside class="sort-by">
                <label for="sort">Sort by:</label>
                <select id="sort">
                    <option value="price">Price</option>
                    <option value="name">Rating</option>
                </select>
            </aside> -->

        </div>
    </main>

    <?php
    include '../component/footer.php';
    ?>

</body>
</html>