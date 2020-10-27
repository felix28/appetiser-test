rm .env
cp .env.example .env
sudo rm -r vendor
docker image prune -f
docker run --rm -v $(pwd):/app composer install
sudo chown -R $USER:$USER .
docker-compose up -d --build
docker-compose exec appetiser-calendar-app php artisan --version
docker-compose exec appetiser-calendar-app php artisan key:generate
docker-compose exec appetiser-calendar-app php artisan config:cache
docker-compose exec appetiser-calendar-app rm public/storage
docker-compose exec appetiser-calendar-app php artisan storage:link
docker-compose exec appetiser-calendar-app php artisan config:clear
docker-compose exec appetiser-calendar-app vendor/bin/phpunit
docker-compose exec appetiser-calendar-app php artisan migrate
docker-compose exec appetiser-calendar-app php artisan db:seed
docker-compose exec appetiser-calendar-app php artisan passport:install
docker ps -a