#!/usr/bin/python
import numpy
import urllib, urllib2
import time
import RPi.GPIO as GPIO
from math import *
inRange = True
i=0
liste = []
def median(lst):
    return numpy.median(numpy.array(lst))
def alerte():
        readalerte = open("/var/bin/alerte", "r")
        alerte = readalerte.readline(4)
        readalerte.close()
        return float(alerte)

def niveau():
        readtemp = open("/var/bin/niveau", "r")
        niveau = readtemp.readline(4)
        readtemp.close()
        return float(niveau)

def round_down(num, divisor):
    return num - (num%divisor)

urlalert = 'http://api.pushingbox.com/pushingbox'
strUrlBase = 'http://admin:2a94r7ow@localhost/gsg/data_granulee.php?value=1'
#while i<50:
while len(liste)<15 and i<50:
	i = i + 1
	GPIO_TRIGGER = 23
	GPIO_ECHO = 24
	profondeur = 72
	GPIO.setmode(GPIO.BCM)
	GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
	GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo
#	GPIO.output(GPIO_TRIGGER, False)
	GPIO.add_event_detect(GPIO_ECHO, GPIO.BOTH)
	time.sleep(0.5)
# Send 10us pulse to trigger
	GPIO.output(GPIO_TRIGGER, True)
	time.sleep(0.00001)
	GPIO.output(GPIO_TRIGGER, False)
#	start = time.time()
#	while GPIO.input(GPIO_ECHO)==0:
	GPIO.wait_for_edge(GPIO_ECHO, GPIO.BOTH)
	start = time.time()
#	while GPIO.input(GPIO_ECHO)==1:
	GPIO.wait_for_edge(GPIO_ECHO, GPIO.BOTH)
	stop = time.time()

# Calculate pulse length
	elapsed = stop-start


# Distance pulse travelled in that time is time
# multiplied by the speed of sound (cm/s)
	distance = elapsed * 34000

# That was the distance there and back so halve the value
	distance = distance / 2

	valeur = (profondeur - distance +5 ) / profondeur * 100

	valeur = floor(valeur)
	valeur = int(valeur)
	valeur = round_down(valeur,2)
	print "Distance par rapport au capteur: %.1f" % distance
	print "Pourcentage de remplissage : %.0f " % valeur
	GPIO.cleanup()
	time.sleep(5)
	if (elapsed < 0.005) and valeur > niveau() -10:
		if 0<valeur<110 :
                	print "resultat valide"
			liste.append(valeur)

valeur=median(liste)
print "Valeur valide : %.0f " % valeur

if niveau() > valeur: # or niveau() <= valeur:
	status = open("/var/bin/niveau", "w+")
	status.write(str(valeur))
	status.close()
elif niveau() +70 < valeur:
	status = open("/var/bin/niveau", "w+")
	status.write(str(valeur))
	status.close()
	urllib.urlopen(strUrlBase)
	time.sleep(1)
        urllib.urlopen(strUrlBase)
        status = open("/var/bin/alerte", "w+")
        status.write(str(0))
        status.close()
elif niveau() +35 < valeur:
       	status = open("/var/bin/niveau", "w+")
        status.write(str(valeur))
        status.close()
        urllib.urlopen(strUrlBase)
        status = open("/var/bin/alerte", "w+")
        status.write(str(0))
        status.close()
if valeur < 30 and alerte()==1:
        data = 'devid=v11E1E7836572599'
        req = urllib2.Request(urlalert, data)
        sendrequest = urllib2.urlopen(req)
        status = open("/var/bin/alerte", "w+")
        status.write(str(2))
        status.close()
elif valeur < 50 and alerte()==0:
        data = 'devid=v9BC293C4A84041F'
        req = urllib2.Request(urlalert, data)
        sendrequest = urllib2.urlopen(req)
       	status = open("/var/bin/alerte", "w+")
       	status.write(str(1))
        status.close()
#break
#i=i+1 
#time.sleep(10)
