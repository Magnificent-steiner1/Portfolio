<?php
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
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan&display=swap" rel="stylesheet">
</head>

<body>

    <div class="header">
        <header class="header-content">
            <a href="#logo" class="logo-text">Portfolio</a>

            <nav>
                <ul class="sidebar">
                    <li><a href="#home" class="nav-link">Home</a></li>
                    <li><a href="#about" class="nav-link">About</a></li>
                    <li><a href="#skills" class="nav-link">Skills</a></li>
                    <li><a href="#projects" class="nav-link">Projects</a></li>
                    <li><a href="#photography" class="nav-link">Photography</a></li>
                    <li><a href="#blog" class="nav-link">Blog</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>
                </ul>
                <ul class="nav-bar">
                    <li><a href="#home" class="nav-link">Home</a></li>
                    <li><a href="#about" class="nav-link">About</a></li>
                    <li><a href="#skills" class="nav-link">Skills</a></li>
                    <li><a href="#projects" class="nav-link">Projects</a></li>
                    <li><a href="#photography" class="nav-link">Photography</a></li>
                    <li><a href="#blog" class="nav-link">Blog</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>

                </ul>
            </nav>

            <a href="admin.php" class="admin-button">Admin</a>

            <button type="button" class="menu-button">
                <img src="./images/icons8-menu-48.png" alt="menu-icon" class="menu-icon">
            </button>

        </header>
        <hr class="header-rule">
    </div>

    <section class="main-section" id="home">
        <div class="content-left">
            <!-- <p class="section-label"></p> -->
            <h1 class="section-title-1">Hi! I'm Asif</h1>
            <h2 class="section-title-2">Web Designer</h2>
            <h2 class="section-title-3">App Developer</h2>
            <p class="section-description">I'm monke. I'm a beginner web designer and app developer.
            </p>
            <div class="button-group">
                <a href="#hire-me" class="hire-me-button">Hire me</a>
                <a href="#download-cv" class="download-cv-button">Download CV</a>
            </div>

        </div>

        <div class="content-right">
            <div class="image-container">
                <img src="./images/monke.jpeg" alt="sectionImage" class="section-image">
            </div>

        </div>
    </section>


    <section class="about-section" id="about">
        <header class="about-me">About Me</header>
        <main class="row">

            <section class="col">
                <header class="title">
                    <h2>Education</h2>
                </header>
                <div class="contents">
                    <div class="box">
                        <h4>2020-present</h4>
                        <h3>BSc in CSE</h3>
                        <p>Khulna University of Engineering & Techonology</p>
                    </div>
                    <div class="box">
                        <h4>2018-2020</h4>
                        <h3>College Degree</h3>
                        <p>Brahmanbaria Government College</p>
                    </div>

                </div>
            </section>

            <section class="col">
                <header class="title">
                    <h2>Experience</h2>
                </header>
                <div class="contents">
                    <div class="box">
                        <h4>2024</h4>
                        <h3>Web Developer</h3>
                        <p>Web lab</p>
                    </div>
            </section>

        </main>

    </section>





    <section class="skills-section" id="skills">
        <?php
        $stmt = $conn->prepare("SELECT * FROM skills WHERE type = 'language'");
        $stmt->execute();
        $languageSkills = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT * FROM skills WHERE type = 'professional'");
        $stmt->execute();
        $professionalSkills = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="column">

            <div class="skills-heading">
                <h2>Language Skills</h2>
            </div>
            <div class="skills-column">
                <?php foreach ($languageSkills as $skill) : ?>
                    <div class="skill-temp">
                        <div class="skill-name">
                            <?php echo $skill['name']; ?>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="--skill-value: <?php echo $skill['value']; ?>;">
                                <?php echo $skill['value']; ?>%
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="column">
            <div class="skills-heading">
                <h2>Professional Skills</h2>
            </div>
            <div class="skills-column">
                <?php foreach ($professionalSkills as $skill) : ?>
                    <div class="skill-temp">
                        <div class="skill-name">
                            <?php echo $skill['name']; ?>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="--skill-value: <?php echo $skill['value']; ?>;">
                                <?php echo $skill['value']; ?>%
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>





    <section class="projects" id="projects">
        <header class="projects-heading">Recent Projects</header>

        <div class="project-filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="web">Web</button>
            <button class="filter-btn" data-filter="android">Android</button>
            <button class="filter-btn" data-filter="desktop">Desktop</button>
        </div>

        <div class="grid">
            <?php
                $stmt = $conn->query("SELECT * FROM projects");
                $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($projects as $project) {
                    echo '<div class="project ' . $project['type'] . '">';
                    echo '<h3>' . $project['name'] . '</h3>';
                    echo '<img src="' . $project['image'] . '" alt="' . $project['name'] . '">';
                    echo '<p>' . $project['description'] . '</p>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>



    



    <section class="photography" id="photography">
        <header class="photography-heading">My Gallery</header>

        <div class="photo-filters">
            <button class="photo-filter-btn active" photo-filter="all">All</button>
            <button class="photo-filter-btn" photo-filter="landscape">Landscape</button>
            <button class="photo-filter-btn" photo-filter="people">People</button>
            <button class="photo-filter-btn" photo-filter="b&w">B&W</button>
        </div>

        <div class="photo-gallery">
            <?php
            $stmt = $conn->query("SELECT * FROM photography");
            $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($photos as $photo) {
                echo '<div class="photo ' . $photo['type'] . '">';
                echo '<img src="' . $photo['image'] . '" alt="' . $photo['description'] . '">';
                echo '</div>';
            }
            ?>
        </div>

    </section>


    <section class="blog" id="blog">

    </section>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const projects = document.querySelectorAll('.project');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    projects.forEach(project => {
                        if (filter === 'all' || project.classList.contains(filter)) {
                            project.style.display = 'block';
                        } else {
                            project.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>





    <section class="footer-section" id="contact">
        <div class="social-box">
            <a href="https://www.linkedin.com/in/asif-mahmud-611a4311a/" target="_blank"><img src="./images/icons8-linkedin-48.png" alt="LinkedIn"></a>
            <a href="" target="_blank"><img src="./images/icons8-github-48.png" alt="GitHub"></a>
            <a href="https://www.facebook.com/AsifMahmudOntu/" target="_blank"><img src="./images/icons8-facebook-48.png" alt="Facebook"></a>
            <a href="" target="_blank"><img src="./images/icons8-upwork-50.png" alt="Upwork"></a>
            <a href="" target="_blank"><img src="./images/icons8-reddit-50.png" alt="Reddit"></a>
        </div>
        <div class="message-contact">
        <div class="message-box">
            <header class="message-header" >Send me a message</header>
            <div class="message-name">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="message-email">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

            </div>
            <div class="message">
                <label for="message">Message</label>
                <textarea name="message" id="message" placeholder="Message (max 500 characters)" maxlength="500" required></textarea>
            </div>
            <div id="send-button" class="send-button">
                <button type="submit">Send</button>
            </div>
        </div>

        <div class="contact-box">
            <div class="contact-item">
                <img class="contact-icon" src="./images/icons8-address-50.png" alt="">Khulna, Bangladesh
            </div>

            <div class="contact-item">
                <img class="contact-icon" src="./images/icons8-email-50.png" alt="">as.if.98914@gmail.com
            </div>
            <div class="contact-item">
                <img class="contact-icon" src="./images/icons8-phone-50.png" alt="">+8801747770396
            </div>
        </div>
        </div>
        <div class="credit">
            Designed By Monke
        </div>
    </section>


    <script src="code.js"></script>
</body>

</html>