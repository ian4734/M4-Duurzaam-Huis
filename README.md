# M4-Duurzaam-Huis

TAKEN:

kyano
1
De actuele buiten temperatuur
2
Buiten- en binnentemperatuur
3
Ik kan op het dashboard zien of een lamp, in het huisje, aan of uit is.
Ik kan via het dashboard een lamp, in het huisje, aan of uit zetten.
Ik kan als het een bepaalde tijd is een lamp, in het huisje, uit of aan laten gaan
(doen we allemaal samen)

ian
1
De weersverwachting
2
Opbrengst energie van zonnepanelen
3
Ik kan op het dashboard zien of een lamp, in het huisje, aan of uit is.
Ik kan via het dashboard een lamp, in het huisje, aan of uit zetten.
Ik kan als het een bepaalde tijd is een lamp, in het huisje, uit of aan laten gaan
(doen we allemaal samen)

deon
1
De zonsopkomst en zonsondergang
2
Energieverbruik
3
Ik kan op het dashboard zien of een lamp, in het huisje, aan of uit is.
Ik kan via het dashboard een lamp, in het huisje, aan of uit zetten.
Ik kan als het een bepaalde tijd is een lamp, in het huisje, uit of aan laten gaan
(doen we allemaal samen) 

CODE ARDUINO:
const int  trigPin = 2;
const int echoPin = 4;
const int buzzerPin = 13;
float duration, distance;


void setup() {
  pinMode(buzzerPin, OUTPUT);
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  Serial.begin(9600);
}

void loop() {
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  duration = pulseIn(echoPin, HIGH);
  distance = (duration*.0343)/2;
  if (distance < 20) {
    digitalWrite(buzzerPin, HIGH);
    delay(100);
    noTone(buzzerPin);
    delay(900);
  } else if (distance < 7) {
    digitalWrite(buzzerPin, HIGH);
    delay(500);
    noTone(buzzerPin);
    delay(500);
  } else {
    noTone(buzzerPin);
  }
  Serial.print("Distance: ");  
    Serial.println(distance);
    delay(100);
}

------------------------------------------------------------------------------------------------------------------------------------------------------------------

#include "DHT.h"
       
// DHT11
#define DHTTYPE DHT11

uint8_t DHTPin = 24;
DHT dht(DHTPin, DHTTYPE);

float Temperature, Humidity, HeatIndex;

void setup() {
    Serial.begin(115200);
    dht.begin();
}

void loop() {
    ReadDHT11();

    // Wait before reading DHT11 again...
    delay(10000);
}

void ReadDHT11() {
    float temperature = round(dht.readTemperature() * 10) / 10;
    float humidity = round(dht.readHumidity() * 10) / 10;
    float heatIndex = round(dht.computeHeatIndex(temperature, humidity, false) * 10) / 10;

    if (isnan(temperature) || isnan(humidity) || isnan(heatIndex)) {
        // sensor error
        Serial.println("DHT11 sensor error");
    }
    else {
        Temperature = temperature;
        Humidity = humidity;
        HeatIndex = heatIndex;

        Serial.println("Temp: " + String(Temperature) + " C");
        Serial.println("Humidity: " + String(Humidity));
        Serial.println("HeatIndex: " + String(HeatIndex) + "\n");
    }
}
