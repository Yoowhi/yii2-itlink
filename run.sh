#!/bin/bash

trap 'docker-compose down' EXIT

docker-compose up -d
docker-compose exec php composer install
docker-compose exec php /app/yii migrate --interactive=0
docker-compose logs -f php postgres