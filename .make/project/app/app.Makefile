include ${_APP_DIR}/app.init.Makefile

_tools_run: _run_phploc

_run_phploc:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHPLOC tun...${_C_STOP}\n";
	@mkdir -p ${APP_DIR}/.tools/.report/.phploc
	@-${_DC_EXEC} ${CONTAINER_NAME} /app/.tools/bin/phploc src > ${APP_DIR}/.tools/.report/.phploc/.phploc_baseline
	@-cat ${APP_DIR}/.tools/.report/.phploc/.phploc_baseline
	@${_ECHO} "${_C_STOP}\n";

test:
	@-${_DC_EXEC} -e XDEBUG_MODE=off ${CONTAINER_NAME} vendor/bin/phpunit

test_coverage:
	@-${_DC_EXEC} -e XDEBUG_MODE=coverage ${CONTAINER_NAME} vendor/bin/phpunit --coverage-text
