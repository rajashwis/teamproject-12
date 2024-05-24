<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
   <div class="containter">
        <nav class="navbar-admin">
            <div class="admin-profile">
                <img src="../resources/user.jpg" alt="trader_profile">
                <h4>John Cena</h4>
            </div>


            <button class="logout">
                Sign Out
            </button>
        </nav>


        <main class="main">
            <aside class="vertical-nav">
                <ul>
                    <li><a class="active" href="#">Dashboard</a></li>
                    <li><a href="#">Recent Order</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="desktop10.html">Report</a></li>
                </ul>
            </aside>

            <section class="general"> 
                <ul class="box-info">
                    <li>
                         <i class="fa-solid fa-cart-shopping"></i>
                        <span class="text">
                            <h3>1020</h3>
                            <p>New Order</p>
                        </span>
                    </li>

                    <li>
                        <i class="fa-solid fa-user-group"></i>
                        <span class="text">
                            <h3>2834</h3>
                            <p>Customer</p>
                        </span>
				    </li>
                    <li>
                     <i class="fa-solid fa-dollar-sign"></i>
                        <span class="text">
                           <h3>$2543</h3>
                            <p>Total Sales</p>
                        </span>
                    </li>
                    
                
                </ul>
            </section>
        </main>
   </div>

</body>
</html>