<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

include('config.php'); // Include your database connection code here

// Initialize variables for displaying content and images
$contentResult = $imageResult = [];

// Fetch content from the 'content' table
$contentQuery = "SELECT * FROM content";
$contentResult = mysqli_query($conn, $contentQuery);

// Fetch images from the 'images' table
$imageQuery = "SELECT * FROM images";
$imageResult = mysqli_query($conn, $imageQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Include necessary CSS and JS here -->
</head>
<body>
    <center><h1>Admin Dashboard</h1>

    <a href="admin_logout.php">Logout</a>

    <h2>Content Management</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($contentResult)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                    <td><a href="edit_content.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Image Management</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($imageResult)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><img src="<?php echo $row['image_path']; ?>" alt="Image"></td>
                    <td><a href="edit_image.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                    <td><a href="delete_image.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table></center>
</body>
</html>
