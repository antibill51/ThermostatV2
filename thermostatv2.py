#!/usr/bin/env python
import os
import re
import RPi.GPIO as GPIO
import time
import math
from datetime import datetime
global val1
global restart1
restart1 = 1
val1 = 0
global oldval1
global val2
global restart2
restart2 = 1
val2 = 0
global oldval2
POELE = 18
GPIO.setwarnings(False)
GPIO.cleanup()
GPIO.setmode(GPIO.BCM)
GPIO.setup(POELE, GPIO.OUT)
GPIO.output(POELE, GPIO.LOW)
status = open("/var/bin/status-rdc", "w+")
status.write("2")
status.close()


#canalisation variables. Regler niveau poele a 18 degres
import spidev
spi1 = spidev.SpiDev()
spi1.open(0, 0)
spi1.max_speed_hz = 976000
spi2 = spidev.SpiDev()
spi2.open(0, 1)
spi2.max_speed_hz = 976000


#Lecture des options

def currmoderdc():
    while(1):
        tfile = open("/var/bin/mode-rdc", "r")
        moderdc = tfile.read()
        tfile.close()     
        return moderdc


def currmode1():
    while(1):
        tfile = open("/var/bin/mode-1", "r")
        mode1 = tfile.read()
        tfile.close()
        return mode1

def currmode2():
    while(1):
        tfile = open("/var/bin/mode-2", "r")
        mode2 = tfile.read()
        tfile.close()
        return mode2

def currprogrdc():
    while(1):
        tfile = open("/var/bin/prog-rdc", "r")
        progrdc = tfile.read()
        tfile.close()
        return progrdc

def currprog1():
    while(1):
        tfile = open("/var/bin/prog-1", "r")
        prog1 = tfile.read()
        tfile.close()
        return prog1

def currprog2():
    while(1):
        tfile = open("/var/bin/prog-2", "r")
        prog2 = tfile.read()
        tfile.close()
        return prog2

#lecture des temperatures reeles
def currtemprdc():
    while(1):
        tfile = open("/var/bin/temp-rdc", "r")
        temperaturerdc = tfile.read()
        tfile.close()
        return float(temperaturerdc)

def currtemp1():
    while(1):
        tfile = open("/var/bin/temp-1", "r")
        temperature1 = tfile.read()
        tfile.close()
        return float(temperature1)

def currtemp2():
    while(1):
        tfile = open("/var/bin/temp-2", "r")
        temperature2 = tfile.read()
        tfile.close()
        return float(temperature2)


# lecture des temperatures de consigne
def settemprdc():
        readtemp = open("/var/bin/thermostat-rdc", "r")
        settemprdc = readtemp.readline(4)
        readtemp.close()
        return float(settemprdc)

def settemp1():
        readtemp = open("/var/bin/thermostat-1", "r")
        settemp1 = readtemp.readline(4)
        readtemp.close()
        return float(settemp1)

def settemp2():
        readtemp = open("/var/bin/thermostat-2", "r")
        settemp2 = readtemp.readline(4)
        readtemp.close()
        return float(settemp2)


# Gestion des temperatures
def holdtemprdcmode1():
# Si passage eco/arret
       	tfile = open("/var/bin/status-rdc", "r")
        moderdc = tfile.read()
        tfile.close()
        if moderdc == "3":
                status = open("/var/bin/status-rdc", "w+")
                status.write("2")
                status.close()    
	if currtemprdc() <= settemprdc() - 0.9:
        	GPIO.output(POELE, GPIO.HIGH)
        	status = open("/var/bin/status-rdc", "w+")
        	status.write("1")
        	status.close()
    	if currtemprdc() >= settemprdc() + 0.5:
        	GPIO.output(POELE, GPIO.LOW)
       		status = open("/var/bin/status-rdc", "w+")
        	status.write("2")
        	status.close()
#on triche sur l'etat des canalisations pour les graphes
		status = open("/var/bin/status-1", "w+")
                status.write("2")
                status.close()
                status = open("/var/bin/status-2", "w+")
                status.write("2")
                status.close()

def holdtemprdcmode2():
        tfile = open("/var/bin/status-rdc", "r")
        moderdc = tfile.read()
        tfile.close()
        if moderdc == "2":
                status = open("/var/bin/status-rdc", "w+")
                status.write("3")
                status.close()	
	elif currtemprdc() <= settemprdc() - 0.5:
        	GPIO.output(POELE, GPIO.HIGH)
        	status = open("/var/bin/status-rdc", "w+")
        	status.write("1")
        	status.close()
    	elif currtemprdc() >= settemprdc() + 0.5:
                GPIO.output(POELE, GPIO.HIGH)
                time.sleep(1)
                GPIO.output(POELE, GPIO.LOW)
        	status = open("/var/bin/status-rdc", "w+")
        	status.write("3")
        	status.close()
# Mode standby, 1 secondes d'activation tous les lancements du script (environ 30 secondes )
	elif moderdc == "3":
                GPIO.output(POELE, GPIO.HIGH)
	    	time.sleep(1)
                GPIO.output(POELE, GPIO.LOW)


def holdtemprdcmode3():
        GPIO.output(POELE, GPIO.LOW)
        status = open("/var/bin/status-rdc", "w+")
        status.write("2")
        status.close()
#on triche sur l'etat des canalisations pour les graphes
        status = open("/var/bin/status-1", "w+")
        status.write("2")
        status.close()
        status = open("/var/bin/status-2", "w+")
        status.write("2")
        status.close()

def tempout1():
	global val1
    	diff1 = settemp1() - 18
    	if currtemp1() < 15.5: 
                val1 = 50
        if (15.5 <= currtemp1() - diff1 and currtemp1() - diff1  < 16):
                val1 = 58
        if (16 <= currtemp1() - diff1  and currtemp1() - diff1  < 16.5):
                val1 = 65
        if (16.5 <= currtemp1() - diff1  and currtemp1() - diff1  < 17):
                val1 = 70
        if (17 <= currtemp1() - diff1  and currtemp1() - diff1  < 18):
                val1 = 79
        if (18 <= currtemp1() - diff1  and currtemp1() - diff1  < 18.3):
                val1 = 84
        if (18.3 <= currtemp1() - diff1  and currtemp1() - diff1  < 18.5):
                val1 = 92
        if (18.5 <= currtemp1() - diff1  and currtemp1() - diff1  < 19):
                val1 = 98
        if (19 <= currtemp1() - diff1  and currtemp1() - diff1  < 19.5):
                val1 = 105
        if (19.5 <= currtemp1() - diff1  and currtemp1() - diff1  < 20):
                val1 = 108
        if (20 <= currtemp1() - diff1  and currtemp1() - diff1  < 20.5):
                val1 = 114
        if (20.5 <= currtemp1() - diff1  and currtemp1() - diff1  < 21):
                val1 = 120
        if (21 <= currtemp1() - diff1  and currtemp1() - diff1  < 21.5):
                val1 = 124
        if (21.5 <= currtemp1() - diff1  and currtemp1() - diff1  < 22):
                val1 = 130
        if currtemp1() - diff1  >= 22:
                val1 = 135
	return int(val1)

def write_pot1(input):
    	msb = input >> 8
    	lsb = input & 0xFF
    	spi1.xfer([msb, lsb])
def writetempout1():
#	print "chambre"
#	print tempout1()
    	write_pot1(tempout1())
def holdtemp1mode1():
	global val1
	global restart1
	global oldval1
	oldval1 = val1
#	print oldval1
#	print val1
	tempout1()
	if val1 != oldval1:
   		writetempout1()
		if currtemp1() <= settemp1() - 0.3:
       			status = open("/var/bin/status-1", "w+")
        		status.write("1")
        		status.close()
			if restart1 == 1:
				restart1 = 0
				write_pot1(60)
               		 	time.sleep(1)
				write_pot1(val1)
        	if currtemp1() >= settemp1():
			restart1 = 1
              		status = open("/var/bin/status-1", "w+")
               		status.write("2")
               		status.close()

def holdtemp1mode2():
	global val1
	global oldval1
        oldval1 = val1
        val1 = 52
        if val1 != oldval1:
        	write_pot1(val1)
        	status = open("/var/bin/status-1", "w+")
        	status.write("1")
        	status.close()


def holdtemp1mode3():
	global val1
	global oldval1
        oldval1 = val1
        val1 = 152
        if val1 != oldval1:
        	write_pot1(val1)
        	status = open("/var/bin/status-1", "w+")
        	status.write("2")
        	status.close()


def tempout2():
	global val2
    	diff2 = settemp2() - 18
	if currtemp2() < 15.5: 
                val2 = 50
        if (15.5 <= currtemp2() - diff2 and currtemp2() - diff2  < 16):
                val2 = 58
        if (16 <= currtemp2() - diff2  and currtemp2() - diff2  < 16.5):
                val2 = 65
        if (16.5 <= currtemp2() - diff2  and currtemp2() - diff2  < 17):
                val2 = 71
        if (17 <= currtemp2() - diff2  and currtemp2() - diff2  < 18):
                val2 = 77
        if (18 <= currtemp2() - diff2  and currtemp2() - diff2  < 18.3):
                val2 = 83
        if (18.3 <= currtemp2() - diff2  and currtemp2() - diff2  < 18.5):
                val2 = 90
        if (18.5 <= currtemp2() - diff2  and currtemp2() - diff2  < 19):
                val2 = 96
        if (19 <= currtemp2() - diff2  and currtemp2() - diff2  < 19.5):
                val2 = 102
        if (19.5 <= currtemp2() - diff2  and currtemp2() - diff2  < 20):
                val2 = 106
        if (20 <= currtemp2() - diff2  and currtemp2() - diff2  < 20.5):
                val2 = 111
        if (20.5 <= currtemp2() - diff2  and currtemp2() - diff2  < 21):
                val2 = 120
        if (21 <= currtemp2() - diff2  and currtemp2() - diff2  < 21.5):
                val2 = 124
        if (21.5 <= currtemp2() - diff2  and currtemp2() - diff2  < 22):
                val2 = 130
        if currtemp2() - diff2  >= 22:
                val2 = 135
	return int(val2)

def write_pot2(input):
    	msb = input >> 8
    	lsb = input & 0xFF
    	spi2.xfer([msb, lsb])
def writetempout2():
#	print "etage"
#	print tempout2()
    	write_pot2(tempout2())
def holdtemp2mode1():
        global val2
	global oldval2
	global restart2
	oldval2 = val2
        tempout2()
        if val2 != oldval2:
                writetempout2()
		if currtemp2() <= settemp2() - 0.3:
       			status = open("/var/bin/status-2", "w+")
        		status.write("1")
        		status.close()
                        if restart2 == 1:
                                restart2 = 0
                                write_pot2(60)
                		time.sleep(1)
				write_pot2(val2)
		if currtemp2() >= settemp2():
			restart2 = 1
            		status = open("/var/bin/status-2", "w+")
            		status.write("2")
            		status.close()
def holdtemp2mode2():
	global val2
	global oldval2
        oldval2 = val2
        val2 = 52
        if val2 != oldval2:
        	write_pot2(52)
        	status = open("/var/bin/status-2", "w+")
        	status.write("1")
        	status.close()


def holdtemp2mode3():
	global val2
	global oldval2
        oldval2 = val2
        val2 = 135
        if val2 != oldval2:
        	write_pot2(135)
        	status = open("/var/bin/status-2", "w+")
        	status.write("2")
        	status.close()

def canalisations():

    if currmode1() == "1" :
        holdtemp1mode1()
    if currmode1() == "2" :
        holdtemp1mode2()
    if currmode1() == "3" :
        holdtemp1mode3()
    if currmode2() == "1" :
        holdtemp2mode1()
    if currmode2() == "2" :
        holdtemp2mode2()
    if currmode2() == "3" :
        holdtemp2mode3()


infloop = 1
while infloop == 1 :
# test conditions et renvois
    		if currmoderdc() == "1" :
       			holdtemprdcmode1()
    		if currmoderdc() == "2" :
        		holdtemprdcmode2()
    		if currmoderdc() == "3" :
        		holdtemprdcmode3()
# Si poele arrete canalisations arretes virtuellement 
  		tfile = open("/var/bin/status-rdc", "r")
  		moderdc = tfile.read()
  		tfile.close()        
		if moderdc != "2" :
			canalisations()
  		time.sleep(30)

