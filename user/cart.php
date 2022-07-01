<?php
include('log.php');

$success="";
if (isset($_GET["deleteID"])){
        foreach ($_SESSION["cart"] as $keys => $value){
            if ($value["product_id"] == $_GET["deleteID"]){
                unset($_SESSION["cart"][$keys]);
                $success="true";
            }
        }
    }

if(isset($_POST['bkash']) || isset($_POST['card']) || isset($_POST['cod'])){
    if(isset($_POST['bkash'])){
        $pay="Bkash";
    }else if(isset($_POST['card'])){
        $pay="Card";
    }else{
        $pay="Cod";
    }
    $user_id=($_SESSION['userid']);
    $address = $_POST['address'];
    $date = date("d/m/Y");

        if(!empty($_SESSION["cart"])){
            foreach ($_SESSION["cart"] as $key => $value) {
                $id = $value["product_id"];
                $price = $value["product_price"];
                $qnty = $value["item_quantity"];

                $query="INSERT INTO `orders` (`product_id`, `order_price`, `order_qnty`, `delivery_add`, `order_date`,`user_id` ,`status`,`pay_meth`) 
                VALUES ('$id', '$price', '$qnty','$address','$date','$user_id','Pending','$pay');";

                $query2 = " SELECT * FROM `products` where `id`='".$id."'";

                $result = mysqli_query($con,$query2);

                while($rows=mysqli_fetch_assoc($result)){
                    $tmp=$rows['qnty'];
                }
                if($tmp<$qnty){
                    echo "<script>alert('Not enough stock available');</script>";
                }else{$tmp=$tmp-$qnty;
                    $query3="UPDATE `products` SET `qnty` = '".$tmp."' WHERE `products`.`id` = '".$id."'";
                    $result2=mysqli_query($con,$query3);
                }
                
                }

                if(mysqli_query($con,$query)){
                 echo "<script>alert('Order Successfull')</script>";
                 echo '<script>window.location="myorder.php"</script>';
                 unset($_SESSION["cart"]);
                }else{
                    echo "<script>alert('Error')</script>";

                }
                
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
    <title>Cart</title>
</head>
<body onload="pageLoading()">
<?php include('../load.php');?>
<form action="cart.php" method="POST" name="cart">

<section class="sec-nav">
  <nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
        <li><a href="home.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="myorder.php">My  Orders</a></li>
          <li><a href="cart.php"  class="active"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span>
            <sup><?php echo $cart_count; ?></sup></span></a></li>
            <li><a href="log.php?logID=<?php echo $log; ?>" name="log" onclick="return Log()" ><i class="fa fa-user"></i>
            <?php echo ($log); ?></a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>


<?php
        if(!empty($_SESSION["cart"])){
            ?>

        <section class="sec-table" data-aos="fade-up">
          
        <h1>Your Cart Details</h1>

            <table>
            <tr>
                <th>Product Name</th>
                <th>Product Image</th>
                <th>Quantity</th>
                <th>Price Details</th>
                <th>Total Price</th>
                <th>Remove Item</th>
            </tr>

            <?php
                if(!empty($_SESSION["cart"])){
                    $total = 0;
                    foreach ($_SESSION["cart"] as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $value["item_name"]; ?></td>
                            <td>
                                <?php

                                    $query="SELECT `img` FROM `products` WHERE `id`='".$value["product_id"]."'";
                                    $result=mysqli_query($con,$query);
                                    while($rows=mysqli_fetch_assoc($result)){
                                         echo '<img src="data:image;base64,'.base64_encode($rows['img']).'" class="img">';
                                    }
                                ?>
                            </td>
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td>TK. <?php echo $value["product_price"]; ?></td>
                            <td>
                                TK. <?php echo number_format($value["item_quantity"] * $value["product_price"], 2); ?></td>
                            <td><a onclick="confirmAction()" href="cart.php?deleteID=<?php echo $value["product_id"]; ?>" id="remove"><span
                                         class="text-danger">Remove Item</span></a></td>

                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["product_price"]);
                    }
                        ?>
                        <tr>
                            <td colspan="5" align="right">Total</td>
                            <th align="right">TK. <?php echo number_format($total, 2); ?></th>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><a href="#checkout" onclick=" showCheckout()" class="btn btn-success">Proceed to checkout</a></td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        <?php 
        }else{
            ?>
            <h1 class="cart-text">Your cart is empty</h1>
            
        <?php
        }
        ?>
        
<br>
<div class="mcontainer" id="checkout">
<div class="inputContainer" >
<h2>Total Item: <?php echo $cart_count;?></h2>
<h2>Net payable ammount: <?php echo $total;?></h2>
<br>
<br>
<i class="fa fa-address-card icon fa-2x"> </i>
<input class="Field" type="text" name="address" id="address" placeholder="Delivery address"  />
<br>
<a href="#" class="btn btn-success" onclick="payCard()" id="btnCard">Credit Card</a>
<br>
<a href="#" class="btn btn-success" onclick="payBkash()" id="btnBkash">Bkash</a>
<br>
<a href="#" class="btn btn-success" onclick="payCod()" id="btnCod">Cash on Delivery</a>
<br>
<br>

<div id="card">
<i class="fa fa-user icon fa-2x"> </i>
<input class="Field" type="text" name="owner" id="owner" placeholder="Card owner name"  />

<i class="fa fa-key icon fa-2x"> </i>
<input class="Field" type="password" name="cardno" id="cardno" placeholder="Valid card No." />

<input class="Field" type="date" name="date" id="date" placeholder="Experation date" />

<i class="fa fa-key icon fa-2x"> </i>
<input class="Field" type="password" name="cvc" id="cvc" placeholder="CVC" />
<input class="button btn-reg" type="submit" name="card" onclick="return validateCard()" value="Card Pay"/>
</div>

<div id="bkash">
<i class="fa fa-phone icon fa-2x"> </i>
<input class="Field" type="text" name="phone" id="phone" placeholder="Bkash account no."  />


<i class="fa fa-key icon fa-2x"> </i>
<input class="Field" type="password" name="pin" id="pin" placeholder="Bkash transaction id" />
<input class="button btn-reg" type="submit" name="bkash" onclick="return validateBkash()" value="Bkash Pay"/>
</div>

<input class="button btn-reg" type="submit" name="cod" id="cod" onclick="return validateCod()" value="COD Pay"/>


    </div>
</div>
</section>

       

        <section class="sec-footer">
          <?php include('../footer.php');?>
          </section>
    </form>
</body>
</html>

<script>
    function confirmAction(){
        var Url = document.getElementById('remove').getAttribute("href");
        event.preventDefault();
        var form = event.target.form;
        swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, Remove it!",
  cancelButtonText: "No, cancel please!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
    window.location=Url; 
  } else {
    swal("Cancelled", "", "error");
  }
});
    }

    function validateBkash(){ 
        var address=document.getElementById("address");
        var phone=document.getElementById("phone");
        var pin=document.getElementById("pin");
        

        if(phone.value=="" || pin.value=="" || address.value==""){
            alert("Please fill out all the required fields");
            return false;
        }else{
            var x = confirm("Are you sure?");
            if(x==true){
                return true;
            }else{
                return false;
            }
        }
     }

     function validateCard(){ 
        var address=document.getElementById("address");
        var owner=document.getElementById("owner");
        var cardno=document.getElementById("cardno");
        var cvc=document.getElementById("cvc");
        var date=document.getElementById("date");

        if(owner.value=="" || cardno.value=="" || cvc.value=="" || date.value=="" || address.value==""){
            alert("Please fill out all the required fields");
            return false;
        }else{
            var x = confirm("Are you sure?");
            if(x==true){
                return true;
            }else{
                return false;
            }
        }
     }

     function validateCod(){
        var address=document.getElementById("address");
        if(address.value==""){
            alert("Please fill out all the required fields");
            return false;
        }else{
            var x = confirm("Are you sure?");
            if(x==true){
                return true;
            }else{
                return false;
            }
        }
     }

     

    function payCard(){ 
        document.getElementById("card").style.display = "block";
        document.getElementById("bkash").style.display = "none";
        document.getElementById("btnCard").style.display = "none";
        document.getElementById("btnCod").style.display = "block";
        document.getElementById("btnBkash").style.display = "block";
        document.getElementById("cod").style.display = "none";
    }
    function payBkash(){ 
        document.getElementById("bkash").style.display = "block";
        document.getElementById("card").style.display = "none";
        document.getElementById("btnCard").style.display = "block";
        document.getElementById("btnCod").style.display = "block";
        document.getElementById("btnBkash").style.display = "none";
        document.getElementById("cod").style.display = "none";
    }

    function payCod(){ 
        document.getElementById("bkash").style.display = "none";
        document.getElementById("card").style.display = "none";
        document.getElementById("btnCard").style.display = "block";
        document.getElementById("btnBkash").style.display = "Block";
        document.getElementById("btnCod").style.display = "none";
        document.getElementById("cod").style.display = "block";
    }

    function showCheckout(){
        var x = ('<?php if(isset($_SESSION['userid'])){ echo (1);} ?>');
        if(x==1){
        document.getElementById("checkout").style.display = "block";
        }else{
            document.getElementById("checkout").style.display = "none";
            alert('Please login first...');
            window.location="userlog.php";
        }
    }

    
    document.getElementById("checkout").style.display = "none"
    payCard();

    var x = ('<?php echo $success; ?>');
    if(x=="true"){
        swal({
    title: "Removed",
    text: "",
    type: "success"
})

}

</script>
