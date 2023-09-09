<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Set the recipient email address
    $to = "jarircse16@gmail.com"; // Replace with the actual recipient's email address

    // Set the email subject
    $subject = "Message from $name";

    // Compose the email message
    $messageBody = "Name: $name\n";
    $messageBody .= "Email: $email\n\n";
    $messageBody .= "Message:\n$message";

    // Additional headers
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Send the email
    if (mail($to, $subject, $messageBody, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Email sending failed. Please try again later.";
    }
} else {
    // Handle invalid requests (GET requests or direct access to the script)
    echo "Invalid request.";
}
?>
