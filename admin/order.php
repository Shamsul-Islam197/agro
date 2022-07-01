<?php
include('log.php');


if(!isset($_SESSION['admin'])){
  echo "<script>alert('Please login first!!!');</script>";
  echo "<script>window.location='adminlog.php'</script>";
}

  $query = "SELECT * FROM `orders`, `products` WHERE `orders`.`product_id` = `products`.`id` AND `orders`.`status`='pending'   ORDER BY `orders`.`order_date` DESC";
  $result = mysqli_query($con,$query);


  


if(isset($_POST['search'])){
  $search = $_POST['search'];
  $query="SELECT * FROM `orders`, `products` WHERE `orders`.`product_id` = `products`.`id` 
          AND (`orders`.`order_id` like '%$search%' OR `products`.`name` like '%$search%') ORDER BY `orders`.`order_date` DESC";
  $result=mysqli_query($con,$query);
}

if(isset($_POST['status'])){
  $status = $_POST['status'];
  $query = "SELECT * FROM `orders`, `products` WHERE `orders`.`product_id` = `products`.`id` AND `orders`.`status` ='$status' ORDER BY `orders`.`order_date` DESC";
  $result = mysqli_query($con,$query);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../link.php');?>
    <title>Order Info</title>
</head>
<body onload="pageLoading()">

<?php include('../load.php');?>
<form method="post" action="order.php">
<section class="sec-nav">
<nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="add.php">Manage Products</a></li>
          <li><a href="order.php"  class="active">Orders</a></li>
          <li><a href="process.php">Process Orders</a></li>
          <li><a href="userinfo.php">User Info</a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="return Log()" ><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>


<section class="sec-table" data-aos="zoom-in-up">
<div class="srch-container">
        <i class="fa fa-search srch-logo fa-2x " aria-hidden="true"></i>
        <input class="search" name="search" type="text"  placeholder="Search by order id/product name...">
        </div>
        <br>
        <select class="nav-cat" name="status" onchange="this.form.submit()">
        <option value="" disabled selected hidden>Delivery Status</option>
    <option value="Pending">Pending</option>
    <option value="Ready to Ship">Reday to Ship</option>
    <option value="Shipped">Shipped</option>
    <option value="In Transit">In Transit</option>
    <option value="Delivered">Delivered</option>
    <option value="Cancelled">Cancelled</option>
</select>
<br>
<table>
		<thead>
    <tr>
				<th>Order ID</th>
        <th>User ID</th>
				<th>Product Name</th>
        <th>Image</th>
				<th>Prcie</th>
				<th>Quantity</th>
				<th>Total Price</th>
        <th>Delivery Address</th>
        <th>Order Date</th>
        <th>Delivery Status</th>
        <th>Payment Method</th>
			</tr>
		</thead>
		<tbody>
    <?php
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>
			<tr>
				<td><?php echo $row['order_id']; ?></td>
        <td><?php echo $row['user_id']; ?></td>
				<td><?php echo $row['name']; ?></td>
        <td><?php echo '<img src="data:image;base64,'.base64_encode($row['img']).'" class="img">';?></td>
				<td><?php echo $row['order_price']; ?></td>
        <td><?php echo $row['order_qnty']; ?></td>
				<td><?php echo ($row['order_qnty']*$row['price']); ?></td>
				<td><?php echo $row['status'];if($row['status']!="Delivered")
                echo (' <i class="far clock fa-clock"></i>');
                else
                echo (' <i class="fas tick fa-check-circle"></i>');
                ?></td>
        <td><?php echo $row['order_date']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><?php echo $row['pay_meth']; ?></td>
			</tr>
      <?php
                }
            }else{
              echo "<h1>No Record Found</h1><br>";
            }
            
        ?>
		</tbody>
	</table>
  </section>
  <br>
<section class="sec-footer">
          <?php include('../footer.php');?>
          </section>


  </form>
</body>
</html>
