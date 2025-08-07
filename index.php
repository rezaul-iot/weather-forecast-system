<!DOCTYPE html>
<html>
<head>
  <title>www.Weather_Project.com</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    @import url(https://fonts.googleapis.com/css?family=Montserrat);
    @import url(https://fonts.googleapis.com/css?family=Advent+Pro:400,200);

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background: #544947;
      font-family: Montserrat, Arial, sans-serif;
      padding: 10px;
    }

    .main-layout {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
    }

    .left-column{
      flex: 1;
      min-width: 500px;
      max-width: 700px;
    } 
    .right-column {
      flex: 1;
      min-width: 400px;
      max-width: 800px;
      height: 180px;
      border-radius: 10px 10px 0 0;
    }

   .widget {
      box-shadow: 0 30px 10px 5px rgba(0,0,0,0.4);
      margin: 100px auto;
      height: 300px;
      position: relative;
      width: 600px;
    }


     .upper {
      border-radius: 5px 5px 0 0;
      background: #f5f5f5;
      height: 250px;
      padding: 20px;
    }
    .date { font-size: 40px; }
    .year { font-size: 30px; color: #c1c1c1; }
    .place { color: #222; font-size: 40px; }

   

   .lower {
      background: #00A8A9;
      border-radius: 0 0 5px 5px;
      font-family: 'Advent Pro';
      font-weight: 200;
      height: 120px;
      width: 100%;
    }

    .clock {
      background: #00A8A9;
      border-radius: 100%;
      box-shadow: 0 0 0 15px #f5f5f5, 0 10px 10px 5px rgba(0,0,0,0.3);
      height: 150px;
      position: absolute;
      right: 25px;
      top: -35px;
      width: 150px;
    }

     .hour, .min {
      background: #f5f5f5;
      left: 50%;
      position: absolute;
      width: 4px;
      border-radius: 5px;
      transform-origin: bottom center;
      transition: all .5s linear;
    }

    .hour { height: 50px; top: 25px; }
    .min { height: 65px; top: 10px; }
.infos { list-style: none; }
    .info {
      color: #fff;
      float: left;
      height: 100%;
      padding-top: 10px;
      text-align: center;
      width: 33.33%;
    }

    .info span {
      display: inline-block;
      font-size: 30px;
      margin-top: 20px;
    }

    a {
      text-align: center;
      text-decoration: none;
      color: white;
      font-size: 15px;
      font-weight: 500;
    }

    table {
      width: 95%;
      margin: 50px auto;
      border-collapse: collapse;
      background: #fff;
      font-family: Arial, sans-serif;
    }

    table th, table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    table th {
      background-color: #00A8A9;
      color: #fff;
    }

    .charts {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      margin-top: 50px;
    }
    .chart-container {
      width: 45%;
      background: white;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 20px;
    }
 .forecast-container {
      display: flex;
      gap: 6px;
      justify-content: center;
      flex-wrap: wrap;
    }
    .forecast-box {
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      width: 215px;
      color: #333;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      text-align: left;
    }
    .forecast-icon {
      font-size: 48px;
      margin-bottom: 10px;
    }
    .forecast-date {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .forecast-info {
      font-size: 16px;
      margin: 5px 0;
    }

  </style>
</head>
<body>

<div class="main-layout">
  <div class="left-column">
    <div class="widget">
      <div class="clock">
        <div class="min" id="min"></div>
        <div class="hour" id="hour"></div>
      </div>
      <div class="upper">
        <div class="date" id="date">Loading...</div>
        <div class="year">Temperature</div>
        <div class="place" id="temperature">-- °C</div>
        <div class="year">Humidity</div>
        <div class="place" id="humidity">--%</div>
      </div>
<div style="text-align: center;">
    <a href="https://www.Weather_Project.com">IOT Based Live Weather Monitoring System</a>
  </div>
      <div class="lower">
        <ul class="infos">
          <li class="info">
            <h2>Pressure</h2>
            <span id="pressure">-- hPa</span>
          </li>
          <li class="info">
            <h2>Altitude</h2>
            <span id="a">-- m</span>
          </li>
          <li class="info">
            <h2>Rain</h2>
            <span id="rain">--%</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
     <div style="margin-top: 80px;">
    <h2 class="section-title" style="color: #28A745;">Next 3 Days Weather Forecast</h2>
    <div class="forecast-container" id="forecast"></div>
</div>
</div>
<div style="margin-top: 80px;">
<h2 style="text-align: center; color: #007BFF;">Live Weather Graphs for Temperature & Humidity (Latest 10 Records)</h2>
<div class="charts">
  <div class="chart-container">
    <canvas id="tempChart"></canvas>
  </div>
  <div class="chart-container">
    <canvas id="humChart"></canvas>
  </div>
</div>
</div>
<div style="margin-top: 80px;"></div>
<h2 class="section-title" style="text-align: center; color: #007BFF;">Table: 30 records of Weather Data</h2>
<table>
  <tr>
    <th>Date</th>
    <th>Temperature (°C)</th>
    <th>Humidity (%)</th>
    <th>Pressure (hPa)</th>
    <th>Altitude (m)</th>
    <th>Rain (%)</th>
  </tr>
  <?php
  $conn = new mysqli("sql12.freesqldatabase.com", "sql12793927", "yXt6FdChwy", "sql12793927");
  $result = $conn->query("SELECT * FROM weather_data ORDER BY id DESC LIMIT 30");
  while($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $row['timestamp'] ?></td>
    <td><?= $row['temperature'] ?></td>
    <td><?= $row['humidity'] ?></td>
    <td><?= $row['pressure'] ?></td>
    <td><?= $row['altitude'] ?></td>
    <td><?= $row['rain'] ?></td>
  </tr>
  <?php endwhile; $conn->close(); ?>
</table>

<script>
setInterval(() => {
  const now = new Date();
  document.getElementById("date").innerHTML = now.toLocaleDateString("en-US", {
    year: 'numeric', month: 'long', day: 'numeric'
  });
  let hour = now.getHours();
  let minute = now.getMinutes();
  let hourAngle = (360 * (hour / 12)) + ((360 / 12) * (minute / 60));
  let minAngle = 360 * (minute / 60);
  document.getElementById("hour").style.transform = `rotate(${hourAngle}deg)`;
  document.getElementById("min").style.transform = `rotate(${minAngle}deg)`;
}, 2000);

function loadWeatherData() {
  fetch('get_data.php')
    .then(res => res.json())
    .then(data => {
      document.getElementById("temperature").innerHTML = data.temperature + " °C";
      document.getElementById("humidity").innerHTML = data.humidity + "%";
      document.getElementById("pressure").innerHTML = data.pressure + " hPa";
      document.getElementById("a").innerHTML = data.altitude + " m";
      document.getElementById("rain").innerHTML = data.rain + "%";
    });
}
loadWeatherData();
setInterval(loadWeatherData, 5000);

fetch('get_chart_data.php')
  .then(res => res.json())
  .then(data => {
    const labels = data.map((_, i) => 'D' + (10 - i));
    const temps = data.map(d => d.temperature);
    const hums = data.map(d => d.humidity);

    new Chart(document.getElementById('tempChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Temperature (°C)',
          data: temps,
          borderColor: 'tomato',
          backgroundColor: 'rgba(255,99,71,0.1)',
          tension: 0.4,
          fill: true,
          pointRadius: 4
        }]
      },
      options: { responsive: true }
    });

    new Chart(document.getElementById('humChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Humidity (%)',
          data: hums,
          borderColor: 'royalblue',
          backgroundColor: 'rgba(65,105,225,0.1)',
          tension: 0.4,
          fill: true,
          pointRadius: 4
        }]
      },
      options: { responsive: true }
    });
  });

const iconMap = {
  "Sunny": "☀️",
  "Cloudy": "☁️",
  "Rainy": "🌧️"
};

fetch('get_forecast.php')
  .then(res => res.json())
  .then(data => {
    const container = document.getElementById("forecast");
    if (data.length === 0) {
      container.innerHTML = "<p>No forecast data available.</p>";
      return;
    }

    data.forEach(day => {
      const icon = iconMap[day.condition] || "❓";
      const html = `
        <div class="forecast-box">
          <div class="forecast-icon">${icon}</div>
          <div class="forecast-date">${new Date(day.date).toDateString()}</div>
          <div class="forecast-info"><strong>Condition:</strong> ${day.condition}</div>
          <div class="forecast-info"><strong>🌡 Temp:</strong> ${parseFloat(day.temperature).toFixed(1)} °C</div>
          <div class="forecast-info"><strong>💧 Humidity:</strong> ${parseFloat(day.humidity).toFixed(1)} %</div>
          <div class="forecast-info"><strong>🔵 Pressure:</strong> ${parseFloat(day.pressure).toFixed(1)} hPa</div>
          <div class="forecast-info"><strong>🌧 Rain Chance:</strong> ${parseFloat(day.rain_chance).toFixed(1)} %</div>
        </div>
      `;
      container.innerHTML += html;
    });
  })
  .catch(err => {
    document.getElementById("forecast").innerHTML = "<p>Error loading forecast.</p>";
    console.error(err);
  });
</script>

</body>
</html>
