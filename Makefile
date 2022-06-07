include ./.make/.core/*
include ./.make/.include/*
include ./.make/project/project.Makefile
include ./var.Makefile


## ————————————————————————————— #️⃣  root.Makefile #️⃣  ———————————————————————————
##
help: ## Outputs this help screen
	@grep -h -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "${_C_GREEN}%-30s${_C_STOP} %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

##
## —— Installation 🏗️  ——————————————————————————-———————————————————————————————
install: _install_done ## Perform installation procedure
uninstall: _docker_down _uninstall ## Run uninstall procedure

##
## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: _docker_up time_current ## Start the docker hub in detached mode

down: _docker_down time_current ## Stop the docker hub

reload: _docker_down _docker_generate_stack _docker_up _docker_ps time_current ## Recreate stack file, restart the docker hub and show the current status

restart: _docker_down _docker_up time_current ## Restart the docker hub

ps: _docker_ps time_current ## List all running containers

clear: _docker_down_clear time_current ## Stop the docker hub and remove volumes

cfg: _docker_config time_current ## Display docker-compose config

logs: _docker_logs ## Show live logs

stack: _docker_generate_stack time_current ## Create docker-compose stack file

build: _docker_pull _docker_build time_current ## Build the docker images

## —— Project 🚧 ———————————————————————————————————————————————————————————————
init: _initialize ## Initialize project and start docker hub

chown: ## Change the owner(user) of the project
	sudo chown -R ${USER_ID}:${GROUP_ID} .


