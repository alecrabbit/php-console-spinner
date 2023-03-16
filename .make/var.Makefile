ifeq ($(wildcard $(_ENV_FILE)),)
    # file does not exist
else
    include $(_ENV_FILE) # to include environment variables
endif

GLOBAL_DEBUG=0

# Git related variables
WORKING_BRANCH=dev
COMMIT_MESSAGE=~wp

# Docker compose files (uncomment to use dev file)
_FILES = \
	-f ${_DOCKER_COMPOSE_FILE} \
	-f docker-compose.dev.${_DC_EXTENSION} \

PROJECT_NAME=php-console-spinner
PROJECT_SHORT_TITLE=🏵️

# ------------------------------------------------------------------------------
# Your variables here
TEST_REPETITION=10
APP_CONTAINER=app
COMPOSER_CONTAINER=app
# COMPOSER_CONTAINER=composer
DUMPER_CONTAINER=${APP_CONTAINER}
APP_DIR=.
WORKING_DIR=/app
APP_PROJECT_NAME=${PROJECT_NAME}
