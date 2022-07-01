<?php 
include('log.php');


if(!isset($_SESSION['admin'])){
  echo "<script>alert('Please login first!!!');</script>";
  echo "<script>window.location='adminlog.php'</script>";
}

$id="";
$img="";
$name="";
$price="";
$offer="";
$qnty="";
$desc="";
$category="";
$status="";

if (isset($_POST['upload'])){
$img=addslashes(file_get_contents($_FILES['img']["tmp_name"]));
$name=$_POST['name'];
$price=$_POST['price'];
$offer=$_POST['offer'];
$qnty=$_POST['qnty'];
$desc=$_POST['desc'];
$category=$_POST['category'];

$query="INSERT INTO products (name,price,offer,qnty,des,img,category,pstatus) values ('$name','$price','$offer','$qnty','$desc','$img','$category','active')";
if(mysqli_query($con,$query)){
    echo "<script>alert('Product uploaded')</script>";
}else{
    echo "<script>alert('Error!!!')</script>";
}
echo '<script>window.location="add.php"</script>';
}

if(isset($_GET['viewID'])){
  $id = $_GET['viewID'];
  $status = $_GET['status'];
  $query = "SELECT * FROM `products` where id='".$id."'";
  $result = mysqli_query($con,$query);

}

if(isset($_GET['editID'])){
  $id = $_GET['editID'];
  $query = "SELECT * FROM `products` where id='".$id."'";
  $result = mysqli_query($con,$query);

  while ($row = mysqli_fetch_array($result)) {
        $name=($row['name']);
        $price=($row['price']);
        $offer=($row['offer']);
        $qnty=($row['qnty']);
        $desc=($row['des']);
        $category=($row['category']);
  }
}

  if(isset($_GET['disableID'])){
        $id=$_GET['disableID'];
        $query="UPDATE `products` SET pstatus='disabled' WHERE `id`='".$id."'";
        if(mysqli_query($con,$query)){
        echo "<script>alert('Disabled')</script>";
        echo '<script>window.location="products.php"</script>';
      }
    }else if(isset($_GET['enableID'])){
        $id=$_GET['enableID'];
        $query="UPDATE `products` SET pstatus='active' WHERE `id`='".$id."'";
        if(mysqli_query($con,$query)){
        echo "<script>alert('Enabled')</script>";
        echo '<script>window.location="products.php"</script>';
    }else{
      echo "<script>alert('Something went wrong!')</script>";
    }
  }



  $query = "SELECT * FROM `products` where id='".$id."'";
  $result = mysqli_query($con,$query);

  if(isset($_POST['update'])){
    
    $id=$_POST['id'];
    $name=$_POST['name'];
    $price=$_POST['price'];
    $offer=$_POST['offer'];
    $qnty=$_POST['qnty'];
    $desc=$_POST['desc'];
    $category=$_POST['category'];

    if($img==""){
      $query="UPDATE products SET name='".$name."' , price='".$price."' , offer='".$offer."' , qnty='".$qnty."' , des='".$desc."' , category='".$category."'  WHERE id='".$id."'  ";
      $result = mysqli_query($con,$query);
      echo "<script>alert('Product Updated!!!')</script>";
      echo '<script>window.location="products.php"</script>';
    }else{
      $img=addslashes(file_get_contents($_FILES['img']["tmp_name"]));
      $query="UPDATE products SET name='".$name."' , price='".$price."' , offer='".$offer."' , qnty='".$qnty."' , des='".$desc."' ,img='".$img."' , category='".$category."'  WHERE id='".$id."'  ";
      $result = mysqli_query($con,$query);
      echo "<script>alert('Product Updated!!!')</script>";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <?php include('../link.php');?>
    <title>Manage Products</title>
</head>
<body>
<?php include('../load.php');?>
<form method="post" action="add.php" enctype="multipart/form-data">
<section class="sec-nav">
      <nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
          <li><a href="home.php" >Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="add.php" class="active">Manage Products</a></li>
          <li><a href="order.php">Orders</a></li>
          <li><a href="process.php">Process Orders</a></li>
          <li><a href="userinfo.php">User Info</a></li>
          <li><a href="log.php?logID=<?php echo ($log); ?>" name="log" onclick="return Log()" ><i class="fa fa-user"></i>
          <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>

      <section class="sec-log" > 
        <div class="product-log" >
     <div id="viewProduct" style="margin-right:5%;" data-aos="fade-down-right">
      <div class="view_product" >
      <?php
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>
                        
                        
                   <?php echo '<img class="view_img" src="data:image;base64,'.base64_encode($row['img']).'" >';?>
                   
                   <p class="name"><?php echo $row["name"]; ?></p>
                   <p class="price">Available: <?php echo $row["qnty"]; ?></p>
                        <strike class="price">৳ <?php echo $row["price"]; ?></strike>
                        <p class="offer">৳ <?php echo $row["offer"]; ?></p>
                        <p class="price">Description: <?php echo $row["des"]; ?></p>
                        <a class="edit" href="add.php?editID=<?php echo $row["id"] ?>">Edit</a>
                        <a class="delete" id="disable" onclick="Status()" href="add.php?disableID=<?php echo $row["id"] ?>">Disable</a>
                        <a class="enable" id="enable" onclick="Status()" href="add.php?enableID=<?php echo $row["id"] ?>">Enable</a>
                        
                    <?php
                }
            }
        ?>
      
      </div>
      </div>
      

      <div class="mcontainer" data-aos="fade-up-right">
      <div class="inputContainer" >

      <input class="Field" type="text" name="name" id="name" placeholder="Product Name" value="<?php echo $name?>" required/>

      <input class="Field" type="text" name="price" id="price" placeholder="Product Price" value="<?php echo $price?>"  required/>

      <input class="Field" type="text" name="offer" id="offer" placeholder="Offer Price" value="<?php echo $offer?>" required/>

      <input class="Field" type="text" name="qnty" id="qnty" placeholder="Product Quantity" value="<?php echo $qnty?>"  required/>

      <textarea class="Field" name="desc" id="desc" placeholder="Product Description" style="height:160px;" value="<?php echo $desc?>" required><?php echo $desc?></textarea>

      

      <select  name="category" class="Field" id="category" placeholder="Category"  required>
          <option value="" disabled selected hidden>Category</option>
          <option>Eggs</option>
          <option>Fish</option>
          <option>Fruits</option>
          <option>Meat</option>
          <option>Milks</option>
          <option>Vegetables</option>
        </select>

        <input class="Field" type="file" name="img" id="img" placeholder="Product Image" onchange="fileValidate()"/>
        <input type="hidden" name="id" value="<?php echo $id; ?>">

          
      <input class="button btn-reg" type="submit" name="upload" onclick="return infoValidate()" id="upload" value="Upload"/>
      <input class="button btn-reg" type="submit" name="update" onclick="return infoValidate()" id="update" value="Update"/>
        
        </div>
        </div>

        </section>
<?php include('../footer.php'); ?>

</form>
</body>
</html>

<script type="text/javascript">

function fileValidate() {
    var image_name = document.getElementById("img");
    var imagePath = image_name.value;
    var extension =/(\.jpg|\.jpeg|\.png|\.gif)$/i; 
    if(!extension.exec(imagePath)){
        alert("Invalid image file");
        image_name='';
        return false;
    }
}

function infoValidate(){
var name = document.getElementById("name");
var price = document.getElementById("price");
var offer = document.getElementById("offer");
var qnty = document.getElementById("qnty");
var desc = document.getElementById("desc");
if(name.value=='' || price.value=='' || offer.value=='' || qnty.value=='' || desc.value==''){
        alert("Please fill out all the feild!!!");
        return false;
    }
}  


if(('<?php echo $id;?>')==""){
document.getElementById("viewProduct").style.display = "none";
document.getElementById("upload").style.display = "block";
document.getElementById("update").style.display = "none";
}else{
document.getElementById("viewProduct").style.display = "block";
document.getElementById("update").style.display = "block";
document.getElementById("upload").style.display = "none";
}


var status = '<?php echo $status;?>'

if(status=="active"){
document.getElementById("disable").style.display="block";
document.getElementById("enable").style.display="none";
}else{
document.getElementById("disable").style.display="none";
document.getElementById("enable").style.display="block";
}

function Status(){
var disable = document.getElementById('disable').getAttribute("href");
var enable = document.getElementById('enable').getAttribute("href");
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
if(status =="active")
window.location=disable;  
else
window.location=enable; 
} else {
swal("Cancelled", "", "error");
}
});
}
</script>