<<<<<<< HEAD
<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navbar</title>
</head>


<style>
    * {
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }


    .footer-background {
        background-image: url('../resources/bluewallpaper.jpg');
    }

    div.container-footer.w-container {
        box-sizing: border-box;
        margin-left: auto;
        margin-right: auto;
        max-width: 900px;
        padding-bottom: 40px;
        padding-top: 70px;
    }

    div.container-footer.w-container:after {
        clear: both;
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.container-footer.w-container:before {
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.w-row {
        box-sizing: border-box;
        margin-left: -10px;
        margin-right: -10px;
    }

    div.w-row:after {
        clear: both;
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.w-row:before {
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.footer-column.w-clearfix.w-col.w-col-4 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 10px;
        padding-right: 10px;
        position: relative;
        width: 33.3333%;
    }

    div.footer-column.w-clearfix.w-col.w-col-4:after {
        clear: both;
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    div.footer-column.w-clearfix.w-col.w-col-4:before {
        content: " ";
        display: table;
        grid-column-end: 2;
        grid-column-start: 1;
        grid-row-end: 2;
        grid-row-start: 1;
    }

    img.failory-logo-image {
        border-width: 0;
        box-sizing: border-box;
        display: inline-block;
        /* float: left; */
        height: 100px;
        width: 150px;
        vertical-align: middle;
    }

    h3.footer-failory-name {
        box-sizing: border-box;
        color: #FFFFFF;
        display: block;
        font-family: Lato, sans-serif;
        font-size: 20px;
        font-weight: 900;
        line-height: 1.1em;
        margin-bottom: 10px;
        margin-left: 10px;
        margin-top: 24px;
    }

    p.footer-description-failory {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 300;
        letter-spacing: .5px;
        line-height: 1.5em;
        margin-bottom: 16px;
        margin-top: 15px;
    }

    br {
        box-sizing: border-box;
    }

    div.footer-column.w-col.w-col-8 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 10px;
        padding-right: 10px;
        position: relative;
        width: 66.6667%;
    }

    div.w-col.w-col-8 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 66.6667%;
    }

    div.w-col.w-col-7.w-col-small-6.w-col-tiny-7 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 58.3333%;
    }

    h3.footer-titles {
        box-sizing: border-box;
        color: #FFFFFF;
        display: block;
        font-family: Lato, sans-serif;
        font-size: 15px;
        font-weight: 900;
        line-height: 1.1em;
        margin-bottom: 0;
        margin-left: 0;
        margin-top: 24px;
    }

    p.footer-links {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 300;
        letter-spacing: .5px;
        line-height: 1.8em;
        margin-bottom: 16px;
        margin-top: 2px;
    }

    a {
        background-color: transparent;
        box-sizing: border-box;
        color: #FFFFFF;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 400;
        line-height: 1.2em;
        text-decoration: none;
    }

    a:active {
        outline: 0;
    }

    a:hover {
        outline: 0;
    }

    span.footer-link {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 300;
    }

    span.footer-link:hover {
        color: #FFFFFF;
        font-weight: 400;
    }

    span {
        box-sizing: border-box;
    }

    strong {
        box-sizing: border-box;
        font-weight: 700;
    }

    div.w-col.w-col-5.w-col-small-6.w-col-tiny-5 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 41.6667%;
    }

    div.column-center-mobile.w-col.w-col-4 {
        box-sizing: border-box;
        float: left;
        min-height: 1px;
        padding-left: 0;
        padding-right: 0;
        position: relative;
        width: 33.3333%;
    }

    a.footer-social-network-icons.w-inline-block {
        background-color: transparent;
        box-sizing: border-box;
        color: #FFFFFF;
        display: inline-block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 400;
        line-height: 1.2em;
        margin-right: 8px;
        margin-top: 10px;
        max-width: 100%;
        opacity: .8;
        text-decoration: none;
    }

    a.footer-social-network-icons.w-inline-block:active {
        outline: 0;
    }

    a.footer-social-network-icons.w-inline-block:hover {
        opacity: 1;
        outline: 0;
    }

    img {
        border-width: 0;
        box-sizing: border-box;
        display: inline-block;
        max-width: 100%;
        vertical-align: middle;
    }

    p.footer-description {
        box-sizing: border-box;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        font-family: Lato, sans-serif;
        font-size: 17px;
        font-weight: 300;
        letter-spacing: .5px;
        line-height: 1.5em;
        margin-bottom: 16px;
        margin-top: 15px;
    }

    strong.link-email-footer {
        box-sizing: border-box;
        font-weight: 700;
    }

    .newsletter-footer {
        color: rgb(141, 139, 139);
        font-family: Lato, sans-serif;

    }

    #form-email {
        height: 40px;
        width: 300px;
        border-radius: 2px;
        border: none;
        text-align: center;
    }

    .btn-email {
        background-color: #f99f1b;
        padding: 20px;
        width: 150px;
        border-radius: 8px;
        border: none;
    }

    @media (max-width: 1416px) {
        .card {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 450px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            /* Hide overflowing content */
            height: 535px;
            /* Increased height */
            display: flex;
            /* Added flex display */
            flex-direction: column;
            /* Added column direction */
            justify-content: space-between;
            /* Space between elements */
        }

        .card-4 {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            /* Hide overflowing content */
            height: 500px;
            /* Increased height */
            display: flex;
            /* Added flex display */
            flex-direction: column;
            /* Added column direction */
            justify-content: space-between;
            /* Space between elements */
        }

    }


    @media (max-width: 1275px) {
        .card {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

    }

    @media (max-width: 1164px) {
        .card {
            background-color: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 20px;
            overflow: hidden;
            height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    }

    @media (max-width: 455px) {}


</style>
<!DOCTYPE html>
<html>
    <body>
        <div class="footer-background">
            <div class="container-footer w-container">
                <div class="w-row">
                    <div class="footer-column w-clearfix w-col w-col-4"><img src="../resources/cfxlocalhubwhitelogo.png" alt="" width="40" class="failory-logo-image">
                        <h3 class="footer-failory-name">CFXLocalHub</h3>
                        <p class="footer-description-failory">Best Shopping Online!<br></p>
                    </div>
                    <div class="footer-column w-col w-col-8">
                        <div class="w-row">
                            <div class="w-col w-col-8">
                                <div class="w-row">

                                    <div class="w-col w-col-7 w-col-small-6 w-col-tiny-7">
                                        <h3 class="footer-titles">Get in touch</h3><br>
                                        <p class="footer-links"><a href="" target="_blank"><span class="footer-link"><i class="fa-solid fa-envelope"></i> cfxsupport@gmail.com<br></span></a><a href=""><span class="footer-link"><i class="fa-solid fa-phone"></i> +977 01577257<br></span></a><a href=""><span class="footer-link"><i class="fa-brands fa-facebook"></i> Facebook</span></a><span><br></span><a href=""><span class="footer-link"><i class="fa-brands fa-x-twitter"></i> Twitter<br></span></a><a href=""><span class="footer-link"><i class="fa-brands fa-square-instagram"></i> Instagram<br></span></a><strong><br></strong></p>
                                    </div>

                                    <div class="w-col w-col-5 w-col-small-6 w-col-tiny-5">
                                        <h3 class="footer-titles">Join a Newsletter</h3><br><br>
                                        <p class="newsletter-footer">Your Email</p><br>
                                        <form>
                                            <input id="form-email"  type="email" placeholder="example@gmail.com"><br><br>
                                            <button class="btn-email" type="submit">Subscribe</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>