include ${_PROJECT_DIR}/project.init.Makefile
include ${_PROJECT_DIR}/project.install.Makefile
include ${_APP_DIR}/app.Makefile

project_info:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO} Project info...${_C_STOP}\n";
	@${_ECHO_DISABLED};
	@${_ECHO} "${_C_DEBUG} Add project info >>here<<${_C_STOP}\n";

release: _release_message _do_release changelog ## Prepare for release

_release_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Preparing for release...${_C_STOP}\n";

_do_release:
	@${_BIN_DIR}/gitattributes.sh

changelog: _changelog_message _do_changelog ## Generate changelog

_changelog_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Generating changelog...${_C_STOP}\n";

_do_changelog:
	@git-chglog --output CHANGELOG.md
