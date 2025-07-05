
<?php
header("Content-Type: application/json");
header("Cache-Control: no-cache, must-revalidate");

$conn = new mysqli("sql12.freesqldatabase.com", "sql12788274", "kXGydCElEj", "sql12788274");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM weather_data ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);
$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(array_reverse($data)); // oldest first
$conn->close();
?>