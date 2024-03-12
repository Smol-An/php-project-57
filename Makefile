start:
	php artisan serve --host 0.0.0.0

start-frontend:
	npm run dev

setup:
	composer install
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm ci
	npm run build

migrate:
	php artisan migrate

console:
	php artisan tinker

test:
	php artisan test

lint:
	composer exec --verbose phpcs -- --standard=PSR12 routes

validate:
	composer validate