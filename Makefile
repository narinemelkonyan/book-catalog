up:
 docker-compose up -d

down:
 docker-compose down

build:
 docker-compose up -d --build

migrate:
docker exec -it book-catalog-php-1 php yii migrate --interactive=0
