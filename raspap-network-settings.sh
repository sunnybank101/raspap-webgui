#!/bin/bash

echo "RaspAP Network Settings Capture - for debug purposes"

echo "---------------- dnsmasq ----------------"
cat /etc/dnsmasq.conf
echo "---------------- hostapd ----------------"
cat /etc/hostapd/hostapd.conf
echo "---------------- dhcpcd ----------------"
cat /etc/dhcpcd.conf

echo "---------------- /etc/raspap/networking ----------------"
ls -la  /etc/raspap/networking/
echo "defaults---------"
cat /etc/raspap/networking/defaults
echo "eth0.ini---------"
cat /etc/raspap/networking/eth0.ini
echo "wlan0.ini---------"
cat /etc/raspap/networking/wlan0.ini
echo "wlan1.ini---------"
cat /etc/raspap/networking/wlan1.ini
