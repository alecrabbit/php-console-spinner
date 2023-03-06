_check_env_file:
	@${_ECHO} "${_C_COMMENT} \n Checking for file [${_ENV_FILE}]... ${_C_STOP}";
	@-if [[ -f "${_ENV_FILE}" ]]; then \
	  ${_ECHO} "\nFound file [${_ENV_FILE}] \n"; \
	  ${_ECHO_OK}; \
	else \
      ${_ECHO} "\n${_C_ERROR} File not found [${_ENV_FILE}] ${_C_STOP}"; \
      if [[ -f "${_ENV_DIST_FILE}" ]]; then \
	    ${_ECHO} "\n${_C_COMMENT} Copying dist file [${_ENV_DIST_FILE}]...  ${_C_STOP}\n"; \
        cp ${_ENV_DIST_FILE} ${_ENV_FILE}; \
        ${_ECHO_OK}; \
      else \
        ${_ECHO} "\n${_C_COMMENT} Creating file [${_ENV_FILE}]...  ${_C_STOP}"; \
        ${_ECHO} "${_ENV_FILE_COMMENT}" > ${_ENV_FILE}; \
      fi;\
    fi;

