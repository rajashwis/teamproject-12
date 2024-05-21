<?php

    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id'];
    $username = $_SESSION['username']; 
    $cart_id = $_SESSION['cart_id'];

    $query2 = "SELECT COUNT(*) FROM CARTPRODUCT";
    $stid2=oci_parse($connection, $query2);
    oci_execute($stid2);
    $count = oci_fetch_assoc($stid2);
    $count = $count['COUNT(*)'];

    echo '<script>alert(' . $count . ')</script>';

    $query = "SELECT * FROM CARTPRODUCT WHERE CART_ID = $cart_id";
    $stid=oci_parse($connection, $query);
    oci_execute($stid);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    function addToCart($product_id, $item_quantity) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $item_quantity;
        } else {
            $_SESSION['cart'][$product_id] = $item_quantity;
        }
    }

    include "../HN/nav1.php";
    include "../HN/nav2.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="check-out1.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Document</title>
</head>
<body>
    <main>
    <h3>Checkout</h3>

        <section class="checkout-details">
            <div class="checkout-details-inner">
                <div class="checkout-lists">

                <?php

                    while($cartproduct = oci_fetch_assoc($stid)) {

                    $product_id = $cartproduct['PRODUCT_ID'];
                    $quantity = $cartproduct['PRODUCT_QUANTITY'];

                    $query3 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $product_id";
                    $statement3 = oci_parse($connection, $query3);
                    oci_execute($statement3);
                    $product = oci_fetch_assoc($statement3);

                    addToCart($product_id, $item_quantity);

                    echo '<div class="card">';
                    echo '<div class="card-image"><img src="../resources/products/jordan.jpg" alt=""></div>';
                    echo '<div class="card-details">';
                    echo '<div class="card-name">';
                    echo $product['PRODUCT_NAME'].',';
                    echo '<a href="#"> <i class="fa-solid fa-store"></i> Shopname</a>';
                    echo '</div>';
                    echo '<div class="card-price">RS.21000 <span>$27000</span></div>';
                    echo '<div class="card-wheel">';
                    echo '<button onclick="decrement()">-</button>';
                    echo '<span id="quantity">1</span>';
                    echo '<button onclick="increment()">+</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    } 

                ?>
                    
                </div>
        
                <div class="checkout-total">
                    <h6>Total</h6>
                    <p>Rs.21570</p>
                </div>
            </div>
        </section>
        <br/>
        <section>
            <button id="deliveryBtn">Collection Slot</button>
        </section>
    
        <div id="overlay" class="overlay"></div>
        <div id="popup" class="popup">
            <h2>Delivery Hours</h2><br/>
            <label for="pickup-time">Collection Slot:<br/></label>
            <select id="pickup-time" name="pickup-time">
                <option value="1">Wednesday (10:00 - 13:00)</option>
                <option value="2">Wednesday (13:00 - 16:00)</option>
                <option value="3">Wednesday (16:00 - 19:00)</option>
                <option value="4">Thursday (10:00 - 13:00)</option>
                <option value="5">Thursday (13:00 - 16:00)</option>
                <option value="6">Thursday(16:00 - 19:00)</option>
                <option value="7">Friday (10:00 - 13:00)</option>
                <option value="8">Friday (13:00 - 16:00)</option>
                <option value="9">Friday (16:00 - 19:00)</option>
            </select>
            
            <br><br>
            <button id="closeBtn">Close</button>
        </div>
        
        <section class="payment-method">
            <h2>Payment Method</h2><br/>
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
            <script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
            <script>
                function initPayPalButton() {
                    paypal.Buttons({
                        style: {
                            shape: 'rect',
                            color: 'gold',
                            layout: 'vertical',
                            label: 'paypal',
                        },
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{"amount":{"currency_code": "USD", "value": 0.99}}]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(orderData) {
                                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                const element = document.getElementById('paypal-button-container');
                                element.innerHTML = '';
                                element.innerHTML = '<h3>Thank you for your payment!</h3>';
                            });
                        },
                        onError: function(err) {
                            console.log(err);
                        }
                    }).render('#paypal-button-container');
                }
                initPayPalButton();
            </script>
        </section>
    </main>

    <?php    include "../HN/footer.php"; ?>s


<script>
        // Get the elements
        const deliveryBtn = document.getElementById('deliveryBtn');
        const overlay = document.getElementById('overlay');
        const popup = document.getElementById('popup');
        const closeBtn = document.getElementById('closeBtn');

        // Function to show the popup
        function showPopup() {
            overlay.style.display = 'block';
            popup.style.display = 'block';
        }

        // Function to hide the popup
        function hidePopup() {
            overlay.style.display = 'none';
            popup.style.display = 'none';
        }

        // Event listeners
        deliveryBtn.addEventListener('click', showPopup);
        closeBtn.addEventListener('click', hidePopup);
        overlay.addEventListener('click', hidePopup);


        // JavaScript to handle increment and decrement functionality
        function increment() {
            var quantityElement = document.getElementById('quantity');
            var quantity = parseInt(quantityElement.textContent);
            quantity++;
            quantityElement.textContent = quantity;
        }

        function decrement() {
            var quantityElement = document.getElementById('quantity');
            var quantity = parseInt(quantityElement.textContent);
            if (quantity > 1) {
                quantity--;
                quantityElement.textContent = quantity;
            }
        }
</script>
</body>
</html>
