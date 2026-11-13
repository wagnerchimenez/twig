.PHONY: setup up down

setup:
	docker-compose run --rm composer install
	make up
	
up:
	docker-compose up -d

down:
	docker-compose down