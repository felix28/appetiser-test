<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## APPETISER TEST

## Instructions for Setting up in Local Environment:

- Install Docker: https://docs.docker.com/engine/install/ubuntu.
- (Optional) Install dos2unix: sudo apt-get install dos2unix
- After cloning this repository, go to project's directory: cd /directory/of/this/project
- (Optional) sudo dos2unix docker-create.sh
- (Optional) sudo dos2unix docker-destroy.sh
- (Optional) sudo dos2unix docker-start.sh
- (Optional) sudo dos2unix docker-stop.sh
- (Optional) sudo chmod +x docker-create.sh
- (Optional) sudo chmod +x docker-destroy.sh
- (Optional) sudo chmod +x docker-start.sh
- (Optional) sudo chmod +x docker-stop.sh
- Create the app by running this command: ./docker-create.sh
- Destroy the app by running this command: ./docker-destroy.sh
- Stop the app (stop but don't destroy) by running this command: ./docker-stop.sh
- Start the stopped app by running this command: ./docker-start.sh
- Check if all containers are running by executing: docker ps -a
- Visit <a href="http://localhost:7017" target="_blank">http://localhost:7017</a> for Laravel.
- Visit <a href="http://localhost:7019" target="_blank">http://localhost:7019</a> for phpMyAdmin.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).