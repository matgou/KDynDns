#!/bin/sh
token="" # Put your token
fqdn="" # Put your fqdn

url="http://dyndns.kapable.info/api/v1/refresh.json"

curl -X PUT -d "token=$token" -d "fqdn=$fqdn" "$url" 2>/dev/null >/dev/null
exit 0
