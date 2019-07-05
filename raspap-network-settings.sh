#!/bin/bash


echo "---------------- dnsmasq ----------------"
cat /etc/dnsmasq.conf
echo "---------------- hostapd ----------------"
cat /etc/hostapd/hostapd.conf
echo "---------------- dhcpcd ----------------"
cat /etc/dhcpcd.conf

echo "---------------- Networking ----------------"
ls -la  /etc/raspap/networking/
echo "ETH0---------"
cat /etc/raspap/networking/eth0.ini
echo "WLAN0---------"
cat /etc/raspap/networking/wlan0.ini
echo "WLAN1---------"
cat /etc/raspap/networking/wlan1.ini

