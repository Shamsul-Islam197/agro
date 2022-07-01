<?php
include('log.php');
if(!isset($_SESSION['admin'])){
  echo "<script>alert('Please login first!!!');</script>";
  echo "<script>window.location='adminlog.php'</script>";
}

  
 $query = "SELECT * FROM products ORDER BY id ASC ";
 $result = mysqli_query($con,$query);


 if(isset($_POST['search'])){
   $search = $_POST['search'];
   $query="SELECT * FROM `products`   WHERE `name` like '%$search%' ORDER BY `name` ASC";
   $result=mysqli_query($con,$query);
 }

 if(isset($_POST['category'])){
   $category = $_POST['category'];
   $query="SELECT * FROM `products`   WHERE category like '%$category%' ";
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
    <title>Products</title>
</head>
<body onload="pageLoading()">

<?php include('../load.php');?>

<form method="post" action="products.php">
<section class="sec-nav">
<nav>
        <a href="home.php" class="logo">Agro</a>

        <select  name="category" class="nav-cat" onchange="this.form.submit()">
          <option value="" disabled selected hidden>Categories</option>
          <option value="Eggs">Eggs</option>
          <option value="Fish">Fish</option>
          <option value="Fruits">Fruits</option>
          <option value="Meat">Meat</option>
          <option value="Milks">Milks</option>
          <option value="Vegetables">Vegetables</option>
        </select>
        
        <div class="srch-container">
        <i class="fa fa-search srch-logo fa-2x " aria-hidden="true"></i>
        <input class="search" name="search" type="text"  placeholder="Search here">
        </div>
        
       
        
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="products.php" class="active">Products</a></li>
          <li><a href="add.php">Manage Products</a></li>
          <li><a href="order.php">Orders</a></li>
          <li><a href="process.php">Process Orders</a></li>
          <li><a href="userinfo.php">User Info</a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="return Log()" ><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>

      <section class="product_container" data-aos="fade-up-right">
<div >
        <?php
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="grid-container">
                        <a href="add.php?viewID=<?php echo ($row["id"]); ?>&status=<?php echo ($row["pstatus"]);?>">
                        <div class="product">
                   <?php echo '<img class="img" src="data:image;base64,'.base64_encode($row['img']).'" >';?>
                   <p class="name"><?php echo $row["name"]; ?></p>
                   <p class="price">Available: <?php echo $row["qnty"]; ?></p>
                        <strike class="price">৳ <?php echo $row["price"]; ?></strike>
                        <p class="offer">৳ <?php echo $row["offer"]; ?></p>
                        <?php if ($row["pstatus"]=="disabled"){echo ('<p class="price">Disabled</p>');}?>
                        </div>
                        </a>
                        
                        </div>
                    <?php
                }
            }else{
              echo ('<h1>No result found!!!</h1>');
            }
        ?>
</div>
</section>
<br>


      </form>
            <section class="sec-footer">
      <?php include('../footer.php');?>
      </section>
</body>
</html>