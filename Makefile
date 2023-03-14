# # #
# # ‼️            STOP           ‼️
# # ‼️ DO **NOT** EDIT THIS FILE ‼️
# # #
# # https://github.com/alecrabbit/dev-app-makefile

# Project: DAM tool
SHELL=/bin/bash
.DEFAULT_GOAL=help_dam_tool

# Root(Tools) directory
_DN_TOOLS=.tools
# DAM directory
_DN_DAM=.dam

__CORE_FILE=./${_DN_TOOLS}/${_DN_DAM}/core.Makefile

# Include core if present
ifneq ("$(wildcard $(__CORE_FILE))","")
  include $(__CORE_FILE)
endif

__DAM_URL="https://github.com/alecrabbit/dev-app-makefile"

install_dam_tool:
	@echo -e "Installing DAM tool...\n";
	@wget -qO- "${__DAM_URL}/archive/refs/heads/dev.tar.gz" | tar -xz \
	 && shopt -s dotglob && cp -r dev-app-makefile-dev/* . && shopt -u dotglob \
 	 && rm -r dev-app-makefile-dev && ./install && make upgrade c=dev

help_dam_tool:
	@echo -e "DAM tool help:\n";
	@echo "  make do_install_dam_tool - install DAM tool";
	@echo "";
