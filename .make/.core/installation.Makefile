_install: _installation_message _do_install
	@${_ECHO};
	@${_ECHO_DONE};

_install_done:
	@${_ECHO} "\n${_C_COMMENT} Installation completed...${_C_STOP}\n";

_do_install: _terminal_title _perform_checks _install_makefile

_install_makefile:
	@${_ECHO} "\n${_C_COMMENT}Makefile installation...${_C_STOP}\n";
	@mv -f ${_MAKEFILE} ${_DIST_CP_DIR}/${_INSTALL_MAKEFILE}
	@mv -f ${_DIST_CP_DIR}/${_MAIN_MAKEFILE} ${_MAKEFILE}
	@${_ECHO_OK}

_terminal_title: _create_terminal_title _title

_create_terminal_title:
	@${_ECHO} "${_C_COMMENT}Creating terminal title file...${_C_STOP}\n";
	@echo "🚧 Project" > ${_TERMINAL_TITLE_FILE}

_installation_message:
	@${_ECHO} "\n${_C_INFO} Installation...${_C_STOP}\n";

done:
	@${_ECHO} "${_C_GREEN}Done! ${_C_STOP}\n";
