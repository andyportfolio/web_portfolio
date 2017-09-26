<?php


$conn = mysqli_connect(); //it is not often
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>