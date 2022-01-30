# Docker related targets
docker_down:
	@echo "\n$(_C_WARNING)Stopping containers...$(_C_STOP)\n";
	docker-compose down --remove-orphans

docker_down_clear:
	@echo "\n$(_C_WARNING)Stopping containers...$(_C_STOP)\n";
	docker-compose down -v --remove-orphans

docker_pull:
	@echo "\n$(_C_INFO)Pulling images...$(_C_STOP)\n";
	@docker-compose pull

docker_build:
	@echo "\n$(_C_INFO)Building containers...$(_C_STOP)\n";
	docker-compose build

docker_up:
	@-title
	@echo "\n$(_C_INFO)Starting containers...$(_C_STOP)\n";
	docker-compose up -d

docker_logs:
	@-title "📔 Logs"
	-docker-compose logs -f

_docker_ps:
	@echo "\n$(_C_INFO)Containers...$(_C_STOP)\n";
	docker-compose ps
	@echo "\n";
