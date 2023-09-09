<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

include('config.php');

// Initialize variables
$imageId = $_GET['id'] ?? null;
$imageData = [];

// Check if an image ID is provided
if (!empty($imageId)) {
    // Query to retrieve image data by ID
    $sql = "SELECT id, title, description, image_path, image_class, base64image FROM images WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $imageId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $imageData = $result->fetch_assoc();
        }
    }
}

// Handle form submission to update image details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_details'])) {
    // Retrieve form data
    $newTitle = $_POST['title'] ?? '';
    $newDescription = $_POST['description'] ?? '';

    // Update image details if provided
    if (!empty($newTitle) && !empty($newDescription)) {
        $sql = "UPDATE images SET title = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newTitle, $newDescription, $imageId);

        if ($stmt->execute()) {
            // Image details updated successfully
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $errorMsg = "Error updating image details: " . $conn->error;
        }
    }
}

// Handle form submission to update the image file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_image'])) {
    $newImage = $_FILES['new_image'];

    // Upload and update image file if provided
    if (!empty($newImage['name'])) {
        $newImageName = uniqid() . '_' . $newImage['name'];
        $targetPath = 'images/' . $newImageName;
        $targetPaths = 'admin/images/' . $newImageName;

        if (move_uploaded_file($newImage['tmp_name'], $targetPath)) {
            // Encode the new image as base64
            $base64image = base64_encode(file_get_contents($targetPath));

            // Update the image path and base64image in the database
            $sql = "UPDATE images SET image_path = ?, base64image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $targetPaths, $base64image, $imageId);

            if ($stmt->execute()) {
                // Image path and base64image updated successfully
                header('Location: admin_dashboard.php');
                exit;
            } else {
                $errorMsg = "Error updating image: " . $conn->error;
            }
        } else {
            $errorMsg = "Error uploading the new image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image - Admin Panel</title>
</head>
<body>
    <center><h1>Edit Image</h1>

    <a href="admin_dashboard.php">Back to Admin Dashboard</a><br><br>
    <a href="admin_logout.php">Logout</a><br><br>

    <?php if (!empty($imageData)) : ?>
        <form method="POST" enctype="multipart/form-data">
            <div>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $imageData['title']; ?>">
            </div>
            <div><br>
                <label for="description">Description:</label><br>
                <textarea name="description" id="description" rows="4"><?php echo $imageData['description']; ?></textarea>
            </div>
            <div><br>
                <button type="submit" name="update_details">Save Changes</button>
            </div>
        </form>

        <!-- Display current image -->
        <h2>Current Image</h2>
        <img src="data:image/jpeg;base64,<?php echo $imageData['base64image']; ?>" alt="<?php echo $imageData['description']; ?>">
        <br><br>
        <!-- Form to update the image file -->
        <form method="POST" enctype="multipart/form-data">
            <div>
                <label for="new_image">Upload New Image:</label><br><br>
                <input type="file" name="new_image" id="new_image">
            </div>
            <div><br>
                <button type="submit" name="update_image">Update Image</button>
            </div>
        </form>

    <?php else : ?>
        <p>Image not found.</p>
    <?php endif; ?>

    <?php if (!empty($errorMsg)) : ?>
        <p>Error: <?php echo $errorMsg; ?></p>
    <?php endif; ?></center>
</body>
</html>
