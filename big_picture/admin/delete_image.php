<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

include('config.php');

// Handle image deletion logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM images WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Image deleted successfully!";
    } else {
        echo "Error deleting image: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include necessary CSS and JS here -->
</head>
<body>
    <h1>Delete Images</h1>

    <a href="admin_logout.php">Logout</a>

    <!-- Add form for image deletion here -->
    <form method="POST">
        <label for="id">Image ID:</label>
        <input type="number" name="id" required>
        <br>
        <input type="submit" value="Delete Image">
    </form>
</body>
</html>
