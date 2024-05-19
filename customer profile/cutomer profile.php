<?php
    session_start();
    error_reporting(0);

    include "../connect.php";

    $user = $_SESSION['user_id']; 

    if(!$user) {
        header("Location: ../login/login.html");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"]=='GET'){

        $query="SELECT * from USER_ WHERE user_id = '$user'";
        $stid=oci_parse($connection, $query);
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);

        if(!$row){
            echo("Error!");
            exit();
        }

        $email = $row['EMAIL'];
        $password = $row['PASSWORD_'];
        $username = $row['USERNAME'];
        $fname = $row['FIRST_NAME'];
        $lname = $row['LAST_NAME'];
        $dob = $row['DATE_OF_BIRTH'];
        $address = $row['ADDRESS_'];
 
    }

    else{
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $dob = $_POST['dob']; 

        $sql = "UPDATE USER_ SET email='$email', password_='$password', username='$username', first_name='$fname', last_name='$lname', date_of_birth=TO_DATE('$dob','YYYY-MM-DD') WHERE user_id='$user'";

        $stid=oci_parse($connection, $sql);
        $result=oci_execute($stid);

        if($result) {
            header("Location: ../component/home.php");
            exit();
        }

        else {
            $error = oci_error($stid);
            echo "<script>alert('Error updating user data: " . $error['message'] . "')</script>";
        }
    }

    oci_close($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer profile</title>
    <link rel="stylesheet" type="text/css" href="customer profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>CFXLocalHub HOME PAGE</title>


</head>

<body>
        <!-- <div class="home-page"> -->
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
        <!--navbar 2-->
        <!-- <div class="navbar2" id="nav2">
            <nav>
                <ul>
                    <li class="home-split"><a class="active" href=""> HOME</a></li>
                    <li><a href="trending.html"> TRENDING</a></li>
                    <li><a href=""> HOME & DECOR</a></li>
                    <li><a href=""> ELECTRONICS</a></li>
                    <li><a href=""> FASHION</a></li>
                    <li><a href=""> SALES</a></li>
                    <li class="bs-split"><a href=""> BECOME A SELLER</a></li>
                </ul>
            </nav>
        </div> -->


        <!--customer profile-->
        <!-- <table class="menu">
            <tr>
                <td class="menu-item"><a href="my-profile.html">My Profile</a></td>
            </tr>
            <tr>
                <td class="menu-item"><a href="my-order.html">My Order</a></td>
            </tr>
            <tr>
                <td class="menu-item"><a href="view-wishlist.html">View Wishlist</a></td>
            </tr>
            <tr>
                <td class="menu-item"><a href="my-reviews.html">My Reviews</a></td>
            </tr>
        </table> -->
        
        <div class="menu">
            <ul>
                <li><a class="active" href="">My Profile</a></li>
                <li><a href="">My Order</a></li>
                <li><a href="">Wishlist</a></li>
                <li><a href="">Reviews</a></li>
              </ul>
        </div>


       
        <div class="wrapper-cp">
                <div class="section-container">
                    <div class="section">
                        <div class="section-content">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control"> <br>

                                <label for="firstname">First Name:</label><br>
                                <div class="input-container">
                                    <input type="text" name="fname" class="single-line-input" value="<?php echo $fname; ?>">
                                </div>
                                <label for="lastname">Last Name:</label><br>
                                <div class="input-container">
                                    <input type="text" name="lname" class="single-line-input" value="<?php echo $lname; ?>">
                                </div>
                                <label for="username">Username:</label><br>
                                <div class="input-container">
                                    <input type="text" class="single-line-input" value="<?php echo $username; ?>">
                                </div>
                                <label for="address">Address:</label><br>
                                    <div class="input-container">
                                        <textarea name="address" class="single-line-input" value="<?php echo $address; ?>"></textarea>
                                    <!-- <input type="text" class="single-line-input" value="<?php echo $address; ?>"> -->
                                    </div>
                                <label for="email">Email:</label><br>
                                <div class="input-container">
                                    <input type="text" class="single-line-input" value="<?php echo $email; ?>">
                                </div>

                                <?php 
                                    $query = "SELECT date_of_birth, gender FROM user_ WHERE user_id=$user";
                                    $stid = oci_parse($connection, $query);
                                    oci_execute($stid);

                                    $information = oci_fetch_array($stid);
                                    $dob = $information['DATE_OF_BIRTH'];

                                    $dob_formatted = date('Y-m-d', strtotime($dob));
                                    $gender = $information['GENDER'];
                                ?>
                                <label for="dob">Date of birth:</label><br>
                                <div class="input-container">
                                    <input type="date" class="single-line-input" value="<?php echo htmlspecialchars($dob_formatted); ?>">
                                </div>

                                <label for="gender">Gender:</label><br>
                                <div class="input-container">

                                    <select id="gender" name="gender" class="single-line-input">
                                        <option value="male" <?php if ($gender == 'M') echo 'selected'; ?>>Male</option>
                                        <option value="female" <?php if ($gender == 'F') echo 'selected'; ?>>Female</option>
                                        <option value="other" <?php if ($gender == 'O') echo 'selected'; ?>>Other</option>
                                    </select>
                                    <!-- <input type="text" class="single-line-input" placeholder="Type here..."> -->
                                </div>
                                <!-- <label for="email">Email:</label><br>
                                <div class="input-container">
                                    <input type="text" class="single-line-input" placeholder="Type here...">
                                </div> -->
                            </form>
                            
                        </div>
                        <div>
                            <div class="profile-icon">
                                <img src="../resources/cfxfavicon.png">
                            </div>
                            <input type="submit" value="Change Password"><br>
                            <input type="submit1" value="Save Changes">
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!--footer-->
 

    <script type="text/javascript" src="customer.js"></script>

</body>

</html>