# Project: DAM tool
SHELL=/bin/bash
.DEFAULT_GOAL=do_help_dam_tool

# Root directory
_DN_TOOLS=.tools
# DAM directory
_DN_DAM=.dam

__CORE_FILE=./${_DN_TOOLS}/${_DN_DAM}/core.Makefile

# Include core if present
ifneq ("$(wildcard $(__CORE_FILE))","")
  include $(__CORE_FILE)
endif

# # #
# # ‼️ DO NOT EDIT THIS FILE ‼️
# # #

do_install_dam_tool:
	@echo "Installing DAM tool...\n";
	@wget -qO- "https://github.com/alecrabbit/dev-app-makefile/archive/refs/tags/0.0.23.tar.gz" | tar -xz \
	 && shopt -s dotglob && cp -rv dev-app-makefile-0.0.23/* . && shopt -u dotglob \
 	 && rm -r dev-app-makefile-0.0.23 && ./install && make upgrade

do_help_dam_tool:
	@echo "DAM tool help:\n";
	@echo "  make do_install_dam_tool - install DAM tool";
	@echo "  make do_dam_tool_help - show this help";
	@echo "";
