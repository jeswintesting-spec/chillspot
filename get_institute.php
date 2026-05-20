<?php
// get_institute.php
require_once 'db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$institute_name = "CUCEK";
$res = $conn->query("SELECT setting_value FROM settings WHERE setting_key = 'institute_name'");
if ($res && $row = $res->fetch_assoc()) {
    $institute_name = $row['setting_value'];
}

echo json_encode(["institute_name" => $institute_name]);
?>
