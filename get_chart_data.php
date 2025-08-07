<?php

$conn = new mysqli("sql12.freesqldatabase.com", "sql12793927", "yXt6FdChwy", "sql12793927");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT temperature, humidity FROM weather_data ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);
$data = [];

while($row = $result->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode(array_reverse($data)); // reverse to make oldest first
$conn->close();
?>
