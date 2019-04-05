#!/usr/bin/env bash
script_dir="$(dirname "$0")"
cd ${script_dir}

. imports.sh

comment "Restarting container..."
if [[ ${EXEC} == 0 ]]
then
  no-exec
else
  docker-compose down && docker-compose -f ${DOCKER_COMPOSE_FILE} up -d
fi

