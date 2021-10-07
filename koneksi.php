<?php
$hostname = "localhost";
$database = "buah";
$username = "root";
$password = "";


// Firebase API Key

define('FIREBASE_API_KEY', 'AAAACHe-Jvc:APA91bFNoQIepsVu1Dy7MGEZW3jT9XYmgHlp4Ya5iiPgb8oMnI-zbEa1XM08KbzVHfqEYJ5gPdeEl7La--JQr9wS4MjYfvzX5HxeBQyECGdbxB5Phxai9UjXri_Z9Fi-fDzgKw7UvKfS');

$connect = mysqli_connect($hostname, $username, $password, $database);   
if (!$connect) {
    die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
}