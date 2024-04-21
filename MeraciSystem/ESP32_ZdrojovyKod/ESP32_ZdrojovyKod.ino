#include <WiFi.h>
#include <HTTPClient.h>

#include <Adafruit_ADS1X15.h>

#include <ACS712.h> //špecifický
#include <BH1750.h>

#include <LiquidCrystal_I2C.h>

//---Wi-Fi
//home
const char* ssid = "***";
const char* password = "***";
const char* URL = "***-/upload.php";

/*//mobilnet
const char* ssid = "***";
const char* password = "***";
const char* URL = "***-/upload.php";
*/

Adafruit_ADS1115 adc;

#define VOLTAGE 4.096 // 6.144  // 4.096
#define BITS 32768

//  ACS712 5A  uses 185 mV per A
//  ACS712 20A uses 100 mV per A
//  ACS712 30A uses  66 mV per A
ACS712  ACS1(1, VOLTAGE, BITS, 185);
//ACS712  ACS2(3, VOLTAGE, BITS, 66);

BH1750 lightMeter;
LiquidCrystal_I2C lcd(0x27,20,4);

void setup() {
  Serial.begin(115200);

  connectWiFi();
  adcSetup();
  acs1Setup();
//  acs2Setup();
  lightMeter.begin();
  lcd.begin();
  lcd.backlight();
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  //Napätie - adc A? 0 or 2
  float voltage = readVoltage(0);

  //Prúd CH1
  float current_ch1 = ACS1.mA_DC();
  current_ch1 = current_ch1/1000,2;

  //Prúd CH2
  //float current_ch2 = ACS2.mA_DC();

  //Výkon
  float power = voltage*current_ch1;

  //Svetelnosť
  int light = lightMeter.readLightLevel();

  //Efektivita
  int effectivity = calcEffectivity(light, power);

  //Zariadenie (MAC)
  String device = WiFi.macAddress();
  
  displayData(voltage, current_ch1, power, light);
  sendData(voltage, current_ch1, power, light, effectivity, device);
  delay(200);
}

void connectWiFi() {
  WiFi.mode(WIFI_OFF);
  delay(1000);

  WiFi.mode(WIFI_STA);

  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.print("Connected to: ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void adcSetup(){
  adc.setGain(adsGain_t::GAIN_ONE); // 4.096 - GAIN_ONE // 6.144 - GAIN_TWOTHIRDS
  adc.setDataRate(RATE_ADS1115_475SPS); // RATE_ADS1115_128SPS // RATE_ADS1115_250SPS //RATE_ADS1115_475SPS
  if (!adc.begin())
    while (true);
}

float readVoltage(uint8_t channel){
    int16_t value = adc.readADC_SingleEnded(channel);
    const int32_t R1 = 180330;
    const int32_t R2 = 2000;
    return adc.computeVolts(value) * ((R1 + R2)/(double)(R2));
}

void acs1Setup(){
  ACS1.setADC(ACS_read, VOLTAGE, BITS);
  ACS1.setMidPoint(12670);
  ACS1.autoMidPointDC(200);
}

/*
void acs2Setup(){
  ACS2.setADC(ACS_read, VOLTAGE, BITS);
  ACS2.setMidPoint(12670);
  ACS2.autoMidPointDC(200);
}
*/

uint16_t ACS_read(uint8_t channel){
  const int32_t R1 = 10000;
  const int32_t R2 = 20000;
  uint16_t value = (double)(adc.readADC_SingleEnded(channel)) * ((R1 + R2)/(double)(R2));
  return value;
}

int calcEffectivity(int light, float power){
  float factor = 0.0001; 
  float effectivity = 100 - (power / light * 100);
  return effectivity = effectivity < 0 ? 0 : (effectivity > 100 ? 100 : effectivity);
}

void sendData(float voltage, float current_ch1, float power, int light, int effectivity, String device){
  String postData = "voltage=" + String(voltage) + "&current=" + String(current_ch1) + "&light=" + String(light) + "&power=" + String(power) + "&effectivity=" + String(effectivity) + "&device=" + device;
  HTTPClient http;
  http.begin(URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData);
  String payload = http.getString();
  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println(payload);
    } else {
      Serial.printf("[HTTP] GET... code: %d\n", httpCode);
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }
  http.end();
  Serial.print("URL: ");
  Serial.println(URL);
  Serial.print("Data: ");
  Serial.println(postData);
  Serial.print("httpCode: ");
  Serial.println(httpCode);
  Serial.print("payload : ");
  Serial.println(payload);
  Serial.println("--------------------------------------------------");
}

void displayData(float voltage, float current_ch1, float power, int light){
  lcd.clear();

  lcd.print("Napatie: ");
  lcd.print(voltage);
  lcd.print(" V");

  lcd.setCursor(0,1);
  lcd.print("Prud: ");
  lcd.print(current_ch1);
  lcd.print(" A");
  
  lcd.setCursor(0,2);
  lcd.print("Vykon: ");
  lcd.print(power);
  lcd.print(" W");

  lcd.setCursor(0,3);
  lcd.print("Svetelnost: ");
  lcd.print(light);
  lcd.print(" lux");
}