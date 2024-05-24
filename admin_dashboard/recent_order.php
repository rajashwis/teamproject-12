<?php

    session_start();
    error_reporting(0);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "../connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="recent_order.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
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
                    <li><a href="#">Dashboard</a></li>
                    <li><a class="active" href="#">Recent Order</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="desktop10.html">Report</a></li>
                </ul>
            </aside>

            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
						<!-- <i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i> -->
					</div>
					<table>
						<thead>

							<tr>
									<th>Order Number</th>
									<th>User</th>
									<th>Order Date</th>
									<th>Status</th>
								</tr>
						</thead>
							
						<tbody>
							<?php 
								$query = "SELECT *
										FROM (
											SELECT 
												OD.*, 
												U.first_name || ' ' || U.last_name AS customer
											FROM ORDERDETAIL OD
											JOIN USER_ U ON OD.customer_id = U.user_id
											ORDER BY OD.ORDER_DATE DESC
										)
										WHERE ROWNUM <= 5";
								$statement = oci_parse($connection, $query);
								oci_execute($statement);

								while($order = oci_fetch_assoc($statement)) {

									echo '<tr>';
									echo '<td>'.$order['ORDER_ID'].'</td>';
									echo '<td>';
									echo '<img src="../resources/johncena.jpg"> <p>'.$order['CUSTOMER'].'</p>';
									echo '</td>';
									echo '<td>'.$order['ORDER_DATE'].'</td>';
									echo '<td><span class="status completed">'.$order['STATUS'].'</span></td>';
									echo '</tr>';

								}
							?>
						
							
						</tbody>
					</table>
				</div>
            </div>
        </main>
   </div>

</body>
</html>