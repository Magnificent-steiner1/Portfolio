<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Admin Panel</h1>
        <div class="buttons">
            <a href="portfolio.php" class="btn">View Portfolio</a>
            <a href="?logout=true" class="btn">Logout</a>
        </div>
        <div class="sections">
            <div class="section">
                <h2>Projects</h2>
                <a href="projects.php">
                    <div class="thumbnail" style="background-image: url('admin/projects.jpg')"></div>
                </a>
            </div>
            <div class="section">
                <h2>Blogs</h2>
                <a href="blogs.php">
                    <div class="thumbnail" style="background-image: url('admin/blog.jpg')"></div>
                </a>
            </div>
            <div class="section">
                <h2>Photography</h2>
                <a href="photography.php">
                    <div class="thumbnail" style="background-image: url('admin/photography.jpg')"></div>
                </a>
            </div>
            <div class="section">
                <h2>Skills</h2>
                <a href="skills.php">
                    <div class="thumbnail" style="background-image: url('admin/skills.jpg')"></div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
