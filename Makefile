SHELL = /bin/bash
.DEFAULT_GOAL := help

NETWORK = sineo_default
COMPOSE = NETWORK=$(NETWORK) docker-compose

.PHONY: start
start: up wait_app install update-db

.PHONY: up
up:
	@$(COMPOSE) up --remove-orphans -d nginx

.PHONY: install
install:
	@$(COMPOSE) exec --user www-data php sh -c "composer install"

.PHONY: update
update:
	$(eval repo ?= )
	@$(COMPOSE) exec --user www-data php sh -c "composer update $(repo)"

.PHONY: update-db
update-db:
	@$(COMPOSE) exec --user www-data php sh -c "bin/console d:s:u --force"

.PHONY: exec
exec:
	$(eval app ?= php)
	$(eval user ?= www-data)
	$(eval cmd ?= bash)
	@$(COMPOSE) exec --user $(user) $(app) sh -c "$(cmd)"

.PHONY: mysql
mysql:
	@$(COMPOSE) run --rm mysql mysql sineo -hmysql -uroot -proot

.PHONY: ps
ps:
	@$(COMPOSE) ps

.PHONY: logs
logs:
	$(eval app ?= mysql php nginx)
	@$(COMPOSE) logs -f $(app)

.PHONY: stop
stop:
	$(eval app ?= mysql php nginx)
	@$(COMPOSE) stop $(app) 2>&1

.PHONY: down
down:
	@$(COMPOSE) down -v --remove-orphans

.PHONY: rm
rm:
	$(eval app ?= mysql php nginx)
	@$(COMPOSE) rm --all -f $(app) 2>&1

.PHONY: destroy
destroy: stop rm

.PHONY: recreate
recreate: destroy up

.PHONY: wait_app
wait_app:
	@docker run --rm --net=$(NETWORK) -e TIMEOUT=120 -e TARGETS=nginx:80,mysql:3306 ddn0/wait 2> /dev/null
