include .env # for environment variables

# Git related variables
WORKING_BRANCH=dev
DEFAULT_COMMIT_MESSAGE=~wp

# Docker compose files

# _FILES = -f ${_DOCKER_COMPOSE_FILE} -f docker-compose.override.${_DC_EXTENSION}
_FILES = \
	-f ${_DOCKER_COMPOSE_FILE} \
	-f docker-compose.dev.${_DC_EXTENSION} \

# ------------------------------------------------------------------------------
PROJECT_NAME=php-console-spinner
PROJECT_SHORT_TITLE=🏵️

TEST_REPETITION=10
APP_CONTAINER=app
COMPOSER_CONTAINER=app
# COMPOSER_CONTAINER=composer
DUMPER_CONTAINER=${APP_CONTAINER}
APP_DIR=.
APP_PROJECT_NAME=${PROJECT_NAME}
