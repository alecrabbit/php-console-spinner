USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
USER_NAME=$(shell id -un)
GROUP_NAME=$(shell id -gn)

_dt_user:
	@${_ECHO} "\n${_C_COMMENT}User: ${_C_STOP}";
	@${_ECHO} "USER_ID    = ${USER_ID}"
	@${_ECHO} "GROUP_ID   = ${GROUP_ID}"
	@${_ECHO} "USER_NAME  = ${USER_NAME}"
	@${_ECHO} "GROUP_NAME = ${GROUP_NAME}"
