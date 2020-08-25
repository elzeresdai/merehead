# change owner of dir with app 
sudo chown -R $USER:$USER $(pwd)

# to run compose
docker-compose up -d

#docker compose exec for invoke .env (will be replaced)

before local run of rename .env.example to .env

docker-compose exec app php artisan key:generate

docker-compose exec app php artisan config:cache

docker-compose exec app php artisan migrate --seed
