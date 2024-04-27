start:
	php artisan serve --host 0.0.0.0

start-frontend:
	npm run dev

setup:
	composer install
	cp -n .env.example .env
	php artisan key:generate
	npm install
	npm run build

migrate:
	php artisan migrate

console:
	php artisan tinker

test:
	php artisan test

test-coverage:
	XDEBUG_MODE=coverage php artisan test --coverage-clover build/logs/clover.xml

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests

validate:
	composer validate