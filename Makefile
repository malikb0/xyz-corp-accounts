# xyz-corp-accounts — local development / operations
# Run `make help` for the available targets.

COMPOSE ?= docker compose
DB_SERVICE ?= db
DB_NAME ?= xyz_corp_db
DB_ROOT_USER ?= root
DB_ROOT_PASSWORD ?= $(shell grep -E '^MYSQL_ROOT_PASSWORD=' .env 2>/dev/null | cut -d= -f2- || echo root_password)

.DEFAULT_GOAL := help

.PHONY: help up down build restart logs ps shell db reset load-backup smoke render-docs url

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-16s\033[0m %s\n", $$1, $$2}'

up: ## Build (if needed) and start all services
	$(COMPOSE) up -d --build

down: ## Stop and remove containers (keeps the database volume)
	$(COMPOSE) down

build: ## Build the application image
	$(COMPOSE) build

restart: ## Restart the application container
	$(COMPOSE) restart app

logs: ## Tail logs (all services, or SVC=app|db)
	$(COMPOSE) logs -f $(SVC)

ps: ## Show service status
	$(COMPOSE) ps

shell: ## Open a shell in the application container
	$(COMPOSE) exec app bash

db: ## Open a MySQL shell (root) in the database container
	$(COMPOSE) exec $(DB_SERVICE) mysql -u$(DB_ROOT_USER) -p$(DB_ROOT_PASSWORD) $(DB_NAME)

reset: ## Stop and DELETE the database volume, then re-create schema + seed
	$(COMPOSE) down -v
	$(COMPOSE) up -d --build

load-backup: ## Import db/private/backup.sql into the running database
	@test -f db/private/backup.sql || (echo "Place your dump at db/private/backup.sql first" && exit 1)
	$(COMPOSE) exec -T $(DB_SERVICE) mysql -u$(DB_ROOT_USER) -p$(DB_ROOT_PASSWORD) $(DB_NAME) < db/private/backup.sql
	@echo "Imported db/private/backup.sql"

smoke: ## Run the end-to-end smoke test (single login + every module)
	bash ./scripts/smoke-test.sh

render-docs: ## Render Mermaid diagram sources to SVG in docs/assets
	@mkdir -p docs/assets
	@for f in docs/diagrams/*.mmd; do \
		out="docs/assets/$$(basename $$f .mmd).svg"; \
		echo "rendering $$f -> $$out"; \
		mmdc -i "$$f" -o "$$out" >/dev/null; \
	done
	@echo "diagrams rendered"

url: ## Print the local URLs
	@echo "App:        http://localhost:8080"
	@echo "phpMyAdmin: http://localhost:8081"
