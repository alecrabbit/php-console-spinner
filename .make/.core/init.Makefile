_initialize: _timer_start _message_initialize _full_init _timer_stop _time_init time_current project_info
	@${_ECHO};
	@${_ECHO_DONE};
	@${_ECHO};

_message_initialize:
	@${_ECHO} "";
	@${_ECHO} "${_C_INFO} Initializing... ${_C_STOP}"
	@${_ECHO} "";
	@${_ECHO} "${_C_INFO} Initialize... ${_C_STOP} ${_C_SELECT} ${PROJECT_NAME} ${_C_STOP}"


_full_init: _title_from_file _project_clear_flags _project_install _docker_init _docker_up _project_init _project_set_flags _docker_ps _title_from_file

_init_not_possible:
	@${_ECHO} "\n ${_C_ERROR}  Initialization is not possible...  ${_C_STOP}\n";
	@${_ECHO} "${_C_COMMENT} Please 'make install' first...${_C_STOP}\n";
