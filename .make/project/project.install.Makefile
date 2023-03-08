_do_project_install: _local_project_install_message _check_env_file
	@${_NO_OP}

_local_project_install_message:
	@${_ECHO} "\n${_C_COMMENT} Performing installation...${_C_STOP}\n";
	@${_ECHO_DISABLED};
