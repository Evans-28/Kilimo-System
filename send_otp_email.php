<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\Exception.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\PHPMailer.php';
require 'C:\wamp64\www\KilimoKe 3rd Trial\PHPMailer\src\SMTP.php';

function sendOtpEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'evandroonyango28@gmail.com'; // SMTP username
        $mail->Password   = 'rcodbeeykgopykuq'; // SMTP password (use an App Password if 2FA is enabled)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                   

        //Recipients
        $mail->setFrom('no-reply@kilimoke.com', 'KilimoKe');
        $mail->addAddress($email);     

        // Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: $otp";

        $mail->send();
        echo 'OTP email has been sent.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
