# Core
.DEFAULT_GOAL = help
SHELL=/bin/bash

NOW=$(shell date +"%Y-%m-%dT%H%M%S")
_PWD_DIR=$(shell pwd)

# Directories, DO NOT EDIT!
_DN_INCLUDE=.include
_DN_DIST=.dist
_DN_MAKE=.make
_DN_CORE=.core
_DN_BIN=.bin
_DN_INITS=.inits
_DN_TIMED=timed
_DN_TITLE=title
_DN_DEPRECATED=.deprecated
_DN_CP=.cp
_DN_APP=app
_DN_PROJECT=project
_DN_TEST=.test

_MAKE_ROOT=${_PWD_DIR}/${_DN_MAKE}
_BIN_DIR=${_MAKE_ROOT}/${_DN_BIN}
_TIMED_DIR=${_BIN_DIR}/${_DN_TIMED}
_TITLE_DIR=${_BIN_DIR}/${_DN_TITLE}
_DIST_DIR=${_MAKE_ROOT}/${_DN_DIST}
_CORE_DIR=${_MAKE_ROOT}/${_DN_CORE}
_PROJECT_DIR=${_MAKE_ROOT}/${_DN_PROJECT}
_APP_DIR=${_PROJECT_DIR}/${_DN_APP}
_TEST_DIR=${_CORE_DIR}/${_DN_TEST}
_DIST_CP_DIR=${_DIST_DIR}/${_DN_CP}
_INCLUDE_DIR=${_MAKE_ROOT}/${_DN_INCLUDE}
_DEPRECATED_DIR=${_INCLUDE_DIR}/${_DN_DEPRECATED}
_UNINSTALL_DIR=${_DEPRECATED_DIR}/uninstall.${NOW}
_INITS_DIR=${_MAKE_ROOT}/${_DN_INITS}
_VAR_FILE_DIR=.

# Executables (local)
_DOCKER = $(shell command -v docker 2> /dev/null)
_DOCKER_COMP = $(shell command -v docker-compose 2> /dev/null)

_TERMINAL_TITLE_FILE=TERMINAL_TITLE

# Makefile to use for help output
_MAKEFILE = Makefile

_VAR_FILE_NAME=var.Makefile
_VAR_DIST_FILE_NAME=var.dist.Makefile

# File to contain all variables
_VAR_FILE=${_VAR_FILE_DIR}/${_VAR_FILE_NAME}
# Dist variables file
_VAR_DIST_FILE=${_DIST_DIR}/${_VAR_DIST_FILE_NAME}

_VAR_DIST_CP_FILE=${_DIST_CP_DIR}/${_VAR_DIST_FILE_NAME}

_VAR_UNINSTALL_FILE=${_UNINSTALL_DIR}/${_VAR_FILE_NAME}

_MAIN_MAKEFILE=main.${_MAKEFILE}
_INSTALL_MAKEFILE=dist.install.${_MAKEFILE}
_MAIN_DIST_MAKEFILE=${_DIST_CP_DIR}/${_MAIN_MAKEFILE}

# Docker compose files
_DC_EXTENSION = yml

_DOCKER_COMPOSE_FILE=docker-compose.${_DC_EXTENSION}

_DC_STACK_FILE = docker-stack.${_DC_EXTENSION}

_STACK_FILE = -f ${_DC_STACK_FILE}

_DC_STACK = ${_DOCKER_COMP} ${_STACK_FILE}

_DC_EXEC = ${_DC_STACK} exec

_ENV_FILE=.env
_ENV_DIST_FILE=.env.dist
_ENV_FILE_COMMENT=\# Project-specific environment variables

# Project variables override in .env file
PROJECT_NAME=project.name
PROJECT_SHORT_TITLE=🚀
