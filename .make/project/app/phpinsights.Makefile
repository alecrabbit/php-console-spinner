a_phpinsights_run: ## Run PHP Insights
	@$(eval c ?=)
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP Insights run...${_C_STOP}\n";
	@${_DC_EXEC} ${APP_CONTAINER} vendor/bin/phpinsights $(c)
	@${_ECHO};
