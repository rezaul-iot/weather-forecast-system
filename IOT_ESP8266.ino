#define BLYNK_PRINT Serial
#define BLYNK_TEMPLATE_ID "TMPL6SVlBAUNx"
#define BLYNK_TEMPLATE_NAME "Weather Monitoring System"
#define BLYNK_AUTH_TOKEN "M4wDTOxN9odeN_yEiZ_s-qkttGvl5WmD"

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <DHT.h>
#include <Wire.h>
#include <Adafruit_BMP085.h>
#include <LiquidCrystal_I2C.h>
#include <math.h>
#include <WiFiClient.h>
#include <BlynkSimpleEsp8266.h>

#define DHTPIN D5
#define DHTTYPE DHT11
#define RAINPIN A0
#define ALTITUDE 1655.0

LiquidCrystal_I2C lcd(0x27, 16, 2);
const char* ssid = "NAZMUL HASAN";
const char* password = "01945994590";
const char* auth = "M4wDTOxN9odeN_yEiZ_s-qkttGvl5WmD";
//const String serverName = "http://rezaul.infinityfreeapp.com/insert_data.php";
const String serverName = "https://weather-forecast-system.onrender.com/insert_data.php";

DHT dht(DHTPIN, DHTTYPE);
Adafruit_BMP085 bmp;

void setup() {
  Serial.begin(115200);
  Blynk.begin(auth, ssid, password);
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print("Weather Monitor");

  WiFi.begin(ssid, password);
  dht.begin();
  bmp.begin();

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting...");
  }

  Serial.println("Connected!");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  lcd.setCursor(0, 1);
  lcd.print("WiFi Connected");
}

void loop() {
  Blynk.run();
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();
  float pressure = bmp.readPressure() / 100.0;
  float altitude = bmp.readAltitude();
  int rainAnalog = analogRead(RAINPIN);
  float rain = map(rainAnalog, 0, 1023, 100, 0);
  //int LDR_value = analogRead(A0);

  // Serial output
  Serial.println("----- Weather Info -----");
  Serial.printf("Temp: %.2f °C\n", temperature);
  Serial.printf("Humidity: %.2f %%\n", humidity);
  Serial.printf("Pressure: %.2f hPa\n", pressure);
  Serial.printf("Altitude: %.2f m\n", altitude);
  Serial.printf("Rain: %.2f %%\n", rain);
  //Serial.printf("Light: %d\n", LDR_value);

  // Blynk update
  Blynk.virtualWrite(V0, temperature);
  Blynk.virtualWrite(V1, humidity);
  Blynk.virtualWrite(V2, pressure);
  Blynk.virtualWrite(V3, altitude);
  Blynk.virtualWrite(V4, rain);
 // Blynk.virtualWrite(V5, LDR_value);

  // LCD output
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("T:");
  lcd.print(temperature, 1);
  lcd.print(" H:");
  lcd.print(humidity, 0);
  lcd.setCursor(0, 1);
  lcd.print("P:");
  lcd.print(pressure, 1);
  lcd.print(" R:");
  lcd.print(rain, 0);

  // HTTP POST to InfinityFree server
  if (WiFi.status() == WL_CONNECTED) {
    
  HTTPClient http;
  //WiFiClient client;
  WiFiClientSecure client;
  client.setInsecure(); // ⚠️ Use only for testing — skips SSL cert verification
  http.begin(client, serverName);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  // ✅ ADD THIS LINE to fool InfinityFree into treating it like a real browser
//http.setUserAgent("Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36");

 // http.setUserAgent("Mozilla/5.0");  // <- add this line


  String data = "temperature=" + String(temperature)
              + "&humidity=" + String(humidity)
              + "&pressure=" + String(pressure)
              + "&altitude=" + String(altitude)
              + "&rain=" + String(rain);

  
  http.setUserAgent("Mozilla/5.0");
     
  Serial.println("----- Posting data to PHP server -----");
  Serial.println(data); // DEBUG POST STRING

  int httpCode = http.POST(data);
  Serial.printf("[HTTP POST] Response code: %d\n", httpCode);
  String payload = http.getString();
  Serial.println("Server says: " + payload);

  http.end();
}
  delay(60000);  // Wait 60 seconds
}
