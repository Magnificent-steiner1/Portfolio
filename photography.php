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

$stmt = $conn->prepare("SELECT * FROM photography");
$stmt->execute();
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_photo"])) {
    try {
        $photo_name = $_POST['photo_name'];
        $photo_type = $_POST['photo_type'];
        $photo_description = $_POST['photo_description'];

        $target_dir = "admin/photography/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

        $stmt = $conn->prepare("INSERT INTO photography 
                            (image, type, description)
                            VALUES (:image, :type, :description)");
        $stmt->bindParam(':type', $photo_type);
        $stmt->bindParam(':image', $target_file);
        $stmt->bindParam(':description', $photo_description);

        if ($stmt->execute()) {
            header("location: photography.php?success=1");
            exit;
        } else {
            header("location: photography.php?error=1");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_photo"])) {
    try {
        $delete_photo_id = $_POST['photo_id'];

        $stmt = $conn->prepare("DELETE FROM photography WHERE id = :id");
        $stmt->bindParam(':id', $delete_photo_id);

        if ($stmt->execute()) {
            header("location: photography.php?success=1");
            exit;
        } else {
            header("location: photography.php?error=1");
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
    <link rel="stylesheet" href="photography.css">
</head>

<body>
    <div class="container">
        <h1>Photos</h1>
        <button id="add-photo-btn">Add a Photo</button>
        <div id="photo-form" class="hidden">
            <h2>Add Photo</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <select name="photo_type" required>
                    <option value="landscape">Landscape</option>
                    <option value="people">People</option>
                    <option value="b&w">B&W</option>
                    <option value="other">Other</option>
                </select>
                <input type="file" name="photo" required>
                <textarea name="photo_description" placeholder="Photo Description (50-150 characters)" required></textarea>
                <button type="submit" name="add_photo">Add</button>
            </form>
        </div>

        <div class="photos">
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($photos as $photo) : ?>
                        <tr>
                            <td><img src="<?php echo $photo['image']; ?>" alt="Project Image" width="100"></td>
                            <td><?php echo $photo['type']; ?></td>
                            <td><?php echo $photo['description']; ?></td>

                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>">
                                    <button type="submit" name="delete_photo" class="delete-btn" onclick="return confirm('Are you sure you want to delete this photo?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        document.getElementById("add-photo-btn").addEventListener("click", function() {
            document.getElementById("photo-form").classList.toggle("hidden");
        });
    </script>
</body>

</html>
