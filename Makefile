.SILENT:
default: start

install:
	composer install
	yarn install
	vendor/bin/sail build

start:
	yarn build
	vendor/bin/sail up -d

stop:
	vendor/bin/sail stop

db-refresh:
	vendor/bin/sail php artisan migrate:fresh --seed

test:
	vendor/bin/sail php artisan test

format:
	vendor/bin/phpcs && vendor/bin/phpcbf
