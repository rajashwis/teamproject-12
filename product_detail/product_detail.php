
<?php


    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id'];

    if (isset($_SESSION['cart_product_added']) && $_SESSION['cart_product_added'] === true) {
        echo "<script>alert('Product Added to Cart!')</script>";
        unset($_SESSION['cart_product_added']);
    }

    if (isset($_SESSION['wishlist_product_added']) && $_SESSION['wishlist_product_added'] === true) {
        echo "<script>alert('Product Added to Wishlist!')</script>";
        unset($_SESSION['wishlist_product_added']);
    }

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        $query="SELECT * from PRODUCT WHERE product_id = $product_id";
        $stid=oci_parse($connection, $query);
        oci_execute($stid);
        $product = oci_fetch_assoc($stid);
        $category_id = $product['CATEGORY_ID'];
        $shop_id = $product['SHOP_ID'];

        $query1 = "SELECT * FROM PRODUCTCATEGORY WHERE category_id = $category_id";
        $stid1=oci_parse($connection, $query1);
        oci_execute($stid1);
        $category = oci_fetch_assoc($stid1);

        $query2 = "SELECT * FROM SHOP WHERE shop_id = $shop_id";
        $stid2=oci_parse($connection, $query2);
        oci_execute($stid2);
        $shop = oci_fetch_assoc($stid2);

        if(isset($_POST['post-review'])) {

            $rating = $_POST['rating'];
            $review = $_POST['review'];

            echo "<script>alert('".$user.", ".$product_id."')</script>";
    
            $query3 = "INSERT INTO REVIEW VALUES (SEQ_REVIEW_ID.NEXTVAL, $rating, '$review', SYSDATE, $user, $product_id)";
            $statement3 = oci_parse($connection, $query3);
            oci_execute($statement3);
            
        }

    }

    else {
        header('location: ../homepage/home.php');
    }

    if (isset($_POST['add_to_cart'])) {

        if(!$user) {
            header('LOCATION: ../signin/signin.html');
        }

        else {
            $quantity = $_POST['quantity'];

            $product_query = "SELECT STOCK_AVAILABLE FROM PRODUCT WHERE PRODUCT_ID = $product_id";
            $product_stid=oci_parse($connection, $product_query);
            oci_execute($product_stid);
            $product_stock = oci_fetch_assoc($product_stid);
            $stock = $product_stock['STOCK_AVAILABLE'];

            $stock_ = $stock - 2;

            if($quantity > $stock_) {
                echo "<script>alert('Not enough stock available!')</script>";
            }

            else {

                $query="SELECT CART_ID from CUSTOMER WHERE customer_id = $user";
                $stid=oci_parse($connection, $query);
                oci_execute($stid);
                $row = oci_fetch_assoc($stid);
                $cart_id = $row['CART_ID'];

                $query1 = "SELECT PRODUCT_ID FROM CARTPRODUCT WHERE CART_ID = $cart_id AND PRODUCT_ID = $product_id";
                $stid1 = oci_parse($connection, $query1);
                oci_execute($stid1);
                $row1 = oci_fetch_assoc($stid1);

                if($row1) {
                    echo "<script>alert('Product already in Cart!')</script>";
                }

                else {
                    $query1="INSERT INTO CARTPRODUCT VALUES (SEQ_CARTPRODUCT_ID.NEXTVAL, $cart_id, $product_id, $quantity)";
                    $stid1=oci_parse($connection, $query1);
                    
                    if(oci_execute($stid1)) {
                        $_SESSION['cart_product_added'] = true;
                        header("LOCATION: ../product_detail/product_detail.php?product_id=$product_id");
                    }
                    
                }

            }
            
        }

    }

    if (isset($_POST['wishlist_button'])) {

        if(!$user) {
            header('LOCATION: ../signin/signin.html');
        }

        else {
            $query="SELECT * from WISHLIST WHERE customer_id = $user";
            $stid=oci_parse($connection, $query);
            oci_execute($stid);
            $row = oci_fetch_assoc($stid);
            $wishlist_id = $row['WISHLIST_ID'];

            $query1 = "SELECT PRODUCT_ID FROM WISHLISTPRODUCT WHERE PRODUCT_ID = $product_id";
            $stid1=oci_parse($connection, $query1);
            oci_execute($stid1);
            $row = oci_fetch_assoc($stid1);

            if($row) {
                echo "<script>alert('Product already in Wishlist!')</script>";
            }

            else {
                $query1 = "INSERT INTO WISHLISTPRODUCT VALUES (SEQ_WISHLISTPRODUCT_ID.NEXTVAL, $wishlist_id, $product_id)";
                $stid1=oci_parse($connection, $query1);
                
                if(oci_execute($stid1)) {
                    $_SESSION['wishlist_product_added'] = true;
                    header("LOCATION: ../product_detail/product_detail.php?product_id=$product_id");
                }
                
            }
            
        }

    }
    
    
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="product_detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>CFXLocalHub HOME PAGE</title>
</head>
<body>
    
    <?php include "../components/header.php"?>

   
    <main class="main">
         <!-- DEEPA Front end -->
        <div class="container">
            <div class="product-details">
                <div class="image-container">
                    <!---IMAGE--->
                    <?php
                        $imageData = $product['PRODUCT_IMAGE']->load();
                        $encodedImageData = base64_encode($imageData);
                        // Determine the image type based on the first few bytes of the image data
                        $header = substr($imageData, 0, 4);
                        $imageType = 'image/jpeg'; // default to JPEG
                        if (strpos($header, 'FFD8') === 0) {
                            $imageType = 'image/jpeg'; // JPEG
                        } elseif (strpos($header, '89504E47') === 0) {
                            $imageType = 'image/png'; // PNG
                        }

                        echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';

                    ?>
                </div>
                <form method="POST">
                    <button class="wishlist-btn" type="submit" name="wishlist_button">&#10084;</button>
                </form>
                <div class="content">
                    <?php
                        echo '<h2>'.$product['PRODUCT_NAME'].'</h2>';
                        echo '<p>'.$product['DESCRIPTION_'].'</p>';
                        echo '<p> Store: '.$shop['SHOP_NAME'].'</p>';

                        $query1 = "SELECT 
                            p.*, 
                            d.discount_percentage, 
                            p.price * (1 - d.discount_percentage / 100) AS discounted_price
                        FROM 
                            product p
                        JOIN 
                            shop s ON p.shop_id = s.shop_id
                        JOIN 
                            discount d ON p.discount_id = d.discount_id 
                                    AND s.trader_id = d.trader_id
                        WHERE
                            product_id = $product_id";

                        $stid1=oci_parse($connection, $query1);
                        oci_execute($stid1);
                        $discount_product = oci_fetch_assoc($stid1);

                        $product_id = $discount_product['PRODUCT_ID'];
                        $discount_id = $discount_product['DISCOUNT_ID'];

                        if($discount_id) {
                            echo '<p>Price: <strike>'.$product['PRICE'].'</strike>&nbsp'.$discount_product['DISCOUNTED_PRICE'].'</p>';
                        }
                        else {
                            echo '<p>Price: '.$product['PRICE'].'</p>';
                        }

                        echo '<form method="POST">';
                        echo '<div class="quantity-input">';
                        echo '<label for="quantity">Quantity:</label>';
                        echo '<div class="quantity-control">';
                        echo '<button class="minus-btn" id="minusBtn">-</button>';
                        echo '<input type="number" id="quantity" name="quantity" value="1" min="'.$product['MIN_ORDER'].'" max="'.$product['MAX_ORDER'].'">';
                        echo '<button class="plus-btn" id="plusBtn">+</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<input type="submit" class = "add-to-cart-btn" value="Add to Cart" name="add_to_cart">';
                        echo '</form>';
                    ?>
                </div>
            </div>
        </div>  


        <div class="customer-reviews-container">


            <div class="rating">
                <p>Rating 5.0 </p>
                <div class="rating-row">
                    <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                </div>
                <!--add review-->
                <section class="add-review">
                    <button onclick="showReviewPopup()">Add Review</button>
                </section>
                
                <form method="POST">
                    <div id="review-popup" class="review-popup">
                        <span class="close-btn" onclick="closeReviewPopup()">&times;</span>
                        <h2>Add Review</h2>
                        <div class="rating-rows">
                            <select name="rating" id="options">
                                <option value="default">--Choose a Rating--</option>
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                            </select>
                        </div><br/>
                        <textarea id="comment" name="review" placeholder="Write your review here"></textarea>
                        <button type = "submit" name="post-review">Post Review</button>
                        <!-- <button onclick="postReview()">Post Review</button> -->
                    </div>
                </form>



            <hr class="comment-line">
                <div class="comments">
                    <div class="customer-profile">
                        <div class="profile-img">
                            <img src="../resources/user.jpg" alt="profile-img">
                        </div>
                        <h5 class="customer-name">John Doe</h5>
                    </div>
                    <div class="customer-ratings">
                        <h5>Rate:</h5>
                        <div class="rating-rows">
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="comment-text">
                        <p>This is the user review for the elit. Illo culpa eligendi quibusdam vel consequuntur, non dicta nulla exercitationem! Laudantium libero quos rem perferendis mollitia beatae sequi laborum consequatur neque sunt recusandae, voluptate blanditiis. Consequuntur, sed? Aperiam  asperiores?</p>
                    </div>
                    <hr>
                </div>
                

                <div class="comments">
                    <div class="customer-profile">
                        <div class="profile-img">
                            <img src="../resources/user.jpg" alt="profile-img">
                        </div>
                        <h5 class="customer-name">John Doe</h5>
                    </div>
                    <div class="customer-ratings">
                        <h5>Rate:</h5>
                        <div class="rating-rows">
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="comment-text">
                        <p>This is the user review for the product Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cupiditate voluptatem molestiae vel accusantium sequi dolorum dicta officiis, quibusdam aperiam exercitationem.culpa eligendi quibusdam vel consequuntur, non dicta nulla exercitationem! Laudantium libero quos rem perferendis mollitia beatae sequi laborum consequatur neque sunt recusandae, voluptate blanditiis. Consequuntur, sed? Aperiam  asperiores?</p>
                    </div>
                </div>



            <!-- <div class="comments">
                <div class="customer-profile">
                    <div class="profile-img">
                        <img src="../resources/user.jpg" alt="profile-img">
                    </div>
                    <h5 class="customer-name">John Doe</h5>
                </div>
                <div class="customer-ratings">
                    <h5>Rate:</h5>
                    <div class="rating-rows">
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                        <span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                    </div>
                </div>
                <div class="comment-box">
                    <textarea placeholder="Add your comment here..."></textarea>
                    <button class="add-comment-btn">Add Comment</button>
                </div>
            </div> -->
        </div>
    </main>

    <?php include "../components/footer.php"?>

    <script type="text/javascript" src="product_details.js"></script>
    <script>
        const toggleBtn = document.querySelector('.toggle')
        const toggleBtnIcon = document.querySelector('.toggle i')
        const dropdown = document.querySelector('.dropdown')

        toggleBtn.onclick = function () {
            dropdown.classList.toggle('open')

            toggleBtnIcon.classList = isOpen
                ? 'fa-solid fa-xmark'
                : 'fa-solid fa-bars'
        }

        let profileDropdownList = document.querySelector(".profile-dropdown-list");
        let btn = document.querySelector(".profile-dropdown-btn");

        let classList = profileDropdownList.classList;

        const toggle = () => classList.toggle("active");

        window.addEventListener("click", function (e) {
            if (!btn.contains(e.target)) classList.remove("active");
        });

        //review

        function showReviewPopup() {
    document.getElementById('review-popup').style.display = 'block';
}

function closeReviewPopup() {
    document.getElementById('review-popup').style.display = 'none';
}

function postReview() {
    // You can add code here to handle posting the review
    // For example, you can collect rating and comment values and send them to the server
    // let rating = document.querySelector('input[name="rating"]:checked').value;
    // let comment = document.getElementById('comment').value;

    // Here you can send the review data to the server using AJAX or any other method
    // console.log("Rating: " + rating);
    // console.log("Comment: " + comment);

    let rating = document.getElementById('chosenStars').value;
    let comment = document.getElementById('comment').value;


    // Close the popup after posting review
    closeReviewPopup();
}


//star


    function rate(stars) {

        document.getElementById('chosenStars').value = stars;
        
        const starIcons = document.querySelectorAll('.rating-rows .star i');
        starIcons.forEach((star, index) => {
            if (index < stars) {
                star.classList.remove('fa-star-o');
                star.classList.add('fa-star');
                star.style.color = 'orange';
            } else {
                star.classList.remove('fa-star');
                star.classList.add('fa-star-o');
                star.style.color = '';
            }
        });
    }
    </script>
</body>
</html>