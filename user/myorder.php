<?php
include('log.php');
if(!isset($_SESSION['userid'])){
  echo "<script>alert('Please login first!!!');</script>";
  echo "<script>window.location='userlog.php'</script>";
}
$query = "SELECT * FROM `orders`, `products` WHERE `orders`.`product_id` = `products`.`id` AND `orders`.`status` = 'pending' AND `orders`.`user_id`='".$_SESSION['userid']."' ORDER BY `orders`.`order_date` DESC";
$result = mysqli_query($con,$query);

if(isset($_POST['search'])){
  $search = $_POST['search'];
  $query="SELECT * FROM `orders`, `products` WHERE `orders`.`product_id` = `products`.`id` 
          AND (`orders`.`order_id` like '%$search%' OR `products`.`name` like '%$search%') AND `orders`.`user_id`='".$_SESSION['userid']."' ORDER BY `orders`.`order_date` DESC";
  $result=mysqli_query($con,$query);
}

if(isset($_POST['status'])){
  $status = $_POST['status'];
  $query = "SELECT * FROM `orders`, `products` WHERE `orders`.`product_id` = `products`.`id` AND `orders`.`user_id`='".$_SESSION['userid']."' AND `orders`.`status` ='$status' ORDER BY `orders`.`order_date` DESC";
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
    <title>My Order</title>
</head>
<body onload="pageLoading()">
<?php include('../load.php');?>
<form method="post" action="myorder.php">
    <section class="sec-nav">
      <nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
        <li><a href="home.php" >Home</a></li>
          <li><a href="products.php" >Products</a></li>
          <li><a href="myorder.php" class="active">My  Orders</a></li>
          <li><a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Cart <span>
              <sup><?php echo $cart_count; ?></sup></span>
        </a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="return Log()" ><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>


      <section class="sec-table" data-aos="fade-right">
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
				<td><?php echo $row['name']; ?></td>
        <td><?php echo '<img src="data:image;base64,'.base64_encode($row['img']).'" class="img">';
        ?></td>
				<td><?php echo $row['order_price']; ?></td>
        <td><?php echo $row['order_qnty']; ?></td>
				<td><?php echo ($row['order_qnty']*$row['order_price']); ?></td>
				<td><?php echo $row['delivery_add']; ?></td>
        <td><?php echo $row['order_date']; ?></td>
        <td><?php echo $row['status'];if($row['status']!="Delivered")
                echo (' <i class="far clock fa-clock"></i>');
                else
                echo (' <i class="fas tick fa-check-circle"></i>');
                ?></td>
        <td><?php echo $row['pay_meth']; ?></td>
			</tr>
      <?php
                }
            }else{
              echo "<h1>No Record Found.</h1><br>";
            }
        ?>
		</tbody>
	</table>
  </section>

      <section class="sec-footer">
          <?php include('../footer.php');?>
          </section>

</form>
    
</body>
</html>