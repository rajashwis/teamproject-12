<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../connect.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM USER_ WHERE USER_ID = '$user_id'";
    $stid = oci_parse($connection, $query);
    oci_execute($stid);
    $user_detail = oci_fetch_assoc($stid);

    if (!$user_detail) {
        echo "Error!";
        exit();
    }

    if ($user_detail['PROFILE_PICTURE'] !== null && $user_detail['PROFILE_PICTURE']->load()) {
        $imageData = $user_detail['PROFILE_PICTURE']->load();
    } else {
        // Use a dummy file if no file was uploaded
        $dummyFilePath = '../resources/user.jpg'; // Path to your dummy image file
        $imageData = file_get_contents($dummyFilePath);
    }

} else {
    header('Location: ../homepage/');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Load user details if it's a GET request
    $email = $user_detail['EMAIL'];
    $username = $user_detail['USERNAME'];
    $fname = $user_detail['FIRST_NAME'];
    $lname = $user_detail['LAST_NAME'];
    $dob = $user_detail['DATE_OF_BIRTH'];
    $gender = $user_detail['GENDER'];
    $address = $user_detail['ADDRESS_'];
    
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
}

if (isset($_POST['save'])) {
    // Update user details if it's a POST request
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    if (isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] == UPLOAD_ERR_OK) {
        $file = file_get_contents($_FILES['imgUpload']['tmp_name']);
    } elseif ($imageData) {
        $file = $imageData;
    } else {
        // Use a dummy file if no file was uploaded
        $dummyFilePath = '../resources/dummy images/dummy_product.png'; // Path to your dummy image file
        $file = file_get_contents($dummyFilePath);
    }

    $query = "UPDATE USER_ SET 
        FIRST_NAME = '$firstName',
        LAST_NAME = '$lastName', 
        USERNAME = '$username', 
        ADDRESS_ = '$address', 
        EMAIL = '$email', 
        DATE_OF_BIRTH = TO_DATE('$dob','YYYY-MM-DD'), 
        GENDER = '$gender',
        PROFILE_PICTURE = EMPTY_BLOB()
    WHERE USER_ID = $user_id
    RETURNING PROFILE_PICTURE INTO :image";

    $statement = oci_parse($connection, $query);
    $blob = oci_new_descriptor($connection, OCI_D_LOB);
    oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);
    $result = oci_execute($statement, OCI_DEFAULT);

    if ($result && $blob->save($file)) {
        oci_commit($connection);
        oci_free_descriptor($blob);
        echo "<script>alert('Profile Updated!')</script>";
        header('Location: ../homepage');
        exit();
    } else {
        oci_rollback($connection);
        echo "<script>alert('Error updating profile!')</script>";
    }
}

if(isset($_POST['delete'])) {

    $query = "DELETE FROM USER_ WHERE USER_ID = $user_id"; //LOGOUT AFTER THIS?????
    $statement = oci_parse($connection, $query);
    $result = oci_execute($statement);

    if($result) {
        echo "<script>
            alert('User deleted successfully!');
            window.location.href = 'trader-dashboard.php#shop';
            </script>";
        exit(); // Ensure script termination after redirection
    }
}

oci_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link type="favicon" rel="icon" type="image/x-icon" href="../resources/cfxfavicon.png">
    <link rel="stylesheet" type="text/css" href="customer_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body>
    <?php include "../components/header.php" ?>
    <main class="container">
        <div class="menu">
            <ul>
                <li><a class="active" href="customer_profile.php">My Profile</a></li>
                <li><a href="customer_order.php">My Order</a></li>
                <li><a href="wishlist.php">Wishlist</a></li>
                <li><a href="customer_review.php">Reviews</a></li>
            </ul>
        </div>
        
        <div class="right">
            <form class="profile-form" method="POST" enctype="multipart/form-data">
                <h2>Customer Profile</h2>
            
                <div class="profile-image">
                    <?php echo '<img id=profileImg src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Profile Image">';?>
                    <!-- <img id="profileImg" src="https://via.placeholder.com/100" alt="Profile Image"> -->
                    <input type="file" name="imgUpload" id="imgUpload" accept="image/*">
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
                    $date_of_birth = date('Y-m-d', strtotime($dob));
                ?>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo $date_of_birth; ?>" required>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="M" <?php if(isset($_POST['gender']) && $_POST['gender'] === 'M') { echo 'selected'; } ?>>Male</option>
                        
                        <option value="F" <?php if(isset($_POST['gender']) && $_POST['gender'] === 'F') { echo 'selected'; } ?>>Male<option value="F">Female</option>

                        <option value="O" <?php if(isset($_POST['gender']) && $_POST['gender'] === 'O') { echo 'selected'; } ?>>Male</option>
                    </select>
                </div>

                <div class="btn-ctrl">
                    <button id="btn-edit" type="submit" name="save">Save</button>
                    <button id="btn-delete" type="submit" name="delete" onclick="return confirm('Are you sure you want to delete your profile? [This action is irreversible and will delete all your history from this site.]');">Delete</button>
                </div>

            </form>
        </div>
    </main>
    <?php include "../components/footer.php" ?>

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
