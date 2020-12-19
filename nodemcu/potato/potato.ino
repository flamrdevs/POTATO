#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>

//POTATO MICRO CONTROLLER

// Key
const char*   apiKey    = "mc.potato.app";
const char*   code      = "mcodeA2";

// Controller
const int     BaudRate        = 9600;

// Capacitive Soil Moisture Sensor 1
const int     sensor_pin      = A0;
const int     getEvery        = 3000;
const int     postEvery       = 15000;

// WiFi var
const char*   ssid            = "Xiaomi";
const char*   pass            = "12341234";

// Server
const String  server          = "http://192.168.43.179/POTATO/public/api";

// Flexible Variable
int           minute          = 0;
String        farming_id      = "0";
float         plant_minHu     = 0;
boolean       hasStoreWatering= false;
String        watering_id     = "";

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

String httpPUT(String server, String data) {
  HTTPClient http;
  http.begin(server);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.PUT(data);
  String payload = httpCode>0 ? http.getString() : "undefined";
  http.end();
  return payload;
}

// Api
void postSetupAPI() {
  Serial.println("\n-------------------------------------------------------------");
  String apiURL = server+"/setup";
  Serial.println("");
  Serial.print("POST ");
  Serial.println(apiURL);
  String postData = (String)"apiKey="+apiKey + "&code="+code;
  String response = httpPOST(apiURL, postData);

  DynamicJsonDocument root(128);
  deserializeJson(root, response);

  String raw_status = root["status"];
  int raw_farming_id = root["data"]["farming_id"];
  float raw_plant_minHu = root["data"]["plant_minHumidity"];
  String raw_message = root["message"];

  Serial.println("--APIsetup--");
  Serial.println("  response : ");
  Serial.print("    status = ");
  Serial.println(raw_status);
  Serial.println("    data : ");
  Serial.print("      farming_id = ");
  Serial.println(raw_farming_id);
  Serial.print("      plant_minHumidity = ");
  Serial.println(raw_plant_minHu);
  Serial.print("    message = ");
  Serial.println(raw_message);
  Serial.println("");
  
  farming_id = (String)raw_farming_id;
  plant_minHu = raw_plant_minHu;
  Serial.println("-------------------------------------------------------------\n");
}

void postSoilMoistureAPI(float value) {
  Serial.println("\n-------------------------------------------------------------");
  String apiURL = server+"/soilmoisture";
  Serial.println("");
  Serial.print("POST ");
  Serial.println(apiURL);
  String postData = (String)"apiKey="+apiKey + "&farming_id="+farming_id + "&value="+value;
  String response = httpPOST(apiURL, postData);

  DynamicJsonDocument root(128);
  deserializeJson(root, response);

  String raw_status = root["status"];
  String raw_message = root["message"];

  Serial.println("--APIpostSoilMoisture--");
  Serial.println("  response : ");
  Serial.print("    status = ");
  Serial.println(raw_status);
  Serial.print("    message = ");
  Serial.println(raw_message);
  Serial.println("");
  Serial.println("-------------------------------------------------------------\n");
}

void postWateringAPI() {
  Serial.println("\n-------------------------------------------------------------");
  String apiURL = server+"/watering";
  Serial.println("");
  Serial.print("POST ");
  Serial.println(apiURL);
  String postData = (String)"apiKey="+apiKey + "&farming_id="+farming_id;
  String response = httpPOST(apiURL, postData);

  DynamicJsonDocument root(128);
  deserializeJson(root, response);

  String raw_status = root["status"];
  int raw_watering_id = root["data"]["watering_id"];
  String raw_message = root["message"];
  
  Serial.println("--APIpostWatering--");
  Serial.println("  response : ");
  Serial.print("    status = ");
  Serial.println(raw_status);
  Serial.println("    data : ");
  Serial.print("      watering_id = ");
  Serial.println(raw_watering_id);
  Serial.print("    message = ");
  Serial.println(raw_message);
  Serial.println("");
  
  watering_id = (String)raw_watering_id;
  hasStoreWatering = true;
  Serial.println("-------------------------------------------------------------\n");
}

void putWateringAPI() {
  Serial.println("\n-------------------------------------------------------------");
  String apiURL = server+"/watering/"+watering_id;
  Serial.println("");
  Serial.print("PUT ");
  Serial.println(apiURL);
  String postData = (String)"apiKey="+apiKey;
  String response = httpPUT(apiURL, postData);
  
  DynamicJsonDocument root(128);
  deserializeJson(root, response);

  String raw_status = root["status"];
  String raw_message = root["message"];

  Serial.println("--APIpostWatering--");
  Serial.println("  response : ");
  Serial.print("    status = ");
  Serial.println(raw_status);
  Serial.print("    message = ");
  Serial.println(raw_message);
  Serial.println("");

  watering_id = "";
  hasStoreWatering = false;
  Serial.println("-------------------------------------------------------------\n");
}

// CORE (PRODUCTION)
void core() {
  delay(getEvery);
  minute = minute + getEvery;

  float value = getSoilMoisture();
  Serial.println("| value = " + (String)value);

  if (value < plant_minHu) {
    if (!hasStoreWatering) {
      postWateringAPI();
    }
  }

  if (value > plant_minHu) {
    if (hasStoreWatering) {
      putWateringAPI();
    }
  }
  
  if (minute >= postEvery) {
    minute = 0;
    postSoilMoistureAPI(value);
  }
}

// SETUP
void setup() {
  Serial.begin(BaudRate);
  WiFiConnect();
  postSetupAPI();
}

// LOOP
void loop() {
  core();
}
