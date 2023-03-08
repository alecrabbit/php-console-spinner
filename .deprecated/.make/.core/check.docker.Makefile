# Docker checks
_DOCKER_EXECUTABLE = $(shell command -v docker 2> /dev/null)
_DOCKER_COMPOSE_EXECUTABLE = $(shell command -v docker-compose 2> /dev/null)

_docker_check:
	@${_ECHO} "${_C_COMMENT} \nChecking if 'docker' is installed... ${_C_STOP}"
ifndef _DOCKER_EXECUTABLE
	$(error "${red}Docker not found... Please install 'docker' first...${reset}")
endif
	@${_ECHO} "";
	@$(_DOCKER) --version
	@${_ECHO} "";
	@${_ECHO_OK}

_docker_compose_check:
	@${_ECHO} "${_C_COMMENT} \nChecking if 'docker-compose' is installed... ${_C_STOP}"
ifndef _DOCKER_COMPOSE_EXECUTABLE
	$(error "${red}Docker-compose not found... Please install 'docker-compose' first...${reset}")
endif
	@${_ECHO} "";
	@${_DOCKER_COMP} --version
	@${_ECHO} "";
	@${_ECHO_OK}
