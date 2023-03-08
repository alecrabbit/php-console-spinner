_uninstall: _uninstall_message _do_uninstall
	@${_ECHO};
	@${_ECHO_DONE};

_do_uninstall: _create_dir _uninstall_files

_uninstall_files: _uninstall_makefile _uninstall_var_file _uninstall_env_file _uninstall_title_file

_uninstall_title_file:
	@${_ECHO} "\n${_C_COMMENT}Title file uninstallation...${_C_STOP}\n";
	@mv -f ${_TERMINAL_TITLE_FILE} ${_UNINSTALL_DIR}/${_TERMINAL_TITLE_FILE}
	@${_ECHO_OK}

_uninstall_env_file:
	@${_ECHO} "\n${_C_COMMENT}Environment file uninstallation...${_C_STOP}\n";
	@mv -f ${_ENV_FILE} ${_UNINSTALL_DIR}/${_ENV_FILE}
	@${_ECHO_OK}

_uninstall_makefile:
	@${_ECHO} "\n${_C_COMMENT}Makefile uninstallation...${_C_STOP}\n";
	@mv -f ${_MAKEFILE} ${_DIST_CP_DIR}/${_MAIN_MAKEFILE}
	@mv -f ${_DIST_CP_DIR}/${_INSTALL_MAKEFILE} ${_MAKEFILE}
	@${_ECHO_OK}

_uninstall_var_file:
	@${_ECHO} "\n${_C_COMMENT}Variables file uninstallation...${_C_STOP}\n";
	@mv -f ${_VAR_FILE} ${_VAR_UNINSTALL_FILE}
	@mv -f ${_VAR_DIST_CP_FILE} ${_VAR_DIST_FILE}
	@${_ECHO_OK}

_create_dir:
	@mkdir -p "${_UNINSTALL_DIR}"

_uninstall_message:
	@${_ECHO} "\n${_C_INFO} Uninstall...${_C_STOP}\n";

_uninstall_not_possible:
	@${_ECHO} "\n ${_C_ERROR}  Uninstall is not possible...  ${_C_STOP}\n";
	@${_ECHO} "${_C_COMMENT} Please 'make install' first...${_C_STOP}\n";
