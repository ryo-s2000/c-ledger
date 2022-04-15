Start
```
docker compose -f docker-compose-dev.yml up
docker compose -f docker-compose-dev.yml exec app bash
chmod -R 777 storage bootstrap/cache
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate

http://localhost:8080/
```

ReStart
```
docker compose -f docker-compose-dev.yml up

http://localhost:8080/
```

Reset
```
docker container prune
docker compose -f docker-compose-dev.yml up --build
```
