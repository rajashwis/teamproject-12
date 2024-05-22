<?php

session_start();
error_reporting(0);

include "../connect.php";

$trader_id = $_SESSION['user_id']; 
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Category</title>
  <link rel="stylesheet" href="add_category.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
  <div>
    <div class="box">
      <!--navbar-->
      <div class="navbar" id="nav">
        <nav>
            <ul>
                <li><img class="logo" src="CFXLocalHub - White_Logo.png"></li>
                <div class="search-bar">
                    <form action="search.php" method="GET">
                        <div class="search">
                            <input type="text" name="searchTerm" class="searchTerm" placeholder="   NIKE SHOES...">
                            <button type="submit" class="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="user-box">
                    <div class="signin">
                        <form action="signin.html" method="get">
                            <button class="btn">
                                <u><i class="fa-solid fa-user"></i> Sign in</u>
                            </button>
                        </form>
                    </div>
                    <div class="signup">
                        <form action="signup.html" method="get">
                            <button class="btn-2">
                                Sign up
                            </button>
                        </form>
                    </div>
                </div>
                <li class="basket"><a href="cart.html"><img src="trolley.png" height="30px"></a></li>
            </ul>
        </nav>
    </div>
     
     
            <div class="vertical-nav">
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Order</a></li>
                    <li><a href="#">Discount</a></li>
                </ul>
            </div>

           


  
    <div class="container">

      <div class="row">
        <div class="item"><a href="">Category ID</a></div>
          <div class="item"><a href="">Category Name</a></div>
          <div class="item"><a href="">No Of Product</a></div>
          <!-- <div class="item"><a href="">View category</a></div> -->
          <div class="item"><a href=""></a></div>
        </div>
      <hr>
        
      <?php

        $query = "SELECT 
            pc.category_id, 
            pc.category_name, 
            COUNT(p.product_id) AS total_count
        FROM 
            ProductCategory pc
        LEFT JOIN 
            Product p ON pc.category_id = p.category_id
        WHERE 
            pc.trader_id = $trader_id
        GROUP BY 
            pc.category_id, 
            pc.category_name";
            
        // $query="SELECT *, COUNT(*) AS TOTAL_COUNT FROM PRODUCTCATEGORY WHERE TRADER_ID = $trader_id";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);

        while($category = oci_fetch_assoc($statement)) {
          echo '<div class="sub-row">';
          echo '<div class="item">'.$category['CATEGORY_ID'].'</div>';
          echo '<div class="item">'.$category['CATEGORY_NAME'].'</div>';
          echo '<div class="item"><a href="">'.$category['TOTAL_COUNT'].'</a></div>';
          echo '<div class="item"><div class=" ">';
                  
          echo '<button class="view">View</button>';
          echo '<button class="edit">Edit</button>';
          echo '</div></a></div>';      
          echo '</div>';
          echo '<hr>';
        }

   

      ?>

    
    </div>
  </div>
  </div>

  <!-- <button class="add-category-btn">Add Category</button> -->

  <!-- Add Category button -->
  <button class="add-category-btn" onclick="openForm()">Add Category</button>

  <!-- Overlay -->
  <div class="overlay" id="overlay"></div>

  <!-- Pop-up Form -->
  <div class="popup-form" id="popupForm">
    <h2>Add New Category</h2>
    <form>
      <input type="text" id="no-of-product" name="no-of-product" required>
      <div>
        <button type="button" class="close-btn" onclick="closeForm()">Cancel</button>
        <button type="submit">   Add </button>
      </div>
    </form>
  </div>

  <script>
    function openForm() {
      document.getElementById("popupForm").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closeForm() {
      document.getElementById("popupForm").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>

  
  <script src="MyOrder.js"></script>
  
</body>
</html>