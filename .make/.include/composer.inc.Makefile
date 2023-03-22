_app_composer_install:
	@${_ECHO} "\n${_C_SELECT}  ${APP_PROJECT_NAME}  ${_C_STOP} ${_C_INFO}Installing composer dependencies...${_C_STOP}\n";
	@${_DC_EXEC} -e XDEBUG_MODE=off $(or ${COMPOSER_CONTAINER},${APP_CONTAINER}) composer install --no-interaction

_app_composer_normalize:
	@${_ECHO} "\n${_C_SELECT}  ${APP_PROJECT_NAME}  ${_C_STOP} ${_C_INFO}Normalizing composer.json...${_C_STOP}\n";
	${_DC_EXEC} -e XDEBUG_MODE=off $(or ${COMPOSER_CONTAINER},${APP_CONTAINER}) composer-normalize
