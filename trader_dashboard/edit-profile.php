<?php

    session_start();
    error_reporting(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../connect.php";

    if(isset($_SESSION['trader_id'])) {
        $trader_id = $_SESSION['trader_id'];
    }

    else {
      header('Location: ../component/home.php');    
      exit();
    }

    if(isset($_POST['submit'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];

        $file = file_get_contents($_FILES['image']['tmp_name']);
        
        $sql = "UPDATE USER_ SET 
                    first_name = '$firstName',
                    last_name = '$lastName', 
                    username = '$username', 
                    address_ = '$address', 
                    email = '$email', 
                    date_of_birth = TO_DATE('$dob','YYYY-MM-DD'), 
                    gender = '$gender',
                    profile_picture = EMPTY_BLOB()
                WHERE USER_ID = $trader_id
                RETURNING profile_picture INTO :image";

        $statement = oci_parse($connection, $sql);
        $blob = oci_new_descriptor($connection, OCI_D_LOB);
        oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);
        $result = oci_execute($statement, OCI_DEFAULT);
    
        if($result && $blob->save($file)) {
            oci_commit($connection);
            oci_free_descriptor($blob);

            header('edit-product?product_id');
            exit();
        }
        else {
            echo "<script>alert('Error!')</script>";
        }
    
    }

    else if($_SERVER["REQUEST_METHOD"]=='GET'){

        if(isset($_GET['trader_id'])) {

            $trader_id = $_GET['trader_id'];

            $query="SELECT * from USER_ WHERE user_id = $trader_id";
            $stid=oci_parse($connection, $query);
            oci_execute($stid);
            $trader = oci_fetch_assoc($stid);

            $imageData = $trader['PROFILE_PICTURE']->load();

            // Encode the BLOB data as base64
            $encodedImageData = base64_encode($imageData);

            // Determine the image type based on the first few bytes of the image data
            $header = substr($imageData, 0, 4);
            $imageType = 'image/jpeg'; // default to JPEG
            if (strpos($header, 'FFD8') === 0) {
                $imageType = 'image/jpeg'; // JPEG
            } elseif (strpos($header, '89504E47') === 0) {
                $imageType = 'image/png'; // PNG
            }

            if(!$trader){
                echo("Error!");
                exit();
            }

            $email = $trader['EMAIL'];
            $password = $trader['PASSWORD_'];
            $username = $trader['USERNAME'];
            $fname = $trader['FIRST_NAME'];
            $lname = $trader['LAST_NAME'];
            $dob = $trader['DATE_OF_BIRTH'];
            $gender = $trader['GENDER'];
            $address = $trader['ADDRESS_'];
            
        }
    }

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="edit-profile.css">
    <title>Document</title>
</head>
<body>
    <div class="navbar">
        <div class="profile">
            <div class="profile-img">
                <a href="trader-profile.html"><img src="../resources/dummy images/dummy_product.png" alt="Profile Picture"></a>
            </div>
            <span>Trader Name</span>
        </div>
        <button class="sign-out-btn">Sign Out</button>
    </div>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" class="profile-form">
        <h2>Trader Profile</h2>
        
        <div class="profile-image">
            <?php 
                echo '<img id="profileImg" src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Profile Image">';
            ?>
            <input type="file" id="imgUpload" name="image" accept="image/*">
            <label for="imgUpload">Change Image</label>
        </div>
        
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo $fname; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo $lname; ?>" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>

        <?php 
            $dob_formatted = date('Y-m-d', strtotime($dob));
        ?>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob_formatted); ?>" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="single-line-input">
                <option value="M" <?php if ($gender == 'M') echo 'selected'; ?>>Male</option>
                <option value="F" <?php if ($gender == 'F') echo 'selected'; ?>>Female</option>
                <option value="O" <?php if ($gender == 'O') echo 'selected'; ?>>Other</option>
            </select>
        </div>

        <button type="submit" name="submit">Submit</button>
    </form>

    <script>
        const imgUpload = document.getElementById('imgUpload');
        const profileImg = document.getElementById('profileImg');

        imgUpload.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profileImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>