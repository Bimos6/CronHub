.PHONY: build up down logs

build:
	docker compose build --no-cache

up:
	docker compose up -d --build

down:
	docker compose down

logs:
	docker compose logs -f

restart: down up

status:
	docker compose ps