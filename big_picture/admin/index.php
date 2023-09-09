<?php
include('config.php');
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];



    // Query to check if the provided username exists in the admin table
    $sql = "SELECT admin_password FROM admin WHERE admin_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username exists, fetch the stored MD5 hashed password
        $stmt->bind_result($storedMD5Password);
        $stmt->fetch();

        // Calculate the MD5 hash of the provided password
        $providedMD5Password = md5($password);

        // Verify the provided MD5 hashed password against the stored hash
        if ($providedMD5Password === $storedMD5Password) {
            $_SESSION['admin'] = true;
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include necessary CSS and JS here -->
</head>
<body><br>
    <center><h1>Admin Login</h1>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="login" value="Login">Login</button>
    </form>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
  </center>
</body>
</html>
