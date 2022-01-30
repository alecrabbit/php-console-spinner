# TODO (2021-12-17 13:38) [Alec Rabbit]: if `./.make/include/var.Makefile` does not exist, include `./.make/dist/var.dist.Makefile`
include ./.make/dist/var.dist.Makefile
include ./.make/include/*
include ./.make/env/*
include .env

up: docker_up
down: docker_down
restart: docker_down docker_up

init: _message_initialize _check_var_file _full_init

_message_initialize:
	@echo "";
	@echo "$(_C_INFO) Initialize... $(_C_STOP) $(_C_SELECT) $(PROJECT_NAME) $(_C_STOP)";

_check_var_file:
	@echo "$(_C_COMMENT)";
	@echo "TODO: check for './.make/include/var.Makefile'...";
	@echo "if it exists do nothing...";
	@echo "if not, copy './.make/dist/var.dist.Makefile' to './.make/include/var.Makefile'";
	@echo "and stop asking to check file contents and start init over again";
	@echo "$(_C_STOP)";

_full_init: docker_down_clear clear_ready docker_pull docker_build docker_up _app_init mark_ready _docker_ps

_app_init:
	@echo "$(_C_INFO)";
	@echo "Initialize application here...";
	@echo "$(_C_STOP)";

clear_ready:
	@echo "\n$(_C_SELECT) $(PROJECT_NAME) $(_C_STOP) $(_C_INFO)Clearing ready flag...$(_C_STOP)\n";
	docker run --rm -v ${PWD}:/app --workdir=/app alpine rm -f .ready

mark_ready:
	@echo "\n$(_C_SELECT)  $(PROJECT_NAME)  $(_C_STOP) $(_C_INFO)Setting ready flag...$(_C_STOP)\n";
	docker run --rm -v ${PWD}:/app --workdir=/app --user=$(shell id -u):$(shell id -g) alpine touch .ready

chown:
	sudo chown -R $(shell id -un):$(shell id -gn) .
