<?php
include('log.php');
$view=0;
$available;

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

 if(isset($_GET['viewID'])){
    $id = $_GET['viewID'];
    $query = "SELECT * FROM `products` where id='".$id."'";
    $result2 = mysqli_query($con,$query);
    $view=1;
  }

  if (isset($_POST['add_cart'])){
    if (isset($_SESSION['cart'])){
      if (!array_key_exists($_POST["id"], $_SESSION['cart'])){
        $item_array = array(
            'product_id' => $_POST['id'],
            'item_name' => $_POST['name'],
            'product_price' => $_POST['price'],
            'item_quantity' => $_POST['qnty'],
        );
        $_SESSION['cart'][$_POST['id']] = $item_array;
        echo '<script>alert("Product is added in the cart")</script>';
        echo '<script>window.location="products.php"</script>';   
    }else{
      $qnty = $_SESSION['cart'][$_POST["id"]]['item_quantity'];
      $_SESSION['cart'][$_POST["id"]]['item_quantity'] = $qnty + $_POST['qnty'];

        echo "<script>alert('Quantity updated')</script>";
        echo '<script>window.location="products.php"</script>';
    }     
}else{
  $item_array = array(
    'product_id' => $_POST['id'],
    'item_name' => $_POST['name'],
    'product_price' => $_POST['price'],
    'item_quantity' => $_POST['qnty'],
  );
  $_SESSION['cart'][$_POST['id']] = $item_array;
  echo '<script>alert("Product is added in the cart")</script>';
  echo '<script>window.location="products.php"</script>';   
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
        <li><a href="home.php" >Home</a></li>
          <li><a href="products.php" class="active">Products</a></li>
          <li><a href="myorder.php">My  Orders</a></li>
          <li><a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Cart <span>
              <sup><?php echo $cart_count; ?></sup></span>
        </a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="return Log()" ><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>

      <section class="product_container" data-aos="fade-left">
      <div id="product_container">
        <?php
        
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="grid-container">
                        <a href="products.php?viewID=<?php echo $row["id"] ?>">
                        <div class="product">
                   <?php echo '<img class="img" src="data:image;base64,'.base64_encode($row['img']).'" >';?>
                   <p class="name"><?php echo $row["name"]; ?></p>
                   <p class="price">Available: <?php echo $row["qnty"]; ?></p>
                        <strike class="price">৳ <?php echo $row["price"]; ?></strike>
                        <p class="offer">৳ <?php echo $row["offer"]; ?></p>
                        </div>
                        </a>
                        </div>
                    <?php
                }
            }else{
                echo "<h1>No result found</h1>";
            }
        ?>
        </div>

    <div id="viewproduct">
    <div class="view_product" >
<?php
if($view==1){

            if(mysqli_num_rows($result2) > 0) {

                while ($row = mysqli_fetch_array($result2)) {
                    ?>

                   <?php echo '<img class="view_img" src="data:image;base64,'.base64_encode($row['img']).'" >';?>
                   
                   <p class="name"><?php echo $row["name"]; ?></p>
                   <p class="price">Available: <?php echo $row["qnty"]; $available=$row["qnty"];?></p>
                        <strike class="price">৳ <?php echo $row["price"]; ?></strike>
                        <p class="offer">৳ <?php echo $row["offer"]; ?></p>
                        <p class="price">Description: <?php echo $row["des"]; ?></p>
                    <div class="product-option">
                        <input type="text" name="qnty" class="qnty" id="qnty" placeholder="Enter quantity">
                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>"/>
                        <input type="hidden" name="name" value="<?php echo $row["name"]; ?>"/>
                        <input type="hidden" name="price" value="<?php echo $row["offer"]; ?>"/>
                        <input class="button btn-reg" type="submit" name="add_cart" value="Add to Cart" onclick="return validateQnty()">
                        </div>
 
                    <?php
                }
            }
        }
 
        ?>
</div>
</div>
</section>





      </form>
            <section class="sec-footer">
      <?php include('../footer.php');?>
      </section>
</body>
</html>

<script type="text/javascript">

    if(('<?php echo $view;?>')==0){
      document.getElementById("product_container").style.display = "block";
      document.getElementById("viewproduct").style.display = "none";
    
    }else{
        document.getElementById("viewproduct").style.display = "block";
        document.getElementById("product_container").style.display = "none";
    }

    function validateQnty(){
        var qnty = document.getElementById("qnty");
        var available = '<?php echo $available; ?>';
        available=parseInt(available);
        if(qnty.value>0 && qnty.value<available){
            return true;
        }else{
            alert("Invalid Quantity");
            return false;
        }
    }



</script>