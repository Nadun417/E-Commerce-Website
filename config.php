<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'velvet_vogue';


$conn = mysqli_connect($host, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['cart_session_id'])) {
    $_SESSION['cart_session_id'] = session_id();
}
?>