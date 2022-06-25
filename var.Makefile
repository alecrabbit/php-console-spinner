include .env # for environment variables

# DO NOT EDIT! See _VAR_FILE variable
# Git related variables
WORKING_BRANCH=dev
DEFAULT_COMMIT_MESSAGE=~wp

# Docker compose files

# _FILES = -f ${_DOCKER_COMPOSE_FILE} -f docker-compose.override.${_DC_EXTENSION}
_FILES = \
	-f ${_DOCKER_COMPOSE_FILE} \
	-f docker-compose.dev.${_DC_EXTENSION} \

# ------------------------------------------------------------------------------
TEST_REPETITION=10
APP_CONTAINER=app
DUMPER_CONTAINER=${APP_CONTAINER}
APP_DIR=.
PROJECT_NAME=php-console-spinner
APP_PROJECT_NAME=${PROJECT_NAME}
