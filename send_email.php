<?php
// Include PHPMailer files manually
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\PHPMailer.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\Exception.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Email information
    $to = "benjaminmusyoki064@gmail.com"; // Replace with your email address
    $subject = "New Message from KilimoKe Contact Form";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'evandroonyango28@gmail.com';
        $mail->Password = 'rcodbeeykgopykuq'; // Use app-specific password if 2FA is enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('evandroonyango28@gmail.com', 'KilimoKe Contact Form');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        // Send success response to JavaScript
        echo json_encode(array('status' => 'success'));
    } catch (Exception $e) {
        // Send error response to JavaScript
        echo json_encode(array('status' => 'error', 'message' => $mail->ErrorInfo));
    }
} else {
    echo 'Invalid request method';
}
?>
