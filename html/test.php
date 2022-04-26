<?php

echo shell_exec('docker run -d -p 74:80 -v /dev/shm:/dev/shm dorowu/ubuntu-desktop-lxde-vnc');

?>