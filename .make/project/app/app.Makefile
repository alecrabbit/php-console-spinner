include ${_APP_DIR}/app.init.Makefile

app_tools_run: test_full app_phploc_run app_php_cs_fixer_run app_deptrac_run_full app_psalm_run
	@${_NO_OP};

PHPLOC_DIR = /usr/local/bin

_W_TOOLS_DIR=${WORKING_DIR}/${_DN_TOOLS}
_DN_REPORT=.report
_DN_DEPTRAC=.deptrac

_DEPTRAC_CONFIG_FILE=deptrac.yaml
_DEPTRAC_CACHE_FILE=.deptrac.cache
_DEPTRAC_REPORT_FILE=.deptrac.report
_DEPTRAC_GRAPH_FILE=.deptrac.graph.png

DPTR_DIR = ${_W_TOOLS_DIR}/${_DN_DEPTRAC}
DPTR_CONFIG = ${DPTR_DIR}/${_DEPTRAC_CONFIG_FILE}
DPTR_CACHE = ${DPTR_DIR}/${_DEPTRAC_CACHE_FILE}
DPTR_OUT_DIR_LOCAL = ${APP_DIR}/${_DN_TOOLS}/${_DN_REPORT}/${_DN_DEPTRAC}
DPTR_OUT_DIR = ${_W_TOOLS_DIR}/${_DN_REPORT}/${_DN_DEPTRAC}

app_save: app_php_cs_fixer_run app_deptrac_run
	$(MAKE) save

app_psalm_run:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Psalm run...${_C_STOP}\n";
	@${_DC_EXEC} ${APP_CONTAINER} mkdir -p ${WORKING_DIR}/.tools/.report/.psalm
	-${_DC_EXEC} ${APP_CONTAINER} psalm --config=${WORKING_DIR}/.tools/.psalm/psalm.xml --report=${WORKING_DIR}/.tools/.report/.psalm/report.txt

app_php_cs_fixer_run:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP-CS-Fixer run...${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} php-cs-fixer -vvv fix --config=${WORKING_DIR}/.tools/.php-cs-fixer/.php-cs-fixer.dist.php --cache-file=${WORKING_DIR}/.tools/.php-cs-fixer/.php-cs-fixer.cache --allow-risky=yes
	@${_ECHO};

app_php_cs_fixer_dry:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP-CS-Fixer run...${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} php-cs-fixer -vvv fix --config=${WORKING_DIR}/.tools/.php-cs-fixer/.php-cs-fixer.dist.php --cache-file=${WORKING_DIR}/.tools/.php-cs-fixer/.php-cs-fixer.cache --allow-risky=yes --diff --dry-run
	@${_ECHO};

app_phploc_run:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHPLOC run...${_C_STOP}\n";
	@mkdir -p ${APP_DIR}/.tools/.report/.phploc
	@-${_DC_EXEC} ${APP_CONTAINER} ${PHPLOC_DIR}/phploc src > ${WORKING_DIR}/.tools/.report/.phploc/.phploc_baseline
	@-cat ${APP_DIR}/.tools/.report/.phploc/.phploc_baseline
	@${_ECHO};

app_deptrac_run_full: _deptrac_run_message _deptrac_run_baseline _deptrac_run_graph _deptrac_run_baseline_formatter app_deptrac_run
	@${_NO_OP};

_deptrac_run_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Deptrac run...${_C_STOP}\n";

_deptrac_run_baseline:
	@-mkdir -p ${DPTR_OUT_DIR_LOCAL}
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --clear-cache --no-progress --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE} > ${DPTR_OUT_DIR_LOCAL}/${_DEPTRAC_REPORT_FILE}

_deptrac_run_graph:
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE} --formatter=graphviz-image --output=${DPTR_OUT_DIR}/${_DEPTRAC_GRAPH_FILE}

_deptrac_run_baseline_formatter:
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE} --formatter=baseline --output=${DPTR_OUT_DIR}/baseline.formatter.output.yaml

app_deptrac_run:
	@${_ECHO};
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE}

app_deptrac_debug_layer:
	@$(eval c ?=)
	-${_DC_EXEC} ${APP_CONTAINER} deptrac debug:layer $(c) --config-file=${DPTR_CONFIG}

app_deptrac_debug_unassigned:
	-${_DC_EXEC} ${APP_CONTAINER} deptrac debug:unassigned --config-file=${DPTR_CONFIG}

app_deptrac_run_uncovered:
	-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --fail-on-uncovered --report-uncovered --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE}

test:
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Default tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit $(c)
	@${_ECHO_BG_GREEN};

test_coverage:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Coverage tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.coverage.xml --coverage-text
	@${_ECHO_BG_GREEN};

test_dox:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Testdox tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=off ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.testdox.xml
	@${_ECHO_BG_GREEN};

test_full: test_coverage test test_dox
	@${_NO_OP};
