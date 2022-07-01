<?php
require_once('connection.php');
session_start();

if(isset($_POST['reg'])){
        $fname=($_POST['fname']);
        $lname=($_POST['lname']);
        $email=($_POST['email']);
        $phone=($_POST['phone']);
        $password=($_POST['pass']);
        $password_2=($_POST['cpass']);

        $query="SELECT * FROM admin WHERE email='$email'";
        $result=mysqli_query($con,$query);

        if(mysqli_num_rows($result)>0)
            {
                echo '<script>alert("Alreadey registered with this mail")</script>';
            }else{

        if($password==$password_2){
            $password=md5($password);
            $query="INSERT INTO admin(fname,lname,phone,email,pass) VALUES('$fname','$lname','$phone','$email','$password')";
            if($result=mysqli_query($con,$query)){
            echo '<script>alert("Successfully registered")</script>';
            echo '<script>window.location="adminlog.php"</script>';
            }else{
                echo '<script>alert("Something went wrong")</script>';
            }
        }
    }
        }

    if(isset($_POST['login'])){
        $email=($_POST['lemail']);
        $password=($_POST['lpass']);
        $password=md5($password);
        $query="SELECT * FROM admin WHERE email='$email' AND pass='$password'";
        $result=mysqli_query($con,$query);
        if(mysqli_num_rows($result)>0)
            {
                while($row = mysqli_fetch_array($result)){
                    $_SESSION['admin']="admin";
                }
                echo "<script>alert('Successfully logged in')</script>";
                echo '<script>window.location="home.php"</script>';
            }else{
                echo "<script>alert('Username or password is incorrect!')</script>";
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
    <title>Admin Log</title>
</head>
<body>
<?php include('../load.php');?>
<form method="post" action="adminlog.php">
<section class="sec-nav">
      <nav>
        <a href="home.php" class="logo">Agro</a>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="products.php">Products</a></li>
          <li><a href="add.php">Manage Products</a></li>
          <li><a href="order.php">Orders</a></li>
          <li><a href="process.php">Process Orders</a></li>
          <li><a href="userinfo.php">User Info</a></li>
          <li><a href="adminlog.php" class="active"><i class="fa fa-user"></i> Login</a></li>
        </ul>
        <div class="toggle"></div>
      </nav>
      </section>
      
      
      <section class="sec-log" data-aos="zoom-out-right">
<div class="mcontainer" id="login">
<img src="../img/user.png"/>
      <div class="inputContainer" >
<i class="fa fa-envelope icon fa-2x"> </i>
<input class="Field" type="text" name="lemail" id="lemail" placeholder="Email"  />


<i class="fa fa-key icon fa-2x"> </i>
<input class="Field" type="password" name="lpass" id="lpass" placeholder="Password" />



<input class="button btn-reg" type="submit" name="login" onclick="return Login()" value="Sign in"/>
  <p class="signin">Not registered?<a class="link" href="#" onclick="closeForm()"> Sign up here</a>
            </p>
    </div>
</div>
      

      <div class="mcontainer" id="signup">
      <img src="../img/user.png"/>
      <div class="inputContainer" >
<i class="fa fa-user icon fa-2x"> </i>
<input class="Field" type="text" name="fname" id="fname" placeholder="First Name"  />

<i class="fa fa-user icon fa-2x"> </i>
<input class="Field" type="text" name="lname" id="lname" placeholder="Last Name"  />

<i class="fa fa-envelope icon fa-2x"> </i>
<input class="Field" type="text" name="email" id="email" placeholder="Email"  />

<i class="fa fa-phone icon fa-2x"> </i>
<input class="Field" type="text" name="phone" id="phone" placeholder="Phone"  />

<i class="fa fa-key icon fa-2x"> </i>
<input class="Field" type="password" name="pass" id="pass" placeholder="Password"  />

<i class="fa fa-key icon fa-2x"> </i>
<input class="Field" type="password"  name="cpass" id="cpass" placeholder="Confirm Password"  />
<input class="button btn-reg" type="submit" name="reg" onclick="return Validate()" value="Sign Up"/>
<p class="signin">Already registered?<a class="link" href="#" onclick="openForm()"> Sign in here</a>
            </p>
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

function openForm() {
    document.getElementById("login").style.display = "block";
    document.getElementById("signup").style.display = "none";
}

function closeForm() {
    document.getElementById("signup").style.display = "block";
    document.getElementById("login").style.display = "none";
}
    openForm();
    function Validate() {
        var fname=document.getElementById("fname");
        var lname=document.getElementById("lname");
        var email=document.getElementById("email");
        var phone=document.getElementById("phone");
        var pass=document.getElementById("pass");
        var cpass=document.getElementById("cpass");
    if(fname.value=="" || lname.value=="" || email.value=="" || phone.value=="" || pass.value=="" || cpass.value==""){
        alert("Please fill out all the required fields");
            return false;
    }
        if(pass.value!=cpass.value){
            alert("Password didn't match!!!");
            return false;
        }
    }

    function Login() {
        var email=document.getElementById("lemail");
        var pass=document.getElementById("lpass");

        if(email.value=="" || pass.value==""){
            alert("Please fill out all the required fields");
            return false;
        }
    }
</script>