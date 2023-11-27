PHPINSIGHTS_BINARY=${COMPOSER_HOME}/vendor/bin/phpinsights
##
## —— PhpInsights 🔭 ———————————————————————————————————————————————————————————

a_phpinsights_run: ## Run PHP Insights
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights run...${_C_STOP}\n";
	${_DC_EXEC} ${APP_CONTAINER} ${PHPINSIGHTS_BINARY} $(c)
	@${_ECHO};

a_phpinsights_analyse: ## Run PHP Insights Analysis
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights analyze...${_C_STOP}\n";
	${_DC_EXEC} ${APP_CONTAINER} ${PHPINSIGHTS_BINARY} analyse
	@${_ECHO};

a_phpinsights_analyse_verbose: ## Run PHP Insights Analysis Verbose Mode
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights analyze...${_C_STOP}\n";
	${_DC_EXEC} ${APP_CONTAINER} ${PHPINSIGHTS_BINARY} analyse -vvv
	@${_ECHO};

a_phpinsights_summary: ## Run PHP Insights summary
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights summary...${_C_STOP}\n";
	@${_DC_EXEC} ${APP_CONTAINER} ${PHPINSIGHTS_BINARY} --summary analyse
	@${_ECHO};
