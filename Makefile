#!make
include .env
export $(shell sed 's/=.*//' .env)

# Docker
docker-build:
	docker build -t local_md_php:7.1 .docker/php/

up:
	docker-compose up -d

down:
	docker-compose down

ps:
	docker-compose ps

logs:
	docker-compose logs -f

install:
	make docker-build
	make up
	docker exec -it md-php composer install
	docker exec -it md-php make orm.install
	docker exec -it md-php make orm.status

## Docker - SSH Container
ssh-php:
	docker exec -it md-php bash

ssh-mysql:
	docker exec -it md-sql bash

#===============================================================
# All command down below supposed you ssh into the php container
#===============================================================

# Database
orm.status:
	php app/console doctrine:schema:validate --env=$(ENV)

orm.status-prod: override ENV=prod
orm.status-prod: orm.status

orm.show-diff:
	php app/console doctrine:schema:update --dump-sql --env=$(ENV)

orm.install:
	php app/console --env=$(ENV) doctrine:database:drop --if-exists --force
	php app/console doctrine:database:create --env=$(ENV)
	php app/console doctrine:schema:create --env=$(ENV)

# Qualimetry rules

## Qualimetry : checkstyle
cs: checkstyle
checkstyle:
	bin/phpcs --extensions=php -np --standard=PSR12 --report=full src

## Qualimetry : code-beautifier
cb: code-beautifier
code-beautifier:
	bin/phpcbf --extensions=php --standard=PSR12 src

## Qualimetry : lint
lint.php:
	find -L src -name '*.php' -print0 | xargs -0 -n 1 -P 4 php -l

lint.yaml:
    php app/console lint:yaml app

## Qualimetry : composer
composer.validate:
	composer validate composer.json

qa: qualimetry
qualimetry: checkstyle lint.php lint.yaml composer.validate

# Test
orm.load-test:
	php app/console doctrine:fixtures:load --fixtures=src/AppBundle/DataFixtures/Tests --no-interaction --env=$(ENV)

orm.dummy-test:
	php app/console entity:test

phpunit:
	bin/phpunit -c app/phpunit.xml.dist --colors=never
