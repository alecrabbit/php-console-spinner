# Docker related targets
_docker_init: _docker_down_clear _docker_generate_stack _docker_pull _docker_build

_docker_down:
	@${_ECHO} "\n${_C_WARNING} Stopping containers...${_C_STOP}\n";
	@-${_DC_STACK} down --remove-orphans
	@$(_ECHO_EXIT)

_docker_down_clear:
	@${_ECHO} "\n${_C_WARNING} Stopping containers...${_C_STOP}\n";
	@-${_DC_STACK} down -v --remove-orphans

_docker_pull:
	@${_ECHO} "\n${_C_INFO} Pulling images...${_C_STOP}\n";
	@${_DC_STACK} pull

_docker_build:
	@${_ECHO} "\n${_C_INFO} Building containers...${_C_STOP}\n";
	@${_DC_STACK} build

_docker_build_no_cache:
	@${_ECHO} "\n${_C_INFO} Building containers...${_C_STOP}\n";
	@${_ECHO} "${_C_COMMENT} No cache...${_C_STOP}\n";
	@${_ECHO} "${_C_COMMENT} Pulling images...${_C_STOP}\n";
	@${_DC_STACK} build --pull --no-cache

_docker_up: _title
	@${_ECHO} "\n${_C_INFO} Starting containers...${_C_STOP}\n";
	@${_DC_STACK} up --detach
	@${_ECHO_OK}

_docker_up_attached: _title
	@${_ECHO} "\n${_C_INFO} Starting containers...${_C_STOP}\n";
	@${_DC_STACK} up

_docker_logs: c="${PROJECT_SHORT_TITLE} 📔 Logs"
_docker_logs: _title
	@-${_DC_STACK} logs --tail=0 --follow
	@${_ECHO} "\n${_C_WARNING} Logs exited...${_C_STOP}\n";

_docker_ps:
	@${_ECHO} "\n${_C_INFO} Containers...${_C_STOP}\n";
	@${_DC_STACK} ps
	@${_ECHO} "\n";

_docker_config:
	@${_ECHO} "\n${_C_INFO} Docker-compose config...${_C_STOP}\n";
	@${_DOCKER_COMP} ${_FILES} config

_docker_generate_stack:
	@${_ECHO} "\n${_C_INFO} Generating stack file...${_C_STOP}\n";
	@${_DOCKER_COMP} ${_FILES} config > ${_DC_STACK_FILE}
	@${_ECHO_OK}
