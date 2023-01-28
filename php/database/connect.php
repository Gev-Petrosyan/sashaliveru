<?php

$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$db = 'sashaliveru'; // Database name

$conn = new mysqli($host, $username, $password, $db); // Connect to database

if ($conn->connect_errno) {
    die("Connection error: {$conn->connect_error}"); // Show errors connect
}
