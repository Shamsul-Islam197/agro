<?php

    $con=mysqli_connect('localhost','root','','agro');

    if(!$con)
    {
        die(' Please Check Your Connection'.mysqli_error($con));
    }
?>
