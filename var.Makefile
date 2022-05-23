include .env # for environment variables

CONTAINER_NAME=app
APP_DIR=.
PROJECT_NAME=php-console-spinner

# DO NOT EDIT! See _VAR_FILE variable
# Git related variables
WORKING_BRANCH=dev
DEFAULT_COMMIT_MESSAGE=~wp

# Docker compose files

# _FILES = -f ${_DOCKER_COMPOSE_FILE} -f docker-compose.override.${_DC_EXTENSION}
_FILES = -f ${_DOCKER_COMPOSE_FILE}

