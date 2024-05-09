<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     // Form has been submitted, handle the data
    //     $name = $_POST['name'];
    //     $email = $_POST['email'];
    //     $subject = $_POST['subject'];
    //     $message = $_POST['message'];

    //     // Set the email headers
    //     $to = "yemoe82003@gmail.com";
    //     $subject = "New message from your website";
    //     $headers = "From: $name <$email>\r\n";
    //     $headers .= "Reply-To: $email\r\n";
    //     $headers .= "X-Mailer: PHP/" . phpversion();

    //     // Construct the email body
    //     $body = "Name: $name\n";
    //     $body .= "Email: $email\n\n";
    //     $body .= "Message:\n$message";

    //     // Send the email
    //     if (mail($to, $subject, $body, $headers)) {
    //         echo "Email sent successfully.";
    //     } 
    //     else {
    //         echo "Failed to send email.";
    //     }
    // }

    if ($isset($_POST['submit'])) {
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $mailFrom = $_POST['mail'];
        $message = $_POST['message'];

        $mailTo = "yemoe82003@gmail.com";
        $headers = "From: " . $mailFrom;
        $text = "You have received an email from " . $name . ".\n\n" . $message;

        mail ($mailTo, $subject, $text, $headers);
        header ("Location: contact.php?mailsend");
    }

?>