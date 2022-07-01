<?php
include('log.php');
if(!isset($_SESSION['admin'])){
  echo "<script>alert('Please login first!!!');</script>";
  echo "<script>window.location='adminlog.php'</script>";
}

$query = "SELECT * FROM user ORDER BY id ASC ";
$result = mysqli_query($con,$query);

if(isset($_POST['search'])){
  $search = $_POST['search'];
  $query="SELECT * FROM `user` WHERE `fname` like '%$search%' OR `lname` like '%$search%' OR `id` like '%$search%' ORDER BY `id` ASC";
  $result=mysqli_query($con,$query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../link.php');?>
    <title>DocuUser Info</title>
</head>
<body>

<?php include('../load.php');?>
<form method="post" action="userinfo.php">
<section class="sec-nav">
<nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="add.php">Manage Products</a></li>
          <li><a href="order.php">Orders</a></li>
          <li><a href="process.php">Process Orders</a></li>
          <li><a href="userinfo.php" class="active">User Info</a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="return Log()" ><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>


<section class="sec-table" data-aos="zoom-out">
<div class="srch-container">
        <i class="fa fa-search srch-logo fa-2x " aria-hidden="true"></i>
        <input class="search" name="search" type="text"  placeholder="Search by name or ID...">
        </div>
        <br>
<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Phone</th>
				<th>Email</th>
        <th>Address</th>
			</tr>
		</thead>
		<tbody>
    <?php
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['fname']; ?></td>
				<td><?php echo $row['lname']; ?></td>
				<td><?php echo $row['phone']; ?></td>
				<td><?php echo $row['email']; ?></td>
        <td><?php echo $row['address']; ?></td>
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
