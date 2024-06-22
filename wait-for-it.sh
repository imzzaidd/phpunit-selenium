#!/usr/bin/env bash
host="$1"
port="$2"
timeout="${3:-30}"

if [ -z "$host" ] || [ -z "$port" ]; then
  echo "Usage: $0 host port [timeout]"
  exit 1
fi

for i in $(seq $timeout); do
  if nc -z $host $port; then
    if curl --silent --head "http://$host:$port" | grep "200 OK" > /dev/null; then
      echo "Selenium Hub is up"
      exit 0
    fi
  fi
  sleep 1
done

echo "Timeout occurred after waiting $timeout seconds for $host:$port"
exit 1
