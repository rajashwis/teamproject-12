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
    <title>Document</title>
    <link type="favicon" rel="icon" type="image/x-icon" href="../resources/cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="customer_profile.css">
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

        
        <div class="menu">
            <ul>
                <li><a class="active" href="">My Profile</a></li>
                <li><a href="">My Order</a></li>
                <li><a href="">Wishlist</a></li>
                <li><a href="">Reviews</a></li>
              </ul>
        </div>


        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="wrapper-cp">
                <div class="section-container">
                    <div class="section">
                        <div class="section-content">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control"> <br>

                            <label for="fname">First Name:</label><br>
                            <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" class="input-field"><br>
                            <label for="lname">Last Name:</label><br>
                            <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" class="input-field"><br>
                            <label for="username">Username:</label><br>
                            <input type="text" id="username" name="username" value="<?php echo $username; ?>" class="input-field"><br>
                            <label for="password">Password:</label><br>
                            <input type="password" id="password" name="password" value="<?php echo $password; ?>" class="input-field"><br>
                            <label for="dob">Date of birth:</label><br>
                            <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" class="input-field"><br>
                            <label for="email">Email:</label><br>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="input-field"><br>
                            
                        </div>
                        <div>
                        <div>
                            <div class="profile-icon"></div>
                            <input type="submit" name="submit" value="Save Changes">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--footer-->
 

    <script type="text/javascript" src="customer.js"></script>

</body>

</html>