include ${_PROJECT_DIR}/project.init.Makefile
include ${_PROJECT_DIR}/project.install.Makefile
include ${_APP_DIR}/app.Makefile

PROJECT_SEL=${_C_SELECT} ${PROJECT_NAME} ${_C_STOP}

info: ## Outputs project information
	@${_ECHO} "\n${PROJECT_SEL} ${_C_INFO} Project info...${_C_STOP}\n";
	@${_ECHO_DISABLED};
	@${_ECHO} "${_C_DEBUG} Add project info >>here<<${_C_STOP}\n";

reset: _env_reset ## Resets project
	@${_NO_OP}

_env_reset:
	@${_ECHO} "\n${PROJECT_SEL} ${_C_INFO} Resetting environment file...${_C_STOP}\n";
	@cp -v ${_ENV_DIST_FILE} ${_ENV_FILE};
	@${_ECHO};
	@${_ECHO_OK};
