#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>

//POTATO MICRO CONTROLLER

// Key
const char*   machine_id      = "mcp.0005.11.20";

// Controller
const int     BaudRate        = 9600;

// Capacitive Soil Moisture Sensor 1
const int     sensor_pin      = A0;
const int     getEvery        = 3000;
const int     postEvery       = 30000;

// WiFi var
const char*   ssid            = "Uliplek";
const char*   pass            = "12344321";

// Server
const char*   server          = "http://192.168.43.179/POTATO/public/api/soilmoisture";

// Flexible Variable
int           minute          = 0;

// CONNECT
void WiFiConnect() {
  WiFi.begin(ssid, pass);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println(".");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  Serial.println(".");
}

// SENSOR
float getSoilMoisture() {
  return (100.00 - ((analogRead(sensor_pin)/1023.00) * 100.00));
}

// HTTP
String httpGET(char* server) {
  HTTPClient http;
  http.begin(server);
  int httpCode = http.GET();
  String payload = httpCode>0 ? http.getString() : "undefined";
  http.end();
  return payload;
}

String httpPOST(String server, String data) {
  HTTPClient http;
  http.begin(server);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(data);
  String payload = httpCode>0 ? http.getString() : "undefined";
  http.end();
  return payload;
}

// SETUP
void setup() {
  Serial.begin(BaudRate);
  WiFiConnect();
}

// LOOP
void loop() {
  delay(getEvery);
  minute = minute + getEvery;

  float value = getSoilMoisture();
  Serial.println("value = " + (String)value);
  
  if (minute >= postEvery) {
    minute = 0;

    String postData = (String)"key=mc.potato.app" + "&machine_id="+machine_id + "&value="+value;
    Serial.println(httpPOST(server, postData));
  }
}
