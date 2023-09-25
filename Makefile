DOCKER_COMPOSE = cd .docker && docker-compose
USER_ID = `id -u`:`id -g`

help: ## Outputs help
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

build: ## Builds the Docker images
	@$(DOCKER_COMPOSE) build --pull --no-cache

up: ## Start docker containers in detached mode
	@$(DOCKER_COMPOSE) up -d

start: build up ## Build and start containers

down: ## Stops containers
	@$(DOCKER_COMPOSE) down

bash: ## Enters user php container console
	@$(DOCKER_COMPOSE) exec --user=$(USER_ID) php bash

root_bash: ## Enters root php container console
	@$(DOCKER_COMPOSE) exec php bash
