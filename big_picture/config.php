<?php
      // Include your PHP database connection code here
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "big_picture_db";

      $conn = mysqli_connect($servername, $username, $password, $dbname);

      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

?>
