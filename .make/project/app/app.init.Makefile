_app_init: _app_init_message _do_app_init
	@${_ECHO};
	@${_ECHO_DONE};

_app_init_message:
	@${_ECHO} "\n${_C_INFO} Applications initialization... ${_C_STOP}\n";

_do_app_init:
	@${_ECHO_DISABLED};

