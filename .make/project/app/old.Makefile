

clear_ready:
	@echo "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Clearing ready flag...${_C_STOP}\n";
	@docker run --rm -v ${PWD}:/app --workdir=/app alpine rm -f .ready

mark_ready:
	@echo "\n${_C_SELECT}  ${PROJECT_NAME}  ${_C_STOP} ${_C_INFO}Setting ready flag...${_C_STOP}\n";
	@docker run --rm -v ${PWD}:/app --workdir=/app --user=$(shell id -u):$(shell id -g) alpine touch .ready

