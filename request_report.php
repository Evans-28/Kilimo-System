<?php

require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\PHPMailer.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\Exception.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the email parameter is provided
if ( isset( $_POST[ 'email' ] ) ) {
    $user_email = $_POST[ 'email' ];

    // Validate the email address
    if ( filter_var( $user_email, FILTER_VALIDATE_EMAIL ) ) {

        // Database connection details
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'kilimokedb';

        // Create connection
        $conn = new mysqli( $servername, $username, $password, $dbname );

        // Check connection
        if ( $conn->connect_error ) {
            die( 'Connection failed: ' . $conn->connect_error );
        }

        // Fetch user information from the database
        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $conn->prepare( $sql );
        $stmt->bind_param( 's', $user_email );
        $stmt->execute();
        $result = $stmt->get_result();

        if ( $result->num_rows > 0 ) {
            $user_info = $result->fetch_assoc();

            // Prepare email content
            $mail = new PHPMailer( true );
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'benjaminmusyoki064@gmail.com';
                // Your email
                $mail->Password = 'bzevpvakkxignqkm';
                // Your email password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipients
                $mail->setFrom( 'no-reply@kilimoke.com', 'KilimoKe' );
                $mail->addAddress( $user_email );
                // Send to user's email address

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Account Information';
                $mail->Body    = "Hello,<br><br>Here is the information about your account:<br><br>"
                                . "Name: " . htmlspecialchars($user_info['name']) . "<br>"
                                . "Email: " . htmlspecialchars($user_info['email']) . "<br>"
                                . "Phone: " . htmlspecialchars($user_info['phone']) . "<br>"
                                . "Address: " . htmlspecialchars($user_info['address']) . "<br>"
                                . "Registration Date: " . htmlspecialchars($user_info['registration_date']) . "<br><br>"
                                . "Best regards, We love hearing from you. Ahsante<br>KilimoKe Team";

                $mail->send();
                echo json_encode(['status' => 'success', 'message' => 'User account information has been sent to your email!']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Mailer Error: ' . $mail->ErrorInfo]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No user found with this email address.']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No email address provided.' ] );
            }
            ?>
