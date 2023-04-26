a_phpinsights_run: ## Run PHP Insights
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights run...${_C_STOP}\n";
	${_DC_EXEC} ${APP_CONTAINER} vendor/bin/phpinsights $(c)
	@${_ECHO};

a_phpinsights_analyse: ## Run PHP Insights Analysis
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights run...${_C_STOP}\n";
	${_DC_EXEC} ${APP_CONTAINER} vendor/bin/phpinsights analyse src
	@${_ECHO};

a_phpinsights_summary: ## Run PHP Insights summary
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights run...${_C_STOP}\n";
	@${_DC_EXEC} ${APP_CONTAINER} vendor/bin/phpinsights --summary analyse src
	@${_ECHO};
