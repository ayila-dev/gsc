#

sudo mkfs.vfat -I -F 32 /dev/sdb

#

sudo mkfs.vfat -F 32 -n USB /dev/sdb

#

sudo dd if=/home/fambfad/Downloads/Win10_22H2_French_x64v1.iso of=/dev/sdb bs=4M status=progress && sync
