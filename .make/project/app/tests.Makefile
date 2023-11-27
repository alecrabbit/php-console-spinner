##
## —— Tests 🧪 —————————————————————————————————————————————————————————————————

test: ## Run tests
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Default tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=off ${APP_CONTAINER} vendor/bin/phpunit $(c) --display-warnings --display-deprecations
	@${_ECHO_BG_GREEN};

test_coverage: ## Run tests with coverage
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Coverage tests...${_C_STOP}\n";
	@${_ECHO} "${_C_COMMENT} ...testing ${_C_STOP}\n";
	@-${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.coverage.xml --colors="never" --no-output
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.coverage.xml --coverage-text
	@${_ECHO_BG_GREEN};

test_path_coverage: ## Run tests including path coverage
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Coverage tests...${_C_STOP}\n";
	@${_ECHO} "${_C_COMMENT} ...testing ${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=coverage ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.coverage.path.xml --coverage-text --path-coverage
	@${_ECHO_BG_GREEN};

test_dox: ## Run tests with testdox
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Testdox tests...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=off ${APP_CONTAINER} vendor/bin/phpunit --configuration phpunit.testdox.xml $(c) --display-warnings --display-deprecations
	@${_ECHO_BG_GREEN};

test_full: test_coverage test test_dox 	## Run tests with coverage, default and testdox
	@${_NO_OP};

tc: test test_coverage ## Run default tests and test with coverage
	@${_NO_OP};
