#!/usr/bin/python
import spidev
spi1 = spidev.SpiDev()
spi1.open(0, 0)
spi1.max_speed_hz = 976000
spi2 = spidev.SpiDev()
spi2.open(0, 1)
spi2.max_speed_hz = 976000


def write_pot1(input):
    msb = input >> 8
    lsb = input & 0xFF
    spi1.xfer([msb, lsb])
 

def write_pot2(input):
    msb = input >> 8
    lsb = input & 0xFF
    spi2.xfer([msb, lsb])

while True: 
	val = input()
	write_pot1(val)
	write_pot2(val)
