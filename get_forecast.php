<?php
header('Content-Type: application/json');

$host = " sql12.freesqldatabase.com";   // example host, replace with yours
$user = "sql12788274";                  // your db username
$pass = "kXGydCElEj";               // your db password
$dbname = "sql12788274";                // your db name


$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$sql = "SELECT * FROM weather_forecast ORDER BY date ASC LIMIT 3";
$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>
