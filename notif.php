<?php
if (function_exists($_GET['function'])) {
    $_GET['function']();
}

function sendPushNotification()
{
    $fcm_token = $_POST["fcm_token"];
    $title = $_POST["title"];
    $message = $_POST["message"];

    $url = "https://fcm.googleapis.com/fcm/send";
    $header = [
        'Authorization: key=AAAACHe-Jvc:APA91bHMGLrrbF1vVBXh11nlhxLJTm1IvSJcZZ5kO-owSfbaUpC_PerZva8xFg7eX0N4m9O88uKJyHKMwbGrVwC6bpCUcT6PtvSYNqlb1KppctUWUvwASsUHonXUh6aDFaQGXoud8PtB',
        'content-type: application/json'
    ];

    $notification = array(
        'title' => $title,
        'body' => $message
    );

    $fcmNotification = array(
        'to' => $fcm_token,
        'notification' => $notification
    );
    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $result = curl_exec($ch);
    curl_close($ch);
    header('Content-Type: application/json');
    echo $result;
}