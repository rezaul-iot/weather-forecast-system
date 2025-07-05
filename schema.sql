CREATE TABLE weather_data (
  id INT AUTO_INCREMENT PRIMARY KEY,
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  temperature FLOAT,
  humidity FLOAT,
  pressure FLOAT,
  altitude FLOAT,
  rain FLOAT
);




CREATE TABLE weather_forecast (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATE,
  temperature FLOAT,
  humidity FLOAT,
  pressure FLOAT,
  rain_chance FLOAT,
  `condition` VARCHAR(10)
);