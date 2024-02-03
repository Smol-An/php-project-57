start:
	php artisan serve --host 0.0.0.0

start-frontend:
	npm run dev

setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm ci
	npm run build
	make ide-helper

migrate:
	php artisan migrate

console:
	php artisan tinker

test:
	php artisan test

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app public routes tests

validate:
	composer validate