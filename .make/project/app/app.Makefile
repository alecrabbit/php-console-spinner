include ${_APP_DIR}/app.init.Makefile

_tools_run: _run_phploc _run_deptrac
	@${_NO_OP};

PHPLOC_DIR = /usr/local/bin

_run_phploc:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHPLOC run...${_C_STOP}\n";
	@mkdir -p ${APP_DIR}/.tools/.report/.phploc
	@-${_DC_EXEC} ${APP_CONTAINER} ${PHPLOC_DIR}/phploc src > ${APP_DIR}/.tools/.report/.phploc/.phploc_baseline
	@-cat ${APP_DIR}/.tools/.report/.phploc/.phploc_baseline
	@${_ECHO} "${_C_STOP}\n";

_run_deptrac:
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --fail-on-uncovered -vvv --no-progress --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache

test:
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Default tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit $(c)

test_coverage:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Coverage tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.coverage.xml --coverage-text

test_full: test_coverage test
	@${_ECHO_BG_GREEN};
