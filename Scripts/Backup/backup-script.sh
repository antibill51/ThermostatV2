echo "***** $(date) RasPi backup *****" > /home/pi/Scripts/Backup/backups.log 
sudo rsync -aHv --delete-during --exclude-from=/home/pi/Scripts/Backup/rsync-exclude / /media/NAS/PI_Backup/ >> /home/pi/Scripts/Backup/backups.log
