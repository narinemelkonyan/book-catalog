# Book Catalog

## Stack
- PHP 8.1
- Yii2
- MySQL 8.0
- Docker

## Setup
make build
make migrate
docker exec -it book-catalog-php-1 php yii rbac/init

Open in browser: http://localhost:8080

## Credentials
- Username: admin
- Password: admin123