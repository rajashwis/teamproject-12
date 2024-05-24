<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="discount.css">
    <title>Discount</title>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="image">
                <img src="/resources/slide_img1.jpg" alt="Image">
            </div>
            <div class="discount-details">
                <div class="text-1">Discount Details:</div>
                <div class="text-2">
                    <div>Discount : 10%</div>
                    <div>Start Date: May 1st</div>
                    <div>End Date: May 25th</div>
                </div>
            </div>
            <div class="container-btn">
                <button id="btn-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                <button id="btn-2"><i class="fa-solid fa-trash"></i> Delete</button>
            </div>
        </div>

        <div class="container">
            <div class="image">
                <img src="/resources/slide_img1.jpg" alt="Image">
            </div>
            <div class="discount-details">
                <div class="text-1">Discount Details:</div>
                <div class="text-2">
                    <div>Discount : 10%</div>
                    <div>Start Date: May 1st</div>
                    <div>End Date: May 25th</div>
                </div>
            </div>
            <div class="container-btn">
                <button id="btn-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                <button id="btn-2"><i class="fa-solid fa-trash"></i> Delete</button>
            </div>
        </div>

        <div class="container">
            <div class="image">
                <img src="/resources/slide_img1.jpg" alt="Image">
            </div>
            <div class="discount-details">
                <div class="text-1">Discount Details:</div>
                <div class="text-2">
                    <div>Discount : 10%</div>
                    <div>Start Date: May 1st</div>
                    <div>End Date: May 25th</div>
                </div>
            </div>
            <div class="container-btn">
                <button id="btn-1"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                <button id="btn-2"><i class="fa-solid fa-trash"></i> Delete</button>
            </div>
        </div>
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
