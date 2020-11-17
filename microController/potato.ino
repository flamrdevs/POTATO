#include <ESP8266HTTPClient.h>
#include <BearSSLHelpers.h>
#include <CertStoreBearSSL.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiAP.h>
#include <ESP8266WiFiGeneric.h>
#include <ESP8266WiFiGratuitous.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266WiFiScan.h>
#include <ESP8266WiFiSTA.h>
#include <ESP8266WiFiType.h>
#include <WiFiClient.h>
#include <WiFiClientSecure.h>
#include <WiFiClientSecureAxTLS.h>
#include <WiFiClientSecureBearSSL.h>
#include <WiFiServer.h>
#include <WiFiServerSecure.h>
#include <WiFiServerSecureAxTLS.h>
#include <WiFiServerSecureBearSSL.h>
#include <WiFiUdp.h>
#include <ESP8266WiFi.h>
#include <ArduinoJson.h>

//POTATO MICRO CONTROLLER

// Controller
const int     BaudRate        = 9600;

// Pin
// Capacitive Soil Moisture Sensor 1
const int     sensor_pin      = A0;
// Display

// WiFi var
const char*   ssid            = "Microctrl";
const char*   pass            = "12341234";

// Time var
const int     _1m             = 60000;
const int     _30s            = 30000;
const int     _10s            = 10000;
const int     _5s             = 5000;
const int     _4s             = 4000;
const int     _3s             = 3000;
const int     _2s             = 2000;
const int     _1s             = 1000;

// Server var
String        API_PATH        = "https://www.potato.test/api/soilmoisture";

// Library
WiFiClient client;

// WiFi Connection
void WiFiConnect() {
  WiFi.begin(ssid, pass);
  while (WiFi.status() != WL_CONNECTED) {
    delay(_1s);
    Serial.print("|");
  }
}

// Get Moisture Level
float getMoisture() {
  return (100.00 - ((analogRead(sensor_pin)/1023.00) * 100.00));
}

// Setup
void setup() {
  Serial.begin(BaudRate);
  WiFiConnect();
}

// Loop
void loop() {
  float moisture = getMoisture();
  Serial.print("Level moisture = ");
  Serial.print(moisture);
  Serial.println("%");
  delay(_5s);
}

// void test() {
//   if (WiFi.status() == WL_CONNECTED) {
//     fetchData();
//   } else {
//     Serial.println("Error in WiFi connection");
//   }
// }

// void fetchData() {
//   HTTPClient http;
//   http.begin(API_PATH);
//   http.addHeader("Content-Type", "text/plain");
//   int httpCode = http.GET();
//   String payload = http.getString();
//   Serial.println(httpCode);
//   Serial.println(payload);
//   http.end();
// }