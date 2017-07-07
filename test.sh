#!/bin/bash

DATA="name=tesztname"

echo
echo "Sending Data: $DATA"
echo
echo "Received:"
curl -i -X POST -d $DATA -b XDEBUG_SESSION=PHPSTORM localhost/register
echo
