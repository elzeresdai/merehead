# change owner of dir with app 
sudo chown -R $USER:$USER $(pwd)

# to run compose
docker-compose up -d

#docker compose exec for invoke .env (will be replaced)

before local run of rename .env.example to .env

docker-compose exec app php artisan key:generate

docker-compose exec app php artisan config:cache

docker-compose exec app php artisan migrate --seed

# public documentation

https://web.postman.co/collections/8053506-4c5858c9-28df-434c-a1e4-dc487483a280?version=latest&workspace=dfc271be-6035-4ef4-83cc-45b686165081
