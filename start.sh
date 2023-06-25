#!/bin/sh

## GENERATE SSL CERT
private_lines=$(echo $PRIVATE | tr " " "\n")
echo "-----BEGIN RSA PRIVATE KEY-----" >> /etc/ssl/private.key
for private_line in $private_lines
do
  if [ "$private_line" != "-----BEGIN" ] && [ "$private_line" != "RSA" ] && [ "$private_line" != "PRIVATE" ] && [ "$private_line" != "KEY-----" ] && [ "$private_line" != "-----END" ]
  then
    echo $private_line >> /etc/ssl/private.key
  fi
done
echo "-----END RSA PRIVATE KEY-----" >> /etc/ssl/private.key
certificate_lines=$(echo $CERTIFICATE | tr " " "\n")
echo "-----BEGIN CERTIFICATE-----" >> /etc/ssl/certificate.crt
for certificate_line in $certificate_lines
do
  if [ "$certificate_line" != "-----BEGIN" ] && [ "$certificate_line" != "CERTIFICATE-----" ] && [ "$certificate_line" != "-----END" ]
  then
    echo $certificate_line >> /etc/ssl/certificate.crt
  fi
done
echo "-----END CERTIFICATE-----" >> /etc/ssl/certificate.crt
ca_bundle_lines=$(echo $CA_BUNDLE | tr " " "\n")
echo "-----BEGIN CERTIFICATE-----" >> /etc/ssl/ca_bundle.crt
for ca_bundle_line in $ca_bundle_lines
do
  if [ "$ca_bundle_line" != "-----BEGIN" ] && [ "$ca_bundle_line" != "CERTIFICATE-----" ] && [ "$ca_bundle_line" != "-----END" ]
  then
    echo $ca_bundle_line >> /etc/ssl/ca_bundle.crt
  fi
done
echo "-----END CERTIFICATE-----" >> /etc/ssl/ca_bundle.crt

## START SERVICES
/etc/init.d/php8.2-fpm start
apachectl -D FOREGROUND