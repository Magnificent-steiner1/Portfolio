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
    $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$stmt = $conn->prepare("SELECT * FROM skills");
$stmt->execute();
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_skill"])) {
    try {
        $skill_name = $_POST['skill_name'];
        $skill_type = $_POST['skill_type'];
        $skill_value = $_POST['skill_value'];

        $stmt = $conn->prepare("INSERT INTO skills 
                            (name, type, value)
                            VALUES (:name, :type, :value)");
        $stmt->bindParam(':name', $skill_name);
        $stmt->bindParam(':type', $skill_type);
        $stmt->bindParam(':value', $skill_value);

        if ($stmt->execute()) {
            header("location: skills.php?success=1");
            exit;
        } else {
            header("location: skills.php?error=1");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_skill"])) {
    try {

        $delete_skill_id = $_POST['skill_id'];


        $stmt = $conn->prepare("DELETE FROM skills WHERE id = :id");
        $stmt->bindParam(':id', $delete_skill_id);

        if ($stmt->execute()) {
            
            header("location: skills.php?success=1");
            exit;
        } else {
            header("location: skills.php?error=1");
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
    <title>Document</title>
    <link rel="stylesheet" href="skills.css">
</head>
<body>
    <div class="container">
        <h1>Skills</h1>
        <button id="add-skill-btn">Add skill</button>
        <div id="skill-form" class="hidden">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="skill_name" placeholder="Skill Name" required>
                <select name="skill_type" required>
                    <option value="language">Language</option>
                    <option value="professional">Professional</option>
                </select>
                <input type="number" name="skill_value" min="10" max="100" placeholder="Enter a value between 10 and 100" required>
                <button type="submit" name="add_skill">Submit</button>
            </form>
        </div>

        <div class="skills">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills as $skill) : ?>
                        <tr>
                            <td><?php echo $skill['name']; ?></td>
                            <td><?php echo $skill['type']; ?></td>
                            <td><?php echo $skill['value']; ?></td>
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" name="skill_id" value="<?php echo $skill['id']; ?>">
                                    
                                    <button type="submit" name="delete_skill" class="delete-btn" onclick="return confirm('Are you sure you want to remove this skill?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        document.getElementById("add-skill-btn").addEventListener("click", function() {
            document.getElementById("skill-form").classList.toggle("hidden");
        });
    </script>
</body>
</html>

