<?php
// Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to send an email with an attachment
function sendEmailWithAttachment($to, $subject, $message, $attachmentPath, $attachmentName) {
    $mail = new PHPMailer(true);

    $subject = ' International Conference on Artificial Intelligence of Things (AIoT) | ' . $subject;



    //Server settings
    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'vmercel@gmail.com';                     //SMTP username
    $mail->Password   = 'vmwrxgvxrshodsiy';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;   

    // Sender and recipient email addresses
    $mail->setFrom('vmercel@gmail.com', 'Mercel');
    $mail->addAddress($to);

    // Email subject and body
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Attach the file
    $mail->addAttachment($attachmentPath, $attachmentName);

    // Send the email
    if ($mail->send()) {
        return true; // Email sent successfully
    } else {
        return false; // Email sending failed
    }
}

// Check if the POST request contains required data
if (isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['body']) && isset($_FILES['attachment'])) {
    $to = $_POST['to'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $attachmentPath = $_FILES['attachment']['tmp_name']; // Temporary path of the attachment file
    $attachmentName = $_FILES['attachment']['name']; // Original name of the attachment file
    if (sendEmailWithAttachment($to, $subject, $body, $attachmentPath, $attachmentName)) {
        http_response_code(200); // Success
    } else {
        http_response_code(500); // Internal Server Error
    }
} else {
    http_response_code(400); // Bad Request
}
?>
