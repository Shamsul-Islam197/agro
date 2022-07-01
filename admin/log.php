<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <?php include('../link.php');?>
  <title>Document</title>
</head>
<body>
  
</body>
</html>
<?php
require_once('connection.php');
session_start();


if(isset($_GET['logID'])){

  if(isset($_SESSION['admin'])){
        unset($_SESSION['admin']);
        echo '<script>window.location="home.php"</script>';
    }else{
      echo '<script>window.location="adminlog.php"</script>';
    }
  }
  

  if(isset($_SESSION['admin'])){
    $log="Logout"; 
  }else{
    $log="Login";
  }
?>

<script>
  function Log(){
    var a = '<?php if(isset($_SESSION['admin'])){echo ($_SESSION['admin']); } ?>'
  if(a==""){
    window.location = "userlog.php";
  }else{
    event.preventDefault();
var form = event.target.form;
        swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, log out!",
  cancelButtonText: "Cancel!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm){
  if (isConfirm) {
    window.location="log.php?logID";
  } else {
    swal("Cancelled", "", "error");
  }
});
}
  }
</script>