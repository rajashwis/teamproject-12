<?php

session_start();
error_reporting(0);

include "../connect.php";

$user = $_SESSION['user_id']; 
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="favicon" rel="icon" type="image/x-icon" href="cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>CFXLocalHub HOME PAGE</title>
</head>
<body>
    <div class="home-page">
        <!--HEADER-->
        <?php

            include "../component/header.php";
            include "../component/navbar2.php";

        ?>
        
        <!--products-->
        <div class="container">
            <div class="card">
                <div class="image-container">
                    <?php
                        $query="SELECT * from PRODUCT WHERE product_id = 112";
                        $stid=oci_parse($connection, $query);
                        oci_execute($stid);
                        $row = oci_fetch_assoc($stid);
                        $product_id = $row['PRODUCT_ID'];
                        
                        $category_id = $row['CATEGORY_ID'];
                        $query1 = "SELECT * FROM PRODUCTCATEGORY WHERE category_id = $category_id";
                        $stid1=oci_parse($connection, $query1);
                        oci_execute($stid1);
                        $category = oci_fetch_assoc($stid1);

                        $imageData = $row['PRODUCT_IMAGE']->load();

                        $encodedImageData = base64_encode($imageData);
            
                        $header = substr($imageData, 0, 4);
                        $imageType = 'image/jpeg';
                        if (strpos($header, 'FFD8') === 0) {
                            $imageType = 'image/jpeg'; 
                        } elseif (strpos($header, '89504E47') === 0) {
                            $imageType = 'image/png';
                        }

                        echo '<a href="../product_detail/product_detail.php?product_id='.$product_id.'">';
                        echo '<td><img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"></td></a>';
                        echo '<h1>'.$row['PRODUCT_NAME'].'</h1>';
                        echo '<p class="price">'.$row['PRICE'].'<i class="fa-solid fa-tag"></i></p>';
                        echo '<p>'.$category['CATEGORY_NAME'].'</p>';
                    ?>
                </div>
                <p><button>Buy</button></p><br>
            </div>
        </div>
        <!--slide-->
        <div class="slideshow-container">
            <div class="slides">
              <img src="../resources/slide_img1.jpg" alt="Image 1">
              <img src="../resources/slide_img2.jpg" alt="Image 2">
              <img src="../resources/slide-img3.jpg" alt="Image 3">
            </div>
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>
        </div>
    </div>
    <!--Sales-->
    <div class="home-page2">
        <label class="text-sales">Sales:</label>
        <div class="container-4">
            <div class="card-4">
                <div class="image-container">
                    <img src="../resources/products/jordan.jpg" alt="jordan-shoe">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-4">
                <div class="image-container">
                    <img src="../resources/products/watch.jpg" alt="watch">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        
            <div class="card-4">
                <div class="image-container">
                    <img src="../resources/products/airpod.jpg" alt="airpod">
                </div>
                <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                <p>Men's Shoes</p>
                <p><button>Buy</button></p><br>
            </div>
        </div>
        
    </div>
    <!--New-->
    <div class="new-item">
        <label class="text-new">New:</label>
        <div class="box">
            <?php
                $query = "SELECT * FROM PRODUCT ORDER BY date_added DESC";
                $stid=oci_parse($connection, $query);
                oci_execute($stid);
                $count = 0;
                
                while(($product = oci_fetch_assoc($stid)) && $count < 3) {
                    $product_id = $product['PRODUCT_ID'];
                    $count++;

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

                    echo '<div class="card-5">';
                    echo '<a href = "../product_detail/product_detail.php?product_id='.$product_id.'"> <img src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Uploaded Image"  style="width:100%"></a><br><br>';
                    echo '</div>';

                }
            ?>
        </div>    
    </div>
    <!--For you-->
    <div class="for-you">
        <label class="text-foryou">For You:</label>
            <div class="container-5">
                <div class="card-6">
                    <div class="image-container">
                        <img src="../resources/products/jordan.jpg" alt="jordan">
                    </div>
                    <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                    <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                    <p>Men's Shoes</p>
                    <p><button>Buy</button></p><br>
                </div>
            
                <div class="card-6">
                    <div class="image-container">
                        <img src="../resources/products/watch.jpg" alt="jordan">
                    </div>
                    <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                    <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                    <p>Men's Shoes</p>
                    <p><button>Buy</button></p><br>
                </div>
            
                <div class="card-6">
                    <div class="image-container">
                        <img src="../resources/products/airpod.jpg" alt="jordan">
                    </div>
                    <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                    <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                    <p>Men's Shoes</p>
                    <p><button>Buy</button></p><br>
                </div>

                <div class="card-6">
                    <div class="image-container">
                        <img src="../resources/products/jordan.jpg" alt="jordan">
                    </div>
                    <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                    <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                    <p>Men's Shoes</p>
                    <p><button>Buy</button></p><br>
                </div>
            
                <div class="card-6">
                    <div class="image-container">
                        <img src="../resources/products/watch.jpg" alt="jordan">
                    </div>
                    <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                    <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                    <p>Men's Shoes</p>
                    <p><button>Buy</button></p><br>
                </div>
            
                <div class="card-6">
                    <div class="image-container">
                        <img src="../resources/products/airpod.jpg" alt="jordan">
                    </div>
                    <h1>AIR JORDAN 1 <span class="purple-text">Purple</span></h1>
                    <p class="price"><s>$64.99</s><br>$49.99 <i class="fa-solid fa-tag"></i></p>
                    <p>Men's Shoes</p>
                    <p><button>Buy</button></p><br>
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br>
            <!--map-->
        <div class="location">
            <p><i class="fa-solid fa-location-dot"></i> Location</p><br>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d44Supportlogou1.60166153526745!2d85.31895302088176!3d27.692164950951184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1711632997867!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
            
            <!--footer-->
            <?php 
                include "../component/footer.php";
            ?>
            
        </div>

<script type="text/javascript" src="home.js"></script>
<script>
    const toggleBtn = document.querySelector('.toggle')
    const toggleBtnIcon = document.querySelector('.toggle i')
    const dropdown = document.querySelector('.dropdown')

    toggleBtn.onclick = function(){
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



</script>
</body>
</html>

