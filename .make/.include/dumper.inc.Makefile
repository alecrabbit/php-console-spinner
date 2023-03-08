# # Symfony var-dumper
dumper: c="${PROJECT_SHORT_TITLE} 💉 VarDumper" ## Launch Symfony var-dumper
dumper: _title
	@${_DC_EXEC} ${DUMPER_CONTAINER} ./vendor/bin/var-dump-server
