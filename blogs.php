<?php
session_start();
if(!isset($_SESSION['loggedin'])|| $_SESSION['loggedin']!==true){
    header("location: login.php");
    exit();
}

$host= 'localhost';
$dbname= 'portfolio';
$username= 'root';
$password= '';

try{
    $conn= new PDO("mysql:host=$host; dbname=$dbname",$username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Connection failed:" . $e->getMessage();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="blogs.css">
</head>
<body>
    
</body>
</html>