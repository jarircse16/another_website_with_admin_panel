<!-- Include your PHP code to load data from the database here -->
<?php
  include('config.php');
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>

      <?php
        // Query to retrieve text content from the database
        $sql = "SELECT title, content FROM content WHERE id = 6"; // Assuming 'Page Title' is at ID 1
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo $row["content"] ;
        } else {
            echo "No records found.";
        }
        ?>
    </title>
    <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">


<!-- Header -->
<header id="header">
    <h1>Big Picture</h1>
    <nav>
        <ul>
            <li><a href="#intro">Intro</a></li>
            <li><a href="#one">What I Do</a></li>
            <li><a href="#two">Who I Am</a></li>
            <li><a href="#work">My Work</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>
</header>

<!-- Intro -->
<section id="intro" class="main style1 dark fullscreen">
    <div class="content">
        <header>
            <h2>Hey.</h2>
        </header>

        <!-- Display data from the 'content' table here -->
        <?php
        // Query to retrieve text content from the database
        $sql = "SELECT title, content FROM content WHERE id=1"; // Assuming 'Welcome' is the title in your database
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<h2>" . $row["title"]. "</h2>";
                echo "<p>" . $row["content"]. "</p>";
            }
        } else {
            echo "No records found.";
        }
        ?>

        <footer>
            <a href="#one" class="button style2 down">More</a>
        </footer>
    </div>
</section>


<!-- What I Do -->
<section id="one" class="main style2 right dark fullscreen">
    <div class="content box style2">
        <?php
        // Fetch content for "What I Do" from the 'content' table
        $sql = "SELECT title, content FROM content WHERE title = 'What I Do'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>" . $row["content"] . "</p>";
            }
        } else {
            echo "<p>No content found.</p>";
        }
        ?>
    </div>
    <a href="#two" class="button style2 down anchored">Next</a>
</section>

<!-- Who I Am -->
<section id="two" class="main style2 left dark fullscreen">
    <div class="content box style2">
        <?php
        // Fetch content for "Who I Am" from the 'content' table
        $sql = "SELECT title, content FROM content WHERE title = 'Who I Am'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>" . $row["content"] . "</p>";
            }
        } else {
            echo "<p>No content found.</p>";
        }
        ?>
    </div>
    <a href="#work" class="button style2 down anchored">Next</a>
</section>

<!-- My Work -->
<section id="work" class="main style3 primary">
    <div class="content">
        <?php
        $sql = "SELECT title, content FROM content WHERE title = 'My Work'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>" . $row["content"] . "</p>";
            }
        } else {
            echo "<p>No content found.</p>";
        }
        ?>

        <!-- Gallery -->
        <div class="gallery">
            <?php
            // Query to retrieve images from the 'images' table
            $sql = "SELECT title, description, image_path, base64image FROM images";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<article class="from-left">';
                    echo '<a href="' . (empty($row["base64image"]) ? $row["image_path"] : 'data:image/jpeg;base64,' . $row["base64image"]) . '" class="image fit">';
                    echo '<img src="' . (empty($row["base64image"]) ? $row["image_path"] : 'data:image/jpeg;base64,' . $row["base64image"]) . '" title="' . $row["title"] . '" alt="' . $row["description"] . '" />';
                    echo '</a>';
                    echo '</article>';
                }
            } else {
                echo "<p>No images found.</p>";
            }
            ?>
        </div>
    </div>
</section>



<!-- Contact -->
<section id="contact" class="main style3 secondary">
    <div class="content">
        <?php
        $sql = "SELECT title, content FROM content WHERE title = 'Say Hello.'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>" . $row["content"] . "</p>";
            }
        } else {
            echo "<p>No content found.</p>";
        }

         ?>
        <div class="box">
            <form method="post" action="send_email.php">
                <div class="fields">
                    <div class="field half"><input type="text" name="name" placeholder="Name" /></div>
                    <div class="field half"><input type="email" name="email" placeholder="Email" /></div>
                    <div class="field"><textarea name="message" placeholder="Message" rows="6"></textarea></div>
                </div>
                <ul class="actions special">
                    <li><input type="submit" value="Send Email" /></li>
                </ul>
            </form>
        </div>
    </div>
</section>

<?php
// Query to retrieve the footer content from the 'content' table
$sql = "SELECT content FROM content WHERE title = 'Footer'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Fetch and display the footer content
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['content'];
    }
} else {
    // Handle the case when no footer content is found
    echo "<p>No content found.</p>";
}
?>


<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.poptrox.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

<!-- Don't forget to close the database connection at the end of your PHP code -->
<?php
    mysqli_close($conn);
?>
