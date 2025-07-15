import pymysql
import pandas as pd
import numpy as np
from datetime import datetime, timedelta
from sklearn.ensemble import RandomForestRegressor
import warnings

warnings.filterwarnings("ignore")

# --- Connect to DB (freesqldatabase.com) ---
db = pymysql.connect(
    host="sql12.freesqldatabase.com",  # replace with your freesqldatabase host
    user="sql12790163",                # your freesqldatabase username
    password="ihSMzzzfFT",    # your freesqldatabase password
    database="sql12790163",            # your freesqldatabase database name (usually same as username)
    port=3306                         # default MySQL port
)
cursor = db.cursor()

# --- Load last 100 sensor records ---
df = pd.read_sql("SELECT * FROM weather_data ORDER BY timestamp DESC LIMIT 100", db)
df = df.sort_values(by='timestamp').reset_index(drop=True)

if len(df) < 10:
    print("⚠️ Not enough data to train models.")
    db.close()
    exit()

# --- Prepare targets for next-step prediction ---
df['target_temp'] = df['temperature'].shift(-1).ffill()
df['target_hum'] = df['humidity'].shift(-1).ffill()
df['target_pres'] = df['pressure'].shift(-1).ffill()

df = df.dropna()

# --- Features and targets ---
features = df[['temperature', 'humidity', 'pressure']]
target_temp = df['target_temp']
target_hum = df['target_hum']
target_pres = df['target_pres']

# --- Train Random Forest regressors ---
model_temp = RandomForestRegressor(random_state=42).fit(features, target_temp)
model_hum = RandomForestRegressor(random_state=42).fit(features, target_hum)
model_pres = RandomForestRegressor(random_state=42).fit(features, target_pres)

# --- Forecast 3 days ahead ---
last_row = df[['temperature', 'humidity', 'pressure']].iloc[-1].values.reshape(1, -1)
forecast = []

for i in range(3):
    pred_temp = model_temp.predict(last_row)[0]
    pred_hum = model_hum.predict(last_row)[0]
    pred_pres = model_pres.predict(last_row)[0]

    # Add noise for natural variation
    pred_temp += np.random.normal(0, 0.03)
    pred_hum += np.random.normal(0, 1.5)
    pred_pres += np.random.normal(0, 1.0)

    # Calculate rain chance
    rain_chance = (pred_hum - 80) * 4 + max(0, (1000 - pred_pres) * 2)
    rain_chance = np.clip(rain_chance, 0, 100)

    # Determine weather condition
    if rain_chance > 70:
        condition = 'Rainy'
    elif rain_chance > 40:
        condition = 'Cloudy'
    else:
        condition = 'Sunny'

    forecast_date = (datetime.now() + timedelta(days=i + 1)).strftime('%Y-%m-%d')
    forecast.append((forecast_date, pred_temp, pred_hum, pred_pres, rain_chance, condition))

    # Prepare for next prediction
    last_row = np.array([[pred_temp, pred_hum, pred_pres]])

# --- Save forecast in weather_forecast table ---
cursor.execute("DELETE FROM weather_forecast")  # Clear old data

insert_sql = """
INSERT INTO weather_forecast 
(date, temperature, humidity, pressure, rain_chance, `condition`)
VALUES (%s, %s, %s, %s, %s, %s)
"""

for date, t, h, p, r, c in forecast:
    cursor.execute(insert_sql, (date, round(t, 2), round(h, 2), round(p, 2), round(r, 1), c))
    print(f"{date} | Temp={round(t,1)}°C | Hum={round(h,1)}% | Pressure={round(p,1)} hPa | 🌦 Rain Chance: {round(r,1)}% | Condition: {c}")

db.commit()
db.close()

print("\n✅ Accurate 3-day weather forecast updated.")
