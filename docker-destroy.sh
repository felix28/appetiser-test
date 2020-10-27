docker stop appetiser-calendar-phpmyadmin
docker stop appetiser-calendar-mysql
docker stop appetiser-calendar-app
docker stop appetiser-calendar-nginx
docker rm appetiser-calendar-phpmyadmin
docker rm appetiser-calendar-mysql
docker rm appetiser-calendar-app
docker rm appetiser-calendar-nginx
docker image prune -f