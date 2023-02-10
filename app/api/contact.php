<?php

include __DIR__.'/../../vendor/autoload.php';

$data = [
    'payload' => [
        "subject" => $_POST['subject'],
        "sender_name" => $_POST['sender_name'],
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "contact_email" => $_POST['contact_email'],
        "contact_phone" => $_POST['contact_phone'],
        "comment" => $_POST['comment'],
        "inquiry_type" => "Contact",
        "mailable" => "contact_mail",
    ]
 ];

$response = (new \GuzzleHttp\Client)->post('https://api.foodonline.test/api/mail', [
    'body' => json_encode($data),
    'headers' => [
        "Content-Type" => "application/json",
        "Authorization" => "Bearer 4bc9aba0-ac94-4da2-8ed8-aa943479872e"
    ]
 ]);

if(isset($_POST['submit']))
{
    echo '<pre>';
        var_dump($response->getBody()->getContents());
    echo '</pre>';
}