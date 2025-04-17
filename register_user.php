<?php
include 'db_connect.php';

$name = $_POST['name'];
$phone = $_POST['phone_number'];
$email = $_POST['email'];
$pass = $_POST['pass'];

$sql = "INSERT INTO user_info (name, phone_number, email, pass) 
        VALUES ('$name', '$phone', '$email', '$pass')";

if ($conn->query($sql) === TRUE) {
  echo "Registered successfully!";
} else {
  echo "Something went wrong!: " . $conn->error;
}

$conn->close();
?>
