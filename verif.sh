#!/bin/sh
# /usr/local/bin/sshd_wrapper.sh
PROCESS_NAME=thermostatv2.py
PROCESS_COMMAND='python /home/pi/thermostatv2.py'
ps auxw | grep -v grep | grep $PROCESS_NAME > /dev/null || $PROCESS_COMMAND &
