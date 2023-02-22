_check_var_file:
	@${_ECHO} "${_C_COMMENT} \nChecking for var file [${_VAR_FILE}]... ${_C_STOP}";
	@-if [[ -f "${_VAR_FILE}" ]]; then \
	  ${_ECHO} "\nVar file ${_VAR_FILE}\n"; \
	  ${_ECHO_OK}; \
	else \
      ${_ECHO} "\n${_C_ERROR}  ${_VAR_FILE} Not found  ${_C_STOP}"; \
    fi;
	@-if [[ -f "${_VAR_DIST_FILE}" ]]; then \
	  ${_ECHO} "${_C_COMMENT}Present${_VAR_DIST_FILE}...${_C_STOP}"; \
	  if [[ -f "${_VAR_FILE}" ]]; then \
	  ${_ECHO} "\n${_VAR_FILE}\n"; \
	  ${_ECHO_OK}; \
	  else \
	    ${_ECHO} "${_C_COMMENT}Copying ${_VAR_DIST_FILE} to ${_VAR_FILE}${_C_STOP}"; \
	    ${_ECHO} "${_C_DEBUG}";\
	    cp -v ${_VAR_DIST_FILE} ${_VAR_FILE}; \
	    ${_ECHO} "${_C_STOP}"; \
	    ${_ECHO_OK}; \
	  fi; \
	  ${_ECHO} "${_C_DEBUG}";\
      mv -fv ${_VAR_DIST_FILE} ${_VAR_DIST_CP_FILE} ; \
	  ${_ECHO} "${_C_STOP}"; \
      ${_ECHO_OK}; \
    fi;

