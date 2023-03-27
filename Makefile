.SILENT:
default: start

install:
	composer install
	yarn install
	vendor/bin/sail build

start:
	yarn build
	vendor/bin/sail up -d
	vendor/bin/sail artisan storage:link --force

stop:
	vendor/bin/sail stop

db-refresh:
	vendor/bin/sail php artisan migrate:fresh --seed

test:
	vendor/bin/sail php artisan test

coverage:
	vendor/bin/sail php artisan test --coverage

format:
	vendor/bin/phpcbf
