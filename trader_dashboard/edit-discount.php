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

    if(isset($_GET['discount_id'])) {

        $discount_id = $_GET['discount_id'];
        $query = "SELECT * FROM DISCOUNT WHERE DISCOUNT_ID = $discount_id";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);

        $discount = oci_fetch_assoc($statement);

        $discount_percent = $discount['DISCOUNT_PERCENTAGE'];
        $description = $discount['DESCRIPTION_'];
        $start_date = $discount['START_DATE'];
        $end_date = $discount['END_DATE'];
        
        $imageData = $discount['DISCOUNT_IMAGE']->load();

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

    if(isset($_POST['submit'])) {

        $discount = $_POST['discount'];
        $start_date = $_POST['start-date'];
        $end_date = $_POST['end-date'];
        $description = $_POST['description'];

        $file = file_get_contents($_FILES['imgUpload']['tmp_name']);

        $query = "INSERT INTO DISCOUNT (DISCOUNT_ID, DISCOUNT_PERCENTAGE, START_DATE, END_DATE, DESCRIPTION_, TRADER_ID, DISCOUNT_IMAGE) VALUES (SEQ_DISCOUNT_ID.NEXTVAL, $discount, TO_DATE('$start_date','YYYY-MM-DD'), TO_DATE('$end_date','YYYY-MM-DD'), '$description', $trader_id, EMPTY_BLOB()) RETURNING DISCOUNT_IMAGE INTO :image";
        $statement = oci_parse($connection, $query);
        $blob = oci_new_descriptor($connection, OCI_D_LOB);
        oci_bind_by_name($statement, ':image', $blob, -1, OCI_B_BLOB);
        $result = oci_execute($statement, OCI_DEFAULT);
        
        if($result && $blob->save($file)) {
            oci_commit($connection);
            oci_free_descriptor($blob);
            echo "<script>alert('Discount Uploaded!')</script>";
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
        <h2><i class="fa-solid fa-tag"></i> Discount Details</h2>
        
        <div class="discount-image">
            <?php echo '<img id=profileImg src="data:' . $imageType . ';base64,' . $encodedImageData . '" alt="Banner Image">';?>
            <!-- <img id="profileImg" src="https://placehold.co/600x400" alt="Banner Image"> -->
            <input type="file" id="imgUpload" name="imgUpload" accept="image/*">
            <label for="imgUpload">Upload Banner</label>
        </div>
        
        <div class="form-group">
            <label for="discount">Discount %</label>
            <input type="number" id="discount" name="discount" value="<?php echo $discount_percent; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" id="discount" name="description" value="<?php echo $description; ?>" required>
        </div>
        
        <?php
        
            $start_date_formatted = date('Y-m-d', strtotime($start_date));
            $end_date_formatted = date('Y-m-d', strtotime($end_date));

        ?>
        <div class="form-group">
            <label for="lastName">Start Date</label>
            <input type="date" id="start-date" name="start-date" value="<?php echo $start_date_formatted; ?>" required>
        </div>

        <div class="form-group">
            <label for="username">End Date</label>
            <input type="date" id="end-date" name="end-date" value="<?php echo $end_date_formatted; ?>" required>
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