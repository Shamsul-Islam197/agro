<?php 
include('log.php');

if(!isset($_SESSION['admin'])){
  echo "<script>alert('Please login first!!!');</script>";
  echo "<script>window.location='adminlog.php'</script>";
}

$query = "SELECT * FROM `orders` WHERE `status`='Pending' ORDER BY `order_date` DESC";
$result = mysqli_query($con,$query);

if(isset($_POST['search'])){
  $search = $_POST['search'];
  $query = "SELECT * FROM orders WHERE order_id LIKE '%$search%' ";
  $result = mysqli_query($con,$query);
}

if(isset($_POST['status'])){
  $status = $_POST['status'];
  $query = "SELECT * FROM `orders` WHERE `status`='$status' ORDER BY `order_date` DESC";
  $result = mysqli_query($con,$query);
}

if(isset($_GET['process'])){
    $process = $_GET['process'];
    $id = $_GET['orderID'];
    $query = "UPDATE orders SET status='".$process."' WHERE order_id='".$id."'";
    if($result=mysqli_query($con,$query)){
      echo "<script>alert('Status Updated');</script>";
      echo "<script>window.location='process.php'</script>";
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../link.php');?>
    <title>Process Order</title>
</head>
<body onload="pageLoading()">

<?php include('../load.php');?>
<form method="post" action="process.php">
<section class="sec-nav">
<nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="add.php">Manage Products</a></li>
          <li><a href="order.php" >Orders</a></li>
          <li><a href="process.php"  class="active">Process Orders</a></li>
          <li><a href="userinfo.php">User Info</a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="return Log()" id="process"><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>

      <section class="sec-table" data-aos="zoom-in-right">
        <div class="srch-container">
        <i class="fa fa-search srch-logo fa-2x " aria-hidden="true"></i>
        <input class="search" name="search" type="text"  placeholder="Search by order id...">
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
        <th>Delivery Address</th>
        <th>Order Date</th>
        <th>Delivery Status</th>
        <th>Update Status</th>
        <th>Invoice</th>
			</tr>
		</thead>
		<tbody>
        <?php
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>
			<tr>
				<td><?php echo $row['order_id']; ?></td>
				<td><?php echo $row['delivery_add']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['status']; 
                if($row['status']!="Delivered")
                echo (' <i class="far clock fa-clock"></i>');
                else
                echo (' <i class="fas tick fa-check-circle"></i>');
                ?></td>
                <td>
                <select id="process" onchange="processValue(this)">
                <option value="">Change</option>
                <option value="process.php?process=Ready to Ship&orderID=<?php echo($row['order_id']); ?>">Ready to Ship</option>
                <option value="process.php?process=Shipped&orderID=<?php echo($row['order_id']); ?>">Shipped</option>
                <option value="process.php?process=In Transit&orderID=<?php echo($row['order_id']); ?>">In Transsit</option>
                <option value="process.php?process=Delivered&orderID=<?php echo($row['order_id']); ?>">Delivered</option>
                <option value="process.php?process=Cancelled&orderID=<?php echo($row['order_id']);?>">Cancelled</option>
        </select>
                </td>
                <td><a href="invoice.php?invoice=<?php echo $row['order_id']; ?> " target="_blank" class="btn btn-success">Print</a></td>
               
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

<section class="sec-footer">
          <?php include('../footer.php');?>
          </section>
        </form>
</body>
</html>

<script type="text/javascript">
 function processValue(process){
        var Url = process.value;
        event.preventDefault(); 
      var form = event.target.form;
        swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, Proceed!",
  cancelButtonText: "Cancel!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
    window.location = Url;
  } else {
    swal("Cancelled", "", "error");
  }
});
   }
</script>