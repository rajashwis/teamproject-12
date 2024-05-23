<?php

    session_start();
    include "../connect.php";

    $trader = $_SESSION['user_id']; 

    if(!$trader) {
        header("Location: trader login.html");
        exit();
    }

    $query="SELECT * FROM DISCOUNT WHERE TRADER_ID = $trader";
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" href="cfxlocalhubwhitelogo.png">
    <link rel="stylesheet" type="text/css" href="discount.css">
    <link rel="stylesheet" type="text/css" href="discount1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Trader</title>
</head>
<body>
    <div class="home-page">
        <!--navbar-->
        <div class="navbar" id="nav">
            <nav>
                <ul>
                    <li><img class="logo" src="CFXLocalHub - White_Logo.png"></li>
                    <!-- <li><p class="cfx">CFX</p></li> -->
                    <li class="basket">
                        <img class="basket-icon" src="Image/login.png" height="40px">
                        <span class="trader-name">Trader's Name</span>
                    </li>
                </ul>
            </nav> 
        </div>
    </div> 
    
     <!-- Vertical navigation -->
     <div class="vertical-nav">
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">Order</a></li>
            <li><a class="active" href="#">Discount</a></li>
        </ul>
    </div>

    

<!-- <div class="column-box">
    <div class="column">SALES REVENUE</div>
    <div class="column">TOTAL SALES</div>
    <div class="column">TOTAL SALES</div>
    
</div>
<div class="big-box-container"> -->
    
    
    <div class="wrapper">
        <?php

            while($discount = oci_fetch_assoc($statement)) {
                    
                $imageData = $discount['DISCOUNT_IMAGE']->load();
                $encodedImageData = base64_encode($imageData);
                // Determine the image type based on the first few bytes of the image data
                $header = substr($imageData, 0, 4);
                $imageType = 'image/jpeg'; // default to JPEG
                if (strpos($header, 'FFD8') === 0) {
                    $imageType = 'image/jpeg'; // JPEG
                } elseif (strpos($header, '89504E47') === 0) {
                    $imageType = 'image/png'; // PNG
                }

                echo '<div class="container">';
                echo '<div class="image">';
                echo '<img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image">';
                echo '</div>';
                echo '<div class="discount-details">';
                echo '<div class="text-1">Discount Details:</div>';
                echo '<div class="text-2">';
                echo '<div>'.$discount['DISCOUNT_PERCENTAGE'].'%</div>';
                echo '<div>Start Date: '.$discount['START_DATE'].'</div>';
                echo '<div>End Date: '.$discount['END_DATE'].'</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="container-btn">';
                echo '<button id="btn-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>';
                echo '<button id="btn-2"><i class="fa-solid fa-trash"></i> Delete</button>';
                echo '</div>';
                echo '</div>';

            }

        ?>
 
    </div>

    <div id="popup-box" class="popup-box">
        <div class="popup-content">
            <span class="close-btn">&times;</span>
            <h2>Edit Discount</h2>
            <div class="upload-upload">
                <label for="image-upload">Upload Image:</label>
                <input type="file" id="image-upload" name="image-upload">
            </div>
            <br>
            <div class="discount-discount">
                <label for="discount">Discount:</label>
                <input type="text" id="discount" name="discount">
            </div>
            <div class="start-date-end-date">
                Start Date :
                <input type="date" id="start-date"><br/><br/>
                End Date : 
                <input type="date" id="end-date">
            </div>
            <br>
            <button class="save-btn">Save</button>
        </div>
    </div>

    <script>
        var popupBox = document.getElementById("popup-box");

        var editButtons = document.querySelectorAll("#btn-1");

        var closeBtn = document.querySelector(".close-btn");

        editButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                popupBox.style.display = "block";
            });
        });

        closeBtn.addEventListener("click", function() {
            popupBox.style.display = "none";
        });

        window.addEventListener("click", function(event) {
            if (event.target == popupBox) {
                popupBox.style.display = "none";
            }
        });
    </script>
</body>
</html>