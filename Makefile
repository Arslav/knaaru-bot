REGISTRY=registry.knaaru.ru
PHP_IMAGE=knaaru-bot/php
APP_IMAGE=knaaru-bot/app
UNAME=$(shell uname -p)

ifeq ($(D_TAG),)
  D_TAG=latest
endif

ifneq ($(UNAME),arm)
  BUILD=build
else
  BUILD=buildx build --platform=linux/amd64
endif

REGISTRY_PHP=$(REGISTRY)/$(PHP_IMAGE):$(D_TAG)
REGISTRY_APP=$(REGISTRY)/$(APP_IMAGE):$(D_TAG)

up: docker-up
down: docker-down
stop: docker-stop
start: docker-start
restart: docker-restart
pull: docker-pull
build: docker-build
build-production: docker-build-php docker-build-app
init: docker-down-clear docker-pull docker-build-php-dev docker-build docker-up

docker-up:
	docker-compose up --detach --remove-orphans

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down --volumes --remove-orphans

docker-stop:
	docker-compose stop

docker-start:
	docker-compose start

docker-restart:
	docker-compose restart

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

docker-build-php:
	cd docker/production/php && \
	docker $(BUILD) -t $(REGISTRY_PHP) -f Dockerfile . && \
	docker push $(REGISTRY_PHP)

docker-build-app:
	tar -cf docker/production/app/app.tar app/ && \
	cd docker/production/app && \
	docker $(BUILD) -t $(REGISTRY_APP) -f Dockerfile . && \
	docker push $(REGISTRY_APP) && \
	rm app.tar

shell:
	docker-compose run --rm php sh

test:
	docker-compose run php vendor/bin/codecept run

test-with-coverage:
	docker-compose run php vendor/bin/codecept run --coverage --coverage-xml --coverage-html
