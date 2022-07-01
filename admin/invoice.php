<?php
include('log.php');

if(!isset($_SESSION['admin'])){
	echo "<script>alert('Please login first!!!');</script>";
	echo "<script>window.location='adminlog.php'</script>";
  }

if(isset($_GET['invoice'])){
	$id=$_GET['invoice'];
	$query = "SELECT * FROM `orders`, `products`,`user` WHERE `orders`.`product_id` = `products`.`id` AND `orders`.`user_id` = `user`.`id` AND `orders`.`order_id`='$id' ";
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
    <title>Invoice</title>
</head>
<body>
<div class="invoice-box">
<?php
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    ?>
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<h1 class="logo">Agro Farm</h1>
									<h3>Eat healthy, be heathy!</h3>
								</td>
								<td>
									Order Date: <?php echo $row['order_date']; ?> <br/>
									Processing Date: <?php echo date("d/m/Y") ?>
								</td>
								
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Agro Farm Food<br>
									Pallabi, Mirpur-12<br>
									Dhaka-1216, Bangladesh
								</td>

								<td>
									Contact Us:<br />
                                    + 01 234 567 88<br />
                                    info@example.com
								</td>
								
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Name : <?php echo $row['fname']." ".$row['lname']; ?> <br>
									Phone : <?php echo $row['phone']; ?><br>
									Delivery Address : <?php echo $row['delivery_add'];?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Payment Method</td>
					<td><?php echo $row['pay_meth']; ?></td>
				</tr>
				<tr class="heading">
					<td>Item</td>
					<td>Price</td>
					
				</tr>

				<tr class="item">
					<td><?php echo $row['name'] ?></td>
					<td><?php echo $row['order_price'] ?> TK.</td>
				</tr>

				<tr>
				<td>Quantity</td>
					<td><?php echo $row['order_qnty'] ?></td>
				</tr>

				<tr class="total">
					<td></td>
					<td>Total: <?php echo $row['order_price']*$row['order_qnty'] ?> TK.</td>
				</tr>
				<?php
                }
            }
        ?>
		<table>
			<td>
			Thanks for purchasing our products. <br> <br>
			&bull; In order to be eligible for a refund, you have to return the product to our delivery man. The product must be in the same condition that you receive it and undamaged in any way.<br><br>

			&bull; After we receive your item, our team of professionals will inspect it and process your refund. The money will be refunded to the original payment method you’ve used during the purchase. <br><br>
			
			&bull; If the product is damaged in any way, you will not be eligible for a refund. <br><br>

			&bull; If anything is unclear or you have more questions feel free to contact our customer support team.

			</td>
		</table>
			</table>
		</div>
		<br>
		<center>
			<button class="button btn-reg" type="button" onclick="Print()" id="printButton">Print</button>
		</center>
		
</body>
</html>

<script>
	function Print() {
		var button = document.getElementById('printButton');
		button.style.display="none";
		window.print();
		button.style.display="block";
		
	}
</script>