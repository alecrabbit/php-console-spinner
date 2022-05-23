_project_init: _project_init_message _do_project_init

_project_init_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO} Project initialization...${_C_STOP}\n";

_project_clear_flags: _project_clear_flags_message _do_project_clear_flags

_project_clear_flags_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO} Clearing flags...${_C_STOP}\n";

_project_set_flags: _project_set_flags_message _do_project_set_flags

_project_set_flags_message:
	@${_ECHO} "\n${_C_SELECT}  ${PROJECT_NAME}  ${_C_STOP} ${_C_INFO} Setting flags...${_C_STOP}\n";

_project_install: _project_install_message _do_project_install
	@${_ECHO_DONE};

_project_install_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO} Project installation...${_C_STOP}\n";

