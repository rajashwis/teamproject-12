<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="recent_product.css">
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
                    <li><a href="#">Recent Products</a></li>
                    <li><a class="active" href="#">Recent Product</a></li>
                    <li><a href="#">Report</a></li>
                </ul>
            </aside>

            <div class="table-data">
				<div class="product">
					<div class="head">
						<h3>Recent Orders</h3>
						<!-- <i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i> -->
					</div>
					<table>
						<thead>
							<tr>
								<th>Product</th>
								<th>Shop</th>
                                <th>Category</th>
                                <th>1</th>
								<th>Date Added</th>
								<th>Is Approved</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="../resources/products/bakery1.jpg">
									<p>Cake</p>
								</td>
								<td>Shop Name</td>
                                <td>Category</td>
                                <td>2</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>
                                    <img src="../resources/products/bakery2.jpg">
									<p>Cake</p>
								</td>
                                <td>Shop Name</td>
                                <td>Category</td>
								<td>3</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
                                    <img src="../resources/products/bakery2.jpg">
									<p>Cake</p>
								</td>
								<td>Shop Name</td>
                                <td>Category</td>
                                <td>4</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
                                    <img src="../resources/products/bakery1.jpg">
									<p>Cake</p>
								</td>
								<td>Shop Name</td>
                                <td>Category</td>
                                <td>5</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
                                    <img src="../resources/products/bakery2.jpg">
									<p>Cake</p>
								</td>
								<td>Shop Name</td>
                                <td>Category</td>
                                <td>99</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
						</tbody>
					</table>
				</div>
            </div>
        </main>
   </div>

</body>
</html>