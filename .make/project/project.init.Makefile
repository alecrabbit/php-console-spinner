_do_project_set_flags:
	@${_ECHO_DISABLED};
	@#docker run --rm -v ${PWD}/$(SUBMODULE_ONE_DIR):/app --workdir=/app --user=$(shell id -u):$(shell id -g) alpine touch .ready

_do_project_clear_flags:
	@${_ECHO_DISABLED};
	@#docker run --rm -v ${PWD}/$(SUBMODULE_ONE_DIR):/app --workdir=/app alpine rm -f .ready

_do_project_init: _app_init
	@${_ECHO};

