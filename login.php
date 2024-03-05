<?php
session_start();
try{

    $server = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'portfolio';

    $conn= new PDO("mysql:host=$server; dbname=$db",$user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo 'Error: ' .$e->getMessage();
}


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: admin.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->execute(array(':username' => $input_username));
    $user = $stmt->fetch();

    if ($user && password_verify($input_password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        header("location: admin.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
