# # Symfony var-dumper
dumper: c="${PROJECT_SHORT_TITLE} 💉 VarDumper"
dumper: _title
	@${_DC_EXEC} ${DUMPER_CONTAINER} ./vendor/bin/var-dump-server
