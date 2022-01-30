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

_full_init: clear_ready _docker_actions _app_init _tools mark_ready

_tools: _tools_install _tools_run

_tools_run: _run_phploc

_run_phploc:
	@echo "\n$(_C_SELECT) $(PROJECT_NAME) $(_C_STOP) $(_C_INFO)PHPLOC tun...$(_C_STOP)\n";
	@mkdir -p $(APP_DIR)/.report/.phploc
	@-docker-compose exec $(CONTAINER_NAME) /app/.tools/phploc src > $(APP_DIR)/.report/.phploc/.phploc_baseline
	@-cat $(APP_DIR)/.report/.phploc/.phploc_baseline
	@echo "$(_C_STOP)\n";

_docker_actions: docker_down_clear docker_pull docker_build docker_up _docker_ps

_tools_install: _install_phploc

_install_phploc:
	@echo "\n$(_C_SELECT) $(PROJECT_NAME) $(_C_STOP) $(_C_INFO)PHPLOC install...$(_C_STOP)\n";
	@mkdir -p  ${PWD}/.tools
	@docker-compose exec $(CONTAINER_NAME) phive install phploc --trust-gpg-keys 0x4AA394086372C20A --target .tools

_app_init:
	@echo "$(_C_INFO)";
	@echo "Initialize application here...";
	@echo "$(_C_STOP)";

clear_ready:
	@echo "\n$(_C_SELECT) $(PROJECT_NAME) $(_C_STOP) $(_C_INFO)Clearing ready flag...$(_C_STOP)\n";
	@docker run --rm -v ${PWD}:/app --workdir=/app alpine rm -f .ready

mark_ready:
	@echo "\n$(_C_SELECT)  $(PROJECT_NAME)  $(_C_STOP) $(_C_INFO)Setting ready flag...$(_C_STOP)\n";
	@docker run --rm -v ${PWD}:/app --workdir=/app --user=$(shell id -u):$(shell id -g) alpine touch .ready

chown:
	@sudo chown -R $(shell id -un):$(shell id -gn) .

test:
	@-docker-compose exec -e XDEBUG_MODE=off $(CONTAINER_NAME) vendor/bin/phpunit

test_coverage:
	@-docker-compose exec -e XDEBUG_MODE=coverage $(CONTAINER_NAME) vendor/bin/phpunit --coverage-text
