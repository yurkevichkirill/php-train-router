up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

restart:
	docker compose restart

logs:
	docker compose logs -f

php:
	docker compose exec php-fpm sh

db:
	docker compose exec postgres psql -U $(shell grep POSTGRES_USER .env | cut -d '=' -f2)

redis:
	docker compose exec redis redis-cli

composer-install:
	docker compose exec php composer install

migrate:
	docker compose exec php php artisan migrate

test:
	docker compose exec php php artisan test

clean:
	docker compose down -v