# wave_picker


install first dependency 

- Python 3
```console
apt-get install python3 python3-pip
```
- Python Module
```console
python3 -m pip install obspy matplotlib scipy numpy pandas
```


and install a web server, php

if used docker then, on docker-compose.yml
```console
# Version
version: '3.1'

# Setup
services:
  # PHP
  php:
    image: kenconex/picker_mseed_web:v666
    restart: always
    build: 
      context: ./
      dockerfile: Dockerfile
    ports:
      - 5000:80
```
