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