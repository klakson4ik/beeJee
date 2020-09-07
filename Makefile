LARADOCK=laradock

# container names
PHP_CONTAINER_NAME=$(LARADOCK)_2_php-fpm_1
DB_CONTAINER_NAME=$(LARADOCK)_2_mysql_1
WORKSPACE_CONTAINER_NAME=$(LARADOCK)_2_workspace_1
REDIS_CONTAINER_NAME=$(LARADOCK)_redis_1
HORIZON_CONTAINER_NAME=$(LARADOCK)_laravel-horizon_1
PORTAINER_CONTAINER_NAME=$(LARADOCK)_2_portainer_1
NODE_IMAGE_NAME=node

# mysql variables
DB_DATABASE=shop.local
DB_USERNAME=maks
DB_PASSWORD=1

# date
DATE=$(shell date +'%Y-%m-%d')

LIST_OF_CONTAINERS_TO_RUN=nginx mysql workspace adminer


# some variables that required by installation target
LARADOCK_REPO=https://github.com/bazavlukd/laradock.git

# the first target is the one that executed by default
# when uesr call make with no target.
# let's do nothing in this case
.PHONY: nop
nop:
	@echo "Please pass a target you want to run"

# custom targets

# put them here

#--------

# clone the repo
# replace some variabls in laradock's .env file
# create and update .env file of laravel
# replace some env variables in laravel's .env file
.PHONY: install-laradock
install-laradock:
	cd $(LARADOCK) && git clone $(LARADOCK_REPO) $(LARADOCK) && \
	cp $(LARADOCK)/env-example $(LARADOCK)/.env && \
	sed -i "/DATA_PATH_HOST=.*/c\DATA_PATH_HOST=..\/docker-data" $(LARADOCK)/.env && \
	(test -s .env || cp .env.example .env) ; \
	sed -i "/DB_CONNECTION=.*/c\DB_CONNECTION=mysql" .env && \
	sed -i "/DB_HOST=.*/c\DB_HOST=mysql" .env && \
	sed -i "/DB_DATABASE=.*/c\DB_DATABASE=$(DB_DATABASE)" .env && \
	sed -i "/DB_USERNAME=.*/c\DB_USERNAME=$(DB_USERNAME)" .env && \
	sed -i "/DB_PASSWORD=.*/c\DB_PASSWORD=$(DB_PASSWORD)" .env && \
	sed -i "/REDIS_HOST=.*/c\REDIS_HOST=redis" .env && \
	chmod -R 777 storage

# run initial scriptscd
# key generate
# fix mysql passwords
# run migrations/seeds
# install composer dependencies
# install js dependencies
.PHONY: initial-build
initial-build:
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) composer install
	docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan key:generate'
	docker exec -it $(DB_CONTAINER_NAME) mysql -u root -proot -e "ALTER USER '$(DB_USERNAME)' IDENTIFIED WITH mysql_native_password BY '$(DB_PASSWORD)';";
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan migrate --seed"
	docker exec -it $(WORKSPACE_CONTAINER_NAME) npm install

# run all containers
.PHONY: up
up:
	cd $(LARADOCK) && docker-compose up -d $(LIST_OF_CONTAINERS_TO_RUN)

# stop all containers
.PHONY: down
down:
	cd $(LARADOCK) && docker-compose down

.PHONY: start-portainer
upp:
	cd $(LARADOCK) && docker-compose up -d portainer

.PHONY: stop-portainer
downp:
	cd $(LARADOCK) && docker-compose down portainer



# show laravel's log in realtime
.PHONY: log
log:
	tail -f storage/logs/laravel.log

# show docker log
.PHONY: docker-log
dlog:
	cd $(LARADOCK) && docker-compose logs -f && cd ..

# JOIN containers targets

.PHONY: join-workspace
jw:
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) bash

.PHONY: join-php
jphp:
	cd $(LARADOCK) && docker exec -it $(PHP_CONTAINER_NAME) bash

.PHONY: join-db
jdb:
	cd $(LARADOCK) && docker exec -it $(DB_CONTAINER_NAME) mysql -u maks -p



#------------------

# javascript related targets
.PHONY: build-js
bjs:
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) npm run-script dev && cd ..

.PHONY: build-js-production
bjsp:
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) npm run production --silent && cd ..
.PHONY:  yarn install
yi:
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) yarn install

.PHONY: watch-js
wjs:
	cd $(LARADOCK) && docker exec -t $(WORKSPACE_CONTAINER_NAME) yarn run watch-poll
#------------------

# queue related targets
.PHONY: queue-flush
queue-flush:
	cd $(LARADOCK) && docker exec -it $(REDIS_CONTAINER_NAME) redis-cli flushall && cd ..

.PHONY: horizon
horizon:
	cd $(LARADOCK) && docker exec -it $(REDIS_CONTAINER_NAME) redis-cli flushall
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) bash -c 'php artisan horizon'
#------------------

# some artisan helpers

.PHONY: key-genrate
key-generate:
	cd $(LARADOCK) && docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan key:generate' && cd ..

.PHONY: new-migration
newm:
	@read -p "Migration name: " migrationname; \
	cd $(LARADOCK) && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan make:migration $$migrationname" && cd ..

.PHONY: run-migrations
runm:
	cd $(LARADOCK) && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan migrate"

.PHONY: run-seeds
runs:
	cd $(LARADOCK) && docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan db:seed' && cd ..

.PHONY: new
new:
	@read -p "Make command and name (e.g. event TestEvent): " commandname;\
	cd $(LARADOCK) && docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan make:$$commandname";
#------------------

# run tests with phpunit
.PHONY: test
test:
	cd $(LARADOCK) && docker exec -it $(PHP_CONTAINER_NAME) ./vendor/bin/phpunit && cd ..

# install composer dependencies
.PHONY: composer-install
ci:
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) composer install

# run ngrok to expose nginx webserver on port 80
.PHONY: up-ngrok
up-ngrok:
	cd $(LARADOCK) && docker exec -it $(WORKSPACE_CONTAINER_NAME) ngrok http http://nginx:80 && cd ..
#------------------

#policiec maks
.PHONY: chown
chown:
	sudo chown maks:users -R ./

.PHONY: git push
push:
	git push origin master

.PHONY: git pull
pull:
	git pull origin master
