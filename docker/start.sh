#!/bin/bash

# Exit when any command fails
set -e

# Dependencies & context
dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)

docker-compose \
  -f docker-compose.yml \
  -f .env.yml \
  up --detach