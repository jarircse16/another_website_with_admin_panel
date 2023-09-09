<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

include('config.php');

// Handle content editing logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldTitle = $_POST['old_title']; // Existing title to identify the record
    $newTitle = $_POST['new_title']; // New title
    $content = $_POST['content']; // Updated content

    $sql = "UPDATE content SET title = ?, content = ? WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $newTitle, $content, $oldTitle);

    if ($stmt->execute()) {
        echo "Content updated successfully!";
    } else {
        echo "Error updating content: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include necessary CSS and JS here -->
</head>
<body>
    <center><h1>Edit Website Content</h1>
    <a href="admin_dashboard.php">Back to Admin Dashboard</a><br><br>
    <a href="admin_logout.php">Logout</a><br><br>

    <!-- Add form for content editing here -->
    <form method="POST">
        <label for="old_title">Existing Content Title:</label>
        <select name="old_title">
            <option value="Welcome">Welcome</option>
            <option value="What I Do">What I Do</option>
            <option value="Who I Am">Who I Am</option>
            <option value="My Work">My Work</option>
            <option value="Say Hello.">Say Hello.</option>
        </select>
        <br><br>
        <label for="new_title">New Content Title:</label>
        <input type="text" name="new_title" required>
        <br><br>
        <label for="content">Content:</label>
        <textarea name="content" rows="4" cols="50"></textarea>
        <br><br>
        <input type="submit" value="Update Content">
    </form></center>
</body>
</html>
