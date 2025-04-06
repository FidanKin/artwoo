install:
	cp .env.example .env
	npm install
	composer install
	php artisan key:generate
fill-db:
	php artisan migrate --seed
local-reset-db:
	php artisan migrate:fresh
	php artisan db:seed
install-prod:
	cp .env.example .env
	echo "Start composer install with --no-dev and optimize"
	composer install --optimize-autoloader --no-dev
	echo "Generate app key"
	php artisan key:generate
	echo "Start app build cache ..."
	php artisan config:cache
	php artisan event:cache
	php artisan route:cache
	php artisan view:cache
	php artisan optimize
	echo "Start build front assets ..."
	npm install
	npm run build #front assets
	echo "Check that app executing from www-data user !!!"
	echo "Check that cron run every 1 minute"
	echo "Check that email smtp is working"
	echo "Enable maintenance mode"
	php artisan down
	echo "PHP version"
	php -v
	echo "Check php.ini setting espicialy max uploaded file size"
migrate-prod:
	php artisan migrate
set-project-permissions:
	echo "Set files permission for web server"
	# https://stackoverflow.com/questions/30639174/how-to-set-up-file-permissions-for-laravel
	sudo chown -R $USER:www-data .
	sudo find . -type f -exec chmod 664 {} \;
	sudo find . -type d -exec chmod 775 {} \;
run-prod:
	# off maintenance mode
	php artisan up
prod-build-front:
	echo "Start build front files"
	npm run build
prod-build-backend:
	echo "Start backend files"
	composer install --optimize-autoloader --no-dev
prod-delete-dev-front:
	echo "Deleting dev front files"
	rm -f package.json
	rm -f package-lock.json
	rm -f postcss.config.js
	rm -f tailwind.config.js
	rm -f vite.config.js
	rm -f .styleci.yml
	rm -rf node_modules
prod-delete-dev-backend:
	echo "Deleting dev backend files"
	rm -f README.md
	rm -f CHANGELOG.md
	rm -f .gitignore
	rm -f .env.dest
	rm -f .env.example
	rm -f .env.phpunit
	rm -f .gitattributes
	rm -f composer.json
	rm -f composer.lock
	rm -f phpunit.xml
	rm -rf tests
	rm -rf web-server
	rm -rf .github

