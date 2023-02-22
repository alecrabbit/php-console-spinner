_perform_checks: _check_message _docker_check _docker_compose_check _check_var_file _check_env_file

_check_message:
	@${_ECHO} "\n${_C_INFO} Performing checks... ${_C_STOP}"
