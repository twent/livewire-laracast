.SILENT:
.default:=start

install:
	composer install
	yarn install
	vendor/bin/sail build

start:
	yarn build
	vendor/bin/sail up -d

db-refresh:
	vendor/bin/sail php artisan migrate:fresh --seed
