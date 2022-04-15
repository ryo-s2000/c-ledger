Run
```
docker compose -f docker-compose-dev.yml up
```

Enter Container
```
docker compose -f docker-compose-dev.yml exec app bash
docker compose -f docker-compose-dev.yml exec {name} bash
```

Setup Laravel
```
chmod -R 777 storage bootstrap/cache
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate
```

Compile JS
```
npm run watch
```

Reset
```
docker container prune
docker compose -f docker-compose-dev.yml build --no-cache
```

URL
http://localhost:8080/
