<?php

session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'];

$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'no-reply@familyroots.com';
$to = 'suport.family.roots@gmail.com';
$subject = 'Solicitud de soporte';
$headers = 'From: ' . $userEmail . "\r\n" .
    'Reply-To: ' . $userEmail . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    }else{
        echo json_encode(['success' => false]);
    }
?>