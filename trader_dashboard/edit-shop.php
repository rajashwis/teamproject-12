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
      header('Location: ../homepage/');    
      exit();
    }

    if(isset($_GET['shop_id'])) {

        $shop_id = $_GET['shop_id'];
        $query = "SELECT * FROM SHOP WHERE SHOP_ID = $shop_id";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);

        $shop = oci_fetch_assoc($statement);

        $shop_name = $shop['SHOP_NAME'];
        $shop_address = $shop['ADDRESS'];
        
        if ($shop['SHOP_IMAGE'] !== null && $shop['SHOP_IMAGE']->load()) {
            $imageData = $shop['SHOP_IMAGE']->load();
        } else {
            // Use a dummy file if no file was uploaded
            $dummyFilePath = '../resources/user.jpg'; // Path to your dummy image file
            $imageData = file_get_contents($dummyFilePath);
        }

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

        if(isset($_POST['submit'])) {

            $shop_name = $_POST['shop-name'];
            $shop_address = $_POST['shop-address'];
    
             // Check if a file was uploaded
            if(isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] == UPLOAD_ERR_OK) {
                $file = file_get_contents($_FILES['imgUpload']['tmp_name']);
            } elseif ($imageData) {       
                $file = $imageData;
            } else {
                // No file uploaded, use a default file
                $default_file_path = '../resources/dummy_banner.png';
                $file = file_get_contents($default_file_path);
            }

    
            $query = "UPDATE SHOP 
                    SET 
                        SHOP_NAME = '$shop_name', 
                        ADDRESS = '$shop_address',
                        SHOP_IMAGE = EMPTY_BLOB()
                    WHERE SHOP_ID = $shop_id
                    RETURNING SHOP_IMAGE INTO :image";
            $statement = oci_parse($connection, $query);
            $blob = oci_new_descriptor($connection, OCI_D_LOB);
            oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);
            $result = oci_execute($statement, OCI_DEFAULT);
            
            if($result && $blob->save($file)) {
                oci_commit($connection);
                oci_free_descriptor($blob);
                echo "<script>alert('Shop edited!')</script>";
                header('Location: trader-dashboard.php#shop');
                exit();
            }
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
    <link rel="stylesheet" type="text/css" href="discount.css">
    <title>Document</title>
</head>
<body>


    <form class="discount-form" method="POST" enctype="multipart/form-data">
        <h2><i class="fa-solid fa-tag"></i> Shop Details</h2>
        
        <div class="discount-image">
            <?php echo '<img id=profileImg src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Banner Image">';?>
            <!-- <img id="profileImg" src="https://placehold.co/600x400" alt="Banner Image"> -->
            <input type="file" id="imgUpload" name="imgUpload" accept="image/*">
            <label for="imgUpload">Upload Image</label>
        </div>
    

        <div class="form-group">
            <label for="shop-name">Shop Name</label>
            <input type="text" id="shop-name" name="shop-name" value="<?php echo $shop_name; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="shop-address">Shop Address</label>
            <input type="shop-address" id="shop-address" name="shop-address" value="<?php echo $shop_address; ?>" required>
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