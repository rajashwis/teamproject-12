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

    if(isset($_POST['closeBtn'])) {
        $collection_slot = $_POST['pickup-time'];
    }

    include "../HN/nav1.php";
    include "../HN/nav2.php";

    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $paypalID = 'sb-nv9tx30555823@business.example.com'; //Business Email

    function getValidDays() {
        $validDays = [];
        $now = new DateTime();
        $now->setTime(0, 0, 0);
    
        // Loop to find the next valid Wed, Thu, Fri
        for ($i = 1; $i <= 14; $i++) {
            $day = clone $now;
            $day->modify("+$i days");
            $dayName = $day->format('D');
    
            if (in_array($dayName, ['Wed', 'Thu', 'Fri'])) {
                $validDays[] = $day;
            }
        }
    
        return $validDays;
    }
    
    function generateDayOptions() {
        $validDays = getValidDays();
        $options = '';
    
        foreach ($validDays as $day) {
            $formattedDay = $day->format('Y-m-d');
            $dayName = $day->format('l, F j, Y');
            $options .= "<option value=\"$formattedDay\">$dayName</option>";
        }
    
        return $options;
    }
    
    function generateTimeOptions($selectedDay = null) {
        $timeSlots = ['10-13', '13-16', '16-19'];
        $options = '';
    
        if ($selectedDay) {
            $now = new DateTime();
            $currentHour = (int)$now->format('H');
            $currentDay = $now->format('Y-m-d');
    
            // If the selected day is the same as today, filter time slots
            if ($selectedDay == $currentDay) {
                foreach ($timeSlots as $slot) {
                    $slotStartHour = (int)explode('-', $slot)[0];
                    if ($slotStartHour > $currentHour + 24) {
                        $options .= "<option value=\"$slot\">$slot</option>";
                    }
                }
            } else {
                foreach ($timeSlots as $slot) {
                    $options .= "<option value=\"$slot\">$slot</option>";
                }
            }
        } else {
            foreach ($timeSlots as $slot) {
                $options .= "<option value=\"$slot\">$slot</option>";
            }
        }
    
        return $options;
    }
    


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="checkout.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Document</title>
</head>
<body>
    <?php
        include "../components/header.php";
    ?>
    <main>
    <h3>Checkout</h3>

        <section class="checkout-details">
            <div class="checkout-details-inner">
                <div class="checkout-lists">

                <?php

                    $totalPrice = 0;
                    $count = 0;

                    while($cartproduct = oci_fetch_assoc($stid)) {
                        $count++;

                        $product_id = $cartproduct['PRODUCT_ID'];
                        $quantity = $cartproduct['PRODUCT_QUANTITY'];

                        $query3 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $product_id";
                        $statement3 = oci_parse($connection, $query3);
                        oci_execute($statement3);
                        $product = oci_fetch_assoc($statement3);

                        addToCart($product_id, $item_quantity);

                        $shop_id = $product['SHOP_ID'];
                        $query5 = "SELECT * FROM SHOP WHERE SHOP_ID = $shop_id";
                        $stid5=oci_parse($connection, $query5);
                        oci_execute($stid5);
                        $shop = oci_fetch_assoc($stid5);

                        echo '<div class="card">';

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

                        echo '';
                        echo '<div class="card-image"><img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"></div>';
                        echo '<div class="card-details">';
                        echo '<div class="card-name">';
                        echo $product['PRODUCT_NAME'].',';
                        echo '<a href="#"> <i class="fa-solid fa-store"></i>'.$shop['SHOP_NAME'].'</a>';
                        echo '</div>';

                        $query4 = "SELECT 
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

                        $stid4=oci_parse($connection, $query4);
                        oci_execute($stid4);
                        $discount_product = oci_fetch_assoc($stid4);

                        $product_id = $discount_product['PRODUCT_ID'];
                        $discount_id = $discount_product['DISCOUNT_ID'];

                        

                        if($discount_id) {
                            echo '<div class="card-price">'.$discount_product['DISCOUNTED_PRICE']. '<span>'.$product['PRICE'].'</span></div>';
                            $price = $discount_product['DISCOUNTED_PRICE'];
                            $totalPrice += ($quantity * $price);
                        }
                        else {
                            echo '<div class="card-price">'.$discount_product['DISCOUNTED_PRICE'].'</div>';
                            $price = $product['PRICE'];
                            $totalPrice += ($quantity * $price);
                        }

                        echo '<div class="card-price">';
                        echo 'Quantity: '.$quantity.'';
                        // echo '<button onclick="decrement()">-</button>';
                        // echo '<span id="quantity">1</span>';
                        // echo '<button onclick="increment()">+</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        

                    } 

                ?>
                    
                </div>
        
                <div class="checkout-total">
                    <h6>Total</h6>
                    <p><?php echo $totalPrice ?></p>
                </div>
            </div>
        </section>
        <br/>
        <section>
            <button class="c-btn" id="deliveryBtn">Collection Slot</button>
        </section>
    
        <div id="overlay" class="overlay"></div>
        <div id="popup" class="popup">
            <form method="POST" action="process_slot.php">
            <h2>Delivery Hours</h2><br/>
                <label for="day">Select Day:<br/></label>
                <select id="pickup-time" name="day">
                    <option value="">Select Day >></option>
                    <?php echo generateDayOptions(); ?>
                </select>

                <label for="time">Select Time:<br/></label>
                <select id="pickup-time" name="time">
                    <option value="">Select Time >></option>
                    <?php echo generateTimeOptions(); ?>
                </select>
                
                <br><br>
                <button type="submit" name="closeBtn" id="closeBtn">Close</button>
            </form>
        </div>

        <form action="<?php echo $paypalURL; ?>" method="post">
        <input type="hidden" name="business" value="<?php echo $paypalID;?>">

        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="item_name" value="A bunch of stuff">
        <input type="hidden" name="item_number" value="0001">
        <input type="hidden" name="amount" value="<?php echo $totalPrice;?>">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="quantity" value="1">

        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost/teamproject-12/checkout/checkout.php'>
        <input type='hidden' name='return' value='http://localhost/teamproject-12/checkout/process_order.php?total_price=<?php echo $totalPrice;?>'>

        <!-- Display the payment button. -->
        <input type="image" name="submit" border="0"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        <img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
        </form>
        
        <?php 
            if(isset($_POST['okBtn'])) {
                echo '<script>alert(' . $totalPrice . ')</script>';

                
                $delete_query = "DELETE FROM CARTPRODUCT WHERE ";
            }
        ?>


        
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

    <?php    include "../HN/footer.php"; ?>


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

<?php
        include "../components/footer.php";
    ?>
</body>
</html>
