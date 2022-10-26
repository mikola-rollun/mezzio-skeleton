echo "#######################################"
echo "Starting in dev mode..."
echo "#######################################"
docker-compose -f docker-compose.yml  -f docker-compose-dev.yml  -f .env.yml  up --detach