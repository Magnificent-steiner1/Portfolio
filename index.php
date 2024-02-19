<?php
$servername = "localhost";
$username = "admin";
$password = "asif11996";
$dbname = "portfolio";
echo"hello";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed". $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (name, email, message) values ('$name', '$email', '$message')";

if ($conn->query($sql) === TRUE){
    echo "Message sent successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>