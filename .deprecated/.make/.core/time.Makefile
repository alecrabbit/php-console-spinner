_CURRENT_DATE_LC=$(shell date)

time_current:
	@${_ECHO} "\n${_C_COMMENT} ${_CURRENT_DATE_LC} ${_C_STOP}\n";

_timer_start:
	@${_TIMED_DIR}/start.sh;

_time_init:
	@${_TIMED_DIR}/init_time.sh ${_INITS_DIR};

_timer_stop:
	@${_ECHO} "${_C_INFO} $(shell ${_TIMED_DIR}/stop.sh) ${_C_STOP}";
