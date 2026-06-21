#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ArduinoJson.h>


// User

const char* ssid = "Redmi C";
const char* password = "87654321";

// server IP
const char* serverHost = "172.16.2.44";
const int serverPort = 80;

// Same API key as config.php
const char* apiKey = "CHANGE_THIS_SECRET_KEY_123";

String receiveUrl = "/security_system_project/api/receive_motion.php";
String settingsUrl = "/security_system_project/api/get_settings.php?api_key=" + String(apiKey);


// Pins

#define PIR_PIN D5
#define BUZZER_PIN D6

WiFiClient wifiClient;

bool systemEnabled = true;
bool lastPirState = LOW;

unsigned long lastSettingsCheck = 0;
unsigned long lastMotionSent = 0;

const unsigned long settingsInterval = 5000;
const unsigned long motionCooldown = 5000;


// WIFI 

void connectWiFi() {
  Serial.print("Connecting to WiFi");

  WiFi.mode(WIFI_STA);   
  WiFi.begin(ssid, password); 

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println();
  Serial.println("WiFi Connected");
  Serial.print("DHCP Assigned IP Address: ");
  Serial.println(WiFi.localIP());
}


// Getting system status

void fetchSystemSettings() {
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  HTTPClient http;
  String fullUrl = String("http://") + serverHost + ":" + String(serverPort) + settingsUrl;

  http.begin(wifiClient, fullUrl);
  int httpCode = http.GET();

  if (httpCode > 0) {
    String payload = http.getString();
    Serial.println("Settings response: " + payload);

    DynamicJsonDocument doc(512);
    DeserializationError error = deserializeJson(doc, payload);

    if (!error && doc["success"] == true) {
      systemEnabled = doc["system_enabled"];

      if (systemEnabled) {
        Serial.println("System ENABLED");
      } else {
        Serial.println("System DISABLED");
      }
    }
  } else {
    Serial.print("Settings HTTP error: ");
    Serial.println(httpCode);
  }

  http.end();
}


// Send Motion data

void sendMotionToServer() {
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  HTTPClient http;
  String fullUrl = String("http://") + serverHost + ":" + String(serverPort) + receiveUrl;

  http.begin(wifiClient, fullUrl);
  http.addHeader("Content-Type", "application/json");

  DynamicJsonDocument doc(256);
  doc["api_key"] = apiKey;
  doc["device"] = "NodeMCU8266";
  doc["status"] = "MOTION DETECTED";

  String requestBody;
  serializeJson(doc, requestBody);

  int httpCode = http.POST(requestBody);
  String response = http.getString();

  Serial.println("Motion sent");
  Serial.print("HTTP Code: ");
  Serial.println(httpCode);
  Serial.print("Response: ");
  Serial.println(response);

  http.end();
}


// Setup

void setup() {
  Serial.begin(115200);

  pinMode(PIR_PIN, INPUT);
  pinMode(BUZZER_PIN, OUTPUT);

  digitalWrite(BUZZER_PIN, LOW);

  connectWiFi();
  fetchSystemSettings();
}


// Loop

void loop() {
  if (millis() - lastSettingsCheck >= settingsInterval) {
    lastSettingsCheck = millis();
    fetchSystemSettings();
  }

  bool pirState = digitalRead(PIR_PIN);

  if (!systemEnabled) {
    digitalWrite(BUZZER_PIN, LOW);
    lastPirState = pirState;
    delay(100);
    return;
  }

  if (pirState == HIGH && lastPirState == LOW) {
    Serial.println("Motion detected!");

    digitalWrite(BUZZER_PIN, HIGH);

    if (millis() - lastMotionSent >= motionCooldown) {
      sendMotionToServer();
      lastMotionSent = millis();
    }

    delay(1500);
    digitalWrite(BUZZER_PIN, LOW);
  }

  lastPirState = pirState;
  delay(100);
}