
#!/bin/sh
# /usr/local/bin/sshd_wrapper.sh
PROCESS_NAME=niveau.py
PROCESS_COMMAND='python /home/pi/niveau.py'
sudo killall python
ps auxw | grep -v grep | grep $PROCESS_NAME > /dev/null || $PROCESS_COMMAND &

