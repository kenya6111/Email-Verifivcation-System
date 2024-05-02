<?php
$to      = 'kenyanke6111@gmail.com';
$subject = 'Hello World';
$message = <<<MAIL
Hello There World,

This is a message to test sending messages.

Best regards,
Jupiteraaaaa
MAIL;

$headers = 'From: TestApp <kenyanke6111@gmail.com>' . "\r\n" .
    'Reply-To: kenyanke6111@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);