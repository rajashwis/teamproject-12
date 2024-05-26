<?php
session_start();
error_reporting(0);

include "../connect.php";

$user = $_SESSION['user_id']; 
$username = $_SESSION['username'];
$cart_id = $_SESSION['cart_id'];

$query = "SELECT * FROM CARTPRODUCT WHERE CART_ID = $cart_id";
$stid = oci_parse($connection, $query);
oci_execute($stid);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE CARTPRODUCT SET PRODUCT_QUANTITY = $quantity WHERE CART_ID = $cart_id AND PRODUCT_ID = $product_id";
    $stmt = oci_parse($connection, $sql);
    oci_execute($stmt);
}

if (isset($_POST['checkoutBtn'])) {
    header('Location: ../checkout/checkout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="cart.css">

</head>
<body>
    <?php include "../components/header.php"; ?>
    
    <div class="container">
        <form method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <?php while ($cart = oci_fetch_assoc($stid)) { 
                $product_id = $cart['PRODUCT_ID'];
                $query1 = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $product_id";
                $stid1 = oci_parse($connection, $query1);
                oci_execute($stid1);
                $product = oci_fetch_assoc($stid1);
            ?>
            <div class="card">
                <div class="image-container">
                    <?php
                        $imageData = $product['PRODUCT_IMAGE']->load();
                        $encodedImageData = base64_encode($imageData);
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
                <div class="content">
                    <h3><?php echo $product['PRODUCT_NAME']; ?></h3>
                    <div class="price">
                        <?php
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

                            $stid1 = oci_parse($connection, $query1);
                            oci_execute($stid1);
                            $discount_product = oci_fetch_assoc($stid1);

                            $product_id = $discount_product['PRODUCT_ID'];
                            $discount_id = $discount_product['DISCOUNT_ID'];

                            if ($discount_id) {
                                echo '<p>Price: <s>' . $product['PRICE'] . '</s> ' . $discount_product['DISCOUNTED_PRICE'] . ' <i class="fa-solid fa-tag"></i></p>';
                            } else {
                                echo '<p><br>' . $product['PRICE'] . ' <i class="fa-solid fa-tag"></i></p>';
                            }

                            $minimum = $product['MIN_ORDER'];
                            $maximum = $product['MAX_ORDER'];
                        ?>
                    </div>

                    <label for="quantity-control">Quantity:</label>
                        <div class="quantity-control">
                            <button type="button" class="minus-btn minus">-</button>
                            <input type="number" class="quantity num" name="quantity" value="<?php echo $minimum; ?>" min="<?php echo $minimum; ?>" max="<?php echo $maximum; ?>" />
                            <button type="button" class="plus-btn plus">+</button>
                        </div>

                    <div class="btn-remove">
                        <a href="cart_delete.php?delete=<?php echo $product['PRODUCT_ID']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Remove</a>
                    </div>

                    <div class="save-btn"><button type="submit" name="save">Save</button></div>
                </div>
            </div>
            <?php } ?>
            <button type="submit" class="checkout" id="checkoutBtn" name="checkoutBtn">Checkout</button>
        </form>
    </div>
    
    <?php include '../components/footer.php'; ?>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Event delegation for dynamically generated product cards
    document.addEventListener("click", function(event) {
        const target = event.target;
        if (target.matches('.plus-btn')) {
            const numInput = target.parentElement.querySelector('.num');
            increaseQuantity(numInput, <?php echo $maximum; ?>);
        } else if (target.matches('.minus-btn')) {
            const numInput = target.parentElement.querySelector('.num');
            decreaseQuantity(numInput, <?php echo $minimum; ?>);
        }
    });

    function increaseQuantity(input, maxQuantity) {
        let currentValue = parseInt(input.value);
        input.value = currentValue < maxQuantity ? currentValue + 1 : currentValue;
        updateLocalStorage(input);
    }

    function decreaseQuantity(input, minQuantity) {
        let currentValue = parseInt(input.value);
        input.value = currentValue > minQuantity ? currentValue - 1 : currentValue;
        updateLocalStorage(input);
    }

    function updateLocalStorage(input) {
        localStorage.setItem(input.id, input.value);
    }

    // Set initial values from localStorage
    const quantityInputs = document.querySelectorAll('.num');
    quantityInputs.forEach(function(input) {
        const storedValue = localStorage.getItem(input.id);
        if (storedValue !== null) {
            input.value = storedValue;
        }
    });
});

    </script>
</body>
</html>
