#!/bin/bash

# Exit when any command fails
set -e

# Dependencies & context
dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
source $dir/lib/common.sh
# app_id=$(get_config_value COMPOSE_PROJECT_NAME)

# Build and enter to "deploy" mode
echo "#######################################"
echo "Building..."
echo "#######################################"


# Run builder
COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 docker-compose \
  -f docker-compose.yml \
  up --build --force-recreate --detach

# Cache dependencies
echo "Caching dependencies..."
# mkdir -p vendor
# docker exec -i "$app_id"_laravel-env_1 sh -c "rsync -a --delete vendor/ .container-outworld/vendor/ || true"

# Update permissions for shared entries
# echo "Setting permissions..."
# docker exec -i "$app_id"_laravel-env_1 sh <<-HEREDOC
# chmod 775 .env
# chgrp -R www-data storage/framework storage/logs storage/app
# chmod -R g+w storage/framework storage/logs storage/app
# chmod g+s storage/framework storage/logs
# HEREDOC

# db1 migration
echo "#######################################"
echo "Running data migration..."
echo "#######################################"
# Wait until mysql is up
# cat << END | docker exec -i "$app_id"_laravel-env_1 sh
# timeout 30 sh -c 'until nc -z -v \$0 \$1; do sleep 1; done' db1_mysql 3306
# END
# Migrate data
# cat << END | docker exec -i "$app_id"_laravel-env_1 bash
# set -e

# composer install
# # Run migrations
# php artisan key:generate
# php artisan config:cache
# php artisan migrate
# npm i
# npm run prod

# # Add dummy data on fresh install
# if [ "\$(php artisan users:count)" = "0" ]; then
#     php artisan db:seed
#     php artisan key:generate

#     # Persist keys
# fi
# END

echo "#######################################"
echo "Build is done"
echo "#######################################"
