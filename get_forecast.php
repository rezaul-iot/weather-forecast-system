<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// ✅ NO spaces in variable values!
$host = "sql12.freesqldatabase.com";
$user = "sql12790163";
$password = "ihSMzzzfFT";
$database = "sql12790163";

// ✅ FIXED: use correct variable names and no spaces
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT * FROM weather_forecast ORDER BY date ASC LIMIT 3";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
