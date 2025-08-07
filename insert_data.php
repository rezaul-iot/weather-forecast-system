<?php
$host = "sql12.freesqldatabase.com";   // example host, replace with yours
$user = "sql12793927";                  // your db username
$pass = "yXt6FdChwy";               // your db password
$dbname = "sql12793927";                // your db name

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("❌ DB Connect failed: " . $conn->connect_error);
}

$temperature = isset($_POST['temperature']) ? floatval($_POST['temperature']) : null;
$humidity = isset($_POST['humidity']) ? floatval($_POST['humidity']) : null;
$pressure = isset($_POST['pressure']) ? floatval($_POST['pressure']) : null;
$altitude = isset($_POST['altitude']) ? floatval($_POST['altitude']) : null;
$rain = isset($_POST['rain']) ? floatval($_POST['rain']) : null;

if ($temperature !== null && $humidity !== null && $pressure !== null && $altitude !== null && $rain !== null) {
    $sql = "INSERT INTO weather_data (temperature, humidity, pressure, altitude, rain)
            VALUES ('$temperature', '$humidity', '$pressure', '$altitude', '$rain')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Data inserted";
    } else {
        echo "❌ Insert error: " . $conn->error; 
    }
} else {
    echo "❌ Missing or invalid parameters";
}
$conn->close();
?>
