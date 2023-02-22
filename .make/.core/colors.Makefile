# Color variables
_C_ERROR=\033[01;38;05;15;48;05;196m
_C_WARNING=\033[01;38;05;226m
_C_YELLOW=\033[33m
_C_COMMENT=${_C_YELLOW}
_C_GREEN=\033[32m
_C_RED=\033[31m
_C_INFO=\033[01;38;05;70m
_C_SELECT=\033[01;04;38;05;19;48;05;227m
_C_STOP=\033[0m
_C_DEBUG=\033[90m

export red := $(shell tput -Txterm setaf 1)
export reset := $(shell tput -Txterm sgr0)
