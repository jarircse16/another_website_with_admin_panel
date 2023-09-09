<?php
      // Include your PHP database connection code here
      $servername = "sql207.byethost17.com";
      $username = "b17_34928775";
      $password = "xD123@xD";
      $dbname = "b17_34928775_big_picture_db";

      $conn = mysqli_connect($servername, $username, $password, $dbname);

      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

?>
