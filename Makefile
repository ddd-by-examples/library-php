.PHONY: $(MAKECMDGOALS)

DOCKER_COMPOSE = docker compose \
	--project-directory ./ \
	-p library_php

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down -v --remove-orphans

start:
	$(DOCKER_COMPOSE) start

stop:
	$(DOCKER_COMPOSE) stop

restart:
	$(DOCKER_COMPOSE) restart

config:
	$(DOCKER_COMPOSE) config

ps:
	$(DOCKER_COMPOSE) ps

bash:
	$(DOCKER_COMPOSE) exec -w /app php /bin/bash

build:
	DOCKER_BUILDKIT=1 $(DOCKER_COMPOSE) build --ssh default

clean:
	@$(DOCKER_COMPOSE) down -v --rmi local

setup:
	$(DOCKER_COMPOSE) exec -w /app php /bin/bash -c "composer install"

ci: setup
	$(DOCKER_COMPOSE) exec -w /app php /bin/bash -c "composer ci"
