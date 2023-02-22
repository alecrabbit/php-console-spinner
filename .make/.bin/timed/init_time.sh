#!/usr/bin/env bash
__NOW=$(date +"%Y-%m-%dT%H%M%S")
__INIT=$(date)
__FILE=".last_init_time"
_INITS_DIR=$1

mkdir -p $_INITS_DIR

if [ -f "$__FILE" ]; then
  mv "$__FILE" ${_INITS_DIR}/"${__NOW}".init
fi
echo "${__INIT}" > ${__FILE}
