#! /usr/bin/python

import sys
sonde = sys.argv[1]
filename = sys.argv[2]
print filename
print sonde
while(1): 
    tfile = open("/sys/bus/w1/devices/" + sonde + "/w1_slave")  
    text = tfile.read()  
    tfile.close()
    firstline  = text.split("\n")[0]
    crc_check = text.split("crc=")[1]
    crc_check = crc_check.split(" ")[1]
    if crc_check.find("YES")>=0:
        break 
    
secondline = text.split("\n")[1] 
temperaturedata = secondline.split(" ")[9]  
temperature = float(temperaturedata[2:])  
temperature = temperature / 1000.0 
result = round(temperature, 1)
if result < 50:
	if result > 5:
		print result
		file = open(filename, "w")
		file.write(str(result))
		file.close()
