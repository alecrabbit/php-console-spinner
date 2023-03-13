include ${_APP_DIR}/app.init.Makefile

app_tools_run: app_phploc_run app_deptrac_run
	@${_NO_OP};

PHPLOC_DIR = /usr/local/bin

app_phploc_run:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHPLOC run...${_C_STOP}\n";
	@mkdir -p ${APP_DIR}/.tools/.report/.phploc
	@-${_DC_EXEC} ${APP_CONTAINER} ${PHPLOC_DIR}/phploc src > ${APP_DIR}/.tools/.report/.phploc/.phploc_baseline
	@-cat ${APP_DIR}/.tools/.report/.phploc/.phploc_baseline
	@${_ECHO} "${_C_STOP}\n";

#app_deptrac_run:
#	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Deptrac run...${_C_STOP}\n";
#	@mkdir -p ${APP_DIR}/.tools/.report/.deptrac
#	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --clear-cache --no-progress --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache > ${APP_DIR}/.tools/.report/.deptrac/.deptrac_baseline
#	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache --formatter=graphviz-image --output=${APP_DIR}/.tools/.report/.deptrac/graph.png
#	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache --formatter=baseline --output=${APP_DIR}/.tools/.report/.deptrac/baseline.formatter.output.yaml
#	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache
#	@#-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --fail-on-uncovered --report-uncovered -vvv --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache

app_deptrac_run_full: _deptrac_run_message _deptrac_run_baseline _deptrac_run_graph _deptrac_run_baseline_formatter app_deptrac_run
	@${_NO_OP};

_deptrac_run_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Deptrac run...${_C_STOP}\n";

_deptrac_run_baseline:
	@mkdir -p ${APP_DIR}/.tools/.report/.deptrac
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --clear-cache --no-progress --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache > ${APP_DIR}/.tools/.report/.deptrac/.deptrac_baseline

_deptrac_run_graph:
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache --formatter=graphviz-image --output=${APP_DIR}/.tools/.report/.deptrac/graph.png

_deptrac_run_baseline_formatter:
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache --formatter=baseline --output=${APP_DIR}/.tools/.report/.deptrac/baseline.formatter.output.yaml

app_deptrac_run:
	@${_ECHO};
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache

app_deptrac_run_uncovered:
	-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --fail-on-uncovered --report-uncovered --config-file=${APP_DIR}/.tools/.deptrac/deptrac.yaml --cache-file=${APP_DIR}/.tools/.deptrac/.deptrac.cache

test:
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Default tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit $(c)

test_coverage:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Coverage tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.coverage.xml --coverage-text

test_full: test_coverage test
	@${_ECHO_BG_GREEN};
