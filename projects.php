<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

$host = 'localhost';
$dbname = 'portfolio';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


$stmt = $conn->prepare("SELECT * FROM projects");
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_project"])) {
    try {
        $project_name = $_POST['project_name'];
        $project_type = $_POST['project_type'];
        $project_description = $_POST['project_description'];

        $target_dir = "admin/projects/";
        $target_file = $target_dir . basename($_FILES["sample_photo"]["name"]);
        move_uploaded_file($_FILES["sample_photo"]["tmp_name"], $target_file);

        $stmt = $conn->prepare("INSERT INTO projects 
                            (name, type, image, description)
                            VALUES (:name, :type, :image, :description)");
        $stmt->bindParam(':name', $project_name);
        $stmt->bindParam(':type', $project_type);
        $stmt->bindParam(':image', $target_file);
        $stmt->bindParam(':description', $project_description);


        if ($stmt->execute()) {
            header("location: projects.php?success=1");
            exit;
        } else {
            header("location: projects.php?error=1");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_project"])) {
    try {
        $delete_project_id = $_POST['project_id'];

        $stmt = $conn->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->bindParam(':id', $delete_project_id);

        if ($stmt->execute()) {

            header("location: projects.php?success=1");
            exit;
        } else {
            header("location: projects.php?error=1");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="projects.css">
</head>

<body>
    <div class="container">
        <h1>Projects</h1>
        <button id="add-project-btn">Add a Project</button>
        <div id="project-form" class="hidden">
            <h2>Add Project</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="text" name="project_name" placeholder="Project Name" required>
                <select name="project_type" required>
                    <option value="android">Android</option>
                    <option value="desktop">Desktop</option>
                    <option value="web">Web</option>
                    <option value="other">Other</option>
                </select>
                <input type="file" name="sample_photo" required>
                <textarea name="project_description" placeholder="Project Description (200-300 characters)" required></textarea>
                <button type="submit" name="add_project">Add</button>
            </form>
        </div>


        <div class="projects">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project) : ?>
                        <tr>
                            <td><?php echo $project['name']; ?></td>
                            <td><?php echo $project['type']; ?></td>
                            <td><?php echo $project['description']; ?></td>
                            <td><img src="<?php echo $project['image']; ?>" alt="Project Image" width="100"></td>
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                    <button type="submit" name="delete_project" class="delete-btn" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        document.getElementById("add-project-btn").addEventListener("click", function() {
            document.getElementById("project-form").classList.toggle("hidden");
        });
    </script>
</body>

</html>