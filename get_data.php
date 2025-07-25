<?php
// ✅ Must be the first line — no space before
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$host = "sql12.freesqldatabase.com";  // Your actual DB info
$user = "sql12791888";
$pass = "gKCQabmHx8";
$db   = "sql12791888";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

// ✅ Only get latest one record for live display
$sql = "SELECT * FROM weather_data ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode($data);
$conn->close();
?>
