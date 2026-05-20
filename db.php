<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chillspot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Automatically create settings table if it doesn't exist, and seed 'institute_name' if empty
$conn->query("CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT NOT NULL
)");
$check = $conn->query("SELECT setting_value FROM settings WHERE setting_key = 'institute_name'");
if ($check && $check->num_rows == 0) {
    $conn->query("INSERT INTO settings (setting_key, setting_value) VALUES ('institute_name', 'CUCEK')");
}

session_start();
?>
