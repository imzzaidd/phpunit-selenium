#!/usr/bin/env bash
set -e

TIMEOUT=15

while getopts "t:" opt; do
  case ${opt} in
    t )
      TIMEOUT=$OPTARG
      ;;
    \? )
      echo "Invalid option: $OPTARG" 1>&2
      exit 1
      ;;
  esac
done
shift $((OPTIND -1))

if [ "$#" -ne 1 ]; then
  echo "Usage: $0 [-t timeout] host:port"
  exit 1
fi

HOSTPORT=$1
HOST=$(echo "$HOSTPORT" | cut -d : -f 1)
PORT=$(echo "$HOSTPORT" | cut -d : -f 2)

for i in $(seq $TIMEOUT); do
  if nc -z "$HOST" "$PORT"; then
    exit 0
  fi
  sleep 1
done

echo "Timeout occurred after waiting $TIMEOUT seconds for $HOST:$PORT"
exit 1
